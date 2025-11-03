<?php
// Simple PHP info page to check server configuration
echo "<h1>Server Information</h1>";
echo "<h2>Document Root & Paths</h2>";
echo "<p><strong>Document Root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Not set') . "</p>";
echo "<p><strong>Script Filename:</strong> " . ($_SERVER['SCRIPT_FILENAME'] ?? 'Not set') . "</p>";
echo "<p><strong>Request URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'Not set') . "</p>";
echo "<p><strong>Script Name:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'Not set') . "</p>";
echo "<p><strong>HTTP Host:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'Not set') . "</p>";

echo "<h2>Current Directory</h2>";
echo "<p><strong>getcwd():</strong> " . getcwd() . "</p>";
echo "<p><strong>__DIR__:</strong> " . __DIR__ . "</p>";
echo "<p><strong>__FILE__:</strong> " . __FILE__ . "</p>";

echo "<h2>File Checks</h2>";
echo "<p><strong>index.php exists:</strong> " . (file_exists('index.php') ? 'YES' : 'NO') . "</p>";
echo "<p><strong>.htaccess exists:</strong> " . (file_exists('.htaccess') ? 'YES' : 'NO') . "</p>";

echo "<h2>Directory Contents</h2>";
echo "<ul>";
foreach (scandir('.') as $file) {
    if ($file != '.' && $file != '..') {
        echo "<li>" . $file . (is_dir($file) ? '/ (dir)' : ' (file)') . "</li>";
    }
}
echo "</ul>";

echo "<h2>CodeIgniter Check</h2>";
if (file_exists('../app/Config/App.php')) {
    echo "<p>✅ CodeIgniter app structure found</p>";
} else {
    echo "<p>❌ CodeIgniter app structure NOT found</p>";
}

echo "<h2>URL Tests</h2>";
echo "<ul>";
echo "<li><a href='/info.php'>This file (should work)</a></li>";
echo "<li><a href='/'>Homepage</a></li>";
echo "<li><a href='/auth/login'>Login page</a></li>";
echo "</ul>";
?>