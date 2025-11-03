@echo off
echo ====================================================
echo PHA Manager v4 - PHP Extensions Check
echo ====================================================
echo.

echo Checking PHP version:
php -v
echo.

echo Checking for required extensions:
echo.

php -m | findstr "intl" >nul
if %errorlevel%==0 (
    echo ✅ intl extension: ENABLED
) else (
    echo ❌ intl extension: MISSING - Need to enable in php.ini
)

php -m | findstr "mysqli" >nul
if %errorlevel%==0 (
    echo ✅ mysqli extension: ENABLED
) else (
    echo ❌ mysqli extension: MISSING - Need to enable in php.ini
)

php -m | findstr "pdo_mysql" >nul
if %errorlevel%==0 (
    echo ✅ pdo_mysql extension: ENABLED
) else (
    echo ❌ pdo_mysql extension: MISSING - Need to enable in php.ini
)

echo.
echo PHP Configuration file location:
php --ini | findstr "Loaded"

echo.
echo ====================================================
echo To fix missing extensions:
echo 1. Edit the php.ini file shown above
echo 2. Remove semicolon (;) from these lines:
echo    ;extension=intl
echo    ;extension=mysqli  
echo    ;extension=pdo_mysql
echo 3. Save the file and run this check again
echo ====================================================
pause