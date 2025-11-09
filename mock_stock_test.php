<?php
// Mock Stock Model για testing χωρίς database
class Mock_Stock {
    
    public function get_demo_stocks($demo_type = null, $in_use = null, $selling_point = null) {
        // Mock demo stocks data
        $mock_data = [
            [
                'id' => 1,
                'serial' => 'PH001234',
                'customer_id' => null,
                'day_out' => null,
                'day_in' => '2024-10-01',
                'on_test' => 1,
                'comments' => 'Demo ακουστικό για δοκιμές',
                'ha_price' => '1200.00',
                'selling_point' => 1,
                'model_name' => 'Audeo Paradise',
                'series_name' => 'Paradise',
                'manufacturer_name' => 'Phonak',
                'customer_name' => null,
                'in_use' => 0,
                'days_out' => null,
                'demo_type' => 'trial'
            ],
            [
                'id' => 2,
                'serial' => 'OT005678',
                'customer_id' => 15,
                'day_out' => '2024-10-15',
                'day_in' => '2024-09-20',
                'on_test' => 0,
                'comments' => 'Replacement demo',
                'ha_price' => '1450.00',
                'selling_point' => 1,
                'model_name' => 'More',
                'series_name' => 'More',
                'manufacturer_name' => 'Oticon',
                'customer_name' => 'Γιάννης Παπαδόπουλος',
                'in_use' => 1,
                'days_out' => 25,
                'demo_type' => 'replacement'
            ],
            [
                'id' => 3,
                'serial' => 'RH002345',
                'customer_id' => null,
                'day_out' => null,
                'day_in' => '2024-10-10',
                'on_test' => 0,
                'comments' => 'Replacement διαθέσιμο',
                'ha_price' => '1350.00',
                'selling_point' => 2,  // Λιβαδειά
                'model_name' => 'Quattro',
                'series_name' => 'Quattro',
                'manufacturer_name' => 'ReSound',
                'customer_name' => null,
                'in_use' => 0,
                'days_out' => null,
                'demo_type' => 'replacement'
            ],
            [
                'id' => 4,
                'serial' => 'WX003456',
                'customer_id' => 22,
                'day_out' => '2024-11-01',
                'day_in' => '2024-10-05',
                'on_test' => 1,
                'comments' => 'Trial σε χρήση',
                'ha_price' => '1100.00',
                'selling_point' => 3,  // Θήβα
                'model_name' => 'Moment',
                'series_name' => 'Moment',
                'manufacturer_name' => 'Widex',
                'customer_name' => 'Μαρία Κωνσταντίνου',
                'in_use' => 1,
                'days_out' => 8,
                'demo_type' => 'trial'
            ]
        ];
        
        // Apply filters
        $filtered = array_filter($mock_data, function($item) use ($demo_type, $in_use, $selling_point) {
            // Filter by demo_type
            if ($demo_type !== null && $item['demo_type'] !== $demo_type) {
                return false;
            }
            
            // Filter by in_use status
            if ($in_use !== null && $item['in_use'] != $in_use) {
                return false;
            }
            
            // Filter by selling_point
            if ($selling_point !== null && $item['selling_point'] != $selling_point) {
                return false;
            }
            
            return true;
        });
        
        return array_values($filtered);  // Re-index array
    }
    
    public function update_demo_type($stock_id, $demo_type) {
        // Mock update - always return success
        return in_array($demo_type, ['trial', 'replacement']);
    }
}

// Usage example:
if (basename($_SERVER['SCRIPT_NAME']) == 'mock_stock_test.php') {
    header('Content-Type: text/html; charset=utf-8');
    
    echo "<h2>🧪 Mock Stock Model Test</h2>";
    echo "<pre>";
    
    $mock = new Mock_Stock();
    
    echo "=== ALL DEMO STOCKS ===\n";
    $all = $mock->get_demo_stocks();
    foreach ($all as $item) {
        echo "- {$item['serial']} ({$item['demo_type']}) - SP: {$item['selling_point']} - " . 
             ($item['in_use'] ? 'In Use' : 'Available') . "\n";
    }
    
    echo "\n=== TRIAL AVAILABLE (SP: 1) ===\n";
    $trial_sp1 = $mock->get_demo_stocks('trial', 0, 1);
    echo "Count: " . count($trial_sp1) . "\n";
    foreach ($trial_sp1 as $item) {
        echo "- {$item['serial']}: {$item['manufacturer_name']} {$item['model_name']}\n";
    }
    
    echo "\n=== REPLACEMENT IN USE (SP: 1) ===\n";
    $repl_use_sp1 = $mock->get_demo_stocks('replacement', 1, 1);
    echo "Count: " . count($repl_use_sp1) . "\n";
    foreach ($repl_use_sp1 as $item) {
        echo "- {$item['serial']}: {$item['customer_name']}\n";
    }
    
    echo "\n=== BY SELLING POINT ===\n";
    for ($sp = 1; $sp <= 3; $sp++) {
        $sp_items = $mock->get_demo_stocks(null, null, $sp);
        $sp_names = ['', 'Αθήνα', 'Λιβαδειά', 'Θήβα'];
        echo "SP $sp ({$sp_names[$sp]}): " . count($sp_items) . " items\n";
    }
    
    echo "</pre>";
}
?>