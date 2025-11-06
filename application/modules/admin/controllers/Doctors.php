<?php

class Doctors extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/doctor'));
        $this->load->model(array('admin/company'));
        $this->load->model(array('admin/chart'));
        
    }

    public function index() {
        $doctors = $this->doctor->get_all();
        $data['company'] = $this->company->get(1);
        $year_now = date('Y');
        
        $i = count($doctors);
        
        for($x=1; $x<=$i+1; $x++){  
            
            $doctors_month_stats = NULL;
            
            for($month = 1; $month <= 12; $month++)
            {              
                $doctors_month_stats[] = $this->chart->get_doc_month_stats( $year_now, $x, $month);                
            }
            $series_data = $doctors_month_stats;
            $series_data1 = $this->chart->clean_column(json_encode($series_data));
            $series_data2 = str_replace('], [', ', ', $series_data1);
            
            $doctor['v_' .$x] = $series_data2;
        }
        
        $data['doctor'] = $doctor;
           
        $data['year'] =  $year_now;        
        
        $data['doctors'] = $doctors;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "doctors_list";
        $this->load->view($this->_container, $data);
    }
    
    public function create() {
        if ($this->input->post('doc_name')) {
            $data['doc_name'] = $this->input->post('doc_name');
            $data['doc_address'] = $this->input->post('doc_address');
            $data['doc_phone_work'] = $this->input->post('doc_phone_work');
            $data['doc_phone_mobile'] = $this->input->post('doc_phone_mobile');
            $data['doc_city'] = $this->input->post('doc_city');
            $data['doc_price'] = $this->input->post('doc_price');

            $this->doctor->insert($data);

            redirect('/admin/doctors', 'refresh');
        } 
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "doctors_create";
        $this->load->view($this->_container, $data);
    }

    public function edit($id) { 
        if ($this->input->post('doc_name')) {
            $data['doc_name'] = $this->input->post('doc_name');
            $data['doc_address'] = $this->input->post('doc_address');
            $data['doc_phone_work'] = $this->input->post('doc_phone_work');
            $data['doc_phone_mobile'] = $this->input->post('doc_phone_mobile');
            $data['doc_city'] = $this->input->post('doc_city');
            $data['doc_price'] = $this->input->post('doc_price');

            $this->doctor->update($data, $id);

            redirect('/admin/doctors', 'refresh');
        }
        
        $doctors = $this->doctor->get($id);

        $data['doctors'] = $doctors;
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "doctors_edit";
        $this->load->view($this->_container, $data);
    }   

    public function delete($id) {
        $this->doctor->delete($id);

        redirect('/admin/doctors', 'refresh');
    }
    
    public function view($id) {
    
        $doctor = $this->doctor->get($id);        

        $data['doctor'] = $doctor;
        $data['year'] = 2014;
        $data['year_now'] = date('Y');
        
         
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "doctors_view";
        $this->load->view($this->_container, $data);
    } 

}
