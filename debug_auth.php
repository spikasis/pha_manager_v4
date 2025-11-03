<?php
/**
 * Database Connection and Authentication Debug Script
 * This script checks database connectivity and authentication tables
 */

// Load CodeIgniter environment
require_once 'vendor/autoload.php';

use Config\Database;
use Config\Services;
use App\Models\UserModel;
use App\Models\GroupModel;

echo "<h1>🔍 Database Connection Debug Script</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .warning { color: orange; font-weight: bold; }
    .info { color: blue; }
    table { border-collapse: collapse; width: 100%; margin: 10px 0; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .section { margin: 20px 0; padding: 15px; border: 1px solid #ccc; border-radius: 5px; }
</style>";

try {
    echo "<div class='section'>";
    echo "<h2>📊 Database Configuration</h2>";
    
    // Get database configuration
    $config = Database::connect();
    $dbConfig = $config->getDatabase();
    
    echo "<table>";
    echo "<tr><th>Setting</th><th>Value</th></tr>";
    echo "<tr><td>Hostname</td><td>" . esc($dbConfig['hostname'] ?? 'N/A') . "</td></tr>";
    echo "<tr><td>Database</td><td>" . esc($dbConfig['database'] ?? 'N/A') . "</td></tr>";
    echo "<tr><td>Username</td><td>" . esc($dbConfig['username'] ?? 'N/A') . "</td></tr>";
    echo "<tr><td>Driver</td><td>" . esc($dbConfig['DBDriver'] ?? 'N/A') . "</td></tr>";
    echo "<tr><td>Port</td><td>" . esc($dbConfig['port'] ?? 'N/A') . "</td></tr>";
    echo "</table>";
    echo "</div>";

    echo "<div class='section'>";
    echo "<h2>🔌 Connection Test</h2>";
    
    // Test database connection
    $db = Database::connect();
    
    if ($db->connID) {
        echo "<p class='success'>✅ Database connection successful!</p>";
        
        // Get database version
        $version = $db->getVersion();
        echo "<p class='info'>Database Version: {$version}</p>";
        
        // List all tables
        $tables = $db->listTables();
        echo "<p class='info'>Total Tables: " . count($tables) . "</p>";
        
        echo "<h3>📋 Available Tables:</h3>";
        echo "<table>";
        echo "<tr><th>Table Name</th><th>Exists</th></tr>";
        
        $requiredTables = ['users', 'groups', 'users_groups', 'login_attempts'];
        foreach ($requiredTables as $table) {
            $exists = in_array($table, $tables);
            $status = $exists ? "<span class='success'>✅ Yes</span>" : "<span class='error'>❌ No</span>";
            echo "<tr><td>{$table}</td><td>{$status}</td></tr>";
        }
        echo "</table>";
        
    } else {
        echo "<p class='error'>❌ Database connection failed!</p>";
        exit;
    }
    echo "</div>";

    echo "<div class='section'>";
    echo "<h2>👥 Users Table Analysis</h2>";
    
    // Check if users table exists and get structure
    if (in_array('users', $tables)) {
        $query = $db->query("DESCRIBE users");
        $fields = $query->getResultArray();
        
        echo "<h3>📊 Table Structure:</h3>";
        echo "<table>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        foreach ($fields as $field) {
            echo "<tr>";
            echo "<td>" . esc($field['Field']) . "</td>";
            echo "<td>" . esc($field['Type']) . "</td>";
            echo "<td>" . esc($field['Null']) . "</td>";
            echo "<td>" . esc($field['Key']) . "</td>";
            echo "<td>" . esc($field['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Count users
        $userCount = $db->table('users')->countAllResults();
        echo "<p class='info'>Total Users: {$userCount}</p>";
        
        if ($userCount > 0) {
            echo "<h3>👤 User Records:</h3>";
            $users = $db->table('users')->get()->getResultArray();
            
            echo "<table>";
            echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Active</th><th>Created</th><th>Last Login</th></tr>";
            foreach ($users as $user) {
                $createdDate = $user['created_on'] ? date('d/m/Y H:i', $user['created_on']) : 'N/A';
                $lastLogin = $user['last_login'] ? date('d/m/Y H:i', $user['last_login']) : 'Never';
                $active = $user['active'] ? '<span class="success">Active</span>' : '<span class="error">Inactive</span>';
                
                echo "<tr>";
                echo "<td>" . esc($user['id']) . "</td>";
                echo "<td>" . esc($user['username']) . "</td>";
                echo "<td>" . esc($user['email']) . "</td>";
                echo "<td>{$active}</td>";
                echo "<td>{$createdDate}</td>";
                echo "<td>{$lastLogin}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='warning'>⚠️ No users found in the database!</p>";
        }
        
    } else {
        echo "<p class='error'>❌ Users table does not exist!</p>";
    }
    echo "</div>";

    echo "<div class='section'>";
    echo "<h2>🔒 Authentication Models Test</h2>";
    
    try {
        // Test UserModel
        $userModel = new UserModel();
        echo "<p class='success'>✅ UserModel loaded successfully</p>";
        
        // Test a simple query
        $testUser = $userModel->first();
        if ($testUser) {
            echo "<p class='success'>✅ UserModel query successful</p>";
            echo "<p class='info'>First user: " . esc($testUser['username']) . " (" . esc($testUser['email']) . ")</p>";
        } else {
            echo "<p class='warning'>⚠️ UserModel loaded but no users found</p>";
        }
        
        // Test GroupModel
        $groupModel = new GroupModel();
        echo "<p class='success'>✅ GroupModel loaded successfully</p>";
        
        $groups = $groupModel->findAll();
        echo "<p class='info'>Groups found: " . count($groups) . "</p>";
        
        if (!empty($groups)) {
            echo "<h3>🏷️ Available Groups:</h3>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Description</th></tr>";
            foreach ($groups as $group) {
                echo "<tr>";
                echo "<td>" . esc($group['id']) . "</td>";
                echo "<td>" . esc($group['name']) . "</td>";
                echo "<td>" . esc($group['description']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
    } catch (Exception $e) {
        echo "<p class='error'>❌ Model Error: " . esc($e->getMessage()) . "</p>";
    }
    echo "</div>";

    echo "<div class='section'>";
    echo "<h2>🔑 Login Test</h2>";
    
    // Test login functionality if users exist
    if ($userCount > 0) {
        $firstUser = $db->table('users')->where('active', 1)->get()->getRowArray();
        
        if ($firstUser) {
            echo "<p class='info'>Testing with user: " . esc($firstUser['username']) . "</p>";
            
            // Test findByLogin method
            $foundUser = $userModel->findByLogin($firstUser['username']);
            if ($foundUser) {
                echo "<p class='success'>✅ findByLogin() method works</p>";
            } else {
                echo "<p class='error'>❌ findByLogin() method failed</p>";
            }
            
            // Check password verification
            echo "<p class='info'>Password field length: " . strlen($firstUser['password']) . " characters</p>";
            echo "<p class='info'>Password starts with: " . substr($firstUser['password'], 0, 10) . "...</p>";
            
        } else {
            echo "<p class='warning'>⚠️ No active users found for login test</p>";
        }
    }
    echo "</div>";

    echo "<div class='section'>";
    echo "<h2>⚙️ Session Configuration</h2>";
    
    echo "<table>";
    echo "<tr><th>Setting</th><th>Value</th></tr>";
    echo "<tr><td>Session Started</td><td>" . (session_status() === PHP_SESSION_ACTIVE ? 'Yes' : 'No') . "</td></tr>";
    echo "<tr><td>Session ID</td><td>" . session_id() . "</td></tr>";
    echo "<tr><td>Session Save Path</td><td>" . session_save_path() . "</td></tr>";
    echo "<tr><td>Session Name</td><td>" . session_name() . "</td></tr>";
    echo "</table>";
    
    // Test session writing
    session_start();
    $_SESSION['test'] = 'debug_value';
    echo "<p class='success'>✅ Session write test successful</p>";
    echo "</div>";

    echo "<div class='section'>";
    echo "<h2>📝 Debug Summary</h2>";
    echo "<ul>";
    echo "<li class='success'>Database connection: OK</li>";
    echo "<li class='" . (in_array('users', $tables) ? 'success' : 'error') . "'>Users table: " . (in_array('users', $tables) ? 'EXISTS' : 'MISSING') . "</li>";
    echo "<li class='" . ($userCount > 0 ? 'success' : 'warning') . "'>User records: {$userCount}</li>";
    echo "<li class='success'>Models: OK</li>";
    echo "<li class='success'>Sessions: OK</li>";
    echo "</ul>";
    
    if ($userCount === 0) {
        echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h3>🚨 Recommendation:</h3>";
        echo "<p>The users table exists but is empty. You need to:</p>";
        echo "<ol>";
        echo "<li>Run the migration: <code>php spark migrate</code></li>";
        echo "<li>Or manually create a user account</li>";
        echo "<li>Or restore user data from backup</li>";
        echo "</ol>";
        echo "</div>";
    }
    echo "</div>";

} catch (Exception $e) {
    echo "<div class='section'>";
    echo "<h2 class='error'>💥 Fatal Error</h2>";
    echo "<p class='error'>Error: " . esc($e->getMessage()) . "</p>";
    echo "<p class='info'>File: " . esc($e->getFile()) . " (Line: " . $e->getLine() . ")</p>";
    echo "<pre>" . esc($e->getTraceAsString()) . "</pre>";
    echo "</div>";
}

echo "<hr>";
echo "<p><small>Debug script completed at " . date('Y-m-d H:i:s') . "</small></p>";
?>