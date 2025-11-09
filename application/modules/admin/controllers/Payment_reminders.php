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
        
        $selling_point_filter = null;
        if (in_array($user_group, [2, 4, 5])) {
            $selling_point_filter = $user_selling_point;
        }
        
        $days = $this->input->get('days') ?: 30;
        $overdue = $this->reminders->get_overdue_debts($selling_point_filter, $days);
        
        $data = [];
        foreach ($overdue as $row) {
            $data[] = [
                'customer_name' => $row['customer_name'],
                'phone' => $row['phone_mobile'] ?: $row['phone_home'],
                'selling_point' => $row['selling_point_name'],
                'device' => $row['serial'] . ' - ' . $row['model'],
                'debt_amount' => '€' . number_format($row['debt_amount'], 2),
                'days_overdue' => $row['days_since_sold'] . ' ημέρες',
                'actions' => $this->build_action_buttons($row)
            ];
        }
        
        echo json_encode(['data' => $data]);
    }

    /**
     * Send reminder notification
     */
    public function send_reminder() {
        if (!$this->input->post()) {
            show_404();
        }
        
        $customer_id = $this->input->post('customer_id');
        $stock_id = $this->input->post('stock_id');
        $reminder_type = $this->input->post('reminder_type') ?: 'standard';
        
        // Validate required fields
        if (empty($customer_id) || !is_numeric($customer_id)) {
            $this->session->set_flashdata('error', 'Μη έγκυρο ID πελάτη!');
            redirect('admin/payment_reminders');
            return;
        }
        
        // Convert empty stock_id to null
        $stock_id = !empty($stock_id) && is_numeric($stock_id) ? $stock_id : null;
        
        // Here you would integrate with SMS/Email service
        // For now, just log the reminder
        $success = $this->reminders->mark_reminder_sent($customer_id, $stock_id, $reminder_type);
        
        if ($success) {
            $this->session->set_flashdata('success', 'Η υπενθύμιση στάλθηκε επιτυχώς!');
        } else {
            $this->session->set_flashdata('error', 'Σφάλμα κατά την αποστολή υπενθύμισης!');
        }
        
        redirect('admin/payment_reminders');
    }

    /**
     * Get notifications count for topbar
     */
    public function get_notifications_count() {
        $user_group = $this->get_user_group();
        $user_selling_point = $this->get_user_selling_point();
        
        $selling_point_filter = null;
        if (in_array($user_group, [2, 4, 5])) {
            $selling_point_filter = $user_selling_point;
        }
        
        $overdue_30 = count($this->reminders->get_overdue_debts($selling_point_filter, 30));
        $urgent_60 = count($this->reminders->get_urgent_reminders($selling_point_filter));
        
        echo json_encode([
            'overdue_30' => $overdue_30,
            'urgent_60' => $urgent_60,
            'total' => $overdue_30 + $urgent_60
        ]);
    }

    /**
     * Build action buttons for DataTable
     */
    private function build_action_buttons($row) {
        $buttons = '<div class="btn-group btn-group-sm">';
        
        // Call button
        if ($row['phone_home'] || $row['phone_mobile']) {
            $phone = $row['phone_mobile'] ?: $row['phone_home'];
            $buttons .= '<a href="tel:' . $phone . '" class="btn btn-info btn-sm" title="Κλήση">';
            $buttons .= '<i class="fas fa-phone"></i>';
            $buttons .= '</a>';
        }
        
        // View customer
        $buttons .= '<a href="' . base_url('admin/customers/view/' . $row['customer_id']) . '" class="btn btn-primary btn-sm" title="Προβολή Πελάτη">';
        $buttons .= '<i class="fas fa-eye"></i>';
        $buttons .= '</a>';
        
        // Payment button
        $buttons .= '<a href="' . base_url('admin/pays/create_specific/' . $row['customer_id'] . '?hearing_aid_id=' . $row['stock_id']) . '" class="btn btn-success btn-sm" title="Νέα Πληρωμή">';
        $buttons .= '<i class="fas fa-euro-sign"></i>';
        $buttons .= '</a>';
        
        // Send reminder
        $buttons .= '<button class="btn btn-warning btn-sm send-reminder" data-customer="' . $row['customer_id'] . '" data-stock="' . $row['stock_id'] . '" title="Αποστολή Υπενθύμισης">';
        $buttons .= '<i class="fas fa-bell"></i>';
        $buttons .= '</button>';
        
        $buttons .= '</div>';
        
        return $buttons;
    }

    /**
     * Get user group ID
     */
    private function get_user_group() {
        $user_id = $this->ion_auth->get_user_id();
        $group = $this->ion_auth->get_users_groups($user_id)->row();
        return $group ? $group->id : 1;
    }

    /**
     * Get user selling point
     */
    private function get_user_selling_point() {
        // This would be based on your user-selling point relationship
        // For now, returning null (admin access)
        return null;
    }
}