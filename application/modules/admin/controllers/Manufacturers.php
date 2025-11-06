<?php

class Manufacturers extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/manufacturer'));
        $this->load->model(array('admin/chart'));
        $this->load->model(array('admin/stock'));
    }

    public function index() {
        $manufacturers = $this->manufacturer->get_all(); 
        
        $ser_stats = $this->service_stats();        
        $data['service_stats'] = $this->chart->clean_pie(json_encode($ser_stats));

        $sales = $this->db->query('SELECT manufacturer, COUNT(id) AS sales FROM stocks WHERE day_out = day_out GROUP BY manufacturer ');
        $data['sales'] = $sales->result();
        $data['manufacturers'] = $manufacturers;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "manufacturers_list";
        $this->load->view($this->_container, $data);
    }

    public function create() {
        if ($this->input->post('name')) {
            $data['name'] = $this->input->post('name');
            $data['country'] = $this->input->post('country');
            $data['ce_mark'] = $this->input->post('ce_mark');
            $data['url'] = $this->input->post('url');

            $this->manufacturer->insert($data);

            redirect('/admin/manufacturers', 'refresh');
        }

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "manufacturers_create";
        $this->load->view($this->_container, $data);
    }

    public function edit($id) {
        if ($this->input->post('name')) {
            $data['name'] = $this->input->post('name');
            $data['country'] = $this->input->post('country');
            $data['ce_mark'] = $this->input->post('ce_mark');
            $data['url'] = $this->input->post('url');

            $this->manufacturer->update($data, $id);

            redirect('/admin/manufacturers', 'refresh');
        }

        $manufacturer = $this->manufacturer->get($id);

        $data['manufacturer'] = $manufacturer;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "manufacturers_edit";
        $this->load->view($this->_container, $data);
    }

    public function delete($id) {
        $this->manufacturer->delete($id);

        redirect('/admin/manufacturers', 'refresh');
    }

    public function service_stats() {
        
         $query = $this->db->query('SELECT stocks.manufacturer AS name, '
            . 'SUM((SELECT COUNT(services.id) FROM services where services.ha_service = stocks.id)) as data '
            . 'FROM stocks '
            . 'group by manufacturer ');
    return $query->result();
    }
}
