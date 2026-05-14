<?php

/**
 * Helper to get environment variables
 */
function env($key, $default = null) {
    $value = getenv($key);
    if ($value === false) return $default;
    return $value;
}

/**
 * Basic asset helper
 */
function asset($path) {
    return '/assets/' . ltrim($path, '/');
}

/**
 * Render a view within the layout
 */
function view($view, $data = []) {
    extract($data);
    $viewPath = __DIR__ . '/../../templates/views/' . $view . '.php';
    
    if (file_exists($viewPath)) {
        ob_start();
        include $viewPath;
        $content = ob_get_clean();
        include __DIR__ . '/../../templates/layout.php';
    } else {
        die("View $view not found at $viewPath");
    }
}
