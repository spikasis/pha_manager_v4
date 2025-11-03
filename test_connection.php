<?php
// Simple test to check if the database connection and models work

// Set up basic paths
define('APPPATH', __DIR__ . '/app/');
define('WRITEPATH', __DIR__ . '/writable/');
define('ROOTPATH', __DIR__ . '/');

// Load environment variables manually
$envPath = __DIR__ . '/.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            putenv(trim($line));
        }
    }
}

// Database connection using mysqli directly
$hostname = 'linux2917.grserver.gr';
$database = 'customers_db2';
$username = 'spik';
$password = '0382sp@#';
$port = 3306;

echo "=== PHA Manager v4 - Database Connection Test ===\n\n";

try {
    // Test direct MySQL connection
    $mysqli = new mysqli($hostname, $username, $password, $database, $port);
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    echo "✅ Connected to database successfully!\n\n";
    
    // Test basic queries
    echo "📊 Quick Statistics:\n";
    echo str_repeat("-", 30) . "\n";
    
    // Count customers
    $result = $mysqli->query("SELECT COUNT(*) as count FROM customers");
    $customerCount = $result->fetch_assoc()['count'];
    echo "👥 Total Customers: $customerCount\n";
    
    // Count active customers
    $result = $mysqli->query("SELECT COUNT(*) as count FROM customers WHERE status = 1");
    $activeCustomers = $result->fetch_assoc()['count'];
    echo "✅ Active Customers: $activeCustomers\n";
    
    // Count doctors
    $result = $mysqli->query("SELECT COUNT(*) as count FROM doctors");
    $doctorCount = $result->fetch_assoc()['count'];
    echo "👨‍⚕️ Total Doctors: $doctorCount\n";
    
    // Count services
    $result = $mysqli->query("SELECT COUNT(*) as count FROM services");
    $serviceCount = $result->fetch_assoc()['count'];
    echo "🔧 Total Services: $serviceCount\n";
    
    // Count active services
    $result = $mysqli->query("SELECT COUNT(*) as count FROM services WHERE status = 1");
    $activeServices = $result->fetch_assoc()['count'];
    echo "⚡ Active Services: $activeServices\n";
    
    // Sample customer data
    echo "\n📋 Sample Customer Data:\n";
    echo str_repeat("-", 50) . "\n";
    
    $result = $mysqli->query("SELECT id, name, phone_mobile, city FROM customers WHERE status = 1 LIMIT 5");
    while ($row = $result->fetch_assoc()) {
        $phone = $row['phone_mobile'] ?: 'N/A';
        $city = $row['city'] ?: 'N/A';
        echo "ID: {$row['id']} | {$row['name']} | {$phone} | {$city}\n";
    }
    
    echo "\n🎉 Database connection and basic queries working perfectly!\n";
    echo "\n📝 Your CI4 application should now work with these settings:\n";
    echo "   - Database: $database\n";
    echo "   - Host: $hostname\n";
    echo "   - Total Records: " . ($customerCount + $doctorCount + $serviceCount) . "\n";
    
    echo "\n⚠️  To run the full CI4 application, you need to enable the 'intl' PHP extension.\n";
    echo "   Edit your php.ini file and uncomment: extension=intl\n";
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nTroubleshooting:\n";
    echo "1. Check if MySQL server is accessible\n";
    echo "2. Verify credentials in .env file\n";
    echo "3. Check firewall settings\n";
}

echo "\n" . str_repeat("=", 60) . "\n";
?>