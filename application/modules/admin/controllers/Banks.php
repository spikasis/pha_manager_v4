<?php

class Banks extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/bank')); 
        $this->load->model(array('admin/company'));
    }

    public function index() {
        $banks = $this->bank->get_all();        

        $data['banks'] = $banks;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "banks_list";
        $this->load->view($this->_container, $data);
    }

    public function create() {
        if ($this->input->post('name')) {
            $data['name'] = $this->input->post('bank_name');
            $data['iban'] = $this->input->post('iban');
            $data['type'] = $this->input->post('type');
            $data['owner'] = $this->input->post('owner');

            $this->bank->insert($data);

            redirect('/admin/banks', 'refresh');
        }
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "banks_create";
        $this->load->view($this->_container, $data);
    }

    public function edit($id) {
        if ($this->input->post('name')) {
            $data['name'] = $this->input->post('bank_name');
            $data['iban'] = $this->input->post('iban');
            $data['type'] = $this->input->post('type');
            $data['owner'] = $this->input->post('owner');

            $this->bank->update($data, $id);

            redirect('/admin/banks', 'refresh');
        }

        $bank = $this->bank->get($id);        
        
        $data['bank'] = $bank;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "banks_edit";
        $this->load->view($this->_container, $data);
    }

    public function view() {

        $bank = $this->bank->get_all(); 
        $company = $this->company->get(1);
        
        $data['company'] = $company;
        $data['banks'] = $bank;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "bank_doc";
        $this->load->view($this->_container, $data);
    }
    public function delete($id) {
        $this->bank->delete($id);

        redirect('/admin/banks', 'refresh');
    }

}
