<?php

// Simple debug version of index.php to diagnose the problem
echo "<h1>Debug Index.php</h1>";
echo "<p>✅ PHP is working</p>";
echo "<p>Time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Not set') . "</p>";
echo "<p>Current Directory: " . __DIR__ . "</p>";
echo "<p>This File: " . __FILE__ . "</p>";

echo "<h2>File System Check</h2>";
echo "<p>index.php exists: " . (file_exists(__FILE__) ? 'YES' : 'NO') . "</p>";
echo "<p>Parent directory: " . dirname(__DIR__) . "</p>";
echo "<p>App directory exists: " . (is_dir(dirname(__DIR__) . '/app') ? 'YES' : 'NO') . "</p>";

echo "<h2>URL Tests</h2>";
echo "<ul>";
echo "<li><a href='/test.php'>Test PHP</a></li>";
echo "<li><a href='/info.php'>Server Info</a></li>";
echo "<li><a href='/auth/login'>Login (will fail until fixed)</a></li>";
echo "</ul>";

echo "<h2>Next Steps</h2>";
echo "<p>If you see this page, the web server can execute PHP files.</p>";
echo "<p>The problem is with CodeIgniter bootstrap or .htaccess routing.</p>";

// Try to load CodeIgniter only if basic PHP works
if (file_exists(dirname(__DIR__) . '/app/Config/Paths.php')) {
    echo "<hr><h2>Attempting CodeIgniter Load...</h2>";
    try {
        require_once dirname(__DIR__) . '/app/Config/Paths.php';
        echo "<p>✅ Paths.php loaded successfully</p>";
        
        $paths = new Config\Paths();
        echo "<p>✅ Paths object created</p>";
        echo "<p>System Path: " . $paths->systemDirectory . "</p>";
        echo "<p>App Path: " . $paths->appDirectory . "</p>";
        
        // Try to load boot
        if (file_exists($paths->systemDirectory . '/Boot.php')) {
            echo "<p>✅ Boot.php exists</p>";
            echo "<p>Attempting to boot CodeIgniter...</p>";
            
            require_once $paths->systemDirectory . '/Boot.php';
            echo "<p>✅ Boot.php included</p>";
            
            CodeIgniter\Boot::bootWeb($paths);
            echo "<p>✅ CodeIgniter booted successfully!</p>";
        } else {
            echo "<p>❌ Boot.php not found at: " . $paths->systemDirectory . '/Boot.php</p>';
        }
        
    } catch (Exception $e) {
        echo "<p>❌ Error loading CodeIgniter: " . $e->getMessage() . "</p>";
        echo "<p>File: " . $e->getFile() . " Line: " . $e->getLine() . "</p>";
    }
} else {
    echo "<p>❌ CodeIgniter Paths.php not found</p>";
}
?>