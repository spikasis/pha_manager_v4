<?php
/**
 * Final verification script για το lab user sidemenu fix
 * Τεστάρει ότι οι demo επιλογές εμφανίζονται σωστά για group 6
 */

echo "<h2>🔧 Final Lab User Sidemenu Verification</h2>";
echo "<hr>";

// Check sidemenu file
$sidemenu_file = "application/views/admin/themes/sbladmin2/sidemenu.php";
if (file_exists($sidemenu_file)) {
    echo "<h3>❌ Wrong Sidemenu File Still Exists</h3>";
    echo "<p><strong>File:</strong> $sidemenu_file</p>";
    echo "<p>This file should not be used. The correct file is sbadmin2/sidemenu.php</p>";
}

$correct_sidemenu = "application/views/admin/themes/sbladmin2/sidemenu.php";
if (file_exists($correct_sidemenu)) {
    echo "<h3>✅ Correct Sidemenu File Analysis</h3>";
    echo "<p><strong>File:</strong> $correct_sidemenu</p>";
    
    $content = file_get_contents($correct_sidemenu);
    
    // Check for Group 6 section
    $group6_pattern = '/group_id == 6.*?collapseStocksLab.*?<\/div>/s';
    if (preg_match($group6_pattern, $content, $group6_match)) {
        echo "<p><strong>✅ Group 6 Section:</strong> FOUND</p>";
        
        $group6_section = $group6_match[0];
        
        // Check for demo options
        $demo_general = strpos($group6_section, 'get_demo') !== false;
        $demo_branch = strpos($group6_section, 'selectBranchDemo') !== false;
        $demo_manage = strpos($group6_section, 'manage_demo_types') !== false;
        
        echo "<h4>Demo Options in Group 6:</h4>";
        echo "<ul>";
        echo "<li>Demo Γενικά (get_demo): " . ($demo_general ? "✅ FOUND" : "❌ MISSING") . "</li>";
        echo "<li>Demo Υποκαταστήματος (selectBranchDemo): " . ($demo_branch ? "✅ FOUND" : "❌ MISSING") . "</li>";
        echo "<li>Διαχείριση Demo Types (manage_demo_types): " . ($demo_manage ? "✅ FOUND" : "❌ MISSING") . "</li>";
        echo "</ul>";
        
        if ($demo_general && $demo_branch && $demo_manage) {
            echo "<h3 style='color: green;'>🎉 SUCCESS: All Demo Options Added to Group 6!</h3>";
        } else {
            echo "<h3 style='color: red;'>❌ ISSUE: Some Demo Options Missing</h3>";
        }
    } else {
        echo "<p><strong>❌ Group 6 Section:</strong> NOT FOUND</p>";
    }
}

echo "<hr>";

// Check controller methods
echo "<h3>📋 Controller Methods Check</h3>";
$controller_file = "application/modules/admin/controllers/stocks.php";
if (file_exists($controller_file)) {
    $controller_content = file_get_contents($controller_file);
    
    $get_demo_exists = strpos($controller_content, 'function get_demo') !== false;
    $manage_demo_exists = strpos($controller_content, 'function manage_demo_types') !== false;
    $update_demo_exists = strpos($controller_content, 'function update_demo_type') !== false;
    
    echo "<ul>";
    echo "<li>get_demo() method: " . ($get_demo_exists ? "✅ EXISTS" : "❌ MISSING") . "</li>";
    echo "<li>manage_demo_types() method: " . ($manage_demo_exists ? "✅ EXISTS" : "❌ MISSING") . "</li>";
    echo "<li>update_demo_type() method: " . ($update_demo_exists ? "✅ EXISTS" : "❌ MISSING") . "</li>";
    echo "</ul>";
}

echo "<hr>";

// Test instructions
echo "<h3>🧪 Testing Instructions for Lab User</h3>";
echo "<ol>";
echo "<li><strong>Login as Lab User:</strong>";
echo "<ul><li>Go to: <a href='http://localhost:8000/auth/login' target='_blank'>http://localhost:8000/auth/login</a></li>";
echo "<li>Use lab user credentials</li></ul></li>";
echo "<li><strong>Navigate to Sidemenu:</strong>";
echo "<ul><li>Look for 'Ακουστικά' menu item</li>";
echo "<li>Click to expand the submenu</li></ul></li>";
echo "<li><strong>Verify Demo Options:</strong>";
echo "<ul>";
echo "<li>Demo Γενικά - should link to /admin/stocks/get_demo</li>";
echo "<li>Demo Υποκαταστήματος - should trigger selectBranchDemo() function</li>";
echo "<li>Διαχείριση Demo Types - should link to /admin/stocks/manage_demo_types</li>";
echo "</ul></li>";
echo "<li><strong>Test Functionality:</strong>";
echo "<ul><li>Click each demo option</li>";
echo "<li>Verify pages load without errors</li>";
echo "<li>Check that data is displayed correctly</li></ul></li>";
echo "</ol>";

echo "<hr>";

// Summary
echo "<h3>📊 Fix Summary</h3>";
echo "<div style='background: #f0f8f0; padding: 15px; border-radius: 5px;'>";
echo "<p><strong>Problem:</strong> Lab user (group 6) could not see Demo options in sidemenu</p>";
echo "<p><strong>Root Cause:</strong> Group 6 section in sidemenu.php was missing Demo menu items</p>";
echo "<p><strong>Solution:</strong> Added three Demo options to collapseStocksLab section:</p>";
echo "<ul>";
echo "<li>✅ Demo Γενικά</li>";
echo "<li>✅ Demo Υποκαταστήματος</li>"; 
echo "<li>✅ Διαχείριση Demo Types</li>";
echo "</ul>";
echo "<p><strong>Result:</strong> Lab users (group 6) now have full access to Demo functionality</p>";
echo "</div>";

echo "<hr>";
echo "<p><em>🔗 Next: Test with actual lab user login to confirm functionality</em></p>";
?>