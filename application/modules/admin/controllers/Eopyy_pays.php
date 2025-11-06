<?php

class Eopyy_pays extends Admin_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->model(array('admin/eopyy_pay'));
        $this->load->model(array('admin/stock'));
        $this->load->model(array('admin/customer'));
        $this->load->model(array('admin/manufacturer'));
        $this->load->model(array('admin/vendor'));
        $this->load->model(array('admin/stock_status'));
        $this->load->model(array('admin/ch_customer'));
        $this->load->model(array('admin/company'));
    }

    public function index() {        
        $data['eopyy_pay'] = $this->eopyy_pay->get_all();
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "eopyy_pay_list";
        $this->load->view($this->_container, $data);
    }

    public function create() {
        if ($this->input->post('price')) {
            $data['date'] = $this->input->post('date');
            $data['price'] = $this->input->post('price');           
            $data['comments'] = $this->input->post('comments');
        
            $this->eopyy_pay->insert($data);

            redirect('/admin/eopyy_pays', 'refresh');
        }

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "eopyy_pay_create";
        $this->load->view($this->_container, $data);
    }

   
    public function edit($id) {
        if ($this->input->post('date')) {
            $data['date'] = $this->input->post('date');
            $data['price'] = $this->input->post('price');
            $data['comments'] = $this->input->post('comments');
            $this->eopyy_pay->update($data, $id);

            redirect('/admin/eopyy_pays', 'refresh');
        }
        $data['eopyy_pay'] = $this->eopyy_pay->get($id);

      
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "eopyy_pay_edit";
        $this->load->view($this->_container, $data);
    }

    public function delete($id) {
        $this->eopyy_pay->delete($id);

        redirect('/admin/eopyy_pays', 'refresh');
    }
    
    public function view($id) {
    
        $pay = $this->pay->get($id);
        $customers = $this->customer->get($pay->customer);

        $data['pay'] = $pay;
        $data['customer'] = $customers;
         
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "pay_view";
        $this->load->view($this->_container, $data);
    }   
}
