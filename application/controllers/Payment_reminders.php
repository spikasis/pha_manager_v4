<?php
/**
 * Payment Reminders Controller
 * Handles overdue payment notifications and reminders
 */

class Payment_reminders extends Admin_Controller {

    // Model properties for PHP 8.2 compatibility
    public $reminders;
    public $selling_point;
    
    // Ion_auth properties inherited from Admin_Controller
    // (no need to redeclare as they're already in parent class)

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/Payment_reminders_model', 'reminders');
        $this->load->model('admin/Selling_point', 'selling_point');
        $this->load->helper(['url', 'form']);
    }

    /**
     * Index - Show reminders dashboard
     */
    public function index() {
        $user_group = $this->get_user_group();
        $user_selling_point = $this->get_user_selling_point();
        
        // Role-based access control
        $selling_point_filter = null;
        if (in_array($user_group, [2, 4, 5])) { // Branch users
            $selling_point_filter = $user_selling_point;
        }
        
        $data = [
            'overdue_30' => $this->reminders->get_overdue_debts($selling_point_filter, 30),
            'urgent_60' => $this->reminders->get_urgent_reminders($selling_point_filter),
            'recent_activity' => $this->reminders->get_recent_payment_activity($selling_point_filter),
            'selling_point_counts' => $user_group == 1 ? $this->reminders->get_reminder_counts_by_selling_point() : null,
            'user_group' => $user_group,
            'user_selling_point' => $user_selling_point
        ];
        
        $this->load->view('admin/themes/sbadmin2/payment_reminders_dashboard', $data);
    }

    /**
     * Get overdue customers for AJAX DataTable
     */
    public function get_overdue_json() {
        $user_group = $this->get_user_group();
        $user_selling_point = $this->get_user_selling_point();
        
        // Role-based filtering
        $selling_point_filter = null;
        if (in_array($user_group, [2, 4, 5])) { // Branch users
            $selling_point_filter = $user_selling_point;
        }
        
        $limit = $this->input->get('limit') ?: 100;
        $offset = $this->input->get('offset') ?: 0;
        
        $overdue_customers = $this->reminders->get_overdue_debts($selling_point_filter, 30, $limit, $offset);
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $overdue_customers,
            'total' => count($overdue_customers)
        ]);
    }

    /**
     * Get notifications count for topbar
     */
    public function get_notifications_count() {
        $user_group = $this->get_user_group();
        $user_selling_point = $this->get_user_selling_point();
        
        // Role-based filtering
        $selling_point_filter = null;
        if (in_array($user_group, [2, 4, 5])) { // Branch users
            $selling_point_filter = $user_selling_point;
        }
        
        $count = $this->reminders->get_overdue_count($selling_point_filter);
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Send reminder to customer
     */
    public function send_reminder() {
        if ($this->input->method() !== 'post') {
            show_404();
            return;
        }

        // Enhanced input validation
        $customer_id = $this->input->post('customer_id');
        $stock_id = $this->input->post('stock_id');
        $reminder_type = $this->input->post('reminder_type') ?: 'standard';
        $notes = $this->input->post('notes') ?: '';

        // Validate customer_id
        if (!$customer_id || !is_numeric($customer_id)) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Invalid customer ID provided'
            ]);
            return;
        }

        // Convert empty stock_id to null for database compatibility
        if (empty($stock_id) || $stock_id === '' || $stock_id === '0') {
            $stock_id = null;
        }

        $user_id = $this->ion_auth->get_user_id();

        try {
            $success = $this->reminders->mark_reminder_sent($customer_id, $stock_id, $reminder_type, $user_id, $notes);
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Reminder sent successfully' : 'Failed to send reminder'
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get user group ID for role-based access
     */
    private function get_user_group() {
        $user_id = $this->ion_auth->get_user_id();
        if (!$user_id) return 6; // Default to service group
        
        $groups = $this->ion_auth->get_users_groups($user_id)->result();
        return !empty($groups) ? $groups[0]->id : 6;
    }

    /**
     * Get user selling point for filtering
     */
    private function get_user_selling_point() {
        $user_group = $this->get_user_group();
        
        switch ($user_group) {
            case 4: return 1; // Levadia
            case 5: return 2; // Thiva  
            default: return null; // Admin or other
        }
    }
}