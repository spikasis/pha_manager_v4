<?php
// Simple test to check if CodeIgniter can load
try {
    echo "Testing CodeIgniter Load...\n";
    
    // Set error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // Check if intl is loaded
    if (extension_loaded('intl')) {
        echo "✅ PHP intl extension loaded\n";
    } else {
        echo "❌ PHP intl extension NOT loaded\n";
    }
    
    // Test Locale class
    if (class_exists('Locale')) {
        echo "✅ Locale class exists\n";
    } else {
        echo "❌ Locale class NOT found\n";
    }
    
    // Basic paths check
    define('SYSTEMPATH', __DIR__ . '/vendor/codeigniter4/framework/system/');
    define('ROOTPATH', __DIR__ . '/');
    define('FCPATH', __DIR__ . '/public/');
    define('APPPATH', __DIR__ . '/app/');
    
    echo "✅ Paths defined\n";
    echo "Base URL: " . (getenv('CI_BASEURL') ?: 'https://manager.pikasishearing.gr/') . "\n";
    echo "Environment: " . (getenv('CI_ENVIRONMENT') ?: 'production') . "\n";
    
    // Test if we can create a basic CI instance
    require_once SYSTEMPATH . 'Boot.php';
    echo "✅ Boot.php loaded successfully\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
} catch (Error $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Done ===\n";
?>