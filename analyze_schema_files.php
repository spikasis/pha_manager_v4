<?php

// Schema File Analyzer for CI3 to CI4 Migration
// This script will analyze local schema files

echo "=== PHA Manager Database Schema File Analyzer ===\n\n";

$schemaDir = __DIR__ . '/database_schema';

if (!is_dir($schemaDir)) {
    echo "❌ Schema directory not found: $schemaDir\n";
    echo "Please create the directory and add your schema files.\n";
    exit(1);
}

echo "📁 Scanning schema directory: $schemaDir\n\n";

// Get all files in schema directory
$files = glob($schemaDir . '/*.*');

if (empty($files)) {
    echo "⚠️  No schema files found in directory.\n";
    echo "\nSupported file types:\n";
    echo "- .sql (SQL dump files)\n";
    echo "- .txt (Text description files)\n";
    echo "- Any file with table definitions\n";
    exit(1);
}

echo "📄 Found " . count($files) . " files:\n";
foreach ($files as $file) {
    echo "  - " . basename($file) . "\n";
}
echo "\n";

$tables = [];
$relationships = [];

// Process each file
foreach ($files as $file) {
    echo "🔍 Analyzing file: " . basename($file) . "\n";
    echo str_repeat("-", 40) . "\n";
    
    $content = file_get_contents($file);
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    
    if ($extension === 'sql') {
        analyzeSqlFile($content, $tables, $relationships);
    } else {
        // Try to detect table definitions in any text file
        analyzeTextFile($content, $tables);
    }
}

// Display results
echo "\n" . str_repeat("=", 60) . "\n";
echo "📊 ANALYSIS RESULTS\n";
echo str_repeat("=", 60) . "\n\n";

if (empty($tables)) {
    echo "❌ No table definitions found in the files.\n";
    echo "\nTip: Make sure your SQL file contains CREATE TABLE statements\n";
    echo "or your text files describe table structures.\n";
    exit(1);
}

echo "📋 Found " . count($tables) . " tables:\n\n";

foreach ($tables as $tableName => $tableInfo) {
    echo "🗂️  Table: $tableName\n";
    
    if (isset($tableInfo['columns']) && !empty($tableInfo['columns'])) {
        foreach ($tableInfo['columns'] as $column) {
            echo "   └── {$column['name']}: {$column['type']}";
            if ($column['primary']) echo " (PRIMARY KEY)";
            if ($column['null'] === false) echo " NOT NULL";
            if ($column['auto_increment']) echo " AUTO_INCREMENT";
            echo "\n";
        }
    }
    
    if (isset($tableInfo['row_count'])) {
        echo "   └── Estimated records: {$tableInfo['row_count']}\n";
    }
    
    echo "\n";
}

// Generate CI4 recommendations
echo "\n🎯 CI4 MIGRATION RECOMMENDATIONS:\n";
echo str_repeat("-", 50) . "\n";

generateRecommendations($tables);

// Generate Models preview
echo "\n📝 SUGGESTED CI4 MODELS:\n";
echo str_repeat("-", 50) . "\n";

generateModelSuggestions($tables);

echo "\n✅ Analysis complete!\n";

// Functions
function analyzeSqlFile($content, &$tables, &$relationships) {
    // Match CREATE TABLE statements
    $pattern = '/CREATE TABLE\s+`?(\w+)`?\s*\((.*?)\)/mis';
    
    if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            $tableName = $match[1];
            $tableDefinition = $match[2];
            
            echo "  ✅ Found table: $tableName\n";
            
            $tables[$tableName] = [
                'columns' => parseColumns($tableDefinition),
                'source' => 'sql'
            ];
        }
    }
    
    // Look for INSERT statements to estimate data size
    $insertPattern = '/INSERT INTO\s+`?(\w+)`?/i';
    if (preg_match_all($insertPattern, $content, $insertMatches)) {
        $insertCounts = array_count_values($insertMatches[1]);
        foreach ($insertCounts as $table => $count) {
            if (isset($tables[$table])) {
                $tables[$table]['row_count'] = $count;
            }
        }
    }
}

function parseColumns($tableDefinition) {
    $columns = [];
    $lines = explode(',', $tableDefinition);
    
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, 'KEY') !== false || strpos($line, 'INDEX') !== false) {
            continue;
        }
        
        // Parse column definition
        if (preg_match('/`?(\w+)`?\s+(\w+(?:\(\d+\))?)/i', $line, $colMatch)) {
            $columns[] = [
                'name' => $colMatch[1],
                'type' => $colMatch[2],
                'null' => strpos($line, 'NOT NULL') === false,
                'primary' => strpos($line, 'PRIMARY KEY') !== false || strpos($line, 'AUTO_INCREMENT') !== false,
                'auto_increment' => strpos($line, 'AUTO_INCREMENT') !== false
            ];
        }
    }
    
    return $columns;
}

function analyzeTextFile($content, &$tables) {
    // Try to find table descriptions in text format
    $lines = explode("\n", $content);
    $currentTable = null;
    
    foreach ($lines as $line) {
        $line = trim($line);
        
        // Look for table names
        if (preg_match('/(?:table|Table):\s*(\w+)/i', $line, $match)) {
            $currentTable = $match[1];
            echo "  ✅ Found table reference: $currentTable\n";
            $tables[$currentTable] = ['columns' => [], 'source' => 'text'];
        }
        
        // Look for column definitions
        if ($currentTable && preg_match('/(\w+)\s*[:=]\s*(\w+)/i', $line, $colMatch)) {
            $tables[$currentTable]['columns'][] = [
                'name' => $colMatch[1],
                'type' => $colMatch[2],
                'null' => true,
                'primary' => false,
                'auto_increment' => false
            ];
        }
    }
}

function generateRecommendations($tables) {
    $recommendations = [];
    
    foreach ($tables as $tableName => $info) {
        // Medical/Healthcare patterns
        if (stripos($tableName, 'patient') !== false) {
            $recommendations[] = "🏥 Create PatientModel for table '$tableName' - Core medical entity";
        }
        if (stripos($tableName, 'doctor') !== false || stripos($tableName, 'physician') !== false) {
            $recommendations[] = "👨‍⚕️ Create DoctorModel for table '$tableName' - Medical professional entity";
        }
        if (stripos($tableName, 'appointment') !== false || stripos($tableName, 'visit') !== false) {
            $recommendations[] = "📅 Create AppointmentModel for table '$tableName' - Scheduling system";
        }
        if (stripos($tableName, 'medicine') !== false || stripos($tableName, 'drug') !== false) {
            $recommendations[] = "💊 Create MedicineModel for table '$tableName' - Pharmacy management";
        }
        if (stripos($tableName, 'prescription') !== false) {
            $recommendations[] = "📝 Create PrescriptionModel for table '$tableName' - Prescription management";
        }
        
        // User/Auth patterns
        if (stripos($tableName, 'user') !== false || stripos($tableName, 'auth') !== false) {
            $recommendations[] = "👤 Create UserModel for table '$tableName' - Authentication system";
        }
        
        // Business patterns
        if (stripos($tableName, 'customer') !== false || stripos($tableName, 'client') !== false) {
            $recommendations[] = "👥 Create CustomerModel for table '$tableName' - Customer management";
        }
        if (stripos($tableName, 'product') !== false || stripos($tableName, 'item') !== false) {
            $recommendations[] = "📦 Create ProductModel for table '$tableName' - Product catalog";
        }
        if (stripos($tableName, 'order') !== false || stripos($tableName, 'sale') !== false) {
            $recommendations[] = "🛒 Create OrderModel for table '$tableName' - Sales management";
        }
    }
    
    if (empty($recommendations)) {
        echo "ℹ️  No specific patterns detected. Create Models for your main business entities.\n";
    } else {
        foreach ($recommendations as $rec) {
            echo "$rec\n";
        }
    }
}

function generateModelSuggestions($tables) {
    foreach ($tables as $tableName => $info) {
        $modelName = ucfirst(camelCase($tableName)) . 'Model';
        echo "📄 $modelName.php (for table: $tableName)\n";
        
        if (!empty($info['columns'])) {
            $allowedFields = [];
            $primaryKey = 'id';
            
            foreach ($info['columns'] as $column) {
                if (!$column['auto_increment'] && !$column['primary']) {
                    $allowedFields[] = $column['name'];
                }
                if ($column['primary']) {
                    $primaryKey = $column['name'];
                }
            }
            
            echo "   └── Primary Key: $primaryKey\n";
            echo "   └── Allowed Fields: " . implode(', ', array_slice($allowedFields, 0, 5));
            if (count($allowedFields) > 5) echo " ...";
            echo "\n";
        }
        echo "\n";
    }
}

function camelCase($string) {
    return str_replace('_', '', ucwords($string, '_'));
}

?>