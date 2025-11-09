<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_notifications extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }
    
    public function index() {
        header('Content-Type: application/json');
        
        // Test what happens when we call the notification endpoints directly
        try {
            // Check if we can load basic models
            if ($this->db->table_exists('customers')) {
                $customers_count = $this->db->count_all('customers');
                $response['customers_count'] = $customers_count;
            }
            
            if ($this->db->table_exists('stocks')) {
                $stocks_count = $this->db->count_all('stocks');
                $response['stocks_count'] = $stocks_count;
            }
            
            // Try to simulate payment reminders count
            if ($this->db->table_exists('stocks') && $this->db->table_exists('customers')) {
                // Simple query to find overdue payments (example logic)
                $this->db->select('COUNT(*) as count');
                $this->db->from('stocks');
                $this->db->join('customers', 'stocks.customer_id = customers.id', 'left');
                $this->db->where('stocks.debt >', 0);
                $this->db->where('DATE(stocks.day_out) <', date('Y-m-d', strtotime('-30 days')));
                
                $query = $this->db->get();
                $overdue_count = $query->row()->count;
                
                $response['overdue_payments'] = $overdue_count;
            }
            
            // Try to simulate task notifications
            if ($this->db->table_exists('task')) {
                $this->db->select('COUNT(*) as count');
                $this->db->from('task');
                $this->db->where('completion_date IS NULL');
                $this->db->where('DATE(entry_date) <', date('Y-m-d', strtotime('-7 days')));
                
                $query = $this->db->get();
                $overdue_tasks = $query->row()->count;
                
                $response['overdue_tasks'] = $overdue_tasks;
            } else {
                $response['overdue_tasks'] = 'Table task does not exist';
            }
            
            $response['success'] = true;
            $response['timestamp'] = date('Y-m-d H:i:s');
            
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'error' => $e->getMessage(),
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
        
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
    
    public function payment_count() {
        header('Content-Type: application/json');
        
        try {
            // Simplified payment reminders count
            $count = 0;
            if ($this->db->table_exists('stocks')) {
                $this->db->select('COUNT(*) as count');
                $this->db->from('stocks');
                $this->db->where('debt >', 0);
                $this->db->where('day_out IS NOT NULL');
                $this->db->where('DATE(day_out) <', date('Y-m-d', strtotime('-30 days')));
                
                $query = $this->db->get();
                $count = $query->row()->count;
            }
            
            echo json_encode(['success' => true, 'count' => $count]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage(), 'count' => 0]);
        }
    }
    
    public function task_count() {
        header('Content-Type: application/json');
        
        try {
            $count = 0;
            if ($this->db->table_exists('task')) {
                $this->db->select('COUNT(*) as count');
                $this->db->from('task');
                $this->db->where('completion_date IS NULL OR completion_date = "0000-00-00"');
                $this->db->where('DATE(entry_date) <', date('Y-m-d', strtotime('-7 days')));
                
                $query = $this->db->get();
                $count = $query->row()->count;
            }
            
            echo json_encode(['success' => true, 'count' => $count]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage(), 'count' => 0]);
        }
    }
}