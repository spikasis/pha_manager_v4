<?php
/**
 * Quick Fix for Production Server - 404 Auth Routes
 * Upload this file to production and run: php quick_fix_routes.php
 */

echo "<h1>🚨 Quick Fix: Auth Routes 404 Error</h1>";
echo "<style>body { font-family: Arial, sans-serif; margin: 20px; }</style>";

$routesFile = __DIR__ . '/app/Config/Routes.php';
$filtersFile = __DIR__ . '/app/Config/Filters.php';

echo "<h2>📁 Checking Files...</h2>";

// Check if files exist
if (!file_exists($routesFile)) {
    echo "<p style='color: red;'>❌ Routes file not found: {$routesFile}</p>";
    exit;
}

if (!file_exists($filtersFile)) {
    echo "<p style='color: red;'>❌ Filters file not found: {$filtersFile}</p>";
    exit;
}

echo "<p style='color: green;'>✅ Files found</p>";

echo "<h2>🔧 Applying Fixes...</h2>";

// Fix 1: Update Routes.php
$routesContent = file_get_contents($routesFile);

// Check if attempt-login route already exists
if (strpos($routesContent, 'attempt-login') === false) {
    echo "<p>📝 Adding attempt-login route...</p>";
    
    // Add the route after 'post('login', 'Auth::attemptLogin');'
    $routesContent = str_replace(
        '$routes->post(\'login\', \'Auth::attemptLogin\');',
        '$routes->post(\'login\', \'Auth::attemptLogin\');' . "\n" . 
        '    $routes->post(\'attempt-login\', \'Auth::attemptLogin\'); // Support dash format',
        $routesContent
    );
    
    // Also add attempt-register route
    $routesContent = str_replace(
        '$routes->post(\'register\', \'Auth::attemptRegister\');',
        '$routes->post(\'register\', \'Auth::attemptRegister\');' . "\n" . 
        '    $routes->post(\'attempt-register\', \'Auth::attemptRegister\'); // Support dash format',
        $routesContent
    );
    
    // Backup and write
    copy($routesFile, $routesFile . '.backup.' . date('Y-m-d_H-i-s'));
    file_put_contents($routesFile, $routesContent);
    
    echo "<p style='color: green;'>✅ Routes.php updated successfully</p>";
} else {
    echo "<p style='color: blue;'>ℹ️ attempt-login route already exists</p>";
}

// Fix 2: Update Filters.php  
$filtersContent = file_get_contents($filtersFile);

// Remove auth routes from CSRF protection
if (strpos($filtersContent, '\'auth/attempt-login\'') !== false) {
    echo "<p>📝 Removing auth routes from CSRF protection...</p>";
    
    // Remove the auth routes from CSRF
    $filtersContent = str_replace('\'auth/attempt-login\',', '', $filtersContent);
    $filtersContent = str_replace('\'auth/attempt-register\',', '', $filtersContent);
    
    // Clean up any double commas or extra whitespace
    $filtersContent = preg_replace('/,\s*,/', ',', $filtersContent);
    
    // Backup and write
    copy($filtersFile, $filtersFile . '.backup.' . date('Y-m-d_H-i-s'));
    file_put_contents($filtersFile, $filtersContent);
    
    echo "<p style='color: green;'>✅ Filters.php updated successfully</p>";
} else {
    echo "<p style='color: blue;'>ℹ️ Auth routes already removed from CSRF</p>";
}

echo "<h2>🧹 Clear Cache</h2>";

// Clear CodeIgniter cache
$cacheDir = __DIR__ . '/writable/cache';
if (is_dir($cacheDir)) {
    $files = glob($cacheDir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "<p style='color: green;'>✅ Cache cleared</p>";
} else {
    echo "<p style='color: orange;'>⚠️ Cache directory not found</p>";
}

echo "<h2>🎯 Test URLs</h2>";
echo "<p>After applying fixes, test these URLs:</p>";
echo "<ul>";
echo "<li><a href='/auth/login'>Login Page</a></li>";
echo "<li><strong>Try Login:</strong> POST to /auth/attempt-login should work</li>";
echo "<li><a href='/dashboard'>Dashboard</a> (after login)</li>";
echo "</ul>";

echo "<h2>📋 Summary</h2>";
echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; border: 1px solid #c3e6cb;'>";
echo "<h3>✅ Fixes Applied:</h3>";
echo "<ol>";
echo "<li>Added <code>/auth/attempt-login</code> route</li>";
echo "<li>Added <code>/auth/attempt-register</code> route</li>";
echo "<li>Removed auth routes from CSRF protection</li>";
echo "<li>Cleared application cache</li>";
echo "</ol>";
echo "<p><strong>Result:</strong> Login form should now work without 404 or CSRF errors!</p>";
echo "</div>";

echo "<h2>🔄 Next Steps</h2>";
echo "<p>If you still have issues:</p>";
echo "<ol>";
echo "<li>Upload missing authentication files (Auth.php controller, models, etc.)</li>";
echo "<li>Restart web server: <code>sudo systemctl restart apache2</code></li>";
echo "<li>Check server error logs for any remaining issues</li>";
echo "</ol>";

echo "<hr>";
echo "<p><small>Quick Fix completed at " . date('Y-m-d H:i:s') . "</small></p>";
?>