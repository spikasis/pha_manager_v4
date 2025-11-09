<?php
// Debug script για Payment Reminders

echo "<h2>Payment Reminders Debug</h2>\n";

// Check if module files exist
$controller_path = __DIR__ . '/application/modules/admin/controllers/Payment_reminders.php';
$model_path = __DIR__ . '/application/modules/admin/models/Payment_reminders_model.php';
$view_path = __DIR__ . '/application/modules/admin/views/themes/sbadmin2/payment_reminders_dashboard.php';

echo "<h3>Files Check:</h3>\n";
echo "Controller: " . (file_exists($controller_path) ? "✓ EXISTS" : "✗ MISSING") . " - $controller_path\n<br>";
echo "Model: " . (file_exists($model_path) ? "✓ EXISTS" : "✗ MISSING") . " - $model_path\n<br>";
echo "View: " . (file_exists($view_path) ? "✓ EXISTS" : "✗ MISSING") . " - $view_path\n<br>";

// Check HMVC setup
echo "<h3>HMVC Check:</h3>\n";
$hmvc_path = __DIR__ . '/application/third_party/MX/';
echo "HMVC Directory: " . (is_dir($hmvc_path) ? "✓ EXISTS" : "✗ MISSING") . " - $hmvc_path\n<br>";

if (is_dir($hmvc_path)) {
    $hmvc_files = scandir($hmvc_path);
    echo "HMVC Files: " . implode(', ', array_filter($hmvc_files, function($f) { return $f != '.' && $f != '..'; })) . "\n<br>";
}

// Check modules location
echo "<h3>Modules Location:</h3>\n";
$modules_path = __DIR__ . '/application/modules/';
echo "Modules Directory: " . (is_dir($modules_path) ? "✓ EXISTS" : "✗ MISSING") . " - $modules_path\n<br>";

if (is_dir($modules_path)) {
    $modules = scandir($modules_path);
    echo "Available Modules: " . implode(', ', array_filter($modules, function($f) { return $f != '.' && $f != '..'; })) . "\n<br>";
}

// Check admin module structure
echo "<h3>Admin Module Structure:</h3>\n";
$admin_module = __DIR__ . '/application/modules/admin/';
if (is_dir($admin_module)) {
    echo "Controllers: ";
    $controllers_path = $admin_module . 'controllers/';
    if (is_dir($controllers_path)) {
        $controllers = array_filter(scandir($controllers_path), function($f) { 
            return $f != '.' && $f != '..' && substr($f, -4) == '.php'; 
        });
        echo implode(', ', $controllers) . "\n<br>";
    } else {
        echo "✗ MISSING\n<br>";
    }
    
    echo "Models: ";
    $models_path = $admin_module . 'models/';
    if (is_dir($models_path)) {
        $models = array_filter(scandir($models_path), function($f) { 
            return $f != '.' && $f != '..' && substr($f, -4) == '.php'; 
        });
        echo implode(', ', $models) . "\n<br>";
    } else {
        echo "✗ MISSING\n<br>";
    }
}

// Check database table
echo "<h3>Database Check:</h3>\n";
try {
    // Simple connection test
    $config_path = __DIR__ . '/application/config/database.php';
    if (file_exists($config_path)) {
        echo "Database config: ✓ EXISTS\n<br>";
        include $config_path;
        if (isset($db['default'])) {
            echo "Default DB Config: ✓ FOUND\n<br>";
            echo "Database: " . $db['default']['database'] . "\n<br>";
            echo "Host: " . $db['default']['hostname'] . "\n<br>";
        }
    }
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n<br>";
}

echo "<h3>URL Testing:</h3>\n";
echo "Direct URL to test: <a href='/index.php/admin/payment_reminders' target='_blank'>http://localhost:8000/index.php/admin/payment_reminders</a>\n<br>";
echo "Without index.php: <a href='/admin/payment_reminders' target='_blank'>http://localhost:8000/admin/payment_reminders</a>\n<br>";

?>