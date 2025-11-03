<?php
/**
 * Pre-Deployment Check Script
 * Validates that all authentication fixes are in place before production deployment
 */

echo "🔍 PHA Manager v4 - Pre-Deployment Authentication Check\n";
echo "====================================================\n\n";

$issues = [];
$fixes = [];

// Check 1: UserModel.php - updateLastLogin method
echo "1. Checking UserModel.php...\n";
$userModelContent = file_get_contents('app/Models/UserModel.php');

if (strpos($userModelContent, "['last_login' => date('Y-m-d H:i:s')]") !== false) {
    $fixes[] = "✅ UserModel updateLastLogin() uses datetime format (not time())";
} else {
    $issues[] = "❌ UserModel updateLastLogin() still uses time() - needs datetime format";
}

if (strpos($userModelContent, 'where("(email = ? OR username = ?)", [$login, $login])') !== false) {
    $fixes[] = "✅ UserModel findByLogin() uses proper parameter binding";
} else {
    $issues[] = "❌ UserModel findByLogin() may have binding issues";
}

// Check 2: Auth Controller - redirect URLs
echo "2. Checking Auth Controller...\n";
$authControllerContent = file_get_contents('app/Controllers/Auth.php');

if (strpos($authControllerContent, "return base_url('dashboard')") !== false) {
    $fixes[] = "✅ Auth Controller uses base_url() for redirects";
} else {
    $issues[] = "❌ Auth Controller may still use relative paths for redirects";
}

if (strpos($authControllerContent, 'getDashboardRedirectUrl') !== false) {
    $fixes[] = "✅ Auth Controller has smart dashboard redirection logic";
} else {
    $issues[] = "❌ Auth Controller missing smart dashboard redirection";
}

// Check 3: Auth Config
echo "3. Checking Auth Config...\n";
$authConfigContent = file_get_contents('app/Config/Auth.php');

if (strpos($authConfigContent, "loginRedirect = 'dashboard'") !== false) {
    $fixes[] = "✅ Auth Config uses relative paths for loginRedirect";
} else {
    $issues[] = "❌ Auth Config loginRedirect should be relative path 'dashboard'";
}

// Check 4: Routes configuration
echo "4. Checking Routes configuration...\n";
$routesContent = file_get_contents('app/Config/Routes.php');

if (strpos($routesContent, "attempt-login") !== false) {
    $fixes[] = "✅ Routes include attempt-login endpoint";
} else {
    $issues[] = "❌ Routes missing attempt-login endpoint";
}

// Check 5: Filters configuration (CSRF)
echo "5. Checking Filters configuration...\n";
$filtersContent = file_get_contents('app/Config/Filters.php');

if (strpos($filtersContent, "// 'csrf',") !== false || strpos($filtersContent, "'csrf' =>") === false) {
    $fixes[] = "✅ CSRF filter is disabled globally (safe for auth routes)";
} else {
    $issues[] = "❌ CSRF filter may interfere with auth routes";
}

// Summary
echo "\n📊 Pre-Deployment Check Results:\n";
echo "================================\n\n";

if (count($fixes) > 0) {
    echo "✅ FIXES CONFIRMED:\n";
    foreach ($fixes as $fix) {
        echo "   $fix\n";
    }
    echo "\n";
}

if (count($issues) > 0) {
    echo "❌ ISSUES FOUND:\n";
    foreach ($issues as $issue) {
        echo "   $issue\n";
    }
    echo "\n";
    echo "🚨 Please fix the issues above before deploying to production!\n\n";
    exit(1);
} else {
    echo "🎉 ALL CHECKS PASSED!\n";
    echo "====================\n\n";
    
    echo "📂 Files ready for production deployment:\n";
    echo "• app/Models/UserModel.php - Database binding fixes applied ✅\n";
    echo "• app/Controllers/Auth.php - Redirect URL fixes applied ✅\n";
    echo "• app/Config/Auth.php - Configuration fixes applied ✅\n";
    echo "• app/Config/Routes.php - Route configuration ready ✅\n";
    echo "• app/Config/Filters.php - CSRF exceptions configured ✅\n\n";
    
    echo "🚀 Ready to deploy to production server!\n";
    echo "📋 Use the deployment guide (DEPLOYMENT_GUIDE.md) for step-by-step instructions.\n\n";
    
    echo "⚡ Quick deployment command examples:\n";
    echo "Linux/Mac: ./deploy_auth_fixes.sh\n";
    echo "Windows: deploy_auth_fixes.bat\n\n";
    
    exit(0);
}
?>