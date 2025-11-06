<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_models_with_details() {
        $this->db->select('
            models.id AS model_id, 
            models.model AS model_name, 
            manufacturers.name AS manufacturer_name, 
            series.series AS series_name, 
            ha_types.type AS ha_type_name, 
            battery_types.type AS battery_type_name
            ');
        $this->db->from('models');
        $this->db->join('series', 'models.series = series.id', 'left');
        $this->db->join('manufacturers', 'series.brand = manufacturers.id', 'left');
        $this->db->join('ha_types', 'models.ha_type = ha_types.id', 'left');
        $this->db->join('battery_types', 'models.battery = battery_types.id', 'left');
        
        $query = $this->db->get();
        
        

        return $query->result_array();        
    }    
}