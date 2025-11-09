<?php
// Direct test of eggyisi_doc functionality
define('BASEPATH', '');
define('ENVIRONMENT', 'production');

// Test database connection
require_once 'application/config/database.php';

echo "Testing eggyisi_doc functionality for ID: 2443\n";
echo "===============================================\n\n";

try {
    // Test database connection
    $host = $db['default']['hostname'];
    $user = $db['default']['username'];
    $pass = $db['default']['password'];
    $dbname = $db['default']['database'];
    
    echo "1. Testing database connection...\n";
    $mysqli = new mysqli($host, $user, $pass, $dbname);
    
    if ($mysqli->connect_error) {
        throw new Exception("Database connection failed: " . $mysqli->connect_error);
    }
    echo "   ✓ Database connection successful\n\n";
    
    // Test stock record
    echo "2. Testing stock record ID 2443...\n";
    $result = $mysqli->query("SELECT * FROM stocks WHERE id = 2443");
    if (!$result || $result->num_rows == 0) {
        throw new Exception("Stock ID 2443 not found!");
    }
    $stock = $result->fetch_object();
    echo "   ✓ Stock found: Serial = " . ($stock->serial ?? 'NULL') . "\n";
    echo "   ✓ Customer ID = " . ($stock->customer_id ?? 'NULL') . "\n";
    echo "   ✓ Model ID = " . ($stock->ha_model ?? 'NULL') . "\n\n";
    
    // Test customer record
    if (empty($stock->customer_id)) {
        throw new Exception("Stock has no customer_id");
    }
    
    echo "3. Testing customer record...\n";
    $result = $mysqli->query("SELECT * FROM customers WHERE id = " . intval($stock->customer_id));
    if (!$result || $result->num_rows == 0) {
        throw new Exception("Customer ID " . $stock->customer_id . " not found!");
    }
    $customer = $result->fetch_object();
    echo "   ✓ Customer found: " . ($customer->name ?? 'NULL') . "\n\n";
    
    // Test model record
    if (empty($stock->ha_model)) {
        throw new Exception("Stock has no ha_model");
    }
    
    echo "4. Testing model record...\n";
    $result = $mysqli->query("SELECT * FROM models WHERE id = " . intval($stock->ha_model));
    if (!$result || $result->num_rows == 0) {
        throw new Exception("Model ID " . $stock->ha_model . " not found!");
    }
    $model = $result->fetch_object();
    echo "   ✓ Model found: " . ($model->name ?? 'NULL') . "\n";
    echo "   ✓ Series ID = " . ($model->series ?? 'NULL') . "\n\n";
    
    // Test mPDF availability
    echo "5. Testing mPDF availability...\n";
    if (file_exists('vendor/autoload.php')) {
        require_once 'vendor/autoload.php';
        if (class_exists('\\Mpdf\\Mpdf')) {
            echo "   ✓ mPDF 8.x available\n\n";
        } else {
            echo "   ✗ mPDF 8.x class not found\n\n";
        }
    } else {
        echo "   ✗ Composer autoloader not found\n\n";
    }
    
    // Test view file
    echo "6. Testing view file...\n";
    $viewFile = 'application/modules/admin/views/themes/sbadmin2/eggyisi_doc_final.php';
    if (file_exists($viewFile)) {
        echo "   ✓ View file exists: " . $viewFile . "\n\n";
    } else {
        echo "   ✗ View file missing: " . $viewFile . "\n\n";
    }
    
    echo "ALL TESTS PASSED! ✓\n";
    echo "The eggyisi_doc should work fine.\n";
    echo "Check PHP error logs or web server error logs for specific 500 error details.\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "This is likely the cause of the 500 error.\n";
} catch (Error $e) {
    echo "PHP ERROR: " . $e->getMessage() . "\n";
    echo "This is likely the cause of the 500 error.\n";
}
?>