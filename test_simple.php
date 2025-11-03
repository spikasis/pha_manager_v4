<?php
// Simple database test without CodeIgniter framework initialization

require_once 'app/Config/Database.php';

try {
    // Get database configuration
    $config = \Config\Database::config();
    
    echo "Testing database connection...\n";
    echo "Database: " . $config['default']['database'] . "\n";
    echo "Host: " . $config['default']['hostname'] . "\n";
    
    // Create PDO connection directly
    $dsn = "mysql:host=" . $config['default']['hostname'] . ";dbname=" . $config['default']['database'] . ";charset=" . $config['default']['charset'];
    $pdo = new PDO($dsn, $config['default']['username'], $config['default']['password']);
    
    echo "✓ Database connection: SUCCESS\n";
    
    // Test users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Users table: EXISTS\n";
        
        // Test query similar to findByLogin
        $stmt = $pdo->prepare("SELECT * FROM users WHERE (email = :login OR username = :login2) LIMIT 1");
        $stmt->bindParam(':login', $testLogin);
        $stmt->bindParam(':login2', $testLogin);
        $testLogin = 'admin@example.com';
        
        $stmt->execute();
        echo "✓ Query test: SUCCESS\n";
        echo "Rows found: " . $stmt->rowCount() . "\n";
        
    } else {
        echo "✗ Users table: NOT FOUND\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
?>