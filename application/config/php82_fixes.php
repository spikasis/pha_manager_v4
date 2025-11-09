<?php
/**
 * 🚨 EMERGENCY PHP 8.2 COMPATIBILITY FIX 🚨
 * This file fixes critical PHP 8.2 compatibility issues
 */

// File: application/config/php82_fixes.php
// Include this in index.php or config files

// 1. Suppress PHP 8.2 deprecation warnings for production
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// 2. Create utf8_encode/utf8_decode compatibility functions if they don't exist
if (!function_exists('utf8_encode')) {
    function utf8_encode($string) {
        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($string, 'UTF-8', 'ISO-8859-1');
        }
        // Fallback for systems without mbstring
        return $string; // Return as-is if no conversion available
    }
}

if (!function_exists('utf8_decode')) {
    function utf8_decode($string) {
        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
        }
        // Fallback for systems without mbstring
        return $string; // Return as-is if no conversion available
    }
}

// 3. Set up proper timezone to avoid warnings
if (!ini_get('date.timezone')) {
    date_default_timezone_set('Europe/Athens');
}

// 4. Memory and execution limits for PDF generation
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 300);

// 5. Set proper character encoding
if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding('UTF-8');
}

// 6. Suppress specific PHP 8.2 warnings that might cause 500 errors
set_error_handler(function($severity, $message, $file, $line) {
    // Ignore deprecation warnings for specific functions
    $ignore_patterns = [
        '/utf8_encode.*deprecated/',
        '/utf8_decode.*deprecated/',
        '/Automatic conversion of false to array/',
        '/Creation of dynamic property/',
    ];
    
    foreach ($ignore_patterns as $pattern) {
        if (preg_match($pattern, $message)) {
            return true; // Suppress this error
        }
    }
    
    // Log other errors normally
    if ($severity & error_reporting()) {
        error_log("PHP Error: $message in $file:$line");
    }
    
    return false; // Let PHP handle other errors normally
}, E_ALL);

// Debug info (remove in production)
if (isset($_GET['debug_php82']) && $_GET['debug_php82'] === 'true') {
    echo "<h3>PHP 8.2 Compatibility Status</h3>";
    echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
    echo "<p><strong>Error Reporting:</strong> " . error_reporting() . "</p>";
    echo "<p><strong>Display Errors:</strong> " . ini_get('display_errors') . "</p>";
    echo "<p><strong>Memory Limit:</strong> " . ini_get('memory_limit') . "</p>";
    echo "<p><strong>Max Execution Time:</strong> " . ini_get('max_execution_time') . "</p>";
    echo "<p><strong>Timezone:</strong> " . date_default_timezone_get() . "</p>";
    echo "<p><strong>utf8_encode available:</strong> " . (function_exists('utf8_encode') ? 'YES' : 'NO') . "</p>";
    echo "<p><strong>mbstring extension:</strong> " . (extension_loaded('mbstring') ? 'YES' : 'NO') . "</p>";
    exit;
}
?>