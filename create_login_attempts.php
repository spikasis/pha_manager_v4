<?php
/**
 * Create Login Attempts Table Script
 */

// Direct database connection for table creation
$host = 'linux2917.grserver.gr';
$username = 'spik';
$password = '0382sp@#';
$database = 'customers_db2';

try {
    $dsn = "mysql:host={$host};dbname={$database};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    // Check if table exists
    $checkTable = $pdo->query("SHOW TABLES LIKE 'login_attempts'")->rowCount();
    
    if ($checkTable > 0) {
        echo "✅ Table 'login_attempts' already exists!\n";
    } else {
        // Create login_attempts table
        $sql = "CREATE TABLE `login_attempts` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `ip_address` varchar(15) NOT NULL,
            `login` varchar(100) NOT NULL,
            `time` int(11) UNSIGNED DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        echo "✅ Table 'login_attempts' created successfully!\n";
    }
    
    // Verify table structure
    $result = $pdo->query("DESCRIBE login_attempts");
    $fields = $result->fetchAll(PDO::FETCH_ASSOC);
    
    echo "\n📊 Table structure:\n";
    foreach ($fields as $field) {
        echo "- {$field['Field']}: {$field['Type']}\n";
    }
    
    echo "\n✅ Login attempts table is ready!\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>