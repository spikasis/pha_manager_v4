<?php
/**
 * PHP Extension Checker and Fixer
 */

echo "<h1>🔧 PHP Extension Check & Fix</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .warning { color: orange; font-weight: bold; }
    .info { color: blue; }
    pre { background: #f4f4f4; padding: 10px; border-radius: 5px; }
</style>";

echo "<h2>📋 Current PHP Configuration:</h2>";

echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>Property</th><th>Value</th></tr>";
echo "<tr><td>PHP Version</td><td>" . PHP_VERSION . "</td></tr>";
echo "<tr><td>PHP SAPI</td><td>" . php_sapi_name() . "</td></tr>";
echo "<tr><td>OS</td><td>" . PHP_OS . "</td></tr>";
echo "<tr><td>Architecture</td><td>" . (PHP_INT_SIZE * 8) . "-bit</td></tr>";
echo "</table>";

echo "<h2>🔍 Extension Status:</h2>";

$required_extensions = [
    'pdo' => 'PDO (PHP Data Objects)',
    'pdo_mysql' => 'PDO MySQL Driver', 
    'mysqlnd' => 'MySQL Native Driver',
    'mysqli' => 'MySQL Improved Extension',
    'curl' => 'cURL',
    'mbstring' => 'Multibyte String',
    'openssl' => 'OpenSSL',
    'json' => 'JSON'
];

echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>Extension</th><th>Status</th><th>Description</th></tr>";

foreach ($required_extensions as $ext => $desc) {
    $loaded = extension_loaded($ext);
    $status = $loaded ? 
        "<span class='success'>✅ LOADED</span>" : 
        "<span class='error'>❌ MISSING</span>";
    
    echo "<tr><td>{$ext}</td><td>{$status}</td><td>{$desc}</td></tr>";
}
echo "</table>";

echo "<h2>💾 Database Connection Test:</h2>";

// Test different MySQL connection methods
echo "<h3>Testing PDO MySQL:</h3>";
if (extension_loaded('pdo_mysql')) {
    try {
        $dsn = "mysql:host=linux2917.grserver.gr;dbname=customers_db2;charset=utf8mb4";
        $username = "spik";
        $password = ""; // You'll need to set this
        
        echo "<pre>DSN: {$dsn}</pre>";
        echo "<p class='info'>PDO MySQL extension is available for testing.</p>";
        echo "<p class='warning'>Note: Password not provided in test - connection will fail but driver is ready.</p>";
        
    } catch (Exception $e) {
        echo "<p class='error'>PDO MySQL Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='error'>❌ PDO MySQL extension not loaded!</p>";
}

echo "<h3>Testing MySQLi:</h3>";
if (extension_loaded('mysqli')) {
    echo "<p class='success'>✅ MySQLi extension is available as alternative.</p>";
} else {
    echo "<p class='error'>❌ MySQLi extension not loaded!</p>";
}

echo "<h2>🛠️ Solutions:</h2>";

if (!extension_loaded('pdo_mysql')) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px;'>";
    echo "<h3>🚨 Missing PDO MySQL Extension</h3>";
    echo "<p>You need to enable the PDO MySQL extension. Here's how:</p>";
    echo "<ol>";
    echo "<li><strong>Find your php.ini file:</strong><br>";
    echo "<code>" . php_ini_loaded_file() . "</code></li>";
    echo "<li><strong>Open php.ini in a text editor (as Administrator)</strong></li>";
    echo "<li><strong>Find this line:</strong><br>";
    echo "<code>;extension=pdo_mysql</code></li>";
    echo "<li><strong>Remove the semicolon to uncomment it:</strong><br>";
    echo "<code>extension=pdo_mysql</code></li>";
    echo "<li><strong>Save the file and restart your web server/PHP</strong></li>";
    echo "</ol>";
    echo "<p><strong>Alternative:</strong> If the line doesn't exist, add this line to your php.ini:</p>";
    echo "<pre>extension=pdo_mysql</pre>";
    echo "</div>";
}

echo "<h2>📝 Quick Fix Commands:</h2>";
echo "<p>Run these commands in Administrator PowerShell:</p>";
echo "<pre>";
echo "# 1. Backup current php.ini\n";
echo "Copy-Item '" . php_ini_loaded_file() . "' '" . php_ini_loaded_file() . ".backup'\n\n";

echo "# 2. Enable PDO MySQL (if commented out)\n";
echo '$content = Get-Content "' . php_ini_loaded_file() . '"' . "\n";
echo '$content = $content -replace "^;extension=pdo_mysql", "extension=pdo_mysql"' . "\n";
echo '$content | Set-Content "' . php_ini_loaded_file() . '"' . "\n\n";

echo "# 3. Add PDO MySQL if not exists\n";
echo '$content = Get-Content "' . php_ini_loaded_file() . '"' . "\n";
echo 'if ($content -notmatch "extension=pdo_mysql") {' . "\n";
echo '    Add-Content "' . php_ini_loaded_file() . '" "extension=pdo_mysql"' . "\n";
echo '}' . "\n\n";

echo "# 4. Restart PHP (if using built-in server)\n";
echo "# Stop current PHP processes and restart\n";
echo "</pre>";

echo "<h2>🔄 After Fixing:</h2>";
echo "<p>After enabling the extension:</p>";
echo "<ol>";
echo "<li>Restart your web server or PHP process</li>";
echo "<li>Run: <code>php simple_debug.php</code> again</li>";
echo "<li>The database connection should work</li>";
echo "</ol>";

?>