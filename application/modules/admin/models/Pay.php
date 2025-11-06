<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Pay extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_customer_debts($selling_point = null) {
        $this->db->select('c.name AS customer_name, s.id AS stock_id, mdl.model AS ha_model, srs.series AS ha_series, mfr.name AS manufacturer, SUM(s.ha_price - s.eopyy - COALESCE(p.pay, 0)) AS debt');
        $this->db->from('customers c');
        $this->db->join('(SELECT hearing_aid, SUM(pay) AS pay, customer FROM pays GROUP BY hearing_aid, customer) p', 'c.id = p.customer', 'left');
        $this->db->join('stocks s', 'p.hearing_aid = s.id');
        $this->db->join('models mdl', 's.ha_model = mdl.id');
        $this->db->join('series srs', 'mdl.series = srs.id');
        $this->db->join('manufacturers mfr', 'srs.brand = mfr.id');
        if ($selling_point !== null) {
            $this->db->where('s.selling_point', $selling_point);
        }
        $this->db->group_by('s.id');
        $this->db->having('debt >', 0);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getPaymentsByStockId($stock_id) {
    $this->db->select('date, pay');
    $this->db->from('pays');
    $this->db->where('hearing_aid', $stock_id);
    $this->db->order_by('date', 'DESC');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->result_array();
    } else {
        return [];
    }
}
}

