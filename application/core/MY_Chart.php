<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Chart extends CI_Model {

    protected $table_name = '';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();

        $this->load->database();

        $this->load->helper('inflector');

        if (!$this->table_name) {
            $this->table_name = strtolower(plural(get_class($this)));
        }
    }

    public function get($id) {
        return $this->db->get_where($this->table_name, array($this->primary_key => $id))->row();
    }

    public function get_all($fields = '', $where = array(), $table = '', $limit = '', $order_by = '', $group_by = '') {
        $data = array();
        if ($fields != '') {
            $this->db->select($fields);
        }

        if (count($where)) {
            $this->db->where($where);
        }

        if ($table != '') {
            $this->table_name = $table;
        }

        if ($limit != '') {
            $this->db->limit($limit);
        }

        if ($order_by != '') {
            $this->db->order_by($order_by);
        }

        if ($group_by != '') {
            $this->db->group_by($group_by);
        }

        $Q = $this->db->get($this->table_name);

        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();

        return $data;
    }

    public function insert($data) {
        $data['date_created'] = $data['date_updated'] = date('Y-m-d H:i:s');
        $data['created_from_ip'] = $data['updated_from_ip'] = $this->input->ip_address();

        $success = $this->db->insert($this->table_name, $data);
        if ($success) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function update($data, $id) {
        $data['date_updated'] = date('Y-m-d H:i:s');
        $data['updated_from_ip'] = $this->input->ip_address();

        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table_name, $data);
    }

    public function delete($id) {
        $this->db->where($this->primary_key, $id);

        return $this->db->delete($this->table_name);
    }

    //old model from old version
    public function get_monthly_data($year) {
        $query = $this->db->query('SELECT COUNT(stock.id) AS data FROM stock, customers WHERE customers.customer_id_sys = stock.customer_id AND YEAR(stock.day_out)=' . $year . ' AND stock.status = 4 GROUP BY MONTH(stock.day_out)');

        return $query->result();
    }

    public function get_monthly_nosale($year) {
        //$query = $this->db->query('SELECT COUNT(customer_id_sys) AS data FROM customers WHERE YEAR(first_visit) =' . $year . ' AND sale = 0 AND ch_customer = 0 GROUP BY MONTH(first_visit)');
        $query = $this->db->query('SELECT COUNT(customers.customer_id_sys) AS data FROM customers WHERE YEAR(customers.first_visit)=' . $year . ' AND customers.status=3 GROUP BY MONTH(customers.first_visit)');
        return $query->result();
    }

    public function get_doctor_data($year) {
        $query = $this->db->query('SELECT doctors.doc_name AS name, COUNT(customers.customer_id_sys) AS data FROM doctors, customers WHERE customers.doctor = doctors.doc_ID AND YEAR(customers.first_fit)=' . $year . ' GROUP BY doctors.doc_name');
        //$query = $this->db->query('SELECT doctor AS name, COUNT(doctor) AS data FROM customers WHERE YEAR(first_fit) =' . $year . ' GROUP BY doctor');

        return $query->result();
    }

    public function get_vendor_data($year) {
        $query = $this->db->query('SELECT vendors.name AS name, COUNT(stock.serial) AS data FROM stock, vendors WHERE stock.vendor = vendors.vendor_id AND YEAR(stock.day_out)=' . $year . ' GROUP BY vendors.name');

        return $query->result();
    }

    public function get_manufacturer_data($year) {
        $query = $this->db->query('SELECT manufacturers.name AS name, COUNT(stock.serial) AS data FROM stock, manufacturers WHERE stock.manufacturer = manufacturers.id AND YEAR(stock.day_out)=' . $year . ' GROUP BY manufacturers.name');

        return $query->result();
    }

    public function get_doc_all($year) {
        $query1 = $this->db->query('SELECT doctors.doc_name AS name, COUNT(customers.customer_id_sys) AS data FROM doctors, customers WHERE customers.doctor = doctors.doc_ID AND YEAR(customers.first_fit)=' . $year . ' AND customers.status = 1 GROUP BY doctors.doc_name');
        $query2 = $this->db->query('SELECT doctors.doc_name AS name, COUNT(customers.customer_id_sys) AS data FROM doctors, customers WHERE customers.doctor = doctors.doc_ID AND YEAR(customers.first_visit)=' . $year . ' AND customers.status = 3 GROUP BY doctors.doc_name');

        $query = array('first_fit' => $query1, 'first_visit' => $query2);

        return $query->result();
    }

//chart-data-for-earlab-moulds and shells-------------------------------------

    public function get_earlab_data($year) {
        $query = $this->db->query('SELECT lab_types.type AS name, COUNT(id) AS data FROM earlab, lab_types WHERE earlab.type = lab_types.id AND YEAR(earlab.date_order)=' . $year . ' GROUP BY lab_types.type');

        return $query->result();
    }

    public function get_earlab_data_client($year) {
        $query = $this->db->query('SELECT lab_status.status AS name, COUNT(id) AS data FROM earlab, lab_status WHERE earlab.status = lab_status.id AND YEAR(earlab.date_order)=' . $year . ' GROUP BY lab_status.status');

        return $query->result();
    }

    public function get_earlab_data_pha($year) {
        $query = $this->db->query('SELECT lab_types.type AS name, COUNT(id) AS data FROM earlab, lab_types WHERE earlab.type = lab_types.id AND YEAR(earlab.date_order)=' . $year . ' AND earlab.status = 1 GROUP BY lab_types.type');

        return $query->result();
    }

//endof chart data for earlab mould and shells---------------------------------


    public function clean_column($series_data) {
        $series_data = str_replace('"', '', $series_data);
        $series_data = str_replace('{', '', $series_data);
        $series_data = str_replace('}', '', $series_data);
        $series_data = str_replace('data', '', $series_data);
        $series_data = str_replace('name', '', $series_data);
        $series_data = str_replace('manufacturer', '', $series_data);
        $series_data = str_replace('.', '', $series_data);
        $series_data = str_replace(':', '', $series_data);
        $series_data = str_replace('[[', '[', $series_data);
        $series_data = str_replace(']]', ']', $series_data);
        $series_data = str_replace(',', ', ', $series_data);

        return $series_data;
    }

    public function clean_pie($series_data) {
        $series_data = str_replace('{"name":"', utf8_encode("{name: '"), $series_data);
        $series_data = str_replace('","data":"', utf8_encode("', data: "), $series_data);
        $series_data = str_replace('"}', utf8_encode("}"), $series_data);
        $series_data = str_replace('data', 'y', $series_data);

        return $series_data;
    }

//end_of Model
}
