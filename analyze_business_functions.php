<?php
// Deep Business Analysis for PHA Manager v4 - Feature Planning

// Load environment variables
$envPath = __DIR__ . '/.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            putenv(trim($line));
        }
    }
}

// Database connection
$hostname = getenv('database.default.hostname') ?: 'linux2917.grserver.gr';
$database = getenv('database.default.database') ?: 'customers_db2';
$username = getenv('database.default.username') ?: 'spik';
$password = getenv('database.default.password') ?: '0382sp@#';
$port = getenv('database.default.port') ?: 3306;

echo "🔍 PHA MANAGER v4 - BUSINESS ANALYSIS & FEATURE PLANNING\n";
echo str_repeat("=", 80) . "\n\n";

try {
    $dsn = "mysql:host=$hostname;port=$port;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "✅ Connected to database: $database\n\n";
    
    // Get all tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = [];
    while ($row = $stmt->fetch()) {
        $tables[] = $row["Tables_in_$database"];
    }
    
    echo "📊 BUSINESS MODULES ANALYSIS\n";
    echo str_repeat("-", 50) . "\n";
    
    // Analyze each business area
    $businessModules = [
        'Customer Management' => ['customers', 'customer_'],
        'Doctor Management' => ['doctors', 'doctor_'],
        'Hearing Aid Products' => ['hearing_aids', 'products', 'models', 'brands'],
        'Sales & Orders' => ['sales', 'orders', 'invoices', 'receipts'],
        'Services & Repairs' => ['services', 'repairs', 'maintenance'],
        'Inventory & Stock' => ['stock', 'inventory', 'warehouse'],
        'Financial Management' => ['payments', 'transactions', 'billing'],
        'Appointments & Schedule' => ['appointments', 'calendar', 'schedule'],
        'Reports & Analytics' => ['reports', 'statistics', 'analytics'],
        'System & Settings' => ['settings', 'users', 'permissions', 'logs']
    ];
    
    foreach ($businessModules as $module => $keywords) {
        echo "\n🎯 $module:\n";
        $moduleTables = [];
        foreach ($tables as $table) {
            foreach ($keywords as $keyword) {
                if (stripos($table, $keyword) !== false) {
                    $moduleTables[] = $table;
                    break;
                }
            }
        }
        
        if (!empty($moduleTables)) {
            foreach ($moduleTables as $table) {
                // Get table structure and sample data
                $stmt = $pdo->query("DESCRIBE $table");
                $columns = $stmt->fetchAll();
                
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM $table");
                $count = $stmt->fetch()['count'];
                
                echo "  📋 $table ($count records)\n";
                
                // Show key columns
                $keyColumns = [];
                foreach ($columns as $col) {
                    if (stripos($col['Field'], 'id') !== false || 
                        stripos($col['Field'], 'name') !== false ||
                        stripos($col['Field'], 'status') !== false ||
                        stripos($col['Field'], 'date') !== false ||
                        stripos($col['Field'], 'type') !== false) {
                        $keyColumns[] = $col['Field'] . ' (' . $col['Type'] . ')';
                    }
                }
                if (!empty($keyColumns)) {
                    echo "     Key fields: " . implode(', ', array_slice($keyColumns, 0, 5)) . "\n";
                }
            }
        } else {
            echo "  ❌ No tables found - Needs to be created\n";
        }
    }
    
    echo "\n" . str_repeat("=", 80) . "\n";
    echo "📈 DETAILED TABLE ANALYSIS\n";
    echo str_repeat("-", 50) . "\n";
    
    foreach ($tables as $table) {
        echo "\n🗄️  TABLE: $table\n";
        
        // Get table structure
        $stmt = $pdo->query("DESCRIBE $table");
        $columns = $stmt->fetchAll();
        
        // Get record count
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM $table");
        $count = $stmt->fetch()['count'];
        
        echo "   📊 Records: $count\n";
        echo "   🏗️  Structure:\n";
        
        foreach ($columns as $col) {
            $key = $col['Key'] ? " [{$col['Key']}]" : "";
            $null = $col['Null'] === 'NO' ? " [NOT NULL]" : "";
            echo "      • {$col['Field']} - {$col['Type']}$key$null\n";
        }
        
        // Try to get sample data
        try {
            $stmt = $pdo->query("SELECT * FROM $table LIMIT 3");
            $samples = $stmt->fetchAll();
            if (!empty($samples)) {
                echo "   📝 Sample Data:\n";
                foreach ($samples as $i => $sample) {
                    echo "      Row " . ($i + 1) . ": ";
                    $sampleData = [];
                    foreach (array_slice($sample, 0, 3) as $key => $value) {
                        if (strlen($value) > 20) $value = substr($value, 0, 20) . '...';
                        $sampleData[] = "$key: $value";
                    }
                    echo implode(', ', $sampleData) . "\n";
                }
            }
        } catch (Exception $e) {
            echo "   ⚠️  Could not fetch sample data\n";
        }
    }
    
    echo "\n" . str_repeat("=", 80) . "\n";
    echo "🎯 RECOMMENDED FEATURES TO IMPLEMENT\n";
    echo str_repeat("-", 50) . "\n";
    
    // Analyze what features should be built based on tables
    $features = [];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM $table");
        $count = $stmt->fetch()['count'];
        
        if ($count > 0) {
            switch (true) {
                case stripos($table, 'customer') !== false:
                    $features['Customer Management'][] = "✅ $table management ($count records)";
                    break;
                case stripos($table, 'doctor') !== false:
                    $features['Doctor Management'][] = "✅ $table management ($count records)";
                    break;
                case stripos($table, 'hearing') !== false || stripos($table, 'product') !== false:
                    $features['Product Catalog'][] = "✅ $table management ($count records)";
                    break;
                case stripos($table, 'sale') !== false || stripos($table, 'order') !== false:
                    $features['Sales Management'][] = "✅ $table management ($count records)";
                    break;
                case stripos($table, 'service') !== false || stripos($table, 'repair') !== false:
                    $features['Service Management'][] = "✅ $table management ($count records)";
                    break;
                case stripos($table, 'stock') !== false || stripos($table, 'inventory') !== false:
                    $features['Inventory Management'][] = "✅ $table management ($count records)";
                    break;
                case stripos($table, 'payment') !== false || stripos($table, 'invoice') !== false:
                    $features['Financial Management'][] = "✅ $table management ($count records)";
                    break;
                case stripos($table, 'appointment') !== false:
                    $features['Appointment System'][] = "✅ $table management ($count records)";
                    break;
                default:
                    $features['Other Systems'][] = "✅ $table management ($count records)";
            }
        }
    }
    
    foreach ($features as $category => $items) {
        echo "\n🔧 $category:\n";
        foreach ($items as $item) {
            echo "   $item\n";
        }
    }
    
    echo "\n" . str_repeat("=", 80) . "\n";
    echo "📋 IMPLEMENTATION PRIORITY SUGGESTIONS\n";
    echo str_repeat("-", 50) . "\n";
    
    echo "\n🥇 HIGH PRIORITY (Core Business):\n";
    echo "   1. Customer CRUD operations\n";
    echo "   2. Service ticket management\n";
    echo "   3. Basic reporting dashboard\n";
    echo "   4. Doctor management\n";
    
    echo "\n🥈 MEDIUM PRIORITY (Operations):\n";
    echo "   5. Inventory/Stock tracking\n";
    echo "   6. Sales order processing\n";
    echo "   7. Payment tracking\n";
    echo "   8. Hearing aid catalog\n";
    
    echo "\n🥉 LOW PRIORITY (Advanced Features):\n";
    echo "   9. Appointment scheduling\n";
    echo "   10. Advanced analytics\n";
    echo "   11. User permissions\n";
    echo "   12. Automated workflows\n";
    
    echo "\n" . str_repeat("=", 80) . "\n";
    echo "✅ Analysis completed successfully!\n";
    echo "📊 Total tables analyzed: " . count($tables) . "\n";
    echo "🎯 Ready for feature development planning\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>