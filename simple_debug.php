<?php
/**
 * Simple Database Debug Script
 * Direct database connection test without CodeIgniter framework
 */

echo "<h1>🔍 Database Debug Script (Direct Connection)</h1>";
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
    
    // Read database config from .env file
    $envFile = __DIR__ . '/.env';
    $config = [];
    
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue; // Skip comments
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $config[trim($key)] = trim($value, "\"' ");
            }
        }
    }
    
    // Database settings
    $host = $config['database.default.hostname'] ?? 'localhost';
    $username = $config['database.default.username'] ?? 'root';
    $password = $config['database.default.password'] ?? '';
    $database = $config['database.default.database'] ?? '';
    $port = $config['database.default.port'] ?? 3306;
    
    echo "<table>";
    echo "<tr><th>Setting</th><th>Value</th></tr>";
    echo "<tr><td>Hostname</td><td>" . htmlspecialchars($host) . "</td></tr>";
    echo "<tr><td>Database</td><td>" . htmlspecialchars($database) . "</td></tr>";
    echo "<tr><td>Username</td><td>" . htmlspecialchars($username) . "</td></tr>";
    echo "<tr><td>Port</td><td>" . htmlspecialchars($port) . "</td></tr>";
    echo "<tr><td>Password</td><td>" . (empty($password) ? 'Empty' : '***hidden***') . "</td></tr>";
    echo "</table>";
    echo "</div>";

    echo "<div class='section'>";
    echo "<h2>🔌 Connection Test</h2>";
    
    // Create PDO connection
    $dsn = "mysql:host={$host};port={$port};charset=utf8mb4";
    if (!empty($database)) {
        $dsn .= ";dbname={$database}";
    }
    
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "<p class='success'>✅ Database connection successful!</p>";
    
    // Get MySQL version
    $version = $pdo->query('SELECT VERSION()')->fetchColumn();
    echo "<p class='info'>MySQL Version: {$version}</p>";
    
    // Select database if not already selected
    if (!empty($database)) {
        $pdo->exec("USE `{$database}`");
        echo "<p class='info'>Using database: {$database}</p>";
    }
    
    // List all tables
    $stmt = $pdo->query('SHOW TABLES');
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<p class='info'>Total Tables: " . count($tables) . "</p>";
    
    echo "<h3>📋 Available Tables:</h3>";
    echo "<table>";
    echo "<tr><th>Table Name</th><th>Exists</th><th>Rows</th></tr>";
    
    $requiredTables = ['users', 'groups', 'users_groups', 'login_attempts'];
    foreach ($requiredTables as $table) {
        $exists = in_array($table, $tables);
        if ($exists) {
            try {
                $count = $pdo->query("SELECT COUNT(*) FROM `{$table}`")->fetchColumn();
                $status = "<span class='success'>✅ Yes</span>";
                $rowCount = $count;
            } catch (Exception $e) {
                $status = "<span class='warning'>⚠️ Error</span>";
                $rowCount = "Error: " . $e->getMessage();
            }
        } else {
            $status = "<span class='error'>❌ No</span>";
            $rowCount = "N/A";
        }
        echo "<tr><td>{$table}</td><td>{$status}</td><td>{$rowCount}</td></tr>";
    }
    echo "</table>";
    
    echo "</div>";

    echo "<div class='section'>";
    echo "<h2>👥 Users Table Analysis</h2>";
    
    if (in_array('users', $tables)) {
        // Get table structure
        $stmt = $pdo->query("DESCRIBE users");
        $fields = $stmt->fetchAll();
        
        echo "<h3>📊 Table Structure:</h3>";
        echo "<table>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        foreach ($fields as $field) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($field['Field']) . "</td>";
            echo "<td>" . htmlspecialchars($field['Type']) . "</td>";
            echo "<td>" . htmlspecialchars($field['Null']) . "</td>";
            echo "<td>" . htmlspecialchars($field['Key']) . "</td>";
            echo "<td>" . htmlspecialchars($field['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Count users
        $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        echo "<p class='info'>Total Users: {$userCount}</p>";
        
        if ($userCount > 0) {
            echo "<h3>👤 User Records:</h3>";
            $stmt = $pdo->query("SELECT id, username, email, active, created_on, last_login FROM users ORDER BY id");
            $users = $stmt->fetchAll();
            
            echo "<table>";
            echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Active</th><th>Created</th><th>Last Login</th></tr>";
            foreach ($users as $user) {
                $createdDate = $user['created_on'] ? date('d/m/Y H:i', $user['created_on']) : 'N/A';
                $lastLogin = $user['last_login'] ? date('d/m/Y H:i', $user['last_login']) : 'Never';
                $active = $user['active'] ? '<span class="success">Active</span>' : '<span class="error">Inactive</span>';
                
                echo "<tr>";
                echo "<td>" . htmlspecialchars($user['id']) . "</td>";
                echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                echo "<td>{$active}</td>";
                echo "<td>{$createdDate}</td>";
                echo "<td>{$lastLogin}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Show password info for first user
            echo "<h3>🔑 Password Analysis (First User):</h3>";
            $stmt = $pdo->prepare("SELECT username, password FROM users WHERE active = 1 LIMIT 1");
            $stmt->execute();
            $firstUser = $stmt->fetch();
            
            if ($firstUser) {
                echo "<table>";
                echo "<tr><th>Field</th><th>Value</th></tr>";
                echo "<tr><td>Username</td><td>" . htmlspecialchars($firstUser['username']) . "</td></tr>";
                echo "<tr><td>Password Length</td><td>" . strlen($firstUser['password']) . " characters</td></tr>";
                echo "<tr><td>Password Hash Type</td><td>" . (strpos($firstUser['password'], '$2y$') === 0 ? 'PHP password_hash() (Bcrypt)' : 'Other/Unknown') . "</td></tr>";
                echo "<tr><td>Password Preview</td><td>" . htmlspecialchars(substr($firstUser['password'], 0, 20)) . "...</td></tr>";
                echo "</table>";
                
                // Test password verification
                echo "<h4>🔐 Password Test:</h4>";
                echo "<p class='info'>Try logging in with:</p>";
                echo "<ul>";
                echo "<li>Username: <strong>" . htmlspecialchars($firstUser['username']) . "</strong></li>";
                echo "<li>Password: Check your migration or manual insert for the password</li>";
                echo "</ul>";
            }
        } else {
            echo "<p class='warning'>⚠️ No users found in the database!</p>";
        }
    } else {
        echo "<p class='error'>❌ Users table does not exist!</p>";
    }
    echo "</div>";

    echo "<div class='section'>";
    echo "<h2>🏷️ Groups Table Analysis</h2>";
    
    if (in_array('groups', $tables)) {
        $stmt = $pdo->query("SELECT * FROM groups ORDER BY id");
        $groups = $stmt->fetchAll();
        
        echo "<p class='info'>Total Groups: " . count($groups) . "</p>";
        
        if (!empty($groups)) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Description</th></tr>";
            foreach ($groups as $group) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($group['id']) . "</td>";
                echo "<td>" . htmlspecialchars($group['name']) . "</td>";
                echo "<td>" . htmlspecialchars($group['description']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='warning'>⚠️ No groups found!</p>";
        }
    } else {
        echo "<p class='error'>❌ Groups table does not exist!</p>";
    }
    echo "</div>";

    echo "<div class='section'>";
    echo "<h2>📝 PHP & Session Info</h2>";
    
    echo "<table>";
    echo "<tr><th>Setting</th><th>Value</th></tr>";
    echo "<tr><td>PHP Version</td><td>" . PHP_VERSION . "</td></tr>";
    echo "<tr><td>Session Auto Start</td><td>" . (ini_get('session.auto_start') ? 'Yes' : 'No') . "</td></tr>";
    echo "<tr><td>Session Save Path</td><td>" . session_save_path() . "</td></tr>";
    echo "<tr><td>Session Cookie Name</td><td>" . session_name() . "</td></tr>";
    echo "<tr><td>Current Time</td><td>" . date('Y-m-d H:i:s') . "</td></tr>";
    echo "</table>";
    echo "</div>";

    echo "<div class='section'>";
    echo "<h2>🚨 Debug Summary & Recommendations</h2>";
    
    $usersExist = in_array('users', $tables);
    $userCount = 0;
    if ($usersExist) {
        $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
    
    echo "<ul>";
    echo "<li class='success'>✅ Database connection: Working</li>";
    echo "<li class='" . ($usersExist ? 'success' : 'error') . "'>" . ($usersExist ? '✅' : '❌') . " Users table: " . ($usersExist ? 'EXISTS' : 'MISSING') . "</li>";
    echo "<li class='" . ($userCount > 0 ? 'success' : 'warning') . "'>" . ($userCount > 0 ? '✅' : '⚠️') . " User records: {$userCount}</li>";
    echo "</ul>";
    
    if (!$usersExist) {
        echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h3>🚨 Critical Issue:</h3>";
        echo "<p>The authentication tables don't exist! You need to run the migration:</p>";
        echo "<code>php spark migrate</code>";
        echo "</div>";
    } elseif ($userCount === 0) {
        echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h3>⚠️ No Users Found:</h3>";
        echo "<p>The tables exist but no users are created. Options:</p>";
        echo "<ol>";
        echo "<li>Re-run migration: <code>php spark migrate:refresh</code></li>";
        echo "<li>Or create a user manually via register form</li>";
        echo "</ol>";
        echo "</div>";
    } else {
        echo "<div style='background: #d1edff; border: 1px solid #bee5eb; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h3>✅ Ready to Test Login:</h3>";
        echo "<p>Everything looks good! Try logging in with the credentials shown above.</p>";
        echo "</div>";
    }
    echo "</div>";

} catch (PDOException $e) {
    echo "<div class='section'>";
    echo "<h2 class='error'>💥 Database Connection Error</h2>";
    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p class='info'>Code: " . $e->getCode() . "</p>";
    echo "</div>";
} catch (Exception $e) {
    echo "<div class='section'>";
    echo "<h2 class='error'>💥 General Error</h2>";
    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
}

echo "<hr>";
echo "<p><small>Debug completed at " . date('Y-m-d H:i:s') . "</small></p>";
?>