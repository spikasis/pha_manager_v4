<?php

class Test extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        // Skip authentication for testing
    }
    
    public function tasks() {
        // Mock data for testing
        $data['tasks'] = [
            [
                'id' => 1,
                'date' => '2025-11-07',
                'client_name' => 'Test Client 1',
                'phone_home' => '2101234567',
                'acoustic_serial' => 'ABC123',
                'acoustic_model' => 'Test Model 1',
                'scan' => 0,
                'gnomateusi' => 1,
                'tel_rdv' => 0,
                'ektelesi' => 0,
                'signatures' => 1,
                'receipt' => 0,
                'arxeio' => 0,
                'comments' => 'Test comment'
            ],
            [
                'id' => 2,
                'date' => '2025-11-07',
                'client_name' => 'Test Client 2',
                'phone_home' => '2109876543',
                'acoustic_serial' => 'DEF456',
                'acoustic_model' => 'Test Model 2',
                'scan' => 1,
                'gnomateusi' => 0,
                'tel_rdv' => 1,
                'ektelesi' => 0,
                'signatures' => 0,
                'receipt' => 1,
                'arxeio' => 0,
                'comments' => 'Another test comment'
            ]
        ];
        
        // Add mock data for other requirements
        $data['clients'] = [];
        $data['acoustics'] = [];
        $data['vendors_stats'] = [];
        
        // Add DataTable CSS and JS files
        $data['page_scripts'] = [
            'assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js',
            'assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js'
        ];
        
        $data['title'] = 'Test Εργασίες μη Ολοκληρωμένες';
        $data['page'] = 'admin/themes/sbadmin2/tasks_list';
        
        // Load the sbadmin2 layout directly
        $this->load->view('admin/themes/sbadmin2/header', $data);
        $this->load->view('admin/themes/sbadmin2/sidemenu', $data);
        $this->load->view('admin/themes/sbadmin2/topbar', $data);
        $this->load->view('admin/themes/sbadmin2/tasks_list', $data);
        $this->load->view('admin/themes/sbadmin2/footer', $data);
    }
    
    // Simple update endpoint for testing
    public function update_field() {
        header('Content-Type: application/json');
        
        $taskId = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');
        
        // Simulate successful update
        echo json_encode(['status' => 'success', 'message' => 'Test update successful']);
        exit();
    }
}