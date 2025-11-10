<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Public Tasks Controller - No authentication required
 * Used for AJAX calls that need to work without full admin login
 */
class Public_tasks extends CI_Controller {

    public $Task;
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Task');
        $this->load->library('session');
    }

    /**
     * Update task field without authentication requirement
     * This is a temporary solution for debugging checkbox updates
     */
    public function update_field() {
        header('Content-Type: application/json');
        
        error_log("=== PUBLIC_TASKS UPDATE_FIELD CALLED ===");
        
        $taskId = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');
        
        // Log all input data
        error_log("POST data: " . json_encode($_POST));
        error_log("TaskId: $taskId, Field: $field, Value: $value");
        
        // Basic validation
        if (empty($taskId)) {
            echo json_encode([
                'status' => 'error', 
                'message' => 'Task ID is required',
                'debug' => 'taskId is empty',
                'received' => $_POST
            ]);
            exit;
        }
        
        if (empty($field)) {
            echo json_encode([
                'status' => 'error', 
                'message' => 'Field is required',
                'debug' => 'field is empty',
                'received' => $_POST
            ]);
            exit;
        }
        
        // Check if task exists
        $task = $this->Task->get_task_by_id($taskId);
        if (!$task) {
            echo json_encode([
                'status' => 'error', 
                'message' => 'Task not found',
                'debug' => "No task found with ID: $taskId",
                'received' => $_POST
            ]);
            exit;
        }
        
        // Update the field
        try {
            $result = $this->Task->update_field_in_db($taskId, $field, $value);
            
            if ($result) {
                error_log("Update successful for task $taskId, field $field, value $value");
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Field updated successfully',
                    'updated' => [
                        'task_id' => $taskId,
                        'field' => $field,
                        'value' => $value
                    ]
                ]);
            } else {
                error_log("Update failed for task $taskId, field $field, value $value");
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Database update failed',
                    'debug' => 'update_field_in_db returned false'
                ]);
            }
        } catch (Exception $e) {
            error_log("Exception in update_field: " . $e->getMessage());
            echo json_encode([
                'status' => 'error', 
                'message' => 'Exception occurred: ' . $e->getMessage(),
                'debug' => $e->getTraceAsString()
            ]);
        }
        
        exit;
    }
    
    /**
     * Simple test endpoint
     */
    public function test() {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'Public_tasks controller is working!',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
        exit;
    }
}