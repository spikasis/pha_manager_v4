<?php
// Debug controller method για get_demo
require_once 'index.php';

$CI =& get_instance();

header('Content-Type: text/html; charset=utf-8');

echo "<h2>🎯 Debug Controller get_demo Method</h2>";
echo "<pre>";

// Simulate the controller logic manually
$test_params = [null, '1', '2', '3', '5'];

foreach ($test_params as $param) {
    echo "\n=== Testing param: " . ($param ?: 'null') . " ===\n";
    
    // Reproduce controller logic
    $selling_point = null;
    if ($param && $param != 5) {
        $selling_point = $param;
    }
    
    echo "Selling point resolved to: " . ($selling_point ?: 'null') . "\n";
    
    // Test the actual calls
    $CI->load->model('admin/Stock', 'stock');
    
    try {
        $trial_available = $CI->stock->get_demo_stocks('trial', 0, $selling_point);
        $trial_in_use = $CI->stock->get_demo_stocks('trial', 1, $selling_point);
        $replacement_available = $CI->stock->get_demo_stocks('replacement', 0, $selling_point);
        $replacement_in_use = $CI->stock->get_demo_stocks('replacement', 1, $selling_point);
        
        echo "Results:\n";
        echo "  trial_available: " . count($trial_available) . "\n";
        echo "  trial_in_use: " . count($trial_in_use) . "\n";
        echo "  replacement_available: " . count($replacement_available) . "\n";
        echo "  replacement_in_use: " . count($replacement_in_use) . "\n";
        
        $total = count($trial_available) + count($trial_in_use) + 
                count($replacement_available) + count($replacement_in_use);
        echo "  TOTAL: $total\n";
        
        if ($total > 0 && count($trial_available) > 0) {
            echo "  First trial_available item:\n";
            $first = $trial_available[0];
            echo "    Serial: {$first['serial']}\n";
            echo "    Selling Point: {$first['selling_point']}\n";
            echo "    Demo Type: {$first['demo_type']}\n";
            echo "    Customer ID: " . ($first['customer_id'] ?: 'NULL') . "\n";
        }
        
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
}

// Test actual URL calls
echo "\n=== URL SIMULATION ===\n";
echo "When user clicks 'Demo Υποκαταστήματος':\n";
echo "- Admin users get prompt for selling point ID\n";
echo "- Branch users get their own selling point ID\n";
echo "- URL becomes: /admin/stocks/get_demo/{selling_point}\n";

// Check if demo_type field exists
echo "\n=== DATABASE FIELD CHECK ===\n";
$columns = $CI->db->list_fields('stocks');
$has_demo_type = in_array('demo_type', $columns);
echo "demo_type field exists: " . ($has_demo_type ? '✅ YES' : '❌ NO') . "\n";

if ($has_demo_type) {
    // Check demo_type values
    $demo_type_query = $CI->db->query("
        SELECT demo_type, COUNT(*) as count 
        FROM stocks 
        WHERE status = 5 
        GROUP BY demo_type
    ");
    
    if ($demo_type_query) {
        echo "demo_type distribution:\n";
        foreach ($demo_type_query->result_array() as $row) {
            $type = $row['demo_type'] ?: 'NULL';
            echo "  $type: {$row['count']} items\n";
        }
    }
}

echo "</pre>";

// Add navigation links
echo "<hr>";
echo "<h3>Test Links</h3>";
echo "<p>";
echo "<a href='/admin/stocks/get_demo' style='background: #28a745; color: white; padding: 8px 12px; text-decoration: none; margin-right: 10px;'>All Demos</a>";
echo "<a href='/admin/stocks/get_demo/1' style='background: #007bff; color: white; padding: 8px 12px; text-decoration: none; margin-right: 10px;'>SP 1 (Αθήνα)</a>";
echo "<a href='/admin/stocks/get_demo/2' style='background: #17a2b8; color: white; padding: 8px 12px; text-decoration: none; margin-right: 10px;'>SP 2 (Λιβαδειά)</a>";
echo "<a href='/admin/stocks/get_demo/3' style='background: #ffc107; color: black; padding: 8px 12px; text-decoration: none; margin-right: 10px;'>SP 3 (Θήβα)</a>";
echo "</p>";
?>