<?php
/**
 * Quick User Password Reset Script
 */

echo "<h1>🔑 User Password Reset</h1>";
echo "<style>body { font-family: Arial, sans-serif; margin: 20px; }</style>";

// Database connection
$host = 'linux2917.grserver.gr';
$username = 'spik';
$password = '0382sp@#';
$database = 'customers_db2';

try {
    $dsn = "mysql:host={$host};dbname={$database};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    echo "<h2>📋 Available Users:</h2>";
    
    $stmt = $pdo->query("SELECT id, username, email, active FROM users ORDER BY id");
    $users = $stmt->fetchAll();
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Active</th><th>Action</th></tr>";
    
    foreach ($users as $user) {
        $active = $user['active'] ? 'Active' : 'Inactive';
        $activeColor = $user['active'] ? 'green' : 'red';
        
        echo "<tr>";
        echo "<td>{$user['id']}</td>";
        echo "<td><strong>{$user['username']}</strong></td>";
        echo "<td>{$user['email']}</td>";
        echo "<td style='color: {$activeColor};'>{$active}</td>";
        echo "<td>";
        echo "<form method='post' style='display: inline;'>";
        echo "<input type='hidden' name='user_id' value='{$user['id']}'>";
        echo "<input type='hidden' name='action' value='reset_password'>";
        echo "<button type='submit' style='background: #007cba; color: white; border: none; padding: 5px 10px; border-radius: 3px;'>Reset Password to 'admin123'</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Handle password reset
    if ($_POST['action'] ?? '' === 'reset_password') {
        $userId = $_POST['user_id'] ?? null;
        
        if ($userId) {
            // Generate new password hash
            $newPassword = 'admin123';
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $updateStmt->execute([$hashedPassword, $userId]);
            
            echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 10px; margin: 20px 0; border-radius: 5px;'>";
            echo "<h3>✅ Password Reset Successful!</h3>";
            echo "<p>User ID {$userId} password has been reset to: <strong>{$newPassword}</strong></p>";
            echo "</div>";
            
            // Refresh user list
            echo "<script>setTimeout(function(){ window.location.reload(); }, 2000);</script>";
        }
    }
    
    echo "<h2>🔐 Quick Login Info:</h2>";
    echo "<div style='background: #e2e3e5; padding: 15px; border-radius: 5px;'>";
    echo "<p><strong>After resetting a password:</strong></p>";
    echo "<ul>";
    echo "<li>Username: <code>[selected username]</code></li>";
    echo "<li>Password: <code>admin123</code></li>";
    echo "<li>Login URL: <a href='https://manager.pikasishearing.gr/auth/login'>https://manager.pikasishearing.gr/auth/login</a></li>";
    echo "</ul>";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>