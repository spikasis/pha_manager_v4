<?php

class Notifications extends Admin_Controller {

    // Model properties to avoid PHP 8.2+ deprecation warnings
    public $ion_auth_model;
    public $notification;
    public $selling_point;

    function __construct() {
        parent::__construct();
        $this->load->model(['admin/notification', 'admin/selling_point']);
    }

    /**
     * Get unread notifications count (AJAX)
     */
    public function get_unread_count() {
        header('Content-Type: application/json');
        
        // Get current user's selling point
        $current_user = $this->ion_auth->user()->row();
        $user_groups = $this->ion_auth->get_users_groups($current_user->id)->result();
        
        // Determine user's notification target (service group gets selling_point = 0)
        $target_selling_point = $current_user->selling_point;
        foreach ($user_groups as $group) {
            if ($group->id == 6) { // Service group
                $target_selling_point = 0;
                break;
            }
        }
        
        $count = $this->notification->get_unread_count($target_selling_point);
        
        echo json_encode(['count' => $count]);
        exit();
    }

    /**
     * Get notifications list (AJAX)
     */
    public function get_notifications() {
        header('Content-Type: application/json');
        
        // Get current user's selling point
        $current_user = $this->ion_auth->user()->row();
        $user_groups = $this->ion_auth->get_users_groups($current_user->id)->result();
        
        // Determine user's notification target (service group gets selling_point = 0)
        $target_selling_point = $current_user->selling_point;
        foreach ($user_groups as $group) {
            if ($group->id == 6) { // Service group
                $target_selling_point = 0;
                break;
            }
        }
        
        $notifications = $this->notification->get_unread($target_selling_point, 10);
        
        // Format notifications for display
        $formatted_notifications = [];
        foreach ($notifications as $notification) {
            $formatted_notifications[] = [
                'id' => $notification->id,
                'task_id' => $notification->task_id,
                'message' => $notification->message,
                'task_title' => $notification->task_title,
                'from_selling_point' => $notification->from_selling_point_name,
                'created_at' => date('d/m/Y H:i', strtotime($notification->created_at)),
                'time_ago' => $this->time_elapsed_string($notification->created_at)
            ];
        }
        
        echo json_encode(['notifications' => $formatted_notifications]);
        exit();
    }

    /**
     * Mark notification as read (AJAX)
     */
    public function mark_as_read() {
        header('Content-Type: application/json');
        
        $notification_id = $this->input->post('id');
        
        if ($notification_id) {
            $result = $this->notification->mark_as_read($notification_id);
            echo json_encode(['status' => $result ? 'success' : 'error']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid notification ID']);
        }
        exit();
    }

    /**
     * Mark all notifications as read (AJAX)
     */
    public function mark_all_as_read() {
        header('Content-Type: application/json');
        
        // Get current user's selling point
        $current_user = $this->ion_auth->user()->row();
        $user_groups = $this->ion_auth->get_users_groups($current_user->id)->result();
        
        // Determine user's notification target (service group gets selling_point = 0)
        $target_selling_point = $current_user->selling_point;
        foreach ($user_groups as $group) {
            if ($group->id == 6) { // Service group
                $target_selling_point = 0;
                break;
            }
        }
        
        $result = $this->notification->mark_all_as_read($target_selling_point);
        
        echo json_encode(['status' => $result ? 'success' : 'error']);
        exit();
    }

    /**
     * Helper function to calculate time elapsed
     */
    private function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        if ($diff->y > 0) {
            return 'πριν από ' . $diff->y . ' χρόνο' . ($diff->y > 1 ? 'ια' : '');
        } elseif ($diff->m > 0) {
            return 'πριν από ' . $diff->m . ' μήνα' . ($diff->m > 1 ? 'ες' : '');
        } elseif ($diff->d >= 7) {
            $weeks = floor($diff->d / 7);
            return 'πριν από ' . $weeks . ' εβδομάδα' . ($weeks > 1 ? 'ες' : '');
        } elseif ($diff->d > 0) {
            return 'πριν από ' . $diff->d . ' ημέρα' . ($diff->d > 1 ? 'ες' : '');
        } elseif ($diff->h > 0) {
            return 'πριν από ' . $diff->h . ' ώρα' . ($diff->h > 1 ? 'ες' : '');
        } elseif ($diff->i > 0) {
            return 'πριν από ' . $diff->i . ' λεπτό' . ($diff->i > 1 ? 'ά' : '');
        } else {
            return 'μόλις τώρα';
        }
    }
}