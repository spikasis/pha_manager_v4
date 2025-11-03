<?php
/**
 * URL Test Script
 */

echo "<h1>🌐 URL Testing for CodeIgniter</h1>";
echo "<style>body { font-family: Arial, sans-serif; margin: 20px; }</style>";

echo "<h2>Testing different URLs:</h2>";

$urls = [
    'https://manager.pikasishearing.gr/',
    'https://manager.pikasishearing.gr/index.php',
    'https://manager.pikasishearing.gr/auth/login',
    'https://manager.pikasishearing.gr/index.php/auth/login',
    'https://manager.pikasishearing.gr/login'
];

foreach ($urls as $url) {
    echo "<h3>Testing: <code>{$url}</code></h3>";
    
    // Initialize curl
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_HEADER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        echo "<p style='color: red;'>❌ Error: {$error}</p>";
    } else {
        echo "<p>HTTP Status: <strong>{$httpCode}</strong></p>";
        
        // Extract just the first few lines of response
        $lines = explode("\n", $response);
        $preview = implode("\n", array_slice($lines, 0, 10));
        echo "<details><summary>Response Preview</summary><pre>" . htmlspecialchars($preview) . "</pre></details>";
    }
    echo "<hr>";
}

echo "<h2>📋 Environment Info:</h2>";
echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr><th>Variable</th><th>Value</th></tr>";
echo "<tr><td>SERVER_NAME</td><td>" . ($_SERVER['SERVER_NAME'] ?? 'N/A') . "</td></tr>";
echo "<tr><td>SERVER_PORT</td><td>" . ($_SERVER['SERVER_PORT'] ?? 'N/A') . "</td></tr>";
echo "<tr><td>DOCUMENT_ROOT</td><td>" . ($_SERVER['DOCUMENT_ROOT'] ?? 'N/A') . "</td></tr>";
echo "<tr><td>REQUEST_URI</td><td>" . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "</td></tr>";
echo "<tr><td>SCRIPT_NAME</td><td>" . ($_SERVER['SCRIPT_NAME'] ?? 'N/A') . "</td></tr>";
echo "</table>";
?>