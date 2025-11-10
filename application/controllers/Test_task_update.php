<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_task_update extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Task');
        // Don't load ion_auth for testing
    }

    public function index() {
        header('Content-Type: application/json');
        
        // Direct test of the update_field_in_db method
        $taskId = $this->input->get('id') ?? 1;
        $field = $this->input->get('field') ?? 'scan';
        $value = $this->input->get('value') ?? 1;
        
        echo "=== DIRECT TEST WITHOUT AUTHENTICATION ===\n";
        echo "Task ID: $taskId\n";
        echo "Field: $field\n";
        echo "Value: $value\n\n";
        
        // Check if task exists
        $this->db->where('id', $taskId);
        $task_query = $this->db->get('tasks');
        
        if ($task_query->num_rows() == 0) {
            echo "ERROR: Task ID $taskId not found\n";
            echo "Available task IDs:\n";
            $all_tasks = $this->db->select('id')->get('tasks')->result_array();
            foreach ($all_tasks as $task) {
                echo "- " . $task['id'] . "\n";
            }
            exit;
        }
        
        echo "Task found!\n";
        echo "Task data: " . json_encode($task_query->row_array()) . "\n\n";
        
        // Test the update method directly
        if (!method_exists($this->Task, 'update_field_in_db')) {
            echo "ERROR: update_field_in_db method not found\n";
            exit;
        }
        
        echo "Method exists, testing update...\n";
        
        try {
            $result = $this->Task->update_field_in_db($taskId, $field, $value);
            echo "Update result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";
            
            if ($result) {
                // Check if the update actually worked
                $this->db->where('id', $taskId);
                $updated_task = $this->db->get('tasks')->row_array();
                echo "Updated field value: " . $updated_task[$field] . "\n";
                echo "SUCCESS: Field updated successfully!\n";
            } else {
                echo "FAILED: update_field_in_db returned false\n";
                $db_error = $this->db->error();
                echo "Database error: " . json_encode($db_error) . "\n";
            }
        } catch (Exception $e) {
            echo "EXCEPTION: " . $e->getMessage() . "\n";
            echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
        }
    }
    
    public function ajax_test() {
        header('Content-Type: application/json');
        
        $taskId = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');
        
        if (empty($taskId) || empty($field) || $value === null) {
            echo json_encode([
                'status' => 'error', 
                'message' => 'Missing parameters',
                'received' => [
                    'id' => $taskId,
                    'field' => $field,
                    'value' => $value,
                    'post_data' => $_POST
                ]
            ]);
            exit;
        }
        
        try {
            $result = $this->Task->update_field_in_db($taskId, $field, $value);
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Updated successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Database update failed']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Exception: ' . $e->getMessage()]);
        }
        
        exit;
    }
}