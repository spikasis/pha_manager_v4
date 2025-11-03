<?php
/**
 * Login Attempt Debug Script
 * Diagnose POST /auth/attempt-login 500 error
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Login Attempt Debug</h1>";
echo "<p><em>Debugging POST /auth/attempt-login 500 error</em></p>";

try {
    // Load Composer autoloader first
    if (file_exists('vendor/autoload.php')) {
        require_once 'vendor/autoload.php';
        echo "<p>✅ Autoloader loaded</p>";
    } else {
        die("<p>❌ Autoloader not found</p>");
    }

    // Set up basic CodeIgniter paths
    if (!defined('APPPATH')) {
        define('APPPATH', __DIR__ . '/app/');
    }
    if (!defined('ROOTPATH')) {
        define('ROOTPATH', __DIR__ . '/');
    }
    if (!defined('FCPATH')) {
        define('FCPATH', __DIR__ . '/public/');
    }
    if (!defined('WRITEPATH')) {
        define('WRITEPATH', __DIR__ . '/writable/');
    }

    echo "<h3>📋 Route Configuration Check</h3>";
    
    // Check Routes.php
    if (file_exists('app/Config/Routes.php')) {
        $routesContent = file_get_contents('app/Config/Routes.php');
        
        if (strpos($routesContent, 'attempt-login') !== false) {
            echo "<p>✅ Routes.php contains attempt-login route</p>";
            
            // Extract the specific route
            preg_match('/\$routes->post\([\'"].*attempt-login.*[\'"], [\'"].*[\'"].*\);/', $routesContent, $matches);
            if (!empty($matches)) {
                echo "<p><strong>Route found:</strong> <code>" . htmlspecialchars($matches[0]) . "</code></p>";
            }
        } else {
            echo "<p>❌ Routes.php missing attempt-login route</p>";
        }
    }

    echo "<h3>🎮 Controller Check</h3>";
    
    // Check Auth controller
    if (file_exists('app/Controllers/Auth.php')) {
        echo "<p>✅ Auth.php controller exists</p>";
        
        $authContent = file_get_contents('app/Controllers/Auth.php');
        if (strpos($authContent, 'function attemptLogin') !== false || 
            strpos($authContent, 'public function attemptLogin') !== false) {
            echo "<p>✅ attemptLogin method found</p>";
        } else {
            echo "<p>❌ attemptLogin method missing</p>";
        }
        
        // Check for potential syntax errors
        $syntaxCheck = shell_exec("php -l app/Controllers/Auth.php 2>&1");
        if (strpos($syntaxCheck, 'No syntax errors') !== false) {
            echo "<p>✅ Auth.php syntax is valid</p>";
        } else {
            echo "<p>❌ Auth.php syntax error:</p><pre>" . htmlspecialchars($syntaxCheck) . "</pre>";
        }
    } else {
        echo "<p>❌ Auth.php controller missing</p>";
    }

    echo "<h3>🗄️ Model Check</h3>";
    
    // Check UserModel
    if (file_exists('app/Models/UserModel.php')) {
        echo "<p>✅ UserModel exists</p>";
        
        $syntaxCheck = shell_exec("php -l app/Models/UserModel.php 2>&1");
        if (strpos($syntaxCheck, 'No syntax errors') !== false) {
            echo "<p>✅ UserModel syntax is valid</p>";
        } else {
            echo "<p>❌ UserModel syntax error:</p><pre>" . htmlspecialchars($syntaxCheck) . "</pre>";
        }
    }

    echo "<h3>🔧 Configuration Check</h3>";
    
    // Check .env file
    if (file_exists('.env')) {
        echo "<p>✅ .env file exists</p>";
        
        $envContent = file_get_contents('.env');
        
        // Check database config
        if (strpos($envContent, 'database.default.hostname') !== false) {
            echo "<p>✅ Database configuration found</p>";
        } else {
            echo "<p>⚠️ Database configuration may be missing</p>";
        }
        
        // Check environment
        if (strpos($envContent, 'CI_ENVIRONMENT = production') !== false) {
            echo "<p>⚠️ Environment is set to production - errors may be hidden</p>";
        } elseif (strpos($envContent, 'CI_ENVIRONMENT = development') !== false) {
            echo "<p>✅ Environment is set to development</p>";
        }
    } else {
        echo "<p>❌ .env file missing</p>";
    }

    echo "<h3>📊 Database Connection Test</h3>";
    
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
        
        // Test users table
        $stmt = $pdo->query("DESCRIBE users LIMIT 1");
        if ($stmt) {
            echo "<p>✅ Users table accessible</p>";
        } else {
            echo "<p>❌ Users table not accessible</p>";
        }
        
    } catch (PDOException $e) {
        echo "<p>❌ Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }

    echo "<h3>📝 Log Files Check</h3>";
    
    // Check for log files
    $logDir = 'writable/logs/';
    if (is_dir($logDir)) {
        $logFiles = glob($logDir . '*.log');
        if (!empty($logFiles)) {
            echo "<p>✅ Log files found: " . count($logFiles) . " files</p>";
            
            // Try to read the latest log
            $latestLog = end($logFiles);
            if (is_readable($latestLog)) {
                $logContent = file_get_contents($latestLog);
                
                // Look for recent errors
                $lines = explode("\n", $logContent);
                $recentErrors = array_slice($lines, -20); // Last 20 lines
                
                $hasErrors = false;
                foreach ($recentErrors as $line) {
                    if (stripos($line, 'error') !== false || 
                        stripos($line, 'exception') !== false ||
                        stripos($line, 'fatal') !== false) {
                        if (!$hasErrors) {
                            echo "<h4>🔥 Recent Error Log Entries:</h4><pre>";
                            $hasErrors = true;
                        }
                        echo htmlspecialchars($line) . "\n";
                    }
                }
                
                if ($hasErrors) {
                    echo "</pre>";
                } else {
                    echo "<p>✅ No recent errors in log file</p>";
                }
            }
        } else {
            echo "<p>⚠️ No log files found</p>";
        }
    } else {
        echo "<p>❌ Log directory not found</p>";
    }

    echo "<h3>💡 Recommended Actions</h3>";
    echo "<ol>";
    echo "<li>Check server error logs for detailed PHP errors</li>";
    echo "<li>Ensure CodeIgniter environment is properly set up</li>";
    echo "<li>Verify file permissions (especially writable/ directory)</li>";
    echo "<li>Test the route directly with a simple controller method</li>";
    echo "<li>Enable CodeIgniter debug mode temporarily</li>";
    echo "</ol>";

    echo "<h3>🧪 Test Simple Route</h3>";
    echo "<p>Try creating a simple test route to isolate the issue:</p>";
    echo "<pre>";
    echo "// In Routes.php:\n";
    echo "\$routes->post('test-login', function() {\n";
    echo "    return 'Login route works!';\n";
    echo "});\n";
    echo "</pre>";

} catch (Exception $e) {
    echo "<h3>❌ Debug Script Error:</h3>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
}

echo "<hr><p><em>Debug completed: " . date('Y-m-d H:i:s') . "</em></p>";
?>