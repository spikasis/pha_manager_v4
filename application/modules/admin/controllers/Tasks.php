<?php

class Tasks extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(['admin/task', 'admin/customer', 'admin/stock', 'admin/model', 'admin/manufacturer']);
       
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
        $taskId = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');

        if (!empty($taskId) && !empty($field)) {
            // Update the field in the database
            $result = $this->task->update_field_in_db($taskId, $field, $value);
            if ($result) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Database update failed']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        }
    }

    // Delete task
    public function delete($id) {
        // Check if task exists
        $task = $this->task->get($id);
        if ($task) {
            // Delete task from the database
            $this->task->delete($id);
        }
        redirect('/admin/tasks', 'refresh');
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

    // Fetch acoustic details
    public function get_acoustic($id) {
        $acoustic = $this->stock->get_stock_by_id($id);
        if ($acoustic) {
            echo json_encode($acoustic);
        } else {
            echo json_encode(['error' => 'Ακουστικό δεν βρέθηκε.']);
        }
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
    
    $data['title'] = 'Εργασίες μη Ολοκληρωμένες';
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "tasks_list"; // Φόρτωσε το tasks_list view
    $this->load->view($this->_container, $data);
}


}
