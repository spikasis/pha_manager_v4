<?php

// Database analyzer specifically for authentication tables
require_once __DIR__ . '/vendor/autoload.php';

echo "🔐 AUTHENTICATION SYSTEM ANALYSIS\n";
echo "================================\n\n";

try {
    $host = 'linux2917.grserver.gr';
    $port = 3306;
    $dbname = 'customers_db2';
    $username = 'customers_db2';
    $password = 'l=9_B+6Pva*8';
    
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Database connection successful\n\n";
    
    // Look for authentication-related tables
    $authTables = ['users', 'groups', 'users_groups', 'login_attempts', 'user_sessions'];
    
    foreach ($authTables as $table) {
        echo "🔍 Analyzing table: {$table}\n";
        echo str_repeat('-', 40) . "\n";
        
        // Check if table exists
        $stmt = $pdo->prepare("SHOW TABLES LIKE ?");
        $stmt->execute([$table]);
        
        if ($stmt->rowCount() > 0) {
            echo "✅ Table EXISTS\n";
            
            // Get table structure
            $stmt = $pdo->query("DESCRIBE {$table}");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "📋 Table Structure:\n";
            foreach ($columns as $column) {
                $nullable = $column['Null'] === 'YES' ? 'NULL' : 'NOT NULL';
                $default = $column['Default'] !== null ? "DEFAULT '{$column['Default']}'" : '';
                echo "  • {$column['Field']} ({$column['Type']}) {$nullable} {$default}\n";
            }
            
            // Get sample data count
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM {$table}");
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            echo "📊 Records count: {$count}\n";
            
            // Show sample data for users table
            if ($table === 'users' && $count > 0) {
                $stmt = $pdo->query("SELECT * FROM {$table} LIMIT 3");
                $samples = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "📄 Sample records:\n";
                foreach ($samples as $i => $record) {
                    echo "  Record " . ($i + 1) . ":\n";
                    foreach ($record as $key => $value) {
                        $displayValue = strlen($value) > 50 ? substr($value, 0, 47) . '...' : $value;
                        echo "    {$key}: {$displayValue}\n";
                    }
                }
            }
            
        } else {
            echo "❌ Table NOT FOUND\n";
        }
        echo "\n";
    }
    
    // Look for any other auth-related tables
    echo "🔎 Looking for other authentication tables...\n";
    $stmt = $pdo->query("SHOW TABLES");
    $allTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $authKeywords = ['auth', 'login', 'permission', 'role', 'session', 'token', 'password'];
    $foundTables = [];
    
    foreach ($allTables as $table) {
        foreach ($authKeywords as $keyword) {
            if (stripos($table, $keyword) !== false && !in_array($table, $authTables)) {
                $foundTables[] = $table;
                break;
            }
        }
    }
    
    if (!empty($foundTables)) {
        echo "📋 Additional authentication-related tables found:\n";
        foreach ($foundTables as $table) {
            echo "  • {$table}\n";
        }
    } else {
        echo "ℹ️  No additional authentication tables found\n";
    }
    
    echo "\n🎯 AUTHENTICATION SYSTEM RECOMMENDATIONS:\n";
    echo "=========================================\n";
    
    // Check if we have the basic ion_auth structure
    $hasUsers = in_array('users', $allTables);
    $hasGroups = in_array('groups', $allTables);
    $hasUsersGroups = in_array('users_groups', $allTables);
    
    if ($hasUsers && $hasGroups && $hasUsersGroups) {
        echo "✅ Ion Auth compatible structure detected!\n";
        echo "👍 Recommended: Use existing tables with custom CI4 auth system\n";
    } elseif ($hasUsers) {
        echo "⚠️  Users table exists but incomplete ion_auth structure\n";
        echo "👍 Recommended: Extend existing users table for CI4 auth\n";
    } else {
        echo "❌ No users table found\n";
        echo "👍 Recommended: Create new authentication system from scratch\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n✅ Authentication analysis completed!\n";