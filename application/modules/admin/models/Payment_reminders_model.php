<?php
/**
 * Payment Reminders Model
 * Handles overdue payment calculations and reminders
 */

class Payment_reminders_model extends MY_Model {

    protected $table_name = 'payment_reminders_log';
    protected $primary_key = 'id';

    public function __construct() {
        // Following MY_Model pattern - don't call parent::__construct()
        $this->load->database();
        $this->load->helper('inflector');
    }

    /**
     * Get overdue payments by selling point
     * @param int|null $selling_point_id
     * @param int $days_overdue (default 30)
     * @return array
     */
    public function get_overdue_debts($selling_point_id = null, $days_overdue = 30) {
        $this->db->select('
            c.id as customer_id,
            c.name as customer_name,
            c.phone_home,
            c.phone_mobile,
            c.selling_point,
            sp.city as selling_point_name,
            s.id as stock_id,
            s.serial,
            s.model,
            s.type,
            s.ha_price,
            s.eopyy,
            s.day_out as date_sold,
            COALESCE(SUM(p.pay), 0) as total_paid,
            (s.ha_price - s.eopyy - COALESCE(SUM(p.pay), 0)) as debt_amount,
            DATEDIFF(CURDATE(), s.day_out) as days_since_sold
        ');
        
        $this->db->from('customers c');
        $this->db->join('stocks s', 'c.id = s.customer_id', 'inner');
        $this->db->join('selling_points sp', 'c.selling_point = sp.id', 'left');
        $this->db->join('pays p', 's.id = p.hearing_aid', 'left');
        
        $this->db->where('s.day_out IS NOT NULL');
        $this->db->where('s.status', 4); // 4 = sold status
        
        if ($selling_point_id) {
            $this->db->where('c.selling_point', $selling_point_id);
        }
        
        $this->db->group_by('c.id, s.id');
        $this->db->having('debt_amount > 0');
        $this->db->having('days_since_sold >', $days_overdue);
        $this->db->order_by('days_since_sold', 'DESC');
        
        return $this->db->get()->result_array();
    }

    /**
     * Get reminder counts per selling point
     * @return array
     */
    public function get_reminder_counts_by_selling_point() {
        $this->db->select('
            c.selling_point,
            sp.city as selling_point_name,
            COUNT(DISTINCT c.id) as overdue_customers,
            SUM(s.ha_price - s.eopyy - COALESCE(p.pay_total, 0)) as total_debt
        ');
        
        $this->db->from('customers c');
        $this->db->join('stocks s', 'c.id = s.customer_id', 'inner');
        $this->db->join('selling_points sp', 'c.selling_point = sp.id', 'left');
        $this->db->join('(
            SELECT hearing_aid, SUM(pay) as pay_total 
            FROM pays 
            GROUP BY hearing_aid
        ) p', 's.id = p.hearing_aid', 'left');
        
        $this->db->where('s.day_out IS NOT NULL');
        $this->db->where('s.status', 4); // 4 = sold status
        $this->db->where('DATEDIFF(CURDATE(), s.day_out) > 30');
        
        $this->db->group_by('c.selling_point');
        $this->db->having('total_debt > 0');
        
        return $this->db->get()->result_array();
    }

    /**
     * Get urgent reminders (over 60 days overdue)
     * @param int|null $selling_point_id
     * @return array
     */
    public function get_urgent_reminders($selling_point_id = null) {
        return $this->get_overdue_debts($selling_point_id, 60);
    }

    /**
     * Get customers with partial payments (recent activity)
     * @param int|null $selling_point_id
     * @param int $days_recent (default 7)
     * @return array
     */
    public function get_recent_payment_activity($selling_point_id = null, $days_recent = 7) {
        $this->db->select('
            c.id as customer_id,
            c.name as customer_name,
            c.selling_point,
            sp.city as selling_point_name,
            s.id as stock_id,
            s.serial,
            s.model,
            p.pay as last_payment,
            p.date as last_payment_date,
            (s.ha_price - s.eopyy - total_pays.total_paid) as remaining_debt
        ');
        
        $this->db->from('pays p');
        $this->db->join('stocks s', 'p.hearing_aid = s.id', 'inner');
        $this->db->join('customers c', 's.customer_id = c.id', 'inner');
        $this->db->join('selling_points sp', 'c.selling_point = sp.id', 'left');
        $this->db->join('(
            SELECT hearing_aid, SUM(pay) as total_paid 
            FROM pays 
            GROUP BY hearing_aid
        ) total_pays', 's.id = total_pays.hearing_aid', 'inner');
        
        $this->db->where('p.date >=', date('Y-m-d', strtotime("-{$days_recent} days")));
        
        if ($selling_point_id) {
            $this->db->where('c.selling_point', $selling_point_id);
        }
        
        $this->db->having('remaining_debt > 0');
        $this->db->order_by('p.date', 'DESC');
        
        return $this->db->get()->result_array();
    }

    /**
     * Mark reminder as sent
     * @param int $customer_id
     * @param int $stock_id
     * @param string $reminder_type
     * @return bool
     */
    public function mark_reminder_sent($customer_id, $stock_id, $reminder_type = 'standard') {
        $data = [
            'customer_id' => $customer_id,
            'stock_id' => $stock_id,
            'reminder_type' => $reminder_type,
            'sent_date' => date('Y-m-d H:i:s'),
            'sent_by' => $this->session->userdata('user_id')
        ];
        
        return $this->db->insert('payment_reminders_log', $data);
    }

    /**
     * Get reminder history for a customer
     * @param int $customer_id
     * @return array
     */
    public function get_reminder_history($customer_id) {
        $this->db->select('
            prl.*,
            s.serial,
            s.model,
            u.first_name,
            u.last_name
        ');
        
        $this->db->from('payment_reminders_log prl');
        $this->db->join('stocks s', 'prl.stock_id = s.id', 'left');
        $this->db->join('users u', 'prl.sent_by = u.id', 'left');
        
        $this->db->where('prl.customer_id', $customer_id);
        $this->db->order_by('prl.sent_date', 'DESC');
        
        return $this->db->get()->result_array();
    }
}