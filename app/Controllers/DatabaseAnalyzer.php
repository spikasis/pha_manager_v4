<?php

namespace App\Controllers;

use CodeIgniter\Database\Config;
use Exception;

class DatabaseAnalyzer extends BaseController
{
    public function index()
    {
        // Override database config for this analysis
        $config = config('Database');
        
        echo "<h2>🔍 Database Structure Analysis - customers_db2</h2>";
        echo "<style>body{font-family:Arial;margin:20px;} table{border-collapse:collapse;width:100%;margin:10px 0;} th,td{border:1px solid #ddd;padding:8px;text-align:left;} th{background:#f5f5f5;} .table-name{background:#e3f2fd;font-weight:bold;}</style>";
        
        try {
            $db = \Config\Database::connect();
            
            echo "<p>✅ Connected to database: <strong>customers_db2</strong></p>";
            
            // Get all tables
            $tables = $db->listTables();
            
            echo "<h3>📊 Found " . count($tables) . " tables:</h3>";
            
            foreach ($tables as $table) {
                echo "<div style='margin: 20px 0; border: 1px solid #ccc; padding: 15px;'>";
                echo "<h4 class='table-name'>📋 Table: $table</h4>";
                
                // Get table structure
                $fields = $db->getFieldData($table);
                
                echo "<table>";
                echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
                
                foreach ($fields as $field) {
                    echo "<tr>";
                    echo "<td><strong>{$field->name}</strong></td>";
                    echo "<td>{$field->type}</td>";
                    echo "<td>" . ($field->nullable ? 'YES' : 'NO') . "</td>";
                    echo "<td>" . ($field->primary_key ? 'PRI' : '') . "</td>";
                    echo "<td>" . ($field->default ?? 'NULL') . "</td>";
                    echo "<td></td>";
                    echo "</tr>";
                }
                echo "</table>";
                
                // Get row count
                try {
                    $count = $db->table($table)->countAllResults();
                    echo "<p><strong>📈 Records:</strong> $count</p>";
                } catch (Exception $e) {
                    echo "<p><strong>📈 Records:</strong> Could not count (possibly a view)</p>";
                }
                
                // Try to get sample data (first 3 rows)
                try {
                    $sampleData = $db->table($table)->limit(3)->get()->getResultArray();
                    if (!empty($sampleData)) {
                        echo "<h5>📋 Sample Data (first 3 rows):</h5>";
                        echo "<table>";
                        echo "<tr>";
                        foreach (array_keys($sampleData[0]) as $column) {
                            echo "<th>$column</th>";
                        }
                        echo "</tr>";
                        
                        foreach ($sampleData as $row) {
                            echo "<tr>";
                            foreach ($row as $value) {
                                $displayValue = strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value;
                                echo "<td>" . htmlspecialchars($displayValue) . "</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                } catch (Exception $e) {
                    echo "<p>⚠️ Could not retrieve sample data</p>";
                }
                
                echo "</div>";
            }
            
            // Generate recommendations
            echo "<div style='background: #f0f8ff; padding: 15px; margin: 20px 0; border-left: 4px solid #2196f3;'>";
            echo "<h3>🎯 CI4 Migration Recommendations:</h3>";
            
            $recommendations = [];
            
            foreach ($tables as $table) {
                // Check for common patterns
                if (strpos($table, 'user') !== false || strpos($table, 'auth') !== false) {
                    $recommendations[] = "👤 Found user/auth table: <strong>$table</strong> - Create UserModel and authentication system";
                }
                
                if (strpos($table, 'patient') !== false) {
                    $recommendations[] = "🏥 Found patient table: <strong>$table</strong> - Create PatientModel";
                }
                
                if (strpos($table, 'appointment') !== false || strpos($table, 'visit') !== false) {
                    $recommendations[] = "📅 Found appointment/visit table: <strong>$table</strong> - Create AppointmentModel";
                }
                
                if (strpos($table, 'doctor') !== false || strpos($table, 'physician') !== false) {
                    $recommendations[] = "👨‍⚕️ Found doctor table: <strong>$table</strong> - Create DoctorModel";
                }
                
                if (strpos($table, 'medicine') !== false || strpos($table, 'drug') !== false || strpos($table, 'medication') !== false) {
                    $recommendations[] = "💊 Found medicine/drug table: <strong>$table</strong> - Create MedicineModel";
                }
                
                if (strpos($table, 'prescription') !== false) {
                    $recommendations[] = "📝 Found prescription table: <strong>$table</strong> - Create PrescriptionModel";
                }
            }
            
            if (empty($recommendations)) {
                echo "<p>ℹ️ No specific medical patterns detected. This appears to be a general customer database.</p>";
                echo "<p>💡 Consider creating Models for your main business entities based on the table analysis above.</p>";
            } else {
                foreach ($recommendations as $rec) {
                    echo "<p>$rec</p>";
                }
            }
            
            echo "</div>";
            
            echo "<div style='background: #f9f9f9; padding: 15px; margin: 20px 0;'>";
            echo "<h3>📝 Next Steps:</h3>";
            echo "<ol>";
            echo "<li>✅ Database connection configured</li>";
            echo "<li>🔄 Create CI4 Models for each relevant table</li>";
            echo "<li>🔄 Migrate Controllers to work with existing data</li>";
            echo "<li>🔄 Update Views for Bootstrap 4/SB Admin 2</li>";
            echo "<li>🔄 Test data migration and functionality</li>";
            echo "</ol>";
            echo "</div>";
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
            echo "<p>Make sure the database credentials in .env are correct and the server is accessible.</p>";
        }
        
        return "";
    }
}