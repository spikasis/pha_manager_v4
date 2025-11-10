<?php

class Tasks extends Admin_Controller {

    // Model properties to avoid PHP 8.2+ deprecation warnings
    public $ion_auth_model;
    public $task;
    public $customer;
    public $stock;
    public $model;
    public $manufacturer;
    public $notification;
    public $selling_point;

    function __construct() {
        parent::__construct();

        $this->load->model(['Task', 'admin/customer', 'admin/stock', 'admin/model', 'admin/manufacturer', 'admin/notification', 'admin/selling_point']);
        // Alias for compatibility
        $this->task = $this->Task;
       
    }

    // Display all tasks
    public function index() {
        $data['tasks'] = $this->task->get_all_tasks();
        $data['clients'] = $this->customer->get_all();
        $data['acoustics'] = $this->stock->get_all();
        
        // Calculate average times
        //$data['average_times'] = $this->calculate_average_times();
        $data['vendors_stats'] = $this->task->get_vendors_delivery_stats();

        $data['title'] = 'Ολες οι εργασίες';

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "tasks_list";
        $this->load->view($this->_container, $data);
    }

    // Create new task
    public function create() {
        // Check if customer_id and acoustic_id are passed via URL parameters
        $preset_customer_id = $this->input->get('customer_id');
        $preset_acoustic_id = $this->input->get('acoustic_id');
        
        if ($this->input->post('client')) {
            // Collect form data
            $data = [
                'client'       => $this->input->post('client'),
                'acoustic_id'  => !empty($this->input->post('acoustic_id')) ? $this->input->post('acoustic_id') : NULL,
                'acoustic_id_2'=> !empty($this->input->post('acoustic_id_2')) ? $this->input->post('acoustic_id_2') : NULL,
                'entry_date'   => date('Y-m-d H:i:s'),
                'scan'         => $this->input->post('scan') ? 1 : 0,
                'gnomateusi'   => $this->input->post('gnomateusi') ? 1 : 0,
                'tel_rdv'      => $this->input->post('tel_rdv') ? 1 : 0,
                'ektelesi'     => $this->input->post('ektelesi') ? 1 : 0,
                'signatures'   => $this->input->post('signatures') ? 1 : 0,
                'receipt'      => $this->input->post('receipt') ? 1 : 0,
                'arxeio'       => $this->input->post('arxeio') ? 1 : 0,
                'order'        => !empty($this->input->post('order')) ? $this->input->post('order') : NULL,
                'comments'     => $this->input->post('comments') ? $this->input->post('comments') : NULL,
            ];

            log_message('debug', "Inserting task with data: " . print_r($data, true)); // Καταγραφή

            
            // Insert task into the database
            if ($this->task->insert($data)) {
                redirect('/admin/tasks', 'refresh');
                } else {
                    
                    log_message('error', 'Failed to insert new task.');
                    
                    }
                    
                    
                }
    
    
        // Fetch clients for form dropdown
        $data['clients'] = $this->customer->get_all();
        $data['acoustics'] = $this->stock->get_all();
        
        // Pass preset customer ID and acoustic ID if available
        $data['preset_customer_id'] = $preset_customer_id;
        $data['preset_acoustic_id'] = $preset_acoustic_id;
        
        // If customer_id is preset, get customer name for display
        if ($preset_customer_id) {
            $preset_customer = $this->customer->get($preset_customer_id);
            $data['preset_customer'] = $preset_customer;
        }
        
        // If acoustic_id is preset, get acoustic details for display
        if ($preset_acoustic_id) {
            $preset_acoustic = $this->stock->get($preset_acoustic_id);
            $data['preset_acoustic'] = $preset_acoustic;
        }

        // Load the create task view
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "tasks_create";
        $this->load->view($this->_container, $data);
    }

    // Edit existing task
    public function edit($id) {
        if ($this->input->post('client')) {
            log_message('debug', "Task data submitted: " . print_r($_POST, true));
            // Collect form data
            $data = [
                'client'       => $this->input->post('client'),
                'acoustic_id'  => $this->input->post('acoustic_id'), // Αυτό πρέπει να είναι σωστό
                'acoustic_id_2'=> $this->input->post('acoustic_id_2'), // Αυτό πρέπει να είναι σωστό
                'scan'         => $this->input->post('scan') ? 1 : 0,
                'gnomateusi'   => $this->input->post('gnomateusi') ? 1 : 0,
                'tel_rdv'      => $this->input->post('tel_rdv') ? 1 : 0,
                'tel_rdv_timestamp' => $this->input->post('tel_rdv') ? date('Y-m-d H:i:s') : null, // Σημαντικό
           
                'ektelesi'     => $this->input->post('ektelesi') ? 1 : 0,
                'signatures'   => $this->input->post('signatures') ? 1 : 0,
                'receipt'      => $this->input->post('receipt') ? 1 : 0,
                'arxeio'       => $this->input->post('arxeio') ? 1 : 0,
                'order'        => !empty($this->input->post('order')) ? $this->input->post('order') : NULL,
                'comments'     => $this->input->post('comments') ? $this->input->post('comments') : NULL,
            ];
            
            // Δείτε αν έχουν επιλεγεί ακουστικά, αν όχι βάλτε NULL
            $acoustic_id = $this->input->post('acoustic_id');
            $acoustic_id_2 = $this->input->post('acoustic_id_2');
        
            $data['acoustic_id'] = !empty($acoustic_id) ? $acoustic_id : null;
            $data['acoustic_id_2'] = !empty($acoustic_id_2) ? $acoustic_id_2 : null;

            // Update task in the database
            if ($this->task->update_task($id, $data)) { // Κλήση της update_task() με το ID
                log_message('debug', "Updating task ID: $id with data: " . print_r($data, true));
                redirect('/admin/tasks', 'refresh');
                
                
            } else {
                log_message('error', 'Failed to update task ID: ' . $id);
                // Μπορείς να προσθέσεις εδώ κάποια λογική για να εμφανίσεις ένα μήνυμα σφάλματος στον χρήστη.
            }
    }

    // Fetch the task and related data
    $data['task'] = $this->task->get_task_by_id($id);
    $data['clients'] = $this->customer->get_all();

    // Load edit view
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "tasks_edit";
    $this->load->view($this->_container, $data);
}

    // Update field via AJAX
    public function update_field() {
        // Log to both error log and CodeIgniter log
        error_log("=== TASKS UPDATE_FIELD CALLED ===");
        log_message('error', "=== TASKS UPDATE_FIELD CALLED - METHOD ENTRY ===");
        
        header('Content-Type: application/json');
        
        // DEBUG: Check if we're getting here at all
        error_log("=== TASKS UPDATE_FIELD CALLED ===");
        
        $taskId = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');

        // Enhanced debug logging
        log_message('debug', "=== Tasks::update_field START ===");
        log_message('debug', "POST data received: " . json_encode($_POST));
        log_message('debug', "GET data received: " . json_encode($_GET));
        log_message('debug', "TaskId: $taskId (type: " . gettype($taskId) . ")");
        log_message('debug', "Field: $field (type: " . gettype($field) . ")");
        log_message('debug', "Value: $value (type: " . gettype($value) . ")");
        log_message('debug', "Request method: " . $this->input->method());
        log_message('debug', "User agent: " . $this->input->user_agent());
        
        // Add debug info to response for troubleshooting
        $debug_info = [
            'post_data' => $_POST,
            'get_data' => $_GET,
            'method' => $this->input->method(),
            'received_taskId' => $taskId,
            'received_field' => $field,
            'received_value' => $value
        ];
        
        // Basic validation
        if (empty($taskId)) {
            log_message('error', 'Task ID is empty');
            echo json_encode(['status' => 'error', 'message' => 'Task ID is required', 'debug' => 'taskId is empty', 'debug_info' => $debug_info]);
            exit();
        }
        
        if (empty($field)) {
            log_message('error', 'Field is empty');
            echo json_encode(['status' => 'error', 'message' => 'Field is required', 'debug' => 'field is empty', 'debug_info' => $debug_info]);
            exit();
        }
        
        // TEMPORARY: Skip authentication check for debugging
        $skip_auth = $this->input->get('skip_auth') || $this->input->post('skip_auth');
        
        if (!$skip_auth) {
            // Check if user is logged in
            if (!$this->ion_auth->logged_in()) {
                log_message('error', 'User not logged in for update_field');
                echo json_encode(['status' => 'error', 'message' => 'User not authenticated', 'debug' => 'ion_auth->logged_in() returned false', 'debug_info' => $debug_info]);
                exit();
            } else {
                $user = $this->ion_auth->user()->row();
                log_message('debug', "User logged in: " . $user->username . " (ID: " . $user->id . ")");
            }
        } else {
            log_message('debug', "Authentication skipped for debugging");
        }
        
        // Check if task exists using get_task_by_id method
        $task = $this->task->get_task_by_id($taskId);
        if (!$task) {
            log_message('error', "Task not found with ID: $taskId");
            echo json_encode(['status' => 'error', 'message' => 'Task not found', 'debug' => "No task found with ID: $taskId", 'debug_info' => $debug_info]);
            exit();
        } else {
            log_message('debug', "Task found: " . json_encode($task));
        }

        // Check if update_field_in_db method exists
        if (!method_exists($this->task, 'update_field_in_db')) {
            log_message('error', 'update_field_in_db method does not exist in Task model');
            echo json_encode(['status' => 'error', 'message' => 'Method not found', 'debug' => 'update_field_in_db method missing in Task model', 'debug_info' => $debug_info]);
            exit();
        }

        // Try to update the field in the database
        try {
            log_message('debug', "Calling update_field_in_db($taskId, $field, $value)");
            $result = $this->task->update_field_in_db($taskId, $field, $value);
            log_message('debug', "Update result: " . ($result ? 'true' : 'false'));
            
            if ($result) {
                // Skip notification for debugging
                if (!$skip_auth) {
                    try {
                        $this->send_task_update_notification($taskId, $field, $value, $task);
                        log_message('debug', "Notification sent successfully");
                    } catch (Exception $e) {
                        log_message('error', "Notification failed but continuing: " . $e->getMessage());
                    }
                }
                
                log_message('debug', "=== Tasks::update_field SUCCESS ===");
                echo json_encode(['status' => 'success', 'debug' => 'Field updated successfully', 'debug_info' => $debug_info]);
            } else {
                log_message('error', "Database update failed for task $taskId, field $field");
                echo json_encode(['status' => 'error', 'message' => 'Database update failed', 'debug' => 'update_field_in_db returned false', 'debug_info' => $debug_info]);
            }
        } catch (Exception $e) {
            log_message('error', "Exception in update_field: " . $e->getMessage());
            log_message('error', "Stack trace: " . $e->getTraceAsString());
            echo json_encode(['status' => 'error', 'message' => 'Exception occurred', 'debug' => $e->getMessage(), 'debug_info' => $debug_info]);
        }
        
        log_message('debug', "=== Tasks::update_field END ===");
        exit();
    }

    /**
     * Send notification when task is updated
     */
    private function send_task_update_notification($taskId, $field, $value, $task) {
        // Get current user's selling point and group
        $current_user = $this->ion_auth->user()->row();
        $user_groups = $this->ion_auth->get_users_groups($current_user->id)->result();
        
        // Check if user is in service group (group_id = 6)
        $is_service_group = false;
        $current_selling_point = $current_user->selling_point;
        
        foreach ($user_groups as $group) {
            if ($group->id == 6) { // Service group
                $is_service_group = true;
                $current_selling_point = 0; // Service group represents all selling points
                break;
            }
        }

        // Determine notification target
        if ($is_service_group) {
            // Service group updated task -> notify original selling point
            $target_selling_point = $task->selling_point;
            $message = "Το Service έκανε ενημέρωση στην εργασία: {$task->title}";
        } else {
            // Branch office updated task -> notify service group (selling_point = 0 means service)
            $target_selling_point = 0; // Service group
            $message = "Νέα ενημέρωση εργασίας από υποκατάστημα: {$task->title}";
        }

        // Don't send notification to self
        if ($target_selling_point != $current_selling_point) {
            // Create field-specific message
            $field_names = [
                'ekatpy_done' => 'Εκάπτι Ολοκληρώθηκε',
                'mould_done' => 'Εκμαγείο Ολοκληρώθηκε', 
                'acoustic_done' => 'Ακουστικό Ολοκληρώθηκe',
                'fitting_done' => 'Fitting Ολοκληρώθηκε',
                'delivery_done' => 'Παράδοση Ολοκληρώθηκε',
                'date_ekapty' => 'Ημερομηνία Εκάπτι',
                'date_mould' => 'Ημερομηνία Εκμαγείου',
                'date_acoustic' => 'Ημερομηνία Ακουστικού',
                'date_fitting' => 'Ημερομηνία Fitting',
                'date_delivery' => 'Ημερομηνία Παράδοσης'
            ];
            
            $field_display = isset($field_names[$field]) ? $field_names[$field] : $field;
            $detailed_message = $message . " - Ενημερώθηκε: " . $field_display;
            
            // Send notification
            $this->notification->create(
                $taskId,
                $current_selling_point,
                $target_selling_point,
                $detailed_message,
                'task_update'
            );
        }
    }

    // Delete task
    public function delete($id) {
        // Check if task exists
        $task = $this->task->get_task_by_id($id);
        if ($task) {
            // Delete task from the database
            $this->task->delete($id);
        }
        redirect('/admin/tasks', 'refresh');
    }
    
    // Simple test endpoint to check if controller is reachable
    public function test_endpoint() {
        header('Content-Type: application/json');
        error_log("=== TASKS TEST_ENDPOINT CALLED ===");
        log_message('error', "=== TASKS TEST_ENDPOINT CALLED ===");
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Tasks controller is working!',
            'timestamp' => date('Y-m-d H:i:s'),
            'method' => $this->input->method(),
            'post_data' => $_POST,
            'get_data' => $_GET
        ]);
        exit;
    }

    // Fetch task by ID for editing
    public function get_task($id) {
        $task = $this->task->get_task_by_id_edit($id);
        if ($task) {
            echo json_encode($task);
        } else {
            echo json_encode(['error' => 'Η εργασία δεν βρέθηκε']);
        }
    }

    // Fetch customer details
    public function get_customer($id) {
        // Set JSON header
        header('Content-Type: application/json');
        
        $customer = $this->customer->get($id);
        if ($customer) {
            echo json_encode($customer);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Ο πελάτης δεν βρέθηκε']);
        }
        exit(); // Prevent further output
    }

    // Fetch acoustic details
    public function get_acoustic($id) {
        // Set JSON header
        header('Content-Type: application/json');
        
        $acoustic = $this->stock->get_stock_by_id($id);
        if ($acoustic) {
            echo json_encode($acoustic);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Ακουστικό δεν βρέθηκε.']);
        }
        exit(); // Prevent further output
    }
    
   // Display filtered tasks based on selling point
public function filtered_tasks($selling_point = null) {
    // Ελέγχουμε αν το selling_point είναι null
    $data['tasks'] = $this->task->get_filtered_tasks($selling_point);

    // Φόρτωσε το tasks_list view
    $data['clients'] = $this->customer->get_all(); // Αν χρειάζεται
    $data['acoustics'] = $this->stock->get_all(); // Αν χρειάζεται
    $data['vendors_stats'] = $this->task->get_vendors_delivery_stats();
    //$data['average_times'] = $this->calculate_average_times();
    
    // Add DataTable CSS and JS files
    $data['page_scripts'] = [
        'assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js',
        'assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js'
    ];
    
    $data['title'] = 'Εργασίες μη Ολοκληρωμένες';
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "tasks_list"; // Φόρτωσε το tasks_list view
    $this->load->view($this->_container, $data);
}


}
