<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Financial extends MY_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_year_pcs($year, $selling_point) {
        $query = $this->db->query(''
                . 'SELECT COUNT(stocks.id) AS data '
                . 'FROM stocks '
                . 'WHERE YEAR(stocks.day_out)= ' . $year . ' '
                . 'AND stocks.selling_point = ' . $selling_point );
    
        return $query->result();
    }
    
    function get_year_price_sum($year, $selling_point) {
        $query = $this->db->query(''
                . 'SELECT SUM(stocks.ha_price) AS data '
                . 'FROM stocks '
                . 'WHERE YEAR(stocks.day_out)= ' . $year . ' '
                . 'AND stocks.selling_point = ' . $selling_point );
    
        return $query->result();
    }
}

?>