<?php

class Charts extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model(array('admin/chart'));
        $this->load->model(array('admin/doctor'));
        $this->load->model(array('admin/stock'));
        $this->load->model(array('admin/customer'));
    }

    public function index() {
        
    }
    
    public function debt_charts($year){

        $debt_data = $this->chart->get_debt_data($year, 4, 1);
        $debt_data1 = json_encode($debt_data);
        $data['debt_data'] = $this->chart->clean_column($debt_data1);
        
        $debt_data3 = $this->chart->get_pays_data($year, 4, 1);
        $debt_data4 = json_encode($debt_data3);
        $data['balance_data'] = $this->chart->clean_column($debt_data4);

        $debt_data5 = $this->chart->get_eopyy_data($year, 4, 0);
        $debt_data6 = json_encode($debt_data5);
        $data['eopyy_data'] = $this->chart->clean_column($debt_data6);
        
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "chart_view_debt";
        $this->load->view($this->_container, $data);       
    }

    public function lab_charts() {
        $year = date("Y");

        $earlab_data = $this->chart->get_earlab_data($year);
        $earlab_client = $this->chart->get_earlab_data_client($year);
        $earlab_pha = $this->chart->get_earlab_data_pha($year);

        $earlab_data = json_encode($earlab_data);
        $data['earlab_data'] = $this->chart->clean_pie($earlab_data);

        $earlab_client = json_encode($earlab_client);
        $data['earlab_client'] = $this->chart->clean_pie($earlab_client);

        $earlab_pha = json_encode($earlab_pha);
        $data['earlab_pha'] = $this->chart->clean_pie($earlab_pha);


        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "chart_view_lab";
        $this->load->view($this->_container, $data);
    }

    public function sales_charts($year) {
        //$year = date("Y");
        $data['year'] = $year;
        
        $data['manufacturer_statistics'] = $this->manufacturer_statistics($year);
               
        $data['sales'] = $this->sales($year, 'stocks.selling_point', 4, 3);
        $data['nosales'] = $this->nosales($year, 'stocks.selling_point', 4);
        $data['doctors'] = $this->doctors($year);
        $data['vendors'] = $this->vendors($year);
        $data['brands'] = $this->brands($year);
         


        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "chart_view";
        $this->load->view($this->_container, $data);
    }

    public function doctors_charts($year, $doc_id) {
        //$year = date("Y");.
        
        $data['patients'] = $this->chart->get_doc_stats($year, $doc_id);
        $data['doctor'] = $this->doctor->get($doc_id);
        $data['year'] = $year;

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "chart_view_doctors";
        $this->load->view($this->_container, $data);
    }
    
    public function doctors_stats($year, $doc_id)
    {
        $series_data = $this->chart->get_doc_stats($year, $doc_id);
        $series_data1 = json_encode($series_data);
        $series_data2 = $this->chart->clean_column($series_data1);

        return $series_data;       
    }
    
    public function sales($year, $selling_point, $status, $or_status) {
        //$series_data = $this->chart->get_data($year, 'stocks', 'customers', 'stocks.day_out', 'customers.id', 'stocks.customer_id', 'stocks.id', 'month', 'customers.status', '1');
        $series_data = $this->chart->get_monthly_data($year, $selling_point, $status, $or_status);
        $series_data1 = json_encode($series_data);
        $series_data2 = $this->chart->clean_column($series_data1);

        return $series_data2;
    }

    public function brands($year) {
        $series_data = $this->chart->get_manufacturer_data($year, 1 OR 2);
        $series_data1 = json_encode($series_data);
        $series_data2 = $this->chart->clean_pie($series_data1);

        return $series_data2;
    }

    public function doctors($year) {
        $series_data = $this->chart->get_doctor_data($year);
        $series_data1 = json_encode($series_data);
        $series_data2 = $this->chart->clean_pie($series_data1);

        return $series_data2;
    }

    public function vendors($year) {
        $series_data = $this->chart->get_vendor_data($year);
        $series_data1 = json_encode($series_data);
        $series_data2 = $this->chart->clean_pie($series_data1);

        return $series_data2;
    }
    
    public function manufacturer_statistics($year) {        

        $series_data = $this->chart->get_manufacturer_statistics($year);
        $series_data1 = json_encode($series_data);
        $series_data2 = $this->chart->clean_pie($series_data1);
        
        $series_data = $this->chart->get_manufacturer_statistics($year);
        $series_data1 = json_encode($series_data);
        $series_data2 = $this->chart->clean_pie($series_data1);
        

        return $series_data;
    }

    public function nosales($year) {
        //$series_data = $this->chart->get_data($year, 'customers', 'stocks.day_out', 'customers.id', 'stocks.customer_id', 'stocks.id', 'month', 'customers.status', '2');
        $series_data = $this->chart->get_monthly_nosale($year, 1, 3);
        $series_data1 = json_encode($series_data);
        $series_data2 = $this->chart->clean_column($series_data1);

        //$data = array('month' => $series_data1, 'brand' => $series_data2, 'doctor' => $series_data3, 'vendor' => $series_data4, 'nosales' => $series_data5, 'year' => $year);

        return $series_data2;
    }

    public function year_statistics_all() {

        $series_data1 = $this->chart->get_monthly_data();
        $series_data1 = json_encode($series_data1);
        $series_data1 = $this->chart->clean_column($series_data1);

        $series_data2 = $this->chart->get_manufacturer_data();
        $series_data2 = json_encode($series_data2);
        $series_data2 = $this->chart->clean_pie($series_data2);

        $series_data3 = $this->chart->get_doctor_data();
        $series_data3 = json_encode($series_data3);
        $series_data3 = $this->chart->clean_pie($series_data3);

        $series_data4 = $this->chart->get_vendor_data();
        $series_data4 = json_encode($series_data4);
        $series_data4 = $this->chart->clean_pie($series_data4);

        $series_data5 = $this->chart->get_monthly_nosale();
        $series_data5 = json_encode($series_data5);
        $series_data5 = $this->chart->clean_column($series_data5);

        $data = array('month' => $series_data1, 'brand' => $series_data2, 'doctor' => $series_data3, 'vendor' => $series_data4, 'nosales' => $series_data5);

        return $data;
    }
    
        public function ha_types($year, $selling_point, $type) {

        $data = $this->chart->get_ha_type_stats(2022, 1, 1);       
        

        return $data;
    }

}
