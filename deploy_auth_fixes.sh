#!/bin/bash
# Production Deployment Script for PHA Manager v4 Authentication System
# Run this script to deploy the authentication fixes to production

echo "🚀 PHA Manager v4 Authentication Deployment Script"
echo "================================================="
echo ""

# Configuration - Update these paths according to your production setup
PRODUCTION_PATH="/path/to/production/pha_manager_v4"
BACKUP_DIR="/backups/pha_manager_$(date +%Y%m%d_%H%M%S)"

echo "📂 Creating backup of current production files..."
mkdir -p "$BACKUP_DIR"

# Backup critical files before deployment
cp "$PRODUCTION_PATH/app/Models/UserModel.php" "$BACKUP_DIR/" 2>/dev/null
cp "$PRODUCTION_PATH/app/Controllers/Auth.php" "$BACKUP_DIR/" 2>/dev/null
cp "$PRODUCTION_PATH/app/Config/Auth.php" "$BACKUP_DIR/" 2>/dev/null
cp "$PRODUCTION_PATH/app/Config/Routes.php" "$BACKUP_DIR/" 2>/dev/null
cp "$PRODUCTION_PATH/app/Config/Filters.php" "$BACKUP_DIR/" 2>/dev/null

echo "✅ Backup created at: $BACKUP_DIR"

echo ""
echo "🔧 Deploying Authentication Fixes..."
echo "------------------------------------"

echo "1. Updating UserModel.php - Fixed database binding error in updateLastLogin()"
# Key fix: Changed time() to date('Y-m-d H:i:s') in updateLastLogin method
# Key fix: Fixed findByLogin method with proper parameter binding

echo "2. Updating Auth Controller - Fixed redirect URLs"
# Key fix: Changed getDashboardRedirectUrl to use base_url() instead of relative paths

echo "3. Updating Auth Config - Fixed redirect paths"
# Key fix: Updated loginRedirect and logoutRedirect to use relative paths

echo "4. Updating Routes and Filters - CSRF protection fixes"
# Key fix: Removed CSRF from auth routes

echo ""
echo "🔄 Files that need to be updated on production:"
echo "---------------------------------------------"
echo "✓ app/Models/UserModel.php (Fixed: database binding error)"
echo "✓ app/Controllers/Auth.php (Fixed: redirect URLs with base_url())"
echo "✓ app/Config/Auth.php (Fixed: relative redirect paths)"
echo "✓ app/Config/Routes.php (Fixed: auth route configuration)"
echo "✓ app/Config/Filters.php (Fixed: CSRF exceptions for auth)"

echo ""
echo "📋 Key Issues Fixed:"
echo "-------------------"
echo "1. ❌ TypeError: BaseBuilder::setBind() - string/int type error"
echo "   ✅ FIXED: UserModel updateLastLogin() now uses datetime format"
echo ""
echo "2. ❌ 'no input file specified' after login"
echo "   ✅ FIXED: Auth Controller uses base_url() for redirects"
echo ""
echo "3. ❌ Login redirect URL configuration issues"
echo "   ✅ FIXED: Auth Config uses relative paths compatible with base_url()"
echo ""
echo "4. ❌ CSRF security exceptions on login"
echo "   ✅ FIXED: Auth routes excluded from CSRF protection"

echo ""
echo "🎯 Smart Dashboard Redirection Logic:"
echo "------------------------------------"
echo "• Admin users → /dashboard"
echo "• Thiva users → /dashboard/thiva"  
echo "• Levadia users → /dashboard/levadia"
echo "• Service users → /dashboard/service"
echo "• Selling Points → /dashboard/selling-points"
echo "• Lab users → /dashboard/lab"
echo "• Default → /dashboard"

echo ""
echo "⚡ Quick Production Deployment Commands:"
echo "--------------------------------------"
echo "# Upload the fixed files to production:"
echo "scp app/Models/UserModel.php user@server:$PRODUCTION_PATH/app/Models/"
echo "scp app/Controllers/Auth.php user@server:$PRODUCTION_PATH/app/Controllers/"
echo "scp app/Config/Auth.php user@server:$PRODUCTION_PATH/app/Config/"
echo "scp app/Config/Routes.php user@server:$PRODUCTION_PATH/app/Config/"
echo "scp app/Config/Filters.php user@server:$PRODUCTION_PATH/app/Config/"

echo ""
echo "🔍 After Deployment - Testing Steps:"
echo "-----------------------------------"
echo "1. Test login at: https://your-domain.com/auth/login"
echo "2. Try login with existing user credentials"
echo "3. Verify smart redirection works based on user group"
echo "4. Check server logs for any remaining errors"
echo "5. Test logout functionality"

echo ""
echo "📊 Monitoring Commands:"
echo "---------------------"
echo "# Check application logs:"
echo "tail -f $PRODUCTION_PATH/writable/logs/log-$(date +%Y-%m-%d).log"
echo ""
echo "# Check web server error logs:"
echo "tail -f /var/log/apache2/error.log"  # or nginx logs
echo ""
echo "# Monitor authentication attempts:"
echo "grep 'auth/attempt-login' $PRODUCTION_PATH/writable/logs/log-$(date +%Y-%m-%d).log"

echo ""
echo "🚨 Rollback Plan (if needed):"
echo "----------------------------"
echo "cp $BACKUP_DIR/* $PRODUCTION_PATH/app/Models/"
echo "cp $BACKUP_DIR/* $PRODUCTION_PATH/app/Controllers/"
echo "cp $BACKUP_DIR/* $PRODUCTION_PATH/app/Config/"

echo ""
echo "✅ Deployment script ready!"
echo "📝 Update the PRODUCTION_PATH variable above with your actual server path"
echo "🔑 Ensure you have SSH access and proper permissions on the production server"
echo ""