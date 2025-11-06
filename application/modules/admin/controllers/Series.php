<?php

class Series extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/manufacturer'));        
        $this->load->model(array('admin/serie'));
    }

    public function index() {
        
        $series = $this->serie->get_all();        
        
        $data['title'] = 'Σειρές Ακουστικών';       

        $data['series'] = $series;       
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "series_list";
        $this->load->view($this->_container, $data);
    }

    public function create() {
        if ($this->input->post('series')) {                        
            $data['series']      =   $this->input->post('series');
            $data['brand']      =   $this->input->post('brand');            
           

            $this->serie->insert($data);

            //redirect('/admin/models', 'refresh');
        }
        //$stock = $this->stock->get($id);

        $manufacturers = $this->manufacturer->get_all();       
        

        $data['brand'] = $manufacturers;        
      

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "series_create";
        $this->load->view($this->_container, $data);
    }

    public function edit($id) {        
        if ($this->input->post('series')) {
            $data['series']      =   $this->input->post('series');
            $data['brand']      =   $this->input->post('brand');            
            
            $this->serie->update($data, $id);

            redirect('/admin/series' , 'refresh');
        }

        $series = $this->serie->get($id);
        
        $manufacturers = $this->manufacturer->get_all();        
        

        $data['series'] = $series;
        $data['brand'] = $manufacturers;        
        
               

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "series_edit";
        $this->load->view($this->_container, $data);
    }

    public function delete($id) {
        $this->serie->delete($id);

        redirect('/admin/series', 'refresh');
    }
}


    
    
