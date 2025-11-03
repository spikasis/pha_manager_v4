<?php

// Simple test to check if we can bypass the intl issue
require_once __DIR__ . '/vendor/autoload.php';

// Try to initialize basic CodeIgniter without the problematic parts
echo "Testing PHP setup...\n";
echo "PHP Version: " . PHP_VERSION . "\n";

// Check if we can use DateTime (alternative to intl-dependent time functions)
$now = new DateTime();
echo "Current time: " . $now->format('Y-m-d H:i:s') . "\n";

// Test database connection
try {
    $host = 'linux2917.grserver.gr';
    $port = 3306;
    $dbname = 'customers_db2';
    $username = 'customers_db2';
    $password = 'l=9_B+6Pva*8';
    
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connection: SUCCESS\n";
    
    // Test a simple query
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM customers LIMIT 1");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Customer count: " . $result['count'] . "\n";
    
} catch (Exception $e) {
    echo "Database connection: FAILED - " . $e->getMessage() . "\n";
}

echo "Basic test completed.\n";