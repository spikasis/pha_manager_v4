<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Notification extends MY_Model {

    public $table = 'notifications';

    public function __construct() {
        // parent::__construct(); // CI_Model has no constructor in CI 3.1.14+
        $this->load->database();
    }

    /**
     * Create a new notification
     */
    public function create($task_id, $from_selling_point, $to_selling_point, $message, $type = 'task_update') {
        $data = [
            'task_id' => $task_id,
            'from_selling_point' => $from_selling_point,
            'to_selling_point' => $to_selling_point,
            'message' => $message,
            'type' => $type,
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->insert($this->table, $data);
    }

    /**
     * Get unread notifications for a selling point
     */
    public function get_unread($selling_point_id, $limit = 10) {
        $this->db->select('n.*, t.title as task_title, sp.name as from_selling_point_name');
        $this->db->from($this->table . ' n');
        $this->db->join('tasks t', 't.id = n.task_id', 'left');
        $this->db->join('selling_points sp', 'sp.id = n.from_selling_point', 'left');
        $this->db->where('n.to_selling_point', $selling_point_id);
        $this->db->where('n.is_read', 0);
        $this->db->order_by('n.created_at', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    /**
     * Get unread count for a selling point
     */
    public function get_unread_count($selling_point_id) {
        $this->db->where('to_selling_point', $selling_point_id);
        $this->db->where('is_read', 0);
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * Mark notification as read
     */
    public function mark_as_read($notification_id) {
        $data = [
            'is_read' => 1,
            'read_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $notification_id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Mark all notifications as read for a selling point
     */
    public function mark_all_as_read($selling_point_id) {
        $data = [
            'is_read' => 1,
            'read_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('to_selling_point', $selling_point_id);
        $this->db->where('is_read', 0);
        return $this->db->update($this->table, $data);
    }

    /**
     * Get all notifications for a selling point (read and unread)
     */
    public function get_all_notifications($selling_point_id, $limit = 20) {
        $this->db->select('n.*, t.title as task_title, sp.name as from_selling_point_name');
        $this->db->from($this->table . ' n');
        $this->db->join('tasks t', 't.id = n.task_id', 'left');
        $this->db->join('selling_points sp', 'sp.id = n.from_selling_point', 'left');
        $this->db->where('n.to_selling_point', $selling_point_id);
        $this->db->order_by('n.created_at', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    /**
     * Delete old read notifications (older than 30 days)
     */
    public function cleanup_old_notifications() {
        $this->db->where('is_read', 1);
        $this->db->where('read_at <', date('Y-m-d H:i:s', strtotime('-30 days')));
        
        return $this->db->delete($this->table);
    }
}