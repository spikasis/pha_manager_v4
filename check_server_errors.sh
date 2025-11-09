#!/bin/bash
# Server Error Log Checker for PHA Manager V4

echo "=== PHA Manager V4 - Error Log Analysis ==="
echo "Time: $(date)"
echo ""

# Check common error log locations
ERROR_LOGS=(
    "/var/log/apache2/error.log"
    "/var/log/httpd/error_log"  
    "/var/log/nginx/error.log"
    "/var/www/vhosts/asal.gr/logs/error_log"
    "/var/www/vhosts/asal.gr/manager.pikasishearing.gr/logs/error_log"
)

echo "1. Searching for error logs..."
for log in "${ERROR_LOGS[@]}"; do
    if [ -f "$log" ]; then
        echo "✅ Found: $log"
        
        echo ""
        echo "=== Recent errors from $log ==="
        
        # Show last 20 lines with timestamp filter for today
        tail -n 50 "$log" | grep -E "(eggyisi_doc|Chart|mPDF|PDF|error|fatal)" --color=never | tail -n 20
        
        echo ""
        echo "=== PHP Fatal errors (last 10) ==="
        tail -n 100 "$log" | grep -i "fatal" | tail -n 10
        
        echo ""
        echo "=== mPDF related errors ==="  
        tail -n 100 "$log" | grep -i "mpdf\|composer" | tail -n 10
        
    else
        echo "❌ Not found: $log"
    fi
done

echo ""
echo "2. Checking PHP error log..."
if [ -f "/var/log/php_errors.log" ]; then
    echo "✅ PHP error log found"
    tail -n 20 /var/log/php_errors.log | grep -E "(eggyisi|PDF|mPDF)"
else
    echo "❌ PHP error log not found at standard location"
fi

echo ""
echo "3. Checking application logs..."
APP_LOG="/var/www/vhosts/asal.gr/manager.pikasishearing.gr/application/logs"
if [ -d "$APP_LOG" ]; then
    echo "✅ Application log directory found: $APP_LOG"
    
    # Find latest log file
    LATEST_LOG=$(find "$APP_LOG" -name "log-*.php" -type f | sort | tail -n 1)
    if [ -n "$LATEST_LOG" ]; then
        echo "📄 Latest app log: $LATEST_LOG"
        tail -n 30 "$LATEST_LOG" | grep -v "<?php" | head -20
    fi
else
    echo "❌ Application log directory not found"
fi

echo ""
echo "4. Quick PDF functionality test..."
cd /var/www/vhosts/asal.gr/manager.pikasishearing.gr/ 2>/dev/null || {
    echo "❌ Cannot access application directory"
    exit 1
}

php -r "
echo 'Testing mPDF availability...' . \"\n\";
if (file_exists('vendor/autoload.php')) {
    try {
        require_once 'vendor/autoload.php';
        if (class_exists('\\\\Mpdf\\\\Mpdf')) {
            echo '✅ mPDF 8.x available' . \"\n\";
        } else {
            echo '❌ mPDF 8.x class not found' . \"\n\";
        }
    } catch (Exception \$e) {
        echo '❌ Composer error: ' . \$e->getMessage() . \"\n\";
    }
} else {
    echo '❌ Composer autoloader not found' . \"\n\";
}

if (file_exists('application/third_party/mpdf/mpdf.php')) {
    echo '⚠️  Legacy mPDF 6.0 present (PHP 8+ incompatible)' . \"\n\";
} else {
    echo '❌ Legacy mPDF not found' . \"\n\";
}
"

echo ""
echo "=== RECOMMENDATIONS ==="
echo "1. Check debug output: https://manager.pikasishearing.gr/admin/stocks/debug_eggyisi_doc/2443"
echo "2. If Composer is broken: rm -rf vendor/ (use fallback)"
echo "3. If no PDF works: upload working vendor/ from development"
echo "4. Monitor logs in real-time: tail -f /var/log/apache2/error.log"

echo ""
echo "Script completed: $(date)"