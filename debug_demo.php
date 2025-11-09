<?php
// Debug script για demo data
require_once 'index.php';

$CI =& get_instance();

// Get all demo stocks without filters
$query = $CI->db->query("
    SELECT 
        s.id, 
        s.serial, 
        s.status,
        ss.status as status_name,
        s.selling_point,
        sp.city as selling_point_name,
        s.demo_type,
        s.customer_id,
        CASE WHEN s.customer_id IS NULL THEN 'Διαθέσιμο' ELSE 'Σε χρήση' END as availability
    FROM stocks s
    LEFT JOIN stock_statuses ss ON s.status = ss.id  
    LEFT JOIN selling_points sp ON s.selling_point = sp.id
    WHERE s.status = 5
    ORDER BY s.selling_point, s.serial
");

$demos = $query->result_array();

echo "<h2>🔍 Debug Demo Stocks Data</h2>";
echo "<pre>";

echo "Συνολικά demo ακουστικά: " . count($demos) . "\n\n";

if (empty($demos)) {
    echo "❌ Δεν βρέθηκαν demo ακουστικά με status = 5!\n";
    
    // Check if there are any stocks with status 5 at all
    $total_query = $CI->db->query("SELECT COUNT(*) as count FROM stocks WHERE status = 5");
    $total_status_5 = $total_query->row()->count;
    echo "Συνολικά ακουστικά με status = 5: $total_status_5\n";
    
    // Check all statuses
    $all_statuses = $CI->db->query("SELECT status, COUNT(*) as count FROM stocks GROUP BY status ORDER BY status")->result_array();
    echo "\nΚατανομή ανά status:\n";
    foreach ($all_statuses as $status) {
        $status_query = $CI->db->query("SELECT status FROM stock_statuses WHERE id = ?", [$status['status']]);
        $status_name = $status_query->row();
        echo "Status {$status['status']} (" . ($status_name ? $status_name->status : 'Unknown') . "): {$status['count']} ακουστικά\n";
    }
    
} else {
    // Group by selling point
    $by_selling_point = [];
    foreach ($demos as $demo) {
        $sp = $demo['selling_point'] ?: 'NULL';
        if (!isset($by_selling_point[$sp])) {
            $by_selling_point[$sp] = [];
        }
        $by_selling_point[$sp][] = $demo;
    }
    
    foreach ($by_selling_point as $sp_id => $items) {
        $sp_name = $items[0]['selling_point_name'] ?: 'Άγνωστο';
        echo "📍 Υποκατάστημα $sp_id ($sp_name): " . count($items) . " demo ακουστικά\n";
        
        foreach ($items as $item) {
            echo "   - ID: {$item['id']}, Serial: {$item['serial']}, Demo Type: " . 
                 ($item['demo_type'] ?: 'NULL') . ", Status: {$item['availability']}\n";
        }
        echo "\n";
    }
}

echo "</pre>";
?>

<hr>
<p><a href="/admin/stocks/get_demo" style="background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">
    🔄 Test Demo Management Page
</a></p>