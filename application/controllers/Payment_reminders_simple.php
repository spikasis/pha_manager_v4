<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_reminders_simple extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->database();
    }
    
    public function index() {
        echo "<h1>Payment Reminders - Simple Version</h1>";
        echo "<p>This is a simplified version to test functionality.</p>";
        
        // Test database connection
        try {
            $query = $this->db->get('customers', 5); // Get first 5 customers
            $customers = $query->result_array();
            
            echo "<h3>Database Test - First 5 Customers:</h3>";
            echo "<ul>";
            foreach ($customers as $customer) {
                echo "<li>ID: {$customer['id']}, Name: {$customer['name']}</li>";
            }
            echo "</ul>";
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>Database Error: " . $e->getMessage() . "</p>";
        }
        
        // Test if the payment_reminders_log table exists
        try {
            if ($this->db->table_exists('payment_reminders_log')) {
                echo "<p style='color: green;'>✓ payment_reminders_log table exists</p>";
                
                $count = $this->db->count_all('payment_reminders_log');
                echo "<p>Records in payment_reminders_log: $count</p>";
            } else {
                echo "<p style='color: red;'>✗ payment_reminders_log table does not exist</p>";
                echo "<p>You need to run the SQL script: database_updates/create_payment_reminders_log.sql</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>Table check error: " . $e->getMessage() . "</p>";
        }
        
        echo "<p><a href='" . base_url('admin/dashboard') . "'>Back to Dashboard</a></p>";
    }
}