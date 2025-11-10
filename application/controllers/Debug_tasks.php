<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug_tasks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Task');
        $this->load->library('ion_auth');
    }

    public function test_update_field() {
        header('Content-Type: application/json');
        
        // Test parameters
        $taskId = $this->input->post('id') ?? 1; // Use existing task ID
        $field = $this->input->post('field') ?? 'scan';
        $value = $this->input->post('value') ?? 1;
        
        echo "=== DEBUG TEST UPDATE FIELD ===\n";
        echo "Task ID: " . $taskId . "\n";
        echo "Field: " . $field . "\n"; 
        echo "Value: " . $value . "\n";
        echo "Method: " . $this->input->method() . "\n";
        echo "POST data: " . json_encode($_POST) . "\n";
        
        // Check if ion_auth is loaded
        if (!class_exists('Ion_auth')) {
            echo "ERROR: Ion_auth not loaded\n";
            exit;
        }
        
        // Check if user is logged in
        if (!$this->ion_auth->logged_in()) {
            echo "ERROR: User not logged in\n";
            echo "User data: " . json_encode($this->ion_auth->user()->row()) . "\n";
            exit;
        } else {
            echo "User is logged in\n";
        }
        
        // Check if task exists
        $this->db->where('id', $taskId);
        $task = $this->db->get('tasks');
        if ($task->num_rows() == 0) {
            echo "ERROR: Task ID $taskId not found\n";
            exit;
        } else {
            echo "Task found: " . json_encode($task->row_array()) . "\n";
        }
        
        // Check if Task model has the method
        if (!method_exists($this->Task, 'update_field_in_db')) {
            echo "ERROR: update_field_in_db method not found in Task model\n";
            exit;
        } else {
            echo "update_field_in_db method exists\n";
        }
        
        // Try to update
        try {
            $result = $this->Task->update_field_in_db($taskId, $field, $value);
            echo "Update result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";
            
            if ($result) {
                echo json_encode(['status' => 'success', 'debug' => 'All checks passed']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Database update failed', 'debug' => 'Method returned false']);
            }
        } catch (Exception $e) {
            echo "EXCEPTION: " . $e->getMessage() . "\n";
            echo json_encode(['status' => 'error', 'message' => 'Exception occurred: ' . $e->getMessage()]);
        }
        
        exit();
    }
    
    public function show_tasks_table() {
        // Show first few tasks to check structure
        $this->db->limit(5);
        $tasks = $this->db->get('tasks')->result_array();
        
        echo "<h2>Tasks Table Structure (First 5 rows)</h2>";
        echo "<pre>";
        print_r($tasks);
        echo "</pre>";
        
        // Show table structure
        echo "<h2>Tasks Table Columns</h2>";
        echo "<pre>";
        $fields = $this->db->field_data('tasks');
        foreach ($fields as $field) {
            echo $field->name . " (" . $field->type . ")\n";
        }
        echo "</pre>";
    }
}