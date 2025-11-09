#!/bin/bash
# Quick Server PDF Fix Script
# Run this on the production server if PDF is broken

echo "=== PHA Manager V4 - Quick PDF Fix ==="

SERVER_PATH="/var/www/vhosts/asal.gr/manager.pikasishearing.gr"
cd "$SERVER_PATH" || exit 1

echo "Current directory: $(pwd)"

# Check current status
echo ""
echo "1. Checking current PDF status..."

if [ -f "vendor/autoload.php" ]; then
    echo "✅ Composer vendor exists"
    
    # Test if it's broken
    php -r "
    try {
        require_once 'vendor/autoload.php';
        if (class_exists('\\\\Mpdf\\\\Mpdf')) {
            echo '✅ mPDF 8.x OK\n';
            exit(0);
        } else {
            echo '❌ mPDF 8.x class missing\n';
            exit(1);
        }
    } catch (Exception \$e) {
        echo '❌ Composer broken: ' . \$e->getMessage() . '\n';
        exit(1);
    }
    "
    
    if [ $? -eq 0 ]; then
        echo "✅ PDF should be working fine!"
        exit 0
    else
        echo "🔧 Composer is broken, fixing..."
        
        # Remove broken composer
        echo "2. Removing broken vendor..."
        rm -rf vendor/
        rm -f composer.lock
        
        # Try to reinstall
        echo "3. Reinstalling Composer packages..."
        if command -v composer >/dev/null 2>&1; then
            composer install --no-dev --optimize-autoloader
            
            if [ $? -eq 0 ]; then
                echo "✅ Composer reinstalled successfully!"
            else
                echo "❌ Composer install failed"
                echo "📌 Will use fallback legacy mPDF"
            fi
        else
            echo "❌ Composer command not found on server"
            echo "📌 Will use fallback legacy mPDF"
        fi
    fi
else
    echo "⚠️ No vendor directory found"
    
    # Check if we can install composer
    if command -v composer >/dev/null 2>&1; then
        if [ -f "composer.json" ]; then
            echo "2. Installing Composer packages..."
            composer install --no-dev --optimize-autoloader
        else
            echo "❌ composer.json not found"
            echo "📌 Need to upload composer.json first"
        fi
    else
        echo "❌ Composer not available on server"
        echo "📌 Will use fallback legacy mPDF"
    fi
fi

# Check legacy fallback
echo ""
echo "4. Checking legacy mPDF fallback..."

LEGACY_PATH="application/third_party/mpdf/mpdf.php"
if [ -f "$LEGACY_PATH" ]; then
    echo "✅ Legacy mPDF available: $LEGACY_PATH"
    echo "📌 PDF export will work using mPDF 6.0"
else
    echo "❌ Legacy mPDF not found: $LEGACY_PATH"
    echo "🚨 PDF export will not work!"
fi

# Final status
echo ""
echo "=== Final Status ==="

# Test current working status
php -r "
echo 'Testing PDF availability...\n';

\$composerOK = false;
if (file_exists('vendor/autoload.php')) {
    try {
        require_once 'vendor/autoload.php';
        if (class_exists('\\\\Mpdf\\\\Mpdf')) {
            echo '✅ mPDF 8.x available\n';
            \$composerOK = true;
        }
    } catch (Exception \$e) {
        echo '❌ mPDF 8.x failed: ' . \$e->getMessage() . '\n';
    }
}

if (!\$composerOK) {
    if (file_exists('application/third_party/mpdf/mpdf.php')) {
        echo '✅ Legacy mPDF 6.0 available\n';
    } else {
        echo '❌ No PDF library available\n';
    }
}
"

echo ""
echo "🔧 If PDF is still not working:"
echo "1. Upload server_pdf_check.php and check via browser"
echo "2. Check /var/log/apache2/error.log for errors"
echo "3. Verify file permissions: chown -R www-data:www-data ."
echo ""
echo "Script completed."