<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Earlab extends MY_Model {

    public function __construct() 
    {
        parent::__construct();
    }
    
    public function get_earlabs_by_selling_point($selling_point = NULL) 
{
    $this->db->select('earlabs.*, vendors.name AS vendor_name, customers.name AS customer_name, selling_points.city AS selling_point');
    $this->db->from('earlabs');
    $this->db->join('customers', 'earlabs.customer_id = customers.id');
    $this->db->join('vendors', 'earlabs.vendor_id = vendors.id');
    $this->db->join('selling_points', 'customers.selling_point = selling_points.id');

    // Add the condition only if $selling_point is provided
    if ($selling_point !== NULL) 
    {
        // Validate selling point if necessary
        $this->db->where('customers.selling_point', $selling_point);
    }

    $query = $this->db->get();

    // Log the last query for debugging purposes
    log_message('debug', $this->db->last_query());

    if ($query->num_rows() > 0) 
    {
        return $query->result_array();  // Return results as an array
    } 
    else 
    {
        return [];  // Return empty array if no results
    }
}

            

    public function get_earlabs_by_sp_and_delivery($selling_point = NULL) 
    {
        $this->db->select('earlabs.*, vendors.name AS vendor_name, customers.name AS customer_name, selling_points.city AS selling_point');
        $this->db->from('earlabs');
        $this->db->join('customers', 'earlabs.customer_id = customers.id');
        $this->db->join('vendors', 'earlabs.vendor_id = vendors.id');
        $this->db->join('selling_points', 'customers.selling_point = selling_points.id');
        
        // Apply filters for date_delivery and selling_point
        $this->db->where('earlabs.date_delivery', 0);  // Filter where date_delivery is 0
    
        if ($selling_point !== NULL) {
            $this->db->where('customers.selling_point', $selling_point);  // Filter by selling_point if provided
        }
        
        $query = $this->db->get();
        return $query->result_array();  // Return results as an array
    
    }    

}
    
    