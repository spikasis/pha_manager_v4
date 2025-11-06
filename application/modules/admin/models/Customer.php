<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Customer extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_customers($status = null, $selling_point = null, $pending = null) {
    $this->db->select('id, name, address, city, phone_home, phone_mobile, first_visit');
    $this->db->from('customers');
    
    if ($status !== null) {
        $this->db->where('status', $status);
    }
    
    if ($selling_point !== null) {
        $this->db->where('selling_point', $selling_point);
    }

    if ($pending !== null) {
            $this->db->where('pending', 'pending'); 
    }
    $query = $this->db->get();
    return $query->result_array();
    
    }
    
    /*
    public function get($id) {
    return $this->db->get_where('customers', ['id' => $id])->row_array();
}
     
     */

}
