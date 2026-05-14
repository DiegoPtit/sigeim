<?php

// Basic error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Simple Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

// Load helpers
require_once __DIR__ . '/../src/Helpers/functions.php';

// Simple Router (Conceptual)
$request_uri = $_SERVER['REQUEST_URI'] ?? '/';
$base_path = '/';
$path = str_replace($base_path, '', $request_uri);
$path = parse_url($path, PHP_URL_PATH);

// Simple landing page for now - Only if not in CLI
if (php_sapi_name() !== 'cli') {
    // Basic Auth Check for Admin
    $isLoggedIn = isset($_COOKIE['remember_me']) && $_COOKIE['remember_me'] === 'true';

    if ($path === '/' || $path === '') {
        if ($isLoggedIn) {
            header('Location: /admin');
            exit;
        }
        view('home', ['title' => 'Inicio']);
    } elseif ($path === 'login') {
        if ($isLoggedIn) {
            header('Location: /admin');
            exit;
        }
        view('login', ['title' => 'Acceso']);
    } elseif ($path === 'subida') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new \App\Controllers\UploadController();
            $result = $controller->process();
            
            view('info-message', [
                'title' => $result['success'] ? 'Éxito' : 'Error',
                'type' => $result['success'] ? 'success' : 'error',
                'message_title' => $result['message_title'],
                'message_body' => $result['message_body'],
                'primary_link' => $result['success'] ? ['url' => '/cola', 'text' => 'Ver Cola de Impresión'] : null
            ]);
            exit;
        }

        $deptModel = new \App\Models\Department();
        $pageTypeModel = new \App\Models\PageType();
        
        view('subida', [
            'title' => 'Subir Documento',
            'departments' => $deptModel->all(),
            'pageTypes' => $pageTypeModel->all()
        ]);
    } elseif ($path === 'admin') {
        if (!$isLoggedIn) {
            header('Location: /login');
            exit;
        }
        view('dashboard', ['title' => 'Panel de Control'], 'admin_layout');
    } else {
        // Simple fallback for other routes
        echo "Ruta: " . $path;
    }
}
