<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install_reminders extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function index() {
        echo "<h1>Payment Reminders Installation</h1>";
        
        // Check if table exists
        if ($this->db->table_exists('payment_reminders_log')) {
            echo "<p style='color: green;'>✓ payment_reminders_log table already exists</p>";
            $count = $this->db->count_all('payment_reminders_log');
            echo "<p>Records: $count</p>";
        } else {
            echo "<p style='color: orange;'>Creating payment_reminders_log table...</p>";
            
            // Create the table
            $sql = "
                CREATE TABLE `payment_reminders_log` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `customer_id` int(11) NOT NULL,
                  `stock_id` int(11) DEFAULT NULL,
                  `reminder_type` enum('standard','urgent','final') DEFAULT 'standard',
                  `sent_date` datetime NOT NULL,
                  `sent_by` int(11) NOT NULL,
                  `method` enum('system','manual','sms','email') DEFAULT 'system',
                  `notes` text DEFAULT NULL,
                  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`),
                  KEY `idx_customer_id` (`customer_id`),
                  KEY `idx_stock_id` (`stock_id`),
                  KEY `idx_sent_date` (`sent_date`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci
            ";
            
            try {
                $this->db->query($sql);
                echo "<p style='color: green;'>✓ Table created successfully!</p>";
                
                // Add foreign key constraints separately (they might fail if tables don't exist)
                $constraints = [
                    "ALTER TABLE `payment_reminders_log` ADD CONSTRAINT `fk_payment_reminders_customer` 
                     FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE",
                    "ALTER TABLE `payment_reminders_log` ADD CONSTRAINT `fk_payment_reminders_stock` 
                     FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE SET NULL",
                ];
                
                foreach ($constraints as $constraint) {
                    try {
                        $this->db->query($constraint);
                        echo "<p style='color: green;'>✓ Foreign key constraint added</p>";
                    } catch (Exception $e) {
                        echo "<p style='color: orange;'>⚠ Constraint skipped: " . $e->getMessage() . "</p>";
                    }
                }
                
            } catch (Exception $e) {
                echo "<p style='color: red;'>✗ Error creating table: " . $e->getMessage() . "</p>";
            }
        }
        
        echo "<h3>Test Payment Reminders Link</h3>";
        echo "<p><a href='" . base_url('payment_reminders_simple') . "'>Test Simple Version</a></p>";
        echo "<p><a href='" . base_url('admin/payment_reminders') . "'>Try Full Version</a></p>";
        echo "<p><a href='" . base_url('admin/dashboard') . "'>Back to Dashboard</a></p>";
    }
}