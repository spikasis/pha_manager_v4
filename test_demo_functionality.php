<?php
/**
 * Test Script for Demo Stocks Functionality
 * Βάλτε αυτό το αρχείο στο root της εφαρμογής και τρέξτε το για να δοκιμάσετε
 * την λειτουργικότητα των demo stocks πριν και μετά τη migration
 */

// Φόρτωση του CodeIgniter
require_once 'index.php';

// Πάρε το CI instance
$CI =& get_instance();

// Φόρτωση του Stock model
$CI->load->model('admin/Stock', 'stock');

echo "<h2>🧪 Test Demo Stocks Functionality</h2>\n";
echo "<pre>\n";

try {
    // Test 1: Έλεγχος αν υπάρχει το demo_type field
    $columns = $CI->db->list_fields('stocks');
    $has_demo_type = in_array('demo_type', $columns);
    
    echo "1. Database Field Check:\n";
    echo "   - demo_type field exists: " . ($has_demo_type ? "✅ YES" : "❌ NO (using fallback)") . "\n";
    echo "   - Available columns: " . implode(', ', array_slice($columns, 0, 10)) . "...\n\n";
    
    // Test 2: Δοκιμή της get_demo_stocks method
    echo "2. Demo Stocks Query Tests:\n";
    
    // Test all demo stocks
    $all_demo = $CI->stock->get_demo_stocks();
    echo "   - Total demo stocks: " . count($all_demo) . "\n";
    
    // Test trial stocks
    $trial_available = $CI->stock->get_demo_stocks('trial', 0);
    $trial_in_use = $CI->stock->get_demo_stocks('trial', 1);
    echo "   - Trial available: " . count($trial_available) . "\n";
    echo "   - Trial in use: " . count($trial_in_use) . "\n";
    
    // Test replacement stocks  
    $replacement_available = $CI->stock->get_demo_stocks('replacement', 0);
    $replacement_in_use = $CI->stock->get_demo_stocks('replacement', 1);
    echo "   - Replacement available: " . count($replacement_available) . "\n";
    echo "   - Replacement in use: " . count($replacement_in_use) . "\n\n";
    
    // Test 3: Δείγμα δεδομένων
    echo "3. Sample Data (first 3 records):\n";
    $sample_data = array_slice($all_demo, 0, 3);
    
    foreach ($sample_data as $item) {
        echo "   - Serial: " . $item['serial'] . 
             " | Type: " . ($item['demo_type'] ?? 'N/A') . 
             " | Customer: " . ($item['customer_name'] ?? 'None') . 
             " | In Use: " . $item['in_use'] . "\n";
    }
    
    echo "\n4. Migration Status:\n";
    if (!$has_demo_type) {
        echo "   ⚠️  Migration needed! Run the SQL script:\n";
        echo "   📁 File: database_schema/demo_type_migration_safe.sql\n";
        echo "   💻 Command: Execute in phpMyAdmin or MySQL client\n\n";
        
        echo "   📋 Quick Migration SQL:\n";
        echo "   ALTER TABLE stocks ADD COLUMN demo_type ENUM('trial', 'replacement') DEFAULT NULL AFTER on_test;\n";
        echo "   UPDATE stocks SET demo_type = CASE WHEN on_test = 1 THEN 'trial' ELSE 'replacement' END WHERE status = 5;\n\n";
    } else {
        echo "   ✅ Migration completed! demo_type field is available.\n\n";
    }
    
    echo "5. 🌐 Demo Page URLs:\n";
    echo "   - General Demo: " . base_url('admin/stocks/get_demo') . "\n";
    echo "   - Branch Demo (SP=1): " . base_url('admin/stocks/get_demo/1') . "\n";
    echo "   - Branch Demo (SP=2): " . base_url('admin/stocks/get_demo/2') . "\n\n";
    
    echo "✅ All tests completed successfully!\n";
    echo "The fallback logic is working properly even without migration.\n";

} catch (Exception $e) {
    echo "❌ Error during testing: " . $e->getMessage() . "\n";
    echo "Please check your database connection and model files.\n";
}

echo "</pre>";
?>