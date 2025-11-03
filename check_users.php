<?php
// Quick database check for users

$host = 'localhost';
$dbname = 'phadb';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Database connection successful\n";
    
    // Check if users table exists and has data
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $count = $stmt->fetch()['count'];
    echo "✓ Users in table: $count\n";
    
    if ($count > 0) {
        // Show first few users
        $stmt = $pdo->query("SELECT id, username, email, first_name, last_name, active FROM users LIMIT 3");
        echo "Sample users:\n";
        while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- ID: {$user['id']}, Username: {$user['username']}, Email: {$user['email']}, Active: {$user['active']}\n";
        }
    } else {
        echo "No users found. You may need to create a test user.\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
}
?>