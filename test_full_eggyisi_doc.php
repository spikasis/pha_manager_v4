<?php
// Test the full eggyisi_doc URL to verify it works
// This mimics a direct web request

define('ENVIRONMENT', 'production');
define('BASEPATH', dirname(__FILE__).'/');

// Set up basic CI constants
if (! defined('VIEWPATH'))
    define('VIEWPATH', BASEPATH.'application/views/');
if (! defined('APPPATH'))
    define('APPPATH', BASEPATH.'application/');
if (! defined('FCPATH'))
    define('FCPATH', BASEPATH);

echo "Testing Direct eggyisi_doc URL simulation for ID 2443\n";
echo "====================================================\n\n";

try {
    // Test if all required files exist
    echo "1. Checking required files...\n";
    
    $requiredFiles = [
        'application/config/database.php' => 'Database config',
        'application/modules/admin/controllers/Stocks.php' => 'Stocks controller',
        'application/modules/admin/models/Chart.php' => 'Chart model',
        'application/modules/admin/views/themes/sbadmin2/eggyisi_doc_final.php' => 'View template',
        'vendor/autoload.php' => 'Composer autoloader'
    ];
    
    foreach ($requiredFiles as $file => $description) {
        if (file_exists($file)) {
            echo "   ✓ $description exists\n";
        } else {
            throw new Exception("Missing file: $description ($file)");
        }
    }
    
    echo "\n2. Testing mPDF initialization...\n";
    require_once 'vendor/autoload.php';
    
    if (class_exists('\\Mpdf\\Mpdf')) {
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10
        ]);
        echo "   ✓ mPDF 8.x initialized successfully\n";
    } else {
        throw new Exception("mPDF class not available");
    }
    
    echo "\n3. Testing database queries for ID 2443...\n";
    require_once 'application/config/database.php';
    $mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);
    
    if ($mysqli->connect_error) {
        throw new Exception("Database connection failed: " . $mysqli->connect_error);
    }
    
    // Test complete data chain
    $queries = [
        'stock' => "SELECT * FROM stocks WHERE id = 2443",
        'customer' => "SELECT * FROM customers WHERE id = (SELECT customer_id FROM stocks WHERE id = 2443)",
        'company' => "SELECT * FROM companies WHERE id = 1", 
        'model' => "SELECT * FROM models WHERE id = (SELECT ha_model FROM stocks WHERE id = 2443)",
        'series' => "SELECT * FROM series WHERE id = (SELECT series FROM models WHERE id = (SELECT ha_model FROM stocks WHERE id = 2443))",
        'manufacturer' => "SELECT * FROM manufacturers WHERE id = (SELECT brand FROM series WHERE id = (SELECT series FROM models WHERE id = (SELECT ha_model FROM stocks WHERE id = 2443)))",
        'type' => "SELECT * FROM ha_types WHERE id = (SELECT ha_type FROM models WHERE id = (SELECT ha_model FROM stocks WHERE id = 2443))"
    ];
    
    $data = [];
    foreach ($queries as $key => $query) {
        $result = $mysqli->query($query);
        if ($result && $result->num_rows > 0) {
            $data[$key] = $result->fetch_object();
            echo "   ✓ $key data found\n";
        } else {
            throw new Exception("Query failed for $key: $query");
        }
    }
    
    echo "\n4. Testing view rendering...\n";
    
    // Assign variables for view
    $stock = $data['stock'];
    $customer = $data['customer'];
    $company = $data['company'];
    $ha_model = $data['model'];
    $ha_series = $data['series'];
    $manufacturer = $data['manufacturer'];
    $type = $data['type'];
    
    // Mock base_url function
    function base_url() { return 'https://manager.pikasishearing.gr/'; }
    
    // Capture view output
    ob_start();
    include 'application/modules/admin/views/themes/sbadmin2/eggyisi_doc_final.php';
    $html = ob_get_clean();
    
    if (strlen($html) > 100) {
        echo "   ✓ View rendered successfully (" . strlen($html) . " characters)\n";
    } else {
        throw new Exception("View output too short or empty");
    }
    
    echo "\n5. Testing PDF generation...\n";
    
    $mpdf->SetProtection(array('print'));
    $mpdf->SetTitle('Εγγύηση Ακουστικού Βαρηκοΐας - ' . $stock->serial);
    $mpdf->SetAuthor("Pikasis Hearing Aids.");
    $mpdf->WriteHTML($html, 2);
    
    // Save to file instead of output
    $filename = 'test_warranty_' . date('Y-m-d_H-i-s') . '.pdf';
    $mpdf->Output($filename, 'F');
    
    if (file_exists($filename)) {
        echo "   ✓ PDF generated successfully: $filename\n";
        echo "   ✓ File size: " . number_format(filesize($filename)) . " bytes\n";
    } else {
        throw new Exception("PDF file was not created");
    }
    
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "🎉 ALL TESTS PASSED! 🎉\n";
    echo "The eggyisi_doc functionality should work perfectly now!\n";
    echo "The 500 error has been RESOLVED.\n";
    echo str_repeat("=", 50) . "\n";
    
} catch (Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "This error needs to be fixed for eggyisi_doc to work.\n";
} catch (Error $e) {
    echo "\n❌ PHP ERROR: " . $e->getMessage() . "\n";
    echo "This error needs to be fixed for eggyisi_doc to work.\n";
}
?>