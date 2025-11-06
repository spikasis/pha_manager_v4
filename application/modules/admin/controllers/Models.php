<?php

class Models extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/manufacturer'));
        $this->load->model(array('admin/ha_type'));
        $this->load->model(array('admin/battery_type'));
        $this->load->model(array('admin/model'));
        $this->load->model(array('admin/serie'));
    }

    public function index() {
        
        $model = $this->model->get_all();        
        
        $data['title'] = 'Μοντέλα Ακουστικών';
        

        $data['models'] = $model;       
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "model_list";
        $this->load->view($this->_container, $data);
    }

    public function create() {
        if ($this->input->post('model')) {                        
            $data['series']      =   $this->input->post('series');
            $data['model']      =   $this->input->post('model');            
            $data['ha_type']       =   $this->input->post('ha_type');
            $data['battery']    =   $this->input->post('battery');

            $this->model->insert($data);

            redirect('/admin/models', 'refresh');
        }
        //$stock = $this->stock->get($id);
        
        $series = $this->serie->get_all();
        $manufacturers = $this->manufacturer->get_all();        
        $ha_type = $this->ha_type->get_all();
        $battery = $this->battery_type->get_all();

        $data['series'] = $series;
        $data['brand'] = $manufacturers;        
        $data['ha_type'] = $ha_type;
        $data['battery'] = $battery;

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "model_create";
        $this->load->view($this->_container, $data);
    }

    public function edit($id) {        
        if ($this->input->post('model')) {
            $data['series']      =   $this->input->post('series');
            $data['model']      =   $this->input->post('model');            
            $data['ha_type']    =   $this->input->post('ha_type');
            $data['battery']    =   $this->input->post('battery');
            
            $this->model->update($data, $id);

            redirect('/admin/models' , 'refresh');
        }

        $model = $this->model->get($id);
        
        
        $manufacturers = $this->manufacturer->get_all();        
        $ha_type = $this->ha_type->get_all();
        $battery = $this->battery_type->get_all();
        $series = $this->serie->get_all();

        $data['series']     = $series;
        $data['model']      = $model;
        $data['brand']      = $manufacturers;        
        $data['ha_type']    = $ha_type;
        $data['battery']    = $battery;
               

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "model_edit";
        $this->load->view($this->_container, $data);
    }

    public function delete($id) {
        $this->model->delete($id);

        redirect('/admin/models', 'refresh');
    }
    
    public function get_all_models_with_details() {
        $this->db->select('models.id AS model_id, models.model AS model_name, manufacturers.name AS manufacturer_name, series.series AS series_name, ha_types.type AS ha_type_name, battery_types.type AS battery_type_name');
        $this->db->from('models');
        $this->db->join('series', 'models.series = series.id', 'left');
        $this->db->join('manufacturers', 'series.brand = manufacturers.id', 'left');
        $this->db->join('ha_types', 'models.ha_type = ha_types.id', 'left');
        $this->db->join('battery_types', 'models.battery = battery_types.id', 'left');

        $query = $this->db->get();
        // Debugging: Έλεγχος αποτελεσμάτων
    log_message('debug', 'Models: ' . print_r($query->result_array(), true));
    
        echo json_encode($query->result_array()); // Επιστρέφει τα μοντέλα ως JSON
    }
}


    
    
