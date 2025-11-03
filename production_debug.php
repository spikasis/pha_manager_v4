<?php
/**
 * Production Debug Script
 * Safe entry point for live server testing
 */

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔧 CodeIgniter 4 Production Debug</h1>";

try {
    // Check if we're in the right directory
    $currentDir = __DIR__;
    echo "<p><strong>Current Directory:</strong> {$currentDir}</p>";
    
    // Check for required files
    $requiredFiles = [
        'app/Config/App.php',
        'vendor/autoload.php',
        'vendor/codeigniter4/framework/system',
        'public/index.php'
    ];
    
    echo "<h3>📋 File Structure Check:</h3><ul>";
    foreach ($requiredFiles as $file) {
        $exists = file_exists($file);
        $status = $exists ? '✅' : '❌';
        echo "<li>{$status} {$file}</li>";
    }
    echo "</ul>";
    
    // Try to load Composer autoloader
    echo "<h3>🔄 Autoloader Test:</h3>";
    if (file_exists('vendor/autoload.php')) {
        require_once 'vendor/autoload.php';
        echo "<p>✅ Composer autoloader loaded successfully</p>";
        
        // Try to load CodeIgniter
        if (class_exists('CodeIgniter\\Config\\BaseConfig')) {
            echo "<p>✅ CodeIgniter BaseConfig class found</p>";
            
            // Try to load our App config
            if (file_exists('app/Config/App.php')) {
                // Set up basic paths first
                if (!defined('APPPATH')) {
                    define('APPPATH', __DIR__ . '/app/');
                }
                if (!defined('ROOTPATH')) {
                    define('ROOTPATH', __DIR__ . '/');
                }
                if (!defined('FCPATH')) {
                    define('FCPATH', __DIR__ . '/public/');
                }
                
                try {
                    require_once 'app/Config/App.php';
                    echo "<p>✅ App.php loaded successfully</p>";
                    
                    $appConfig = new \Config\App();
                    echo "<p>✅ App config instantiated successfully</p>";
                    echo "<p><strong>Base URL:</strong> " . ($appConfig->baseURL ?? 'Not set') . "</p>";
                    
                } catch (Exception $e) {
                    echo "<p>❌ Error loading App.php: " . $e->getMessage() . "</p>";
                }
            } else {
                echo "<p>❌ app/Config/App.php not found</p>";
            }
        } else {
            echo "<p>❌ CodeIgniter BaseConfig class not found</p>";
        }
    } else {
        echo "<p>❌ Composer autoloader not found</p>";
    }
    
    // Check PHP version
    echo "<h3>🐘 PHP Information:</h3>";
    echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
    echo "<p><strong>Required:</strong> >= 8.1</p>";
    
    if (version_compare(PHP_VERSION, '8.1.0', '>=')) {
        echo "<p>✅ PHP version is compatible</p>";
    } else {
        echo "<p>❌ PHP version too old</p>";
    }
    
    // Check database connection
    echo "<h3>🗄️ Database Connection Test:</h3>";
    if (file_exists('.env')) {
        $envContent = file_get_contents('.env');
        if (strpos($envContent, 'database.default.hostname') !== false) {
            echo "<p>✅ Database configuration found in .env</p>";
            
            // Try database connection
            try {
                $config = [
                    'host' => 'linux2917.grserver.gr',
                    'database' => 'customers_db2',
                    'username' => 'spik',
                    'password' => '0382sp@#'
                ];
                
                $pdo = new PDO(
                    "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4",
                    $config['username'],
                    $config['password']
                );
                
                echo "<p>✅ Database connection successful</p>";
                
                // Test a simple query
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM customers LIMIT 1");
                $result = $stmt->fetch();
                echo "<p>✅ Database query test successful</p>";
                
            } catch (PDOException $e) {
                echo "<p>❌ Database connection failed: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p>⚠️ Database configuration not found in .env</p>";
        }
    } else {
        echo "<p>❌ .env file not found</p>";
    }
    
    // Recommendations
    echo "<h3>💡 Recommendations:</h3>";
    echo "<ul>";
    echo "<li>Use the main application via <a href='public/index.php'>public/index.php</a></li>";
    echo "<li>Ensure .env file is properly configured</li>";
    echo "<li>Check file permissions on production server</li>";
    echo "<li>Use CodeIgniter's built-in routing system</li>";
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<h3>❌ Critical Error:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
}

echo "<hr><p><em>Generated: " . date('Y-m-d H:i:s') . "</em></p>";
?>