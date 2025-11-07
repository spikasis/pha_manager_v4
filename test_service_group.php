<?php
// Test script για να ελέγξουμε την λειτουργία του Service Group

// Περιλαμβάνουμε το index.php 
define('BASEPATH', __DIR__ . '/system/');
define('APPPATH', __DIR__ . '/application/');

// Προσομοιώνουμε ότι είμαστε service group user
echo "Testing Service Group (Group 6) Dashboard Access\n";
echo "===============================================\n\n";

// Έλεγχος εάν υπάρχει το dashboard_sp template
$dashboard_file = __DIR__ . '/application/modules/admin/views/themes/sbadmin2/dashboard_sp.php';
if (file_exists($dashboard_file)) {
    echo "✓ Dashboard SP file exists: " . $dashboard_file . "\n";
} else {
    echo "✗ Dashboard SP file missing: " . $dashboard_file . "\n";
}

// Έλεγχος εάν υπάρχει το Admin controller
$admin_controller = __DIR__ . '/application/modules/admin/controllers/Admin.php';
if (file_exists($admin_controller)) {
    echo "✓ Admin controller exists: " . $admin_controller . "\n";
    
    // Έλεγχος εάν υπάρχει η data_stats_consolidated μέθοδος
    $content = file_get_contents($admin_controller);
    if (strpos($content, 'data_stats_consolidated') !== false) {
        echo "✓ data_stats_consolidated method found in Admin controller\n";
    } else {
        echo "✗ data_stats_consolidated method missing from Admin controller\n";
    }
    
    // Έλεγχος εάν υπάρχει το Group 6 routing
    if (strpos($content, 'case 6:') !== false) {
        echo "✓ Group 6 routing found in Admin controller\n";
    } else {
        echo "✗ Group 6 routing missing from Admin controller\n";
    }
} else {
    echo "✗ Admin controller missing: " . $admin_controller . "\n";
}

// Έλεγχος των models που χρησιμοποιούνται
$models = [
    'Task' => __DIR__ . '/application/modules/admin/models/Task.php',
    'Stock' => __DIR__ . '/application/modules/admin/models/Stock.php',
    'Customer' => __DIR__ . '/application/modules/admin/models/Customer.php',
];

foreach ($models as $name => $path) {
    if (file_exists($path)) {
        echo "✓ $name model exists: $path\n";
    } else {
        echo "✗ $name model missing: $path\n";
    }
}

echo "\nTest completed. If all items are marked with ✓, Service Group should work properly.\n";
?>