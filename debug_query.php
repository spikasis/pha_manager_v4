<?php
// Debug script για το get_demo_stocks query
require_once 'index.php';

$CI =& get_instance();
$CI->load->model('admin/Stock', 'stock');

header('Content-Type: text/html; charset=utf-8');

echo "<h2>🔍 Debug Demo Stocks Query</h2>";
echo "<pre>";

// Test parameters που πέρνει από το sidemenu
$selling_points = [1, 2, 3]; // Αθήνα, Λιβαδειά, Θήβα
$demo_types = ['trial', 'replacement'];
$in_use_states = [0, 1]; // Available, In Use

echo "=== TESTING ALL COMBINATIONS ===\n";

foreach ($selling_points as $sp) {
    echo "\n📍 SELLING POINT $sp:\n";
    
    // Test total για το selling point
    $total_for_sp = $CI->stock->get_demo_stocks(null, null, $sp);
    echo "   Total demos: " . count($total_for_sp) . "\n";
    
    foreach ($demo_types as $type) {
        foreach ($in_use_states as $use) {
            $use_text = $use ? 'In Use' : 'Available';
            $result = $CI->stock->get_demo_stocks($type, $use, $sp);
            echo "   $type $use_text: " . count($result) . " items\n";
            
            // Show first 2 items for debugging
            if (count($result) > 0) {
                for ($i = 0; $i < min(2, count($result)); $i++) {
                    $item = $result[$i];
                    echo "     - {$item['serial']} (SP: {$item['selling_point']}, Type: {$item['demo_type']}, Customer: " . 
                         ($item['customer_id'] ?: 'NULL') . ")\n";
                }
                if (count($result) > 2) {
                    echo "     ... and " . (count($result) - 2) . " more\n";
                }
            }
        }
    }
}

echo "\n=== TESTING GENERAL QUERIES ===\n";

// Test χωρίς selling point filter
$all_demos = $CI->stock->get_demo_stocks();
echo "Total demos (no SP filter): " . count($all_demos) . "\n";

$all_trial = $CI->stock->get_demo_stocks('trial');
echo "Total trial demos: " . count($all_trial) . "\n";

$all_replacement = $CI->stock->get_demo_stocks('replacement'); 
echo "Total replacement demos: " . count($all_replacement) . "\n";

// Check selling point distribution
echo "\n=== SELLING POINT DISTRIBUTION ===\n";
$sp_counts = [];
foreach ($all_demos as $demo) {
    $sp = $demo['selling_point'] ?: 'NULL';
    $sp_counts[$sp] = ($sp_counts[$sp] ?? 0) + 1;
}

foreach ($sp_counts as $sp => $count) {
    echo "Selling Point $sp: $count items\n";
}

// Test raw SQL query  
echo "\n=== RAW SQL TEST ===\n";
$raw_query = "
SELECT 
    s.selling_point,
    s.demo_type,
    CASE WHEN s.customer_id IS NULL THEN 'Available' ELSE 'In Use' END as usage_status,
    COUNT(*) as count
FROM stocks s
WHERE s.status = 5
GROUP BY s.selling_point, s.demo_type, usage_status
ORDER BY s.selling_point, s.demo_type
";

$raw_result = $CI->db->query($raw_query);
if ($raw_result) {
    echo "Raw query results:\n";
    foreach ($raw_result->result_array() as $row) {
        echo "SP: {$row['selling_point']}, Type: {$row['demo_type']}, Status: {$row['usage_status']}, Count: {$row['count']}\n";
    }
} else {
    echo "Raw query failed: " . $CI->db->error()['message'] . "\n";
}

echo "</pre>";

echo "<hr>";
echo "<p>Debug για το sidemenu Demo Υποκαταστήματος</p>";
echo "<p><a href='/admin/stocks/get_demo/1'>Test SP 1</a> | ";
echo "<a href='/admin/stocks/get_demo/2'>Test SP 2</a> | ";
echo "<a href='/admin/stocks/get_demo/3'>Test SP 3</a></p>";
?>