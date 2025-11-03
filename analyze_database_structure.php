<?php
/**
 * Database Schema Analysis for PHA Manager v4
 * Complete database structure analysis with relationships
 */

// Database configuration
$config = [
    'host' => 'linux2917.grserver.gr',
    'database' => 'customers_db2',
    'username' => 'spik',
    'password' => '0382sp@#'
];

try {
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4",
        $config['username'],
        $config['password']
    );
    
    echo "<!DOCTYPE html><html><head><title>Database Schema Analysis</title>";
    echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>";
    echo "<style>body{font-family: 'Courier New', monospace;} .table-info{background:#e7f3ff;} .relationship{color:#0066cc;font-weight:bold;}</style>";
    echo "</head><body class='bg-light p-4'>";
    
    echo "<div class='container-fluid'>";
    echo "<h1 class='mb-4'>📊 PHA Manager v4 - Database Schema Analysis</h1>";
    
    // Get all tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<div class='alert alert-info'>";
    echo "<h4>🗄️ Total Tables Found: " . count($tables) . "</h4>";
    echo "</div>";
    
    $tableAnalysis = [];
    
    foreach ($tables as $table) {
        echo "<div class='card mb-4'>";
        echo "<div class='card-header'><h3>📋 Table: <code>{$table}</code></h3></div>";
        echo "<div class='card-body'>";
        
        // Get table structure
        $stmt = $pdo->query("DESCRIBE `$table`");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get row count
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM `$table`");
        $rowCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        echo "<p><strong>📊 Rows:</strong> {$rowCount} | <strong>📝 Columns:</strong> " . count($columns) . "</p>";
        
        // Analyze table structure
        echo "<table class='table table-sm table-striped'>";
        echo "<thead class='table-dark'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        echo "</thead><tbody>";
        
        $primaryKeys = [];
        $foreignKeys = [];
        
        foreach ($columns as $column) {
            $rowClass = '';
            if ($column['Key'] == 'PRI') {
                $rowClass = 'table-warning';
                $primaryKeys[] = $column['Field'];
            } elseif (strpos(strtolower($column['Field']), '_id') !== false && $column['Field'] != 'id') {
                $rowClass = 'table-info';
                $foreignKeys[] = $column['Field'];
            }
            
            echo "<tr class='{$rowClass}'>";
            echo "<td><code>{$column['Field']}</code></td>";
            echo "<td>{$column['Type']}</td>";
            echo "<td>{$column['Null']}</td>";
            echo "<td>" . ($column['Key'] ? "<span class='badge bg-success'>{$column['Key']}</span>" : '') . "</td>";
            echo "<td>{$column['Default']}</td>";
            echo "<td>{$column['Extra']}</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
        
        // Store analysis data
        $tableAnalysis[$table] = [
            'columns' => $columns,
            'row_count' => $rowCount,
            'primary_keys' => $primaryKeys,
            'foreign_keys' => $foreignKeys
        ];
        
        // Show relationships
        if (!empty($foreignKeys)) {
            echo "<div class='alert alert-primary'>";
            echo "<h6>🔗 Potential Relationships:</h6>";
            foreach ($foreignKeys as $fk) {
                $relatedTable = str_replace('_id', '', $fk);
                if ($relatedTable === 'user') $relatedTable = 'users';
                echo "<span class='relationship'>{$table}.{$fk} → {$relatedTable}.id</span><br>";
            }
            echo "</div>";
        }
        
        echo "</div></div>";
    }
    
    // Generate CRUD Priority Analysis
    echo "<div class='card border-success mb-4'>";
    echo "<div class='card-header bg-success text-white'>";
    echo "<h3>🎯 CRUD Implementation Priority Analysis</h3>";
    echo "</div><div class='card-body'>";
    
    // Categorize tables by importance
    $coreEntities = [];
    $userManagement = [];
    $systemTables = [];
    $lookupTables = [];
    
    foreach ($tableAnalysis as $table => $analysis) {
        $columnNames = array_column($analysis['columns'], 'Field');
        
        // Core business entities (main data)
        if (in_array($table, ['customers', 'patients', 'appointments', 'devices', 'orders', 'products'])) {
            $coreEntities[] = $table;
        }
        // User management
        elseif (in_array($table, ['users', 'groups', 'users_groups', 'login_attempts'])) {
            $userManagement[] = $table;
        }
        // Lookup/Reference tables (usually have 'name' field)
        elseif (in_array('name', $columnNames) || in_array('title', $columnNames) || $analysis['row_count'] < 100) {
            $lookupTables[] = $table;
        }
        // System tables
        else {
            $systemTables[] = $table;
        }
    }
    
    echo "<div class='row'>";
    
    echo "<div class='col-md-3'>";
    echo "<h5 class='text-primary'>🔥 Priority 1: Core Entities</h5>";
    echo "<ul class='list-group'>";
    foreach ($coreEntities as $table) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo "<code>{$table}</code>";
        echo "<span class='badge bg-primary'>{$tableAnalysis[$table]['row_count']} rows</span>";
        echo "</li>";
    }
    echo "</ul></div>";
    
    echo "<div class='col-md-3'>";
    echo "<h5 class='text-success'>👥 Priority 2: User Management</h5>";
    echo "<ul class='list-group'>";
    foreach ($userManagement as $table) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo "<code>{$table}</code>";
        echo "<span class='badge bg-success'>{$tableAnalysis[$table]['row_count']} rows</span>";
        echo "</li>";
    }
    echo "</ul></div>";
    
    echo "<div class='col-md-3'>";
    echo "<h5 class='text-warning'>📋 Priority 3: Lookup Tables</h5>";
    echo "<ul class='list-group'>";
    foreach ($lookupTables as $table) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo "<code>{$table}</code>";
        echo "<span class='badge bg-warning'>{$tableAnalysis[$table]['row_count']} rows</span>";
        echo "</li>";
    }
    echo "</ul></div>";
    
    echo "<div class='col-md-3'>";
    echo "<h5 class='text-secondary'>⚙️ Priority 4: System Tables</h5>";
    echo "<ul class='list-group'>";
    foreach ($systemTables as $table) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo "<code>{$table}</code>";
        echo "<span class='badge bg-secondary'>{$tableAnalysis[$table]['row_count']} rows</span>";
        echo "</li>";
    }
    echo "</ul></div>";
    
    echo "</div>";
    echo "</div></div>";
    
    // Export analysis for todo generation
    $analysisData = [
        'core_entities' => $coreEntities,
        'user_management' => $userManagement, 
        'lookup_tables' => $lookupTables,
        'system_tables' => $systemTables,
        'table_analysis' => $tableAnalysis
    ];
    
    file_put_contents('database_analysis.json', json_encode($analysisData, JSON_PRETTY_PRINT));
    
    echo "<div class='alert alert-success'>";
    echo "<h4>✅ Analysis Complete!</h4>";
    echo "<p>Database analysis saved to <code>database_analysis.json</code></p>";
    echo "<p>Ready to generate CRUD implementation todo list!</p>";
    echo "</div>";
    
    echo "</div></body></html>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>