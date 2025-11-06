<?php

class Vendors extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/vendor'));
        $this->load->model(array('admin/company'));        
        $this->load->model(array('admin/chart'));   
        $this->load->model(array('admin/stock')); 
        $this->load->model(array('admin/service_ticket')); 
    }

    public function index() {
        $year_now = date('Y');
        //$year_now = 2015;
        $vendors = $this->vendor->get_all();
        $data['company'] = $this->company->get(1);
        
        $i = count($vendors);
        
        for($x=1; $x<=$i+1; $x++){  
            
            $vendor_month_stats = NULL;
            
            for($month = 1; $month <= 12; $month++)
            {              
                $vendor_month_stats[] = $this->chart->get_vendor_stats($year_now, $x, $month);                
            }
            $series_data = $vendor_month_stats;
            $series_data1 = $this->chart->clean_column(json_encode($series_data));
            $series_data2 = str_replace('], [', ', ', $series_data1);
            
            $vendor['v_' .$x] = $series_data2;
        }
        
        $data['vendor'] = $vendor;
        $data['vendors'] = $vendors; 
        $data['year_now'] = $year_now;
    
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "vendors_list";
        $this->load->view($this->_container, $data);
    }

    public function view_all_ekapty() {
        $year_now = date('Y');
        //$year_now = 2015;
        $vendors = $this->vendor->get_all();
        $data['company'] = $this->company->get(1);
        
        $i = count($vendors);
        
        for($x=1; $x<=$i+1; $x++){  
            
            $vendor_month_stats = NULL;
            
            for($month = 1; $month <= 12; $month++)
            {              
                $vendor_month_stats[] = $this->chart->get_vendor_stats($year_now, $x, $month);                
            }
            $series_data = $vendor_month_stats;
            $series_data1 = $this->chart->clean_column(json_encode($series_data));
            $series_data2 = str_replace('], [', ', ', $series_data1);
            
            $vendor['v_' .$x] = $series_data2;
        }
        
        $data['vendor'] = $vendor;
        $data['vendors'] = $vendors; 
        $data['year_now'] = $year_now;
    
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "ekapty/vendors_list_ekapty";
        $this->load->view($this->_container, $data);
    }    
    public function create() {
        if ($this->input->post('name')) {
            $data['name']       =   $this->input->post('name');
            $data['address']    =   $this->input->post('address');
            $data['phone']      =   $this->input->post('phone');
            $data['city']       =   $this->input->post('city');
            $data['vat']        =   $this->input->post('vat');

            $this->vendor->insert($data);

            redirect('/admin/vendors', 'refresh');
        }        
                
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "vendors_create";
        $this->load->view($this->_container, $data);
    }

    public function edit($id) {
        if ($this->input->post('name')) {
            $data['name']       =   $this->input->post('name');
            $data['address']    =   $this->input->post('address');
            $data['phone']      =   $this->input->post('phone');
            $data['city']       =   $this->input->post('city');
            $data['vat']        =   $this->input->post('vat');

            $this->vendor->update($data, $id);

            redirect('/admin/vendors', 'refresh');
        }
        
        $vendors = $this->vendor->get($id);

        $data['vendors'] = $vendors;
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "vendors_edit";
        $this->load->view($this->_container, $data);
    }

    public function delete($id) {
        $this->vendor->delete($id);

        redirect('/admin/vendors', 'refresh');
    }
//------custom routines for further data----------------------------------------
    
    public function stats($id) {
        
        $year_now = date('Y');
    
        $data['vendors'] = $this->vendor->get($id);
        $data['company'] = $this->company->get(1);
    
        for($month = 1; $month <= 12; $month++){
            $vendor_stats[] = $this->chart->get_vendor_stats($year_now, $id, $month);                
            }           
            
        $series_data = $this->chart->clean_column(json_encode($vendor_stats));
        $series_data1 = str_replace('], [', ', ', $series_data);
        
        $data['vendor_stats'] = str_replace('"', '', $series_data1);
        
        
        //$data['service_stats'] = $this->service_stat->service_stats($id);
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "vendors_stats";
        $this->load->view($this->_container, $data);
    }
    
    public function stats_all($id) {
        
        $year_now = date('Y');
    
        $data['vendors'] = $this->vendor->get($id);
        $data['company'] = $this->company->get(1);
    
       for($year = 2014; $year <= $year_now; $year++){
            $vendor_stats[] = $this->chart->get_vendor_stats_year($id, $year); 
            $vendor_year[] = $year;
            }
            
        $series_data = $this->chart->clean_column(json_encode($vendor_stats));
        $series_data1 = str_replace('], [', ', ', $series_data);
        
        
        $data['vendor_year'] = $vendor_year;
        $data['vendor_stats'] = str_replace('"', '', $series_data1);
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "vendors_stats_year";
        $this->load->view($this->_container, $data);
    }
    public function view($id) {
    
        $vendor = $this->vendor->get($id);              

        $data['vendor'] = $vendor;
        $data['year'] = 2014;
        $data['year_now'] = date('Y');            
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "vendors_view";
        $this->load->view($this->_container, $data);
    }     
}
