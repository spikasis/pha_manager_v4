<?php
echo "<!DOCTYPE html><html><head><title>PHP Test</title></head><body>";
echo "<h1>PHP Functionality Test</h1>";

// Basic PHP info
echo "<h2>PHP Version: " . phpversion() . "</h2>";

// Check if we can access basic CodeIgniter path
echo "<h3>Path Tests:</h3>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "HTTP Host: " . $_SERVER['HTTP_HOST'] . "<br>";

// Try to access the app directory
$app_path = __DIR__ . '/../app';
echo "<br><h3>Directory Tests:</h3>";
echo "App Path Exists: " . (is_dir($app_path) ? "YES" : "NO") . "<br>";
echo "App Path: $app_path<br>";

if (is_dir($app_path)) {
    $config_path = $app_path . '/Config';
    echo "Config Path Exists: " . (is_dir($config_path) ? "YES" : "NO") . "<br>";
    
    if (is_dir($config_path)) {
        $files = scandir($config_path);
        echo "Config Files: " . implode(', ', array_slice($files, 2, 5)) . "<br>";
    }
}

// Check if we can include files without error
echo "<br><h3>Include Tests:</h3>";

try {
    $autoload_path = $app_path . '/Config/Autoload.php';
    if (file_exists($autoload_path)) {
        echo "Autoload.php exists<br>";
        // Don't actually include it, just check if readable
        echo "Autoload.php readable: " . (is_readable($autoload_path) ? "YES" : "NO") . "<br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

// Check extensions
echo "<br><h3>PHP Extensions:</h3>";
echo "intl: " . (extension_loaded('intl') ? "LOADED" : "NOT LOADED") . "<br>";
echo "mbstring: " . (extension_loaded('mbstring') ? "LOADED" : "NOT LOADED") . "<br>";
echo "json: " . (extension_loaded('json') ? "LOADED" : "NOT LOADED") . "<br>";

// Check if Locale class exists when intl is loaded
if (extension_loaded('intl')) {
    echo "Locale class exists: " . (class_exists('Locale') ? "YES" : "NO") . "<br>";
    if (class_exists('Locale')) {
        try {
            $locale = Locale::getDefault();
            echo "Default locale: $locale<br>";
        } catch (Exception $e) {
            echo "Locale error: " . $e->getMessage() . "<br>";
        }
    }
}

echo "<br><h3>Result:</h3>";
echo "<p style='color: green;'>Basic PHP is working fine!</p>";

echo "</body></html>";
?>