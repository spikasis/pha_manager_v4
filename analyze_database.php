<?php

// Database Structure Analyzer for CI3 to CI4 Migration
// This script will help analyze your existing database structure

echo "=== PHA Manager CI3 Database Structure Analyzer ===\n\n";

// Existing CI3 database credentials
$hostname = 'linux2917.grserver.gr';
$database = 'customers_db2';
$username = 'spik';
$password = '0382sp@#';
$port = 3306;

echo "Analyzing database: $database\n";
echo "Host: $hostname:$port\n\n";

try {
    // Create MySQLi connection
    $mysqli = new mysqli($hostname, $username, $password, $database, $port);
    
    // Check for connection errors
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    echo "✅ Connected to existing database successfully!\n\n";
    
    // Get all tables
    $result = $mysqli->query("SHOW TABLES");
    $tables = [];
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }
    
    echo "📊 Found " . count($tables) . " tables:\n";
    echo str_repeat("-", 50) . "\n";
    
    foreach ($tables as $table) {
        echo "📋 Table: $table\n";
        
        // Get table structure
        $result = $mysqli->query("DESCRIBE `$table`");
        
        while ($column = $result->fetch_assoc()) {
            $null = $column['Null'] == 'YES' ? 'NULL' : 'NOT NULL';
            $key = $column['Key'] ? "({$column['Key']})" : '';
            $extra = $column['Extra'] ? "({$column['Extra']})" : '';
            
            echo "  └── {$column['Field']}: {$column['Type']} $null $key $extra\n";
        }
        
        // Get row count
        $countResult = $mysqli->query("SELECT COUNT(*) as count FROM `$table`");
        $count = $countResult->fetch_assoc()['count'];
        echo "  └── Records: $count\n";
        
        echo "\n";
    }
    
    echo "\n🎯 Migration Recommendations:\n";
    echo str_repeat("-", 50) . "\n";
    
    // Check for common CI3 patterns
    $recommendations = [];
    
    foreach ($tables as $table) {
        // Check if it's a typical CI3 table pattern
        if (strpos($table, 'ci_sessions') !== false) {
            $recommendations[] = "✅ Found CI3 sessions table: $table - Can be migrated to CI4 session handling";
        }
        
        // Check for user/auth tables
        if (strpos($table, 'user') !== false || strpos($table, 'auth') !== false) {
            $recommendations[] = "👤 Found user/auth table: $table - Will need authentication migration";
        }
        
        // Check for typical medical/patient tables
        if (strpos($table, 'patient') !== false) {
            $recommendations[] = "🏥 Found patient table: $table - Create PatientModel in CI4";
        }
        
        if (strpos($table, 'appointment') !== false) {
            $recommendations[] = "📅 Found appointment table: $table - Create AppointmentModel in CI4";
        }
        
        if (strpos($table, 'doctor') !== false || strpos($table, 'physician') !== false) {
            $recommendations[] = "👨‍⚕️ Found doctor table: $table - Create DoctorModel in CI4";
        }
    }
    
    if (empty($recommendations)) {
        echo "ℹ️  No specific patterns detected. Manual analysis needed.\n";
    } else {
        foreach ($recommendations as $rec) {
            echo "$rec\n";
        }
    }
    
    echo "\n📝 Next Steps:\n";
    echo "1. Update .env file with these database credentials\n";
    echo "2. Create CI4 Models for each table\n";
    echo "3. Migrate Controllers to work with existing data\n";
    echo "4. Update Views for Bootstrap 4 compatibility\n";
    
} catch (Exception $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
    echo "\nPlease check:\n";
    echo "1. Database server is accessible from your location\n";
    echo "2. Credentials are correct\n";
    echo "3. Firewall/network allows connection to linux2917.grserver.gr:3306\n";
} finally {
    if (isset($mysqli)) {
        $mysqli->close();
    }
}

echo "\n=== Analysis Complete ===\n";
?>