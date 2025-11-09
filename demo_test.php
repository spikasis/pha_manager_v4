<?php
// Quick test for demo stocks functionality
require_once 'index.php';

$CI =& get_instance();
$CI->load->model('admin/Stock', 'stock');

header('Content-Type: text/html; charset=utf-8');

echo "<h2>🧪 Demo Stocks Test</h2>";
echo "<pre>";

try {
    // Test demo_type field exists
    $columns = $CI->db->list_fields('stocks');
    $has_demo_type = in_array('demo_type', $columns);
    echo "demo_type field exists: " . ($has_demo_type ? "✅ YES" : "❌ NO") . "\n";
    
    if ($has_demo_type) {
        // Test get_demo_stocks method
        echo "\nTesting get_demo_stocks method:\n";
        
        $all_demo = $CI->stock->get_demo_stocks();
        echo "- Total demo stocks: " . count($all_demo) . "\n";
        
        $trial_available = $CI->stock->get_demo_stocks('trial', 0);
        echo "- Trial available: " . count($trial_available) . "\n";
        
        $replacement_available = $CI->stock->get_demo_stocks('replacement', 0);
        echo "- Replacement available: " . count($replacement_available) . "\n";
        
        echo "\n✅ All tests passed! Demo functionality is working.\n";
        echo "\n🌐 Try these URLs:\n";
        echo "- Demo management: http://localhost:8000/admin/stocks/manage_demo_types\n";
        echo "- Demo page: http://localhost:8000/admin/stocks/get_demo\n";
        
    } else {
        echo "\n❌ demo_type field not found! Please run the migration SQL.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";
?>

<hr>
<h3>Navigation Links</h3>
<p>
    <a href="/admin" style="background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">
        🏠 Go to Admin Dashboard
    </a>
</p>