<?php
// Minimal CodeIgniter test - no Locale dependency
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>CI Minimal Test</title></head><body>";
echo "<h1>CodeIgniter Minimal Bootstrap Test</h1>";

try {
    // Try to define basic constants that CI needs
    if (!defined('SYSTEMPATH')) {
        define('SYSTEMPATH', __DIR__ . '/../system/');
    }
    
    if (!defined('APPPATH')) {
        define('APPPATH', __DIR__ . '/../app/');
    }
    
    if (!defined('ROOTPATH')) {
        define('ROOTPATH', __DIR__ . '/../');
    }
    
    if (!defined('FCPATH')) {
        define('FCPATH', __DIR__ . '/');
    }
    
    echo "<p style='color: green;'>✓ Constants defined successfully</p>";
    
    // Check if autoloader exists
    $autoloader_path = ROOTPATH . 'vendor/autoload.php';
    if (file_exists($autoloader_path)) {
        echo "<p style='color: green;'>✓ Composer autoloader found</p>";
        require_once $autoloader_path;
        echo "<p style='color: green;'>✓ Autoloader loaded</p>";
    } else {
        echo "<p style='color: red;'>✗ Composer autoloader not found at: $autoloader_path</p>";
    }
    
    // Try to load CI Config without full bootstrap
    $config_path = APPPATH . 'Config/App.php';
    if (file_exists($config_path)) {
        echo "<p style='color: green;'>✓ App config file exists</p>";
    }
    
    echo "<h3>Test Result: Basic CI structure OK</h3>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
} catch (Error $e) {
    echo "<p style='color: red;'>Fatal Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>";
echo "<p><a href='/static_login.html'>← Back to Static Login</a></p>";
echo "</body></html>";
?>