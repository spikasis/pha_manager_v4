<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

class AnalyzeDatabase extends BaseCommand
{
    protected $group = 'migration';
    protected $name = 'db:analyze';
    protected $description = 'Analyze existing CI3 database structure for migration to CI4';

    public function run(array $params)
    {
        CLI::write('=== PHA Manager CI3 Database Structure Analyzer ===', 'yellow');
        CLI::newLine();

        try {
            $db = Database::connect();
            
            CLI::write('✅ Connected to database: customers_db2', 'green');
            CLI::newLine();

            // Get all tables
            $tables = $db->listTables();
            
            CLI::write('📊 Found ' . count($tables) . ' tables:', 'cyan');
            CLI::write(str_repeat('-', 50));
            
            foreach ($tables as $table) {
                CLI::newLine();
                CLI::write("📋 Table: $table", 'yellow');
                
                // Get table structure
                $fields = $db->getFieldData($table);
                
                foreach ($fields as $field) {
                    $null = $field->nullable ? 'NULL' : 'NOT NULL';
                    $key = $field->primary_key ? '(PRI)' : '';
                    
                    CLI::write("  └── {$field->name}: {$field->type} $null $key", 'white');
                }
                
                // Get row count
                try {
                    $count = $db->table($table)->countAllResults();
                    CLI::write("  └── Records: $count", 'light_blue');
                } catch (\Exception $e) {
                    CLI::write("  └── Records: Could not count", 'red');
                }
            }
            
            CLI::newLine(2);
            CLI::write('🎯 CI4 Migration Recommendations:', 'yellow');
            CLI::write(str_repeat('-', 50));
            
            $recommendations = [];
            
            foreach ($tables as $table) {
                // Check for common patterns
                if (strpos($table, 'user') !== false || strpos($table, 'auth') !== false) {
                    $recommendations[] = "👤 Found user/auth table: $table - Create UserModel and authentication";
                }
                
                if (strpos($table, 'patient') !== false) {
                    $recommendations[] = "🏥 Found patient table: $table - Create PatientModel";
                }
                
                if (strpos($table, 'appointment') !== false || strpos($table, 'visit') !== false) {
                    $recommendations[] = "📅 Found appointment/visit table: $table - Create AppointmentModel";
                }
                
                if (strpos($table, 'doctor') !== false || strpos($table, 'physician') !== false) {
                    $recommendations[] = "👨‍⚕️ Found doctor table: $table - Create DoctorModel";
                }
                
                if (strpos($table, 'medicine') !== false || strpos($table, 'drug') !== false || strpos($table, 'medication') !== false) {
                    $recommendations[] = "💊 Found medicine/drug table: $table - Create MedicineModel";
                }
                
                if (strpos($table, 'prescription') !== false) {
                    $recommendations[] = "📝 Found prescription table: $table - Create PrescriptionModel";
                }
                
                if (strpos($table, 'customer') !== false || strpos($table, 'client') !== false) {
                    $recommendations[] = "👥 Found customer/client table: $table - Create CustomerModel";
                }
            }
            
            if (empty($recommendations)) {
                CLI::write('ℹ️ No specific patterns detected. Manual analysis needed.', 'light_blue');
            } else {
                foreach ($recommendations as $rec) {
                    CLI::write($rec, 'green');
                }
            }
            
            CLI::newLine(2);
            CLI::write('📝 Next Steps:', 'yellow');
            CLI::write('1. ✅ Database connection configured');
            CLI::write('2. 🔄 Create CI4 Models for each relevant table');
            CLI::write('3. 🔄 Migrate Controllers to work with existing data');
            CLI::write('4. 🔄 Update Views for Bootstrap 4/SB Admin 2');
            CLI::write('5. 🔄 Test data migration and functionality');
            
            CLI::newLine();
            CLI::write('=== Analysis Complete ===', 'yellow');
            
        } catch (\Exception $e) {
            CLI::error('❌ Database connection failed: ' . $e->getMessage());
            CLI::newLine();
            CLI::write('Make sure the database credentials in .env are correct and the server is accessible.', 'red');
        }
    }
}