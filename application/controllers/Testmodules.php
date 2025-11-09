<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testmodules extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }
    
    public function index() {
        echo "<h1>Module Test Controller Works!</h1>";
        echo "<p>If you see this, basic routing is working.</p>";
        echo "<p>Time: " . date('Y-m-d H:i:s') . "</p>";
        
        // Test if we can load modules
        if (class_exists('Modules')) {
            echo "<p>✓ HMVC Modules class is available</p>";
        } else {
            echo "<p>✗ HMVC Modules class not found</p>";
        }
        
        // Test if MX_Controller exists
        if (class_exists('MX_Controller')) {
            echo "<p>✓ MX_Controller class is available</p>";
        } else {
            echo "<p>✗ MX_Controller class not found</p>";
        }
        
        // Check what's available
        echo "<p>Available classes:</p><ul>";
        $classes = get_declared_classes();
        foreach ($classes as $class) {
            if (strpos($class, 'MX_') === 0 || strpos($class, 'Admin') === 0) {
                echo "<li>$class</li>";
            }
        }
        echo "</ul>";
        
        echo "<p><a href='" . base_url('admin/payment_reminders') . "'>Try Payment Reminders</a></p>";
    }
}