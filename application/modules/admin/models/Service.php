<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Service extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    
     public function get_services_data() {
        // Your SQL query to fetch data
        $query = "
            SELECT man.name AS manufacturer_name, 
                   ser.series, 
                   m.model AS hearing_aid_model, 
                   COUNT(*) AS number_of_repairs,
                   model_count
            FROM services s
            JOIN stocks st ON s.ha_service = st.id AND st.status != 5
            JOIN models m ON st.ha_model = m.id
            JOIN series ser ON m.series = ser.id
            JOIN manufacturers man ON ser.brand = man.id
            JOIN (SELECT ha_model, COUNT(*) AS model_count FROM stocks WHERE status != 5 GROUP BY ha_model) AS stock_counts ON m.id = stock_counts.ha_model
            GROUP BY man.name, ser.series, m.model, model_count
            ORDER BY number_of_repairs DESC";

        // Execute the query
        $result = $this->db->query($query);

        // Return the result
        return $result->result_array();  // Assuming you want to fetch data as an array
    }
    
    public function get_services($selling_point = null) {
        $this->db->select('services.*, customers.name AS customer, vendors.name AS lab_sent, stocks.selling_point AS selling_point, stocks.serial AS ha_serial, models.model AS ha_model_name');
        $this->db->from('services');
        $this->db->join('stocks', 'services.ha_service = stocks.id');
        $this->db->join('customers', 'stocks.customer_id = customers.id');
        $this->db->join('vendors', 'services.lab_sent = vendors.id', 'left'); // LEFT JOIN για vendors
        $this->db->join('models', 'stocks.ha_model = models.id', 'left'); // LEFT JOIN για models
        if ($selling_point !== null) {
            $this->db->where('stocks.selling_point', $selling_point);
        }
        $query = $this->db->get();
        return $query->result_array(); // Χρησιμοποιούμε τη μέθοδο result_array() αντί για result()
    }
    
    
}
