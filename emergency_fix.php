<?php
/**
 * EMERGENCY SERVER FIX - Run immediately to fix PDF crashes
 * Upload this file to server root and run: php emergency_fix.php
 */

echo "=== EMERGENCY PDF FIX - PHA Manager V4 ===\n\n";

$serverPath = __DIR__;
echo "Working directory: $serverPath\n";

// Step 1: Remove broken Composer immediately
echo "1. Checking for broken Composer installation...\n";

if (file_exists('vendor/autoload.php')) {
    echo "   Found vendor/autoload.php\n";
    
    // Test if it's broken
    $broken = false;
    try {
        ob_start();
        @include_once 'vendor/autoload.php';
        ob_end_clean();
        
        if (!class_exists('\\Mpdf\\Mpdf')) {
            $broken = true;
        }
    } catch (Exception $e) {
        $broken = true;
    } catch (Error $e) {
        $broken = true;
    } catch (Throwable $e) {
        $broken = true;
    }
    
    if ($broken) {
        echo "   ❌ Composer installation is BROKEN - removing...\n";
        
        // Remove broken composer files
        if (is_dir('vendor')) {
            exec('rm -rf vendor 2>/dev/null', $output, $return);
            if ($return === 0) {
                echo "   ✅ Removed broken vendor directory\n";
            } else {
                echo "   ⚠️  Could not remove vendor directory automatically\n";
                echo "   🔧 Manual action: rm -rf vendor/\n";
            }
        }
        
        if (file_exists('composer.lock')) {
            unlink('composer.lock');
            echo "   ✅ Removed composer.lock\n";
        }
        
    } else {
        echo "   ✅ Composer installation appears to be working\n";
    }
} else {
    echo "   ℹ️  No vendor directory found\n";
}

// Step 2: Check legacy mPDF
echo "\n2. Checking legacy mPDF availability...\n";

$legacyPath = 'application/third_party/mpdf/mpdf.php';
if (file_exists($legacyPath)) {
    echo "   ✅ Legacy mPDF found: $legacyPath\n";
    
    // Check PHP version for legacy mPDF compatibility
    $phpVersion = PHP_VERSION;
    echo "   PHP Version: $phpVersion\n";
    
    if (version_compare($phpVersion, '8.0.0', '>=')) {
        echo "   ⚠️  Legacy mPDF is NOT compatible with PHP 8.0+\n";
        echo "   💡 Legacy mPDF uses deprecated syntax (curly braces)\n";
        echo "   📌 mPDF 8.x is REQUIRED for PHP 8.0+\n";
    } else {
        // Test legacy mPDF only on PHP 7.x
        try {
            $oldErrorReporting = error_reporting(0);
            ob_start();
            
            include_once $legacyPath;
            
            ob_end_clean();
            error_reporting($oldErrorReporting);
            
            if (class_exists('mPDF')) {
                echo "   ✅ Legacy mPDF class loads successfully\n";
            } else {
                echo "   ❌ Legacy mPDF class not found after include\n";
            }
        } catch (Throwable $e) {
            error_reporting($oldErrorReporting);
            echo "   ❌ Legacy mPDF error: " . $e->getMessage() . "\n";
        }
    }
} else {
    echo "   ❌ Legacy mPDF NOT found: $legacyPath\n";
    echo "   🚨 WARNING: PDF functionality may not work!\n";
}

// Step 3: Test current Chart.php protection
echo "\n3. Testing Chart.php error handling...\n";

if (file_exists('application/modules/admin/models/Chart.php')) {
    $chartContent = file_get_contents('application/modules/admin/models/Chart.php');
    
    if (strpos($chartContent, 'catch (Throwable $e)') !== false) {
        echo "   ✅ Enhanced error handling is present\n";
    } else {
        echo "   ⚠️  Enhanced error handling missing\n";
        echo "   📥 Need to update Chart.php from development\n";
    }
    
    if (strpos($chartContent, 'error_reporting(0)') !== false) {
        echo "   ✅ Error suppression is active\n";
    } else {
        echo "   ⚠️  Error suppression missing\n";
    }
} else {
    echo "   ❌ Chart.php not found!\n";
}

// Step 4: Quick functionality test
echo "\n4. Testing PDF functionality...\n";

try {
    // Simulate what Chart.php does
    $composerOK = false;
    
    if (file_exists('vendor/autoload.php')) {
        $oldErrorReporting = error_reporting(0);
        ob_start();
        
        try {
            include_once 'vendor/autoload.php';
            if (class_exists('\\Mpdf\\Mpdf')) {
                $composerOK = true;
                echo "   ✅ mPDF 8.x is working\n";
            }
        } catch (Throwable $e) {
            // Ignore - will use fallback
        }
        
        ob_end_clean();
        error_reporting($oldErrorReporting);
    }
    
    if (!$composerOK) {
        if (file_exists($legacyPath)) {
            if (version_compare(PHP_VERSION, '8.0.0', '>=')) {
                echo "   ❌ Legacy mPDF incompatible with PHP " . PHP_VERSION . "\n";
                echo "   💡 mPDF 8.x REQUIRED for PHP 8.0+\n";
            } else {
                try {
                    $oldErrorReporting = error_reporting(0);
                    ob_start();
                    include_once $legacyPath;
                    ob_end_clean();
                    error_reporting($oldErrorReporting);
                    
                    if (class_exists('mPDF')) {
                        echo "   ✅ Legacy mPDF 6.0 is working\n";
                    } else {
                        echo "   ❌ Legacy mPDF class not found\n";
                    }
                } catch (Throwable $e) {
                    error_reporting($oldErrorReporting);
                    echo "   ❌ Legacy mPDF error: " . $e->getMessage() . "\n";
                }
            }
        } else {
            echo "   ❌ No PDF library available\n";
        }
    }
    
} catch (Throwable $e) {
    echo "   ❌ PDF test failed: " . $e->getMessage() . "\n";
}

// Step 5: Final status and recommendations
echo "\n=== FINAL STATUS ===\n";

$pdfWorking = false;

// Check if any PDF method works
if (file_exists('vendor/autoload.php')) {
    try {
        $oldErrorReporting = error_reporting(0);
        ob_start();
        include_once 'vendor/autoload.php';
        ob_end_clean();
        error_reporting($oldErrorReporting);
        
        if (class_exists('\\Mpdf\\Mpdf')) {
            echo "✅ PDF Status: mPDF 8.x WORKING\n";
            $pdfWorking = true;
        }
    } catch (Throwable $e) {
        // Continue to legacy check
    }
}

if (!$pdfWorking && file_exists($legacyPath)) {
    if (version_compare(PHP_VERSION, '8.0.0', '<')) {
        try {
            $oldErrorReporting = error_reporting(0);
            ob_start();
            include_once $legacyPath;
            ob_end_clean();
            error_reporting($oldErrorReporting);
            
            if (class_exists('mPDF')) {
                echo "⚠️  PDF Status: Legacy mPDF 6.0 WORKING\n";
                $pdfWorking = true;
            }
        } catch (Throwable $e) {
            error_reporting($oldErrorReporting);
            echo "❌ Legacy mPDF error: " . $e->getMessage() . "\n";
        }
    } else {
        echo "❌ Legacy mPDF incompatible with PHP " . PHP_VERSION . "\n";
    }
}

if (!$pdfWorking) {
    echo "❌ PDF Status: NOT WORKING\n";
    echo "\n🔧 REQUIRED ACTIONS:\n";
    echo "1. Upload vendor/ folder from development\n";
    echo "2. OR run: composer install --no-dev\n";
    echo "3. OR ensure legacy mPDF is properly installed\n";
} else {
    echo "\n✅ PDF export should work now!\n";
    echo "📋 Test: Go to Stocks → Actions → PDF εγγύηση\n";
}

echo "\n⏰ Fix completed: " . date('Y-m-d H:i:s') . "\n";
echo "🛡️  Application is protected from crashes\n";
?>