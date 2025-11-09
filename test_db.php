<?php
// Test database connection
header('Content-Type: text/html; charset=utf-8');

echo "<h2>🔧 Database Connection Test</h2>";
echo "<pre>";

$hostname = 'linux2917.grserver.gr';
$username = 'spik';  
$password = '0382sp@#';
$database = 'customers_db2';
$port = 3306;

echo "Testing connection to:\n";
echo "Host: $hostname:$port\n";
echo "Database: $database\n";
echo "Username: $username\n\n";

try {
    // Test raw MySQL connection
    $connection = new mysqli($hostname, $username, $password, $database, $port);
    
    if ($connection->connect_error) {
        echo "❌ MySQL Connection Error: " . $connection->connect_error . "\n";
        echo "\nPossible issues:\n";
        echo "- Internet connection problem\n";
        echo "- Remote server is down\n"; 
        echo "- Firewall blocking port 3306\n";
        echo "- Database credentials changed\n";
        echo "- Remote access not allowed from your IP\n";
    } else {
        echo "✅ MySQL Connection: SUCCESS!\n";
        echo "Server version: " . $connection->server_info . "\n\n";
        
        // Test demo stocks query
        $result = $connection->query("SELECT COUNT(*) as count FROM stocks WHERE status = 5");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "✅ Demo stocks count: " . $row['count'] . "\n";
            
            // Test selling points
            $result2 = $connection->query("SELECT COUNT(*) as count, selling_point FROM stocks WHERE status = 5 GROUP BY selling_point");
            if ($result2) {
                echo "\nDemo stocks by selling point:\n";
                while ($row2 = $result2->fetch_assoc()) {
                    $sp = $row2['selling_point'] ?: 'NULL';
                    echo "- Selling point $sp: {$row2['count']} items\n";
                }
            }
            
        } else {
            echo "❌ Query Error: " . $connection->error . "\n";
        }
        
        $connection->close();
    }
    
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}

echo "\n</pre>";

if (!extension_loaded('mysqli')) {
    echo "<div style='color: red; font-weight: bold;'>❌ MySQLi extension is not loaded!</div>";
}

echo "<hr>";
echo "<p><a href='/admin' style='background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;'>🏠 Back to Admin</a></p>";
?>