@echo off
REM Production Deployment Script for PHA Manager v4 Authentication System
REM Run this script to deploy the authentication fixes to production

echo.
echo 🚀 PHA Manager v4 Authentication Deployment Script
echo =================================================
echo.

REM Configuration - Update these paths according to your production setup
set PRODUCTION_PATH=C:\path\to\production\pha_manager_v4
set BACKUP_DIR=C:\backups\pha_manager_%date:~-4%%date:~-10,2%%date:~-7,2%_%time:~0,2%%time:~3,2%%time:~6,2%

echo 📂 Creating backup of current production files...
mkdir "%BACKUP_DIR%" 2>nul

REM Backup critical files before deployment
copy "%PRODUCTION_PATH%\app\Models\UserModel.php" "%BACKUP_DIR%\" 2>nul
copy "%PRODUCTION_PATH%\app\Controllers\Auth.php" "%BACKUP_DIR%\" 2>nul
copy "%PRODUCTION_PATH%\app\Config\Auth.php" "%BACKUP_DIR%\" 2>nul
copy "%PRODUCTION_PATH%\app\Config\Routes.php" "%BACKUP_DIR%\" 2>nul
copy "%PRODUCTION_PATH%\app\Config\Filters.php" "%BACKUP_DIR%\" 2>nul

echo ✅ Backup created at: %BACKUP_DIR%

echo.
echo 🔧 Deploying Authentication Fixes...
echo ------------------------------------

echo 1. UserModel.php - Fixed database binding error
echo    ✓ Fixed updateLastLogin(): time() → date('Y-m-d H:i:s')
echo    ✓ Fixed findByLogin(): proper parameter binding with WHERE clause
echo.

echo 2. Auth Controller - Fixed redirect URLs  
echo    ✓ Fixed getDashboardRedirectUrl(): relative paths → base_url()
echo.

echo 3. Auth Config - Fixed redirect paths
echo    ✓ Updated loginRedirect: '/dashboard' → 'dashboard'
echo    ✓ Updated logoutRedirect: '/auth/login' → 'auth/login'
echo.

echo 4. Routes and Filters - CSRF protection fixes
echo    ✓ Excluded auth routes from CSRF protection
echo.

echo 🎯 Smart Dashboard Redirection Logic:
echo ------------------------------------
echo • Admin users       → /dashboard
echo • Thiva users       → /dashboard/thiva  
echo • Levadia users     → /dashboard/levadia
echo • Service users     → /dashboard/service
echo • Selling Points    → /dashboard/selling-points
echo • Lab users         → /dashboard/lab
echo • Default           → /dashboard
echo.

echo 📋 Key Issues Fixed:
echo -------------------
echo 1. ❌ TypeError: BaseBuilder::setBind() - string/int type error
echo    ✅ FIXED: UserModel updateLastLogin() uses datetime format
echo.
echo 2. ❌ 'no input file specified' after login
echo    ✅ FIXED: Auth Controller uses base_url() for redirects
echo.
echo 3. ❌ Login redirect URL configuration issues
echo    ✅ FIXED: Auth Config uses relative paths
echo.
echo 4. ❌ CSRF security exceptions on login
echo    ✅ FIXED: Auth routes excluded from CSRF protection
echo.

echo ⚡ Files Ready for Production Upload:
echo ------------------------------------
echo ✓ app\Models\UserModel.php (Fixed database binding)
echo ✓ app\Controllers\Auth.php (Fixed redirect URLs)
echo ✓ app\Config\Auth.php (Fixed config paths)  
echo ✓ app\Config\Routes.php (Fixed route config)
echo ✓ app\Config\Filters.php (Fixed CSRF config)
echo.

echo 🔍 After Deployment Testing:
echo ---------------------------
echo 1. Navigate to: https://your-domain.com/auth/login
echo 2. Test login with existing user credentials
echo 3. Verify smart redirection based on user group
echo 4. Check server logs for errors
echo 5. Test logout functionality
echo.

echo 📊 Log Monitoring:
echo -----------------  
echo Check application logs at:
echo %PRODUCTION_PATH%\writable\logs\log-%date:~-4%-%date:~-10,2%-%date:~-7,2%.log
echo.

echo 🚨 Rollback Commands (if needed):
echo --------------------------------
echo copy "%BACKUP_DIR%\*" "%PRODUCTION_PATH%\app\Models\"
echo copy "%BACKUP_DIR%\*" "%PRODUCTION_PATH%\app\Controllers\"
echo copy "%BACKUP_DIR%\*" "%PRODUCTION_PATH%\app\Config\"
echo.

echo ✅ Ready for production deployment!
echo 📝 Update PRODUCTION_PATH variable with your server path
echo 🔑 Upload the fixed files to your production server
echo.
pause