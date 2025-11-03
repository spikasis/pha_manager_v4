<?php
/**
 * Router script for PHP built-in server
 * This file handles URL rewriting for development server
 */

$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);

// Remove query string
$path = explode('?', $path)[0];

// Check if the request is for an actual file
if ($path !== '/' && file_exists(__DIR__ . $path)) {
    return false; // Serve the file directly
}

// Check for common static file extensions
$extension = pathinfo($path, PATHINFO_EXTENSION);
$staticExtensions = ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'ico', 'svg', 'woff', 'woff2', 'ttf', 'eot'];

if (in_array($extension, $staticExtensions)) {
    if (file_exists(__DIR__ . $path)) {
        return false; // Let PHP serve the file
    } else {
        // File not found
        http_response_code(404);
        echo "File not found: " . $path;
        return true;
    }
}

// For all other requests, route through index.php
$_SERVER['REQUEST_URI'] = $uri;
$_SERVER['SCRIPT_NAME'] = '/index.php';

// Include the main index.php
require_once __DIR__ . '/index.php';
return true;
?>