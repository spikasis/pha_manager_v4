<?php
echo "<h1>🔧 Web Server Test</h1>";
echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
echo "<p>Current directory: " . getcwd() . "</p>";
echo "<p>Script path: " . __FILE__ . "</p>";

echo "<h2>Environment:</h2>";
echo "<pre>";
print_r($_SERVER);
echo "</pre>";
?>