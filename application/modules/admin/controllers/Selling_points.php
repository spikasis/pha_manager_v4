<?php

class Selling_points extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/company'));
        $this->load->model(array('admin/user'));
        $this->load->model(array('admin/selling_point'));
    }

    public function index() {
        $selling_point = $this->selling_point->get_all();        

        $data['selling_point'] = $selling_point;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "selling_points_list";
        $this->load->view($this->_container, $data);
    }

    public function create() {
        if ($this->input->post('city')) {
            $data['city'] = $this->input->post('city');
            $data['address'] = $this->input->post('address');
            $data['phone'] = $this->input->post('phone');
            $data['email'] = $this->input->post('email');
            $data['administrator'] = $this->input->post('administrator');

            $this->selling_point->insert($data);

            redirect('/admin/selling_points', 'refresh');
        }

        $data['users'] = $this->user->get_all();
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "selling_points_create";
        $this->load->view($this->_container, $data);
    }

    public function edit($id) {
        if ($this->input->post('city')) {
            $data['city'] = $this->input->post('city');
            $data['address'] = $this->input->post('address');
            $data['phone'] = $this->input->post('phone');
            $data['email'] = $this->input->post('email');
            $data['administrator'] = $this->input->post('administrator');

            $this->selling_point->update($data, $id);

            redirect('/admin/selling_points', 'refresh');
        }

        $selling_point = $this->selling_point->get($id);
        
        $data['users'] = $this->user->get_all();
        $data['selling_point'] = $selling_point;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "selling_points_edit";
        $this->load->view($this->_container, $data);
    }

    public function delete($id) {
        $this->selling_point->delete($id);

        redirect('/admin/selling_points', 'refresh');
    }

}
