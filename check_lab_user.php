<?php
// Direct database check για τον χρήστη lab
// Database config
$host = 'linux2917.grserver.gr';
$username = 'spik';  
$password = '0382sp@#';
$database = 'customers_db2';
$port = 3306;

header('Content-Type: text/html; charset=utf-8');

echo "<h2>🔍 Database Check: Lab User</h2>";
echo "<pre>";

try {
    $connection = new mysqli($host, $username, $password, $database, $port);
    
    if ($connection->connect_error) {
        echo "❌ MySQL Connection Error: " . $connection->connect_error . "\n";
        exit;
    }
    
    echo "✅ Connected to database successfully!\n\n";
    
    // 1. Check users table
    echo "=== USERS TABLE ===\n";
    $result = $connection->query("SELECT id, username, email, active, created_on FROM users WHERE username = 'lab'");
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "User found:\n";
            echo "- ID: {$row['id']}\n";
            echo "- Username: {$row['username']}\n";
            echo "- Email: {$row['email']}\n";
            echo "- Active: {$row['active']}\n";
            echo "- Created: {$row['created_on']}\n\n";
            
            $lab_user_id = $row['id'];
        }
    } else {
        echo "❌ No user found with username 'lab'\n\n";
        
        // Show all users
        echo "All users in system:\n";
        $all_users = $connection->query("SELECT id, username, email, active FROM users ORDER BY id");
        if ($all_users) {
            while ($user = $all_users->fetch_assoc()) {
                echo "- ID: {$user['id']}, Username: {$user['username']}, Email: {$user['email']}, Active: {$user['active']}\n";
            }
        }
        exit;
    }
    
    // 2. Check groups table
    echo "=== GROUPS TABLE ===\n";
    $groups_result = $connection->query("SELECT * FROM groups ORDER BY id");
    if ($groups_result) {
        echo "All groups:\n";
        while ($group = $groups_result->fetch_assoc()) {
            echo "- ID: {$group['id']}, Name: {$group['name']}, Description: {$group['description']}\n";
        }
        echo "\n";
    }
    
    // 3. Check users_groups table
    echo "=== USER GROUPS FOR LAB ===\n";
    $user_groups_result = $connection->query("
        SELECT ug.user_id, ug.group_id, g.name, g.description 
        FROM users_groups ug 
        JOIN groups g ON ug.group_id = g.id 
        WHERE ug.user_id = $lab_user_id
    ");
    
    if ($user_groups_result && $user_groups_result->num_rows > 0) {
        echo "Lab user groups:\n";
        while ($ug = $user_groups_result->fetch_assoc()) {
            echo "- Group ID: {$ug['group_id']}, Name: {$ug['name']}, Description: {$ug['description']}\n";
        }
    } else {
        echo "❌ Lab user has no groups assigned!\n";
        
        // Show all user-group assignments
        echo "\nAll user-group assignments:\n";
        $all_assignments = $connection->query("
            SELECT ug.user_id, u.username, ug.group_id, g.name 
            FROM users_groups ug 
            JOIN users u ON ug.user_id = u.id 
            JOIN groups g ON ug.group_id = g.id 
            ORDER BY ug.user_id
        ");
        if ($all_assignments) {
            while ($assignment = $all_assignments->fetch_assoc()) {
                echo "- User ID: {$assignment['user_id']} ({$assignment['username']}) → Group ID: {$assignment['group_id']} ({$assignment['name']})\n";
            }
        }
    }
    
    $connection->close();
    
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}

echo "</pre>";

echo "<hr>";
echo "<h3>Sidemenu Logic Check</h3>";
echo "<p>Current sidemenu condition: <code>\$is_admin || \$group_id > 1</code></p>";
echo "<p>If lab user has group_id = 1, this explains why Demo options don't show.</p>";

echo "<h3>Solutions:</h3>";
echo "<ol>";
echo "<li><strong>Assign lab user to correct group:</strong> UPDATE users_groups SET group_id = 6 WHERE user_id = [lab_user_id]</li>";
echo "<li><strong>Or remove condition:</strong> Show Demo for all users regardless of group</li>";
echo "</ol>";
?>