<?php

class Companies extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/company'));
        $this->load->model(array('admin/user'));
    }

    public function index() {
        $companies = $this->company->get_all();  
        $data['company_start'] = 2014;

        $data['companies'] = $companies;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "companies_list";
        $this->load->view($this->_container, $data);
    }

    public function create() {
        if ($this->input->post('company_name')) {
            $data['company_name'] = $this->input->post('company_name');
            $data['address'] = $this->input->post('address');
            $data['phone'] = $this->input->post('phone');
            $data['fax'] = $this->input->post('fax');
            $data['email'] = $this->input->post('email');
            $data['city'] = $this->input->post('city');
            $data['postal'] = $this->input->post('postal');
            $data['vat'] = $this->input->post('vat');
            $data['logo'] = $this->input->post('logo');
            $data['ekapty'] = $this->input->post('ekapty');
            $data['administrator'] = $this->input->post('administrator');

            $this->company->insert($data);

            redirect('/admin/companies', 'refresh');
        }

        $data['users'] = $this->user->get_all();
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "companies_create";
        $this->load->view($this->_container, $data);
    }

    public function edit($id) {
        if ($this->input->post('company_name')) {
            $data['company_name'] = $this->input->post('company_name');
            $data['address'] = $this->input->post('address');
            $data['phone'] = $this->input->post('phone');
            $data['fax'] = $this->input->post('fax');
            $data['email'] = $this->input->post('email');
            $data['city'] = $this->input->post('city');
            $data['postal'] = $this->input->post('postal');
            $data['vat'] = $this->input->post('vat');
            $data['logo'] = $this->input->post('logo');
            $data['ekapty'] = $this->input->post('ekapty');
            $data['administrator'] = $this->input->post('administrator');

            $this->company->update($data, $id);

            redirect('/admin/companies', 'refresh');
        }

        $company = $this->company->get($id);
        
        $data['users'] = $this->user->get_all();
        $data['company'] = $company;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "companies_edit";
        $this->load->view($this->_container, $data);
    }

    public function delete($id) {
        $this->company->delete($id);

        redirect('/admin/companies', 'refresh');
    }

}
