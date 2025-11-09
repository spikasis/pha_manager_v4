<?php
// Debug sidemenu logic for lab user
require_once 'index.php';

$CI =& get_instance();

header('Content-Type: text/html; charset=utf-8');

echo "<h2>🔍 Sidemenu Debug for Current User</h2>";
echo "<pre>";

try {
    echo "=== SIDEMENU LOGIC TEST ===\n\n";
    
    // Test the exact same logic as sidemenu
    if (method_exists($CI, 'ion_auth') && $CI->ion_auth) {
        $user_id = $CI->ion_auth->get_user_id();
        echo "User ID: " . ($user_id ?: 'NULL') . "\n";
        
        if ($user_id) {
            $groups = $CI->ion_auth->get_users_groups($user_id)->result();
            echo "Groups found: " . count($groups) . "\n";
            
            foreach ($groups as $i => $group) {
                echo "Group $i: ID = {$group->id}, Name = {$group->name}\n";
            }
            
            $group_id = isset($groups[0]) ? $groups[0]->id : 0;
            echo "Primary group_id: $group_id\n";
            
            $is_admin = $CI->ion_auth->is_admin();
            echo "Is admin: " . ($is_admin ? 'YES' : 'NO') . "\n\n";
            
            // Test sidemenu conditions
            echo "=== SIDEMENU CONDITIONS ===\n";
            echo "Current condition: No conditions (show for all)\n";
            echo "Demo options should be visible: YES\n\n";
            
            // Test specific conditions we had before
            echo "Previous conditions test:\n";
            echo "- \$is_admin: " . ($is_admin ? 'TRUE' : 'FALSE') . "\n";
            echo "- in_array(\$group_id, [2,3,4,5,6]): " . (in_array($group_id, [2,3,4,5,6]) ? 'TRUE' : 'FALSE') . "\n";
            echo "- \$group_id > 1: " . ($group_id > 1 ? 'TRUE' : 'FALSE') . "\n";
            echo "- Overall: " . (($is_admin || in_array($group_id, [2,3,4,5,6]) || $group_id > 1) ? 'SHOW' : 'HIDE') . "\n";
            
        } else {
            echo "❌ User not logged in!\n";
        }
        
    } else {
        echo "❌ ion_auth not available or not loaded!\n";
        echo "Available CI properties:\n";
        foreach (get_object_vars($CI) as $prop => $value) {
            if (is_object($value)) {
                echo "- $prop: " . get_class($value) . "\n";
            } else {
                echo "- $prop: " . gettype($value) . "\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "</pre>";

echo "<hr>";
echo "<h3>Current Sidemenu Code:</h3>";
echo "<code>";
echo htmlentities('<?php
$CI =& get_instance();
$user_id = $CI->ion_auth->get_user_id();
$groups = $CI->ion_auth->get_users_groups($user_id)->result();
$group_id = isset($groups[0]) ? $groups[0]->id : 0;
$is_admin = $CI->ion_auth->is_admin();
?>');
echo "</code>";

echo "<h3>Possible Issues:</h3>";
echo "<ol>";
echo "<li><strong>ion_auth library not loaded</strong> in sidemenu context</li>";
echo "<li><strong>Cache issue</strong> - try hard refresh</li>";
echo "<li><strong>Wrong theme</strong> - check which sidemenu file is being used</li>";
echo "<li><strong>JavaScript error</strong> - check browser console</li>";
echo "</ol>";

echo "<h3>Quick Fix:</h3>";
echo "<p>Since we removed all conditions, Demo options should show for ALL users. If they don't show for lab user, there's likely a different sidemenu file being used.</p>";
?>