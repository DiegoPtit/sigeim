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
    if ($path === '/' || $path === '') {
        view('home', ['title' => 'Inicio']);
    } else {
        // Simple fallback for other routes
        echo "Ruta: " . $path;
    }
}
