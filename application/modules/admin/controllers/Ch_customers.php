<?php

class Ch_customers extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/ch_customer'));
        $this->load->model(array('admin/stock'));        
        $this->load->model(array('admin/doctor'));
        $this->load->model(array('admin/selling_points'));
        $this->load->model(array('admin/ch_customer_status'));
        $this->load->model(array('admin/insurance'));
        $this->load->model(array('admin/chart'));
    }

    public function index() {
        $ch_customers = $this->ch_customer->get_all();

        $data['ch_customers'] = $ch_customers;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "ch_customers_list";
        $this->load->view($this->_container, $data);
    }

    public function create() {
        if ($this->input->post('name')) {
            $data['name'] = $this->input->post('name');
            $data['birthday'] = $this->input->post('birthday');
            $data['phone_home'] = $this->input->post('phone_home');
            $data['phone_mobile'] = $this->input->post('phone_mobile');
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['vat_id'] = $this->input->post('vat_id');
            $data['insurance'] = $this->input->post('insurance');
            $data['old_user'] = $this->input->post('old_user');
            $data['selling_point'] = $this->input->post('selling_point');
            $data['status'] = $this->input->post('status');
            $data['doctor'] = $this->input->post('doctor');
            $data['first_visit'] = $this->input->post('first_visit');
            $data['first_fit'] = $this->input->post('first_fit');
            $data['guarantee_end'] = $this->input->post('guarantee_end');
            $data['ha_price'] = $this->input->post('ha_price');
            $data['ch_customer_id'] = $this->input->post('ch_customer_id');
            $data['profession'] = $this->input->post('profession');
            $data['comments'] = $this->input->post('comments');
            $this->ch_customer->insert($data);

            redirect('/admin/ch_customers', 'refresh');
        }

        $doctors = $this->doctor->get_all();
        $selling_points = $this->selling_points->get_all();
        $ch_customer_status = $this->ch_customer_status->get_all();
        $insurance = $this->insurance->get_all();

        $data['doctors'] = $doctors;
        $data['selling_points'] = $selling_points;
        $data['ch_customer_status'] = $ch_customer_status;
        $data['insurances'] = $insurance;

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "ch_customers_create";
        $this->load->view($this->_container, $data);
    }

    public function edit($id) {
        if ($this->input->post('name')) {
            $data['name'] = $this->input->post('name');
            $data['birthday'] = $this->input->post('birthday');
            $data['phone_home'] = $this->input->post('phone_home');
            $data['phone_mobile'] = $this->input->post('phone_mobile');
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['vat_id'] = $this->input->post('vat_id');
            $data['insurance'] = $this->input->post('insurance');
            $data['old_user'] = $this->input->post('old_user');
            $data['selling_point'] = $this->input->post('selling_point');
            $data['status'] = $this->input->post('status');
            $data['doctor'] = $this->input->post('doctor');
            $data['first_visit'] = $this->input->post('first_visit');
            $data['first_fit'] = $this->input->post('first_fit');
            $data['guarantee_end'] = $this->input->post('guarantee_end');
            $data['ha_price'] = $this->input->post('ha_price');
            $data['ch_customer_id'] = $this->input->post('ch_customer_id');
            $data['profession'] = $this->input->post('profession');
            $data['comments'] = $this->input->post('comments');
             $this->ch_customer->update($data, $id);

            redirect('/admin/ch_customers', 'refresh');
        }

        $ch_customer = $this->ch_customer->get($id);
        $doctors = $this->doctor->get_all();
        $selling_points = $this->selling_points->get_all();
        $ch_customer_status = $this->ch_customer_status->get_all();
        $insurances = $this->insurance->get_all();

        $data['doctors'] = $doctors;
        $data['selling_points'] = $selling_points;
        $data['ch_customer_status'] = $ch_customer_status;
        $data['insurances'] = $insurances;

        $data['ch_customer'] = $ch_customer;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "ch_customers_edit";
        $this->load->view($this->_container, $data);
    }
    
    public function view($id) {
        
        $ch_customer = $this->ch_customer->get($id);        
        $data['doctor'] = $this->doctor->get($ch_customer->doctor);
        $data['selling_points'] = $this->selling_points->get($ch_customer->selling_point);
        $data['ch_customer_status'] = $this->ch_customer_status->get($ch_customer->status);
        $data['insurance'] = $this->insurance->get($ch_customer->insurance);
        $data['stocks'] = $this->stock->get_all('id, serial, manufacturer, model, type, day_out, guarantee_end, comments', 'ch_customer_id=' . $id);
        
        $data['ch_customer'] = $ch_customer; 
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "ch_customers_view_old";
        $this->load->view($this->_container, $data);
    }

    public function delete($id) {
        $this->ch_customer->delete($id);

        redirect('/admin/ch_customers', 'refresh');
    }
    public function get_sold() {
        $ch_customers = $this->ch_customer->get_all('id, name, address, city, phone_home, first_visit','status = 1');

        $data['ch_customers'] = $ch_customers;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "ch_customers_list";
        $this->load->view($this->_container, $data);
    }
    public function get_interested() {
        $ch_customers = $this->ch_customer->get_all('id, name, address, city, phone_home, first_visit','status = 3');

        $data['ch_customers'] = $ch_customers;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "ch_customers_list";
        $this->load->view($this->_container, $data);
    }
        public function get_onhold() {
        $ch_customers = $this->ch_customer->get_all('id, name, address, city, phone_home, first_visit','status = 5');

        $data['ch_customers'] = $ch_customers;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "ch_customers_list";
        $this->load->view($this->_container, $data);
    }

    

}
