<?php
/**
 * Debug script για την επαλήθευση του sidemenu για lab user (group 6)
 * Εκτελώ ως: http://localhost:8000/debug_lab_sidemenu.php
 */

// Include CodeIgniter bootstrap
require_once 'application/config/config.php';
require_once 'application/config/database.php';

echo "<h3>Debug Lab User Sidemenu Access</h3>";
echo "<hr>";

// Database connection
$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

if ($mysqli->connect_error) {
    echo "Database connection failed: " . $mysqli->connect_error . "<br>";
    exit;
}

// Find lab user details  
$query = "SELECT u.id, u.username, u.first_name, u.last_name, u.active, ug.group_id, g.name as group_name 
          FROM users u 
          LEFT JOIN users_groups ug ON u.id = ug.user_id 
          LEFT JOIN groups g ON ug.group_id = g.id 
          WHERE u.username = 'lab' OR u.first_name LIKE '%lab%' OR u.last_name LIKE '%lab%'
          ORDER BY u.id";

$result = $mysqli->query($query);

if ($result && $result->num_rows > 0) {
    echo "<h4>Lab User Details:</h4>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Username</th><th>Name</th><th>Active</th><th>Group ID</th><th>Group Name</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        $active_status = $row['active'] ? 'Yes' : 'No';
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
        echo "<td>" . $active_status . "</td>";
        echo "<td>" . ($row['group_id'] ?? 'No Group') . "</td>";
        echo "<td>" . ($row['group_name'] ?? 'No Group') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p><strong>No lab users found!</strong></p>";
}

echo "<hr>";

// Check sidemenu configuration
echo "<h4>Sidemenu Configuration Check:</h4>";

// Check active theme configuration
$config_file = 'application/config/ci_my_admin.php';
if (file_exists($config_file)) {
    $config_content = file_get_contents($config_file);
    if (preg_match('/\$config\[\'ci_my_admin_template_dir_admin\'\]\s*=\s*[\'"]([^\'"]+)[\'"]/', $config_content, $matches)) {
        $active_theme = $matches[1];
        echo "<p><strong>Active Theme Directory:</strong> $active_theme</p>";
        
        $sidemenu_file = "application/views/$active_theme/sidemenu.php";
        if (file_exists($sidemenu_file)) {
            echo "<p><strong>Sidemenu File:</strong> $sidemenu_file (EXISTS)</p>";
            
            // Check for group 6 section
            $sidemenu_content = file_get_contents($sidemenu_file);
            $group6_exists = strpos($sidemenu_content, 'group_id == 6') !== false;
            echo "<p><strong>Group 6 Section:</strong> " . ($group6_exists ? 'FOUND' : 'NOT FOUND') . "</p>";
            
            // Check for demo options in group 6
            if (preg_match('/group_id == 6.*?collapseStocksLab.*?<\/div>/s', $sidemenu_content, $group6_section)) {
                $demo_exists = strpos($group6_section[0], 'get_demo') !== false;
                $demo_branch_exists = strpos($group6_section[0], 'selectBranchDemo') !== false;
                $demo_types_exists = strpos($group6_section[0], 'manage_demo_types') !== false;
                
                echo "<p><strong>Group 6 Demo Options:</strong></p>";
                echo "<ul>";
                echo "<li>Demo Γενικά: " . ($demo_exists ? '✓ FOUND' : '✗ NOT FOUND') . "</li>";
                echo "<li>Demo Υποκαταστήματος: " . ($demo_branch_exists ? '✓ FOUND' : '✗ NOT FOUND') . "</li>";
                echo "<li>Διαχείριση Demo Types: " . ($demo_types_exists ? '✓ FOUND' : '✗ NOT FOUND') . "</li>";
                echo "</ul>";
                
                if ($demo_exists && $demo_branch_exists && $demo_types_exists) {
                    echo "<p><strong style='color: green;'>✓ ALL DEMO OPTIONS ARE AVAILABLE FOR GROUP 6!</strong></p>";
                } else {
                    echo "<p><strong style='color: red;'>✗ SOME DEMO OPTIONS ARE MISSING FOR GROUP 6</strong></p>";
                }
            } else {
                echo "<p><strong style='color: red;'>✗ Group 6 section not found in sidemenu</strong></p>";
            }
        } else {
            echo "<p><strong style='color: red;'>✗ Sidemenu file not found: $sidemenu_file</strong></p>";
        }
    }
} else {
    echo "<p><strong style='color: red;'>✗ Config file not found</strong></p>";
}

echo "<hr>";
echo "<h4>Next Steps:</h4>";
echo "<ol>";
echo "<li>Login as lab user to test sidemenu visibility</li>";
echo "<li>Navigate to Ακουστικά section</li>";
echo "<li>Verify Demo options are now visible</li>";
echo "<li>Test Demo functionality access</li>";
echo "</ol>";

$mysqli->close();
?>