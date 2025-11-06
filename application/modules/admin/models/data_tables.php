<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class data_tables extends MY_Model {

    function __construct() {
        parent::__construct();
    }

//manufacturer------------------------------------------------------------------
    public function getActive_manufacturer($active_id) {
        $query = $this->db->query('SELECT * FROM manufacturers WHERE id =' . $active_id);

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $man_active = $row;
            }
        }
        return $man_active;
    }

    public function getActive_vendor($active_id) {
        $query = $this->db->query('SELECT * FROM vendors WHERE vendor_id =' . $active_id);

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $ven_active = $row;
            }
        }
        return $ven_active;
    }

//endof_manufacturer------------------------------------------------------------  
//stock-------------------------------------------------------------------------
    public function getActive_stock($active_id) {
        $query = $this->db->query('SELECT * FROM stock WHERE id =' . $active_id);

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $haActive = $row;
            }
        }
        return $haActive;
    }

//endof_stock-------------------------------------------------------------------
//customer----------------------------------------------------------------------  
    public function getActive_customer($active_id) {
        $query = $this->db->query('SELECT * FROM customers WHERE customer_id_sys =' . $active_id);

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $customerActive = $row;
            }
        }

        return $customerActive;
    }

//endof_customer----------------------------------------------------------------
//doctor------------------------------------------------------------------------  
    function getActive_doctor($record_id) {
        $query = $this->db->query('SELECT * FROM doctors WHERE doc_ID =' . $record_id);

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $doc_active = $row;
            }
        }

        return $doc_active;
    }

//endof_doctor------------------------------------------------------------------  
//insurance------------------------------------------------------------------------  
    function getActive_insurance($record_id) {
        $query = $this->db->query('SELECT * FROM insurance WHERE id =' . $record_id);

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $insurance_act = $row;
            }
        }

        return $insurance_act;
    }

//endof_insurance---------------------------------------------------------------
//dap-------------------------------------------------------------------------
    public function getActive_dap($active_id) {
        $query = $this->db->query('SELECT * FROM dap WHERE id =' . $active_id);

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $dapActive = $row;
            }
        }
        return $dapActive;
    }

//endof_dap------------------------------------------------------------------- 
//ch_customer-------------------------------------------------------------------------
    public function getActive_ch_customer($active_id) {
        $query = $this->db->query('SELECT * FROM customers WHERE id =' . $active_id);

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $chActive = $row;
            }
        }
        return $chActive;
    }

//endof_ch_customer-------------------------------------------------------------------     
}

?>
