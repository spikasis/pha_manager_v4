<?php
/**
 * Server PDF Status Check
 * Upload this file to server root and access via browser
 */

define('BASEPATH', __DIR__ . '/system/');
define('FCPATH', __DIR__ . '/');
define('APPPATH', __DIR__ . '/application/');

echo "<h1>PHA Manager V4 - Server PDF Status</h1>";

echo "<h2>1. Composer Status</h2>";
if (file_exists('vendor/autoload.php')) {
    echo "✅ vendor/autoload.php exists<br>";
    
    try {
        require_once 'vendor/autoload.php';
        echo "✅ Composer autoloader loaded successfully<br>";
        
        if (class_exists('\\Mpdf\\Mpdf')) {
            echo "✅ mPDF 8.x class available<br>";
            try {
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
                echo "✅ mPDF 8.x instance created successfully<br>";
                echo "📊 Version: " . \Mpdf\Mpdf::VERSION . "<br>";
            } catch (Exception $e) {
                echo "❌ mPDF 8.x instance creation failed: " . $e->getMessage() . "<br>";
            }
        } else {
            echo "❌ mPDF 8.x class not found<br>";
        }
        
    } catch (Exception $e) {
        echo "❌ Composer autoloader failed: " . $e->getMessage() . "<br>";
    } catch (Error $e) {
        echo "❌ Composer autoloader error: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ vendor/autoload.php not found<br>";
}

echo "<h2>2. Legacy mPDF Status</h2>";
$legacy_path = 'application/third_party/mpdf/mpdf.php';
if (file_exists($legacy_path)) {
    echo "✅ Legacy mPDF file exists: {$legacy_path}<br>";
    
    try {
        include_once $legacy_path;
        if (class_exists('mPDF')) {
            echo "✅ Legacy mPDF class loaded<br>";
            try {
                $legacy_mpdf = new mPDF('utf-8', 'A4');
                echo "✅ Legacy mPDF instance created<br>";
            } catch (Exception $e) {
                echo "❌ Legacy mPDF instance failed: " . $e->getMessage() . "<br>";
            }
        } else {
            echo "❌ Legacy mPDF class not found<br>";
        }
    } catch (Exception $e) {
        echo "❌ Legacy mPDF load failed: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ Legacy mPDF not found: {$legacy_path}<br>";
}

echo "<h2>3. Recommendations</h2>";
if (file_exists('vendor/autoload.php') && class_exists('\\Mpdf\\Mpdf')) {
    echo "✅ <strong>PDF export should work with mPDF 8.x</strong><br>";
} elseif (file_exists($legacy_path) && class_exists('mPDF')) {
    echo "⚠️ <strong>PDF export will use legacy mPDF 6.0</strong><br>";
    echo "💡 Consider running: <code>composer install --no-dev</code><br>";
} else {
    echo "❌ <strong>PDF export is not available</strong><br>";
    echo "🔧 <strong>Actions needed:</strong><br>";
    echo "1. Run: <code>composer install --no-dev</code><br>";
    echo "2. Or upload vendor/ folder from development<br>";
    echo "3. Or ensure legacy mPDF is properly installed<br>";
}

echo "<h2>4. PHP Environment</h2>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Server: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";

echo "<hr>";
echo "<small>Generated: " . date('Y-m-d H:i:s') . "</small>";
?>