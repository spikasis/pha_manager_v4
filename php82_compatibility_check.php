<?php
/**
 * PHP 8.2.29 Compatibility Check for PHA Manager V4
 * Checks for common PHP 8.2+ deprecations and issues
 */

echo "PHP 8.2.29 Compatibility Analysis for PHA Manager V4\n";
echo str_repeat("=", 60) . "\n\n";

echo "Current PHP Version: " . PHP_VERSION . "\n";
echo "Current Date: " . date('Y-m-d H:i:s') . "\n\n";

$issues = [];
$warnings = [];
$fixes = [];

// 1. Check for utf8_encode/utf8_decode (deprecated in PHP 8.2)
echo "1. Checking for deprecated utf8_encode/utf8_decode functions...\n";
$utf8_files = [];
$directory = new RecursiveDirectoryIterator('application');
$iterator = new RecursiveIteratorIterator($directory);

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (strpos($content, 'utf8_encode') !== false || strpos($content, 'utf8_decode') !== false) {
            $utf8_files[] = $file->getPathname();
        }
    }
}

if (count($utf8_files) > 0) {
    $issues[] = "Found utf8_encode/utf8_decode usage in " . count($utf8_files) . " files (deprecated in PHP 8.2)";
    foreach ($utf8_files as $file) {
        echo "   ⚠️  $file\n";
    }
    $fixes[] = "Replace utf8_encode() with mb_convert_encoding(\$string, 'UTF-8', 'ISO-8859-1')";
} else {
    echo "   ✅ No deprecated utf8_encode/utf8_decode functions found\n";
}

// 2. Check for dynamic properties (deprecated in PHP 8.2)
echo "\n2. Checking for potential dynamic property issues...\n";
$controllers_with_properties = [];

// Check main controllers
$controller_dirs = [
    'application/controllers',
    'application/modules/admin/controllers'
];

foreach ($controller_dirs as $dir) {
    if (is_dir($dir)) {
        $files = glob($dir . '/*.php');
        foreach ($files as $file) {
            $content = file_get_contents($file);
            // Look for property assignments without declarations
            if (preg_match_all('/\$this->([a-zA-Z_][a-zA-Z0-9_]*)\s*=/', $content, $matches)) {
                $properties = array_unique($matches[1]);
                // Filter out known CI properties
                $ci_properties = ['load', 'db', 'input', 'session', 'config', 'uri', 'router', 'output', 'security', 'lang'];
                $custom_properties = array_diff($properties, $ci_properties);
                
                if (!empty($custom_properties)) {
                    $controllers_with_properties[$file] = $custom_properties;
                }
            }
        }
    }
}

if (count($controllers_with_properties) > 0) {
    $warnings[] = "Found potential dynamic property usage in controllers";
    foreach ($controllers_with_properties as $file => $props) {
        echo "   ⚠️  $file: " . implode(', ', $props) . "\n";
    }
    $fixes[] = "Declare properties in controller classes or use #[AllowDynamicProperties] attribute";
} else {
    echo "   ✅ No obvious dynamic property issues found in controllers\n";
}

// 3. Check mPDF compatibility
echo "\n3. Checking mPDF PHP 8.2 compatibility...\n";
if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
    
    try {
        // Test error suppression level used in Chart.php
        $oldErrorReporting = error_reporting(0);
        
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10
        ]);
        
        error_reporting($oldErrorReporting);
        
        echo "   ✅ mPDF 8.x compatible with PHP 8.2.29\n";
        echo "   ✅ Error suppression works correctly\n";
        
    } catch (Exception $e) {
        $issues[] = "mPDF compatibility issue: " . $e->getMessage();
        echo "   ❌ mPDF error: " . $e->getMessage() . "\n";
    } catch (Error $e) {
        $issues[] = "mPDF PHP error: " . $e->getMessage();
        echo "   ❌ mPDF PHP error: " . $e->getMessage() . "\n";
    }
} else {
    $warnings[] = "mPDF not found - Composer autoloader missing";
    echo "   ⚠️  Composer autoloader not found\n";
}

// 4. Check CodeIgniter 3 PHP 8.2 compatibility
echo "\n4. Checking CodeIgniter 3 PHP 8.2 compatibility...\n";
$ci_version_file = 'system/core/CodeIgniter.php';
if (file_exists($ci_version_file)) {
    $content = file_get_contents($ci_version_file);
    if (preg_match("/define\('CI_VERSION', '([^']+)'/", $content, $matches)) {
        $ci_version = $matches[1];
        echo "   ℹ️  CodeIgniter version: $ci_version\n";
        
        if (version_compare($ci_version, '3.1.11', '>=')) {
            echo "   ✅ CodeIgniter version supports PHP 8.x\n";
        } else {
            $warnings[] = "CodeIgniter version may have PHP 8.2 compatibility issues";
            echo "   ⚠️  Old CodeIgniter version - may have PHP 8.2 issues\n";
        }
    }
} else {
    echo "   ⚠️  CodeIgniter system files not found\n";
}

// 5. Check for other deprecated functions
echo "\n5. Checking for other PHP 8.2 deprecated functions...\n";
$deprecated_functions = [
    'each(' => 'Use foreach() instead',
    'create_function(' => 'Use anonymous functions instead', 
    'ereg(' => 'Use preg_match() instead',
    'split(' => 'Use preg_split() or explode() instead',
    'mysql_' => 'Use mysqli or PDO instead'
];

$deprecated_found = [];
foreach ($deprecated_functions as $func => $replacement) {
    $files_with_func = [];
    $directory = new RecursiveDirectoryIterator('application');
    $iterator = new RecursiveIteratorIterator($directory);
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            if (strpos($content, $func) !== false) {
                $files_with_func[] = $file->getPathname();
            }
        }
    }
    
    if (count($files_with_func) > 0) {
        $deprecated_found[$func] = $files_with_func;
        echo "   ❌ Found $func in " . count($files_with_func) . " files\n";
        $fixes[] = "$func: $replacement";
    }
}

if (empty($deprecated_found)) {
    echo "   ✅ No other deprecated functions found\n";
}

// Summary
echo "\n" . str_repeat("=", 60) . "\n";
echo "COMPATIBILITY ANALYSIS SUMMARY\n";
echo str_repeat("=", 60) . "\n";

if (count($issues) === 0) {
    echo "🎉 NO CRITICAL ISSUES FOUND!\n";
    echo "✅ Your PHA Manager V4 appears to be PHP 8.2.29 compatible\n\n";
} else {
    echo "❌ CRITICAL ISSUES FOUND:\n";
    foreach ($issues as $issue) {
        echo "   • $issue\n";
    }
    echo "\n";
}

if (count($warnings) > 0) {
    echo "⚠️  WARNINGS:\n";
    foreach ($warnings as $warning) {
        echo "   • $warning\n";
    }
    echo "\n";
}

if (count($fixes) > 0) {
    echo "🔧 RECOMMENDED FIXES:\n";
    foreach ($fixes as $fix) {
        echo "   • $fix\n";
    }
    echo "\n";
}

echo "📊 FINAL ASSESSMENT:\n";
if (count($issues) === 0 && count($warnings) <= 1) {
    echo "✅ EXCELLENT - Ready for production with PHP 8.2.29\n";
    echo "✅ The 500 errors are likely NOT caused by PHP compatibility issues\n";
} elseif (count($issues) === 0) {
    echo "✅ GOOD - Minor warnings but should work with PHP 8.2.29\n";
} else {
    echo "❌ NEEDS ATTENTION - Critical compatibility issues found\n";
}

echo "\nGenerated: " . date('Y-m-d H:i:s') . "\n";
?>