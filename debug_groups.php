<?php
// Debug script για να δω τι groups υπάρχουν
require_once 'index.php';

$CI =& get_instance();

header('Content-Type: text/html; charset=utf-8');

echo "<h2>🔍 Debug User Groups</h2>";
echo "<pre>";

try {
    // Get current user info
    if ($CI->ion_auth->logged_in()) {
        $user_id = $CI->ion_auth->get_user_id();
        $user = $CI->ion_auth->user()->row();
        
        echo "Current User:\n";
        echo "- ID: $user_id\n";
        echo "- Username: {$user->username}\n";
        echo "- Email: {$user->email}\n";
        echo "- Is Admin: " . ($CI->ion_auth->is_admin() ? 'YES' : 'NO') . "\n\n";
        
        // Get user groups
        $groups = $CI->ion_auth->get_users_groups($user_id)->result();
        echo "User Groups:\n";
        foreach ($groups as $group) {
            echo "- Group ID: {$group->id}, Name: {$group->name}, Description: {$group->description}\n";
        }
        
        $group_id = isset($groups[0]) ? $groups[0]->id : 0;
        echo "\nPrimary Group ID: $group_id\n\n";
        
    } else {
        echo "❌ User not logged in!\n\n";
    }
    
    // Get all groups
    echo "All Groups in System:\n";
    $all_groups = $CI->ion_auth->groups()->result();
    foreach ($all_groups as $group) {
        echo "- ID: {$group->id}, Name: {$group->name}, Description: {$group->description}\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";

echo "<hr>";
echo "<h3>Test Links</h3>";
echo "<p>";
echo "<a href='/admin/auth/logout' style='background: #dc3545; color: white; padding: 8px 12px; text-decoration: none; margin-right: 10px;'>Logout</a>";
echo "<a href='/admin' style='background: #007bff; color: white; padding: 8px 12px; text-decoration: none; margin-right: 10px;'>Admin Dashboard</a>";
echo "</p>";

// Instructions
echo "<h3>Instructions:</h3>";
echo "<ol>";
echo "<li>Login as 'lab' user</li>";
echo "<li>Run this script to see group ID</li>";
echo "<li>Update sidemenu with group-specific logic if needed</li>";
echo "</ol>";
?>