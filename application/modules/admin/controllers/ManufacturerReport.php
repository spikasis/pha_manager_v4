<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManufacturerReport extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ManufacturerReport_model');
    }

    // Φορτώνει το αρχικό HTML view (με dropdown, γράφημα κ.λπ.)
    public function index() {
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "reports/manufacturer_report";
        $this->load->view($this->_container, $data);
        //$this->load->view('admin/themes/default/reports/manufacturer_report');
        
    }

    // Επιστρέφει τα δεδομένα JSON για τον συγκεκριμένο κατασκευαστή (για Ajax)
    public function data($manufacturer_id = null) {
    // Αν είναι κενή συμβολοσειρά "0" ή "", κάνε το null για καθολικά δεδομένα
    if ($manufacturer_id === '0' || $manufacturer_id === '') {
        $manufacturer_id = null;
    }

    $sales_per_year = $this->ManufacturerReport_model->get_sales_yearly($manufacturer_id);
    $avg_order_diff = $this->ManufacturerReport_model->get_avg_order_delay($manufacturer_id);
    $extra_kpis = $this->ManufacturerReport_model->get_extra_kpis($manufacturer_id);
    $repairs = $this->ManufacturerReport_model->get_repairs_by_manufacturer($manufacturer_id);
    $repairs_by_category = $this->ManufacturerReport_model->get_repairs_by_category($manufacturer_id);
    $specific_issue_count = $this->ManufacturerReport_model->get_specific_issue_count($manufacturer_id);

    echo json_encode([
        'sales_per_year' => $sales_per_year,
        'avg_order_diff' => $avg_order_diff,
        'extra_kpis' => $extra_kpis,
        'repairs' => $repairs,
        'repairs_by_category' => $repairs_by_category,
        'specific_issue_count' => $specific_issue_count
    ]);
}

    // Επιστρέφει όλους τους κατασκευαστές για το dropdown
    public function list_manufacturers() {
        $query = $this->db->get('manufacturers');
        $manufacturers = $query->result_array();
        echo json_encode($manufacturers);
    }
}
