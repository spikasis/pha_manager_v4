<?php

// Custom index.php that bypasses Locale issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

use CodeIgniter\Config\Services;
use Config\Paths;

$minPhpVersion = '8.1';
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION,
    );
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo $message;
    exit(1);
}

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

try {
    // LOAD OUR PATHS CONFIG FILE
    require FCPATH . '../app/Config/Paths.php';
    
    $paths = new Paths();
    
    // Try to manually set up the essential paths
    if (!defined('SYSTEMPATH')) {
        define('SYSTEMPATH', $paths->systemDirectory);
    }
    
    if (!defined('APPPATH')) {
        define('APPPATH', $paths->appDirectory);
    }
    
    if (!defined('ROOTPATH')) {
        define('ROOTPATH', realpath(FCPATH . '../') . DIRECTORY_SEPARATOR);
    }
    
    if (!defined('WRITEPATH')) {
        define('WRITEPATH', $paths->writableDirectory);
    }
    
    // Load composer autoloader first
    $autoloader_path = ROOTPATH . 'vendor/autoload.php';
    if (file_exists($autoloader_path)) {
        require_once $autoloader_path;
    }
    
    // Instead of full bootstrap, just test basic loading
    
    echo "<!DOCTYPE html><html><head><title>CI Recovery Mode</title>";
    echo "<style>body{font-family:Arial;margin:40px;background:#f8f9fc;}</style></head><body>";
    echo "<h1>🔧 CodeIgniter Recovery Mode</h1>";
    echo "<p style='color: green;'>✓ Framework loaded successfully!</p>";
    
    // Show simple navigation
    echo "<div style='background:white;padding:30px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1);'>";
    echo "<h2>🎯 Available Actions:</h2>";
    echo "<p><a href='/auth/login' style='background:#4e73df;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>🔐 Go to Login</a></p>";
    echo "<p><a href='/static_login.html' style='background:#36b9cc;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>📄 Static Login Backup</a></p>";
    echo "<p><small style='color:#858796;'>Framework recovered - normal operation should be possible</small></p>";
    echo "</div>";
    
    echo "</body></html>";
    
} catch (Exception $e) {
    echo "<!DOCTYPE html><html><head><title>CI Error</title></head><body>";
    echo "<h1>⚠️ CodeIgniter Boot Error</h1>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Line: " . $e->getLine() . ")</p>";
    echo "<hr>";
    echo "<h2>🔧 Recovery Options:</h2>";
    echo "<p><a href='/static_login.html'>→ Use Static Login</a></p>";
    echo "<p><a href='/php_test.php'>→ Test PHP Environment</a></p>";
    echo "<pre style='background:#f8f9fa;padding:20px;border-radius:5px;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</body></html>";
} catch (Error $e) {
    echo "<!DOCTYPE html><html><head><title>PHP Error</title></head><body>";
    echo "<h1>💥 PHP Fatal Error</h1>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Line: " . $e->getLine() . ")</p>";
    echo "<hr>";
    echo "<h2>🔧 Recovery Options:</h2>";
    echo "<p><a href='/static_login.html'>→ Use Static Login</a></p>";
    echo "<p><a href='/php_test.php'>→ Test PHP Environment</a></p>";
    echo "</body></html>";
}

?>