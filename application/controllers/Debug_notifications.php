<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug_notifications extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }
    
    public function index() {
        echo "<h1>Debug Notifications System</h1>";
        echo "<p>Checking why notifications are not loading...</p>";
        
        // Test basic functionality
        echo "<h2>1. Database Connection Test</h2>";
        try {
            $query = $this->db->query("SELECT COUNT(*) as count FROM customers LIMIT 1");
            $result = $query->row();
            echo "✅ Database connected - Customers count: " . $result->count . "<br>";
        } catch (Exception $e) {
            echo "❌ Database error: " . $e->getMessage() . "<br>";
        }
        
        echo "<h2>2. Payment Reminders Table Check</h2>";
        try {
            if ($this->db->table_exists('payment_reminders_log')) {
                $count = $this->db->count_all('payment_reminders_log');
                echo "✅ payment_reminders_log table exists with $count records<br>";
            } else {
                echo "❌ payment_reminders_log table does not exist<br>";
            }
        } catch (Exception $e) {
            echo "❌ Table check error: " . $e->getMessage() . "<br>";
        }
        
        echo "<h2>3. Controllers Check</h2>";
        $controllers = ['Payment_reminders', 'Tasks', 'Admin'];
        foreach ($controllers as $controller) {
            $path = APPPATH . "controllers/$controller.php";
            echo "$controller: " . (file_exists($path) ? "✅ EXISTS" : "❌ MISSING") . " - $path<br>";
            
            // Also check in modules
            $module_path = APPPATH . "modules/admin/controllers/$controller.php";
            if (file_exists($module_path)) {
                echo "$controller (module): ✅ EXISTS - $module_path<br>";
            }
        }
        
        echo "<h2>4. Models Check</h2>";
        $models = ['Payment_reminders_model', 'Task'];
        foreach ($models as $model) {
            $path = APPPATH . "models/$model.php";
            echo "$model: " . (file_exists($path) ? "✅ EXISTS" : "❌ MISSING") . " - $path<br>";
            
            // Also check in modules
            $module_path = APPPATH . "modules/admin/models/$model.php";
            if (file_exists($module_path)) {
                echo "$model (module): ✅ EXISTS - $module_path<br>";
            }
        }
        
        echo "<h2>5. Test Payment Reminders Endpoints</h2>";
        $endpoints = [
            'payment_reminders' => 'Payment Reminders Dashboard',
            'payment_reminders/get_notifications_count' => 'Notifications Count (AJAX)',
            'payment_reminders/get_overdue_json' => 'Overdue List (AJAX)',
        ];
        
        foreach ($endpoints as $endpoint => $description) {
            echo "<a href='" . base_url($endpoint) . "' target='_blank'>$description</a><br>";
        }
        
        echo "<h2>6. Test Task Reminders (if exists)</h2>";
        $task_endpoints = [
            'tasks' => 'Tasks Dashboard',
            'admin/tasks' => 'Admin Tasks',
        ];
        
        foreach ($task_endpoints as $endpoint => $description) {
            echo "<a href='" . base_url($endpoint) . "' target='_blank'>$description</a><br>";
        }
        
        echo "<h2>7. Authentication Status</h2>";
        // Try to load ion_auth if available
        if (file_exists(APPPATH . 'libraries/Ion_auth.php')) {
            $this->load->library('ion_auth');
            if ($this->ion_auth->logged_in()) {
                $user = $this->ion_auth->user()->row();
                echo "✅ User logged in: " . $user->username . "<br>";
                
                $groups = $this->ion_auth->get_users_groups()->result();
                echo "User groups: ";
                foreach ($groups as $group) {
                    echo $group->name . " (ID: " . $group->id . "), ";
                }
                echo "<br>";
            } else {
                echo "❌ User not logged in<br>";
                echo "<a href='" . base_url('auth/login') . "'>Login Here</a><br>";
            }
        } else {
            echo "❌ Ion_auth library not found<br>";
        }
        
        echo "<hr>";
        echo "<p><strong>Next Steps:</strong></p>";
        echo "<ul>";
        echo "<li>Fix any missing files/tables shown above</li>";
        echo "<li>Ensure authentication is working</li>";
        echo "<li>Test the endpoint URLs</li>";
        echo "<li>Check browser console for AJAX errors</li>";
        echo "</ul>";
        
        echo "<p><a href='" . base_url() . "'>Go to Homepage</a></p>";
    }
}