<?php

// Simple database connection test for PHA Manager v4
// This file should be deleted after successful connection

echo "=== PHA Manager v4 Database Connection Test ===\n\n";

// Database settings from .env
$hostname = 'localhost';
$database = 'pha_manager_v4';
$username = 'root';  // Change this to your MySQL username
$password = '';      // Change this to your MySQL password
$port = 3306;

echo "Testing connection to MySQL...\n";
echo "Host: $hostname\n";
echo "Database: $database\n";
echo "Username: $username\n";
echo "Port: $port\n\n";

try {
    // Test basic MySQL connection
    $pdo = new PDO(
        "mysql:host=$hostname;port=$port;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    
    echo "✅ MySQL Connection: SUCCESS\n";
    
    // Check if database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE '$database'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Database '$database': EXISTS\n";
        
        // Test connection to specific database
        $pdo_db = new PDO(
            "mysql:host=$hostname;port=$port;dbname=$database;charset=utf8mb4",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
        echo "✅ Database Connection: SUCCESS\n";
        
    } else {
        echo "❌ Database '$database': NOT FOUND\n";
        echo "Creating database...\n";
        
        $pdo->exec("CREATE DATABASE `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
        echo "✅ Database '$database': CREATED\n";
    }
    
    echo "\n🎉 Database setup is ready!\n";
    echo "\nNext steps:\n";
    echo "1. Update .env with your correct database credentials\n";
    echo "2. Run: php spark migrate (when ready)\n";
    echo "3. Run: php spark serve\n";
    echo "4. Delete this test file: database_test.php\n";
    
} catch (PDOException $e) {
    echo "❌ Database Connection FAILED: " . $e->getMessage() . "\n";
    echo "\nTroubleshooting:\n";
    echo "1. Make sure MySQL/XAMPP is running\n";
    echo "2. Check your username/password in this file\n";
    echo "3. Update .env file with correct credentials\n";
    echo "4. Make sure MySQL is listening on port $port\n";
}

echo "\n=== Test Complete ===\n";
?>