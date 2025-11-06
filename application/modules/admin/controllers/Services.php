<?php

class Services extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/service'));
        $this->load->model(array('admin/customer'));
        $this->load->model(array('admin/lab_status'));
        $this->load->model(array('admin/stock'));
        $this->load->model(array('admin/service_status'));
        $this->load->model(array('admin/service_condition'));
        $this->load->model(array('admin/vendor'));
        $this->load->model(array('admin/manufacturer'));
        $this->load->model(array('admin/ha_type'));
        $this->load->model(array('admin/chart'));
        $this->load->model(array('admin/service_subcategory'));
        $this->load->model(array('admin/service_category'));
        $this->load->model(array('admin/service_ticket'));
        $this->load->model(array('admin/model'));
        $this->load->model(array('admin/serie'));
    }

    public function index() {
        $service = $this->service->get_all();

        $data['service'] = $service;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "service_list";
        $this->load->view($this->_container, $data);
    }
    
    public function list_sp($selling_point = NULL) {
        
        /*
        $ha_service = $this->stock->get_all('id, serial, day_in, day_out, first_fit, selling_point, customer_id', 'selling_point=' . $selling_point);
        foreach ($ha_service as $key => $list):
            
            $service = $this->service->get_all('id, ha_service, day_in, ha_temp, action_service, malfunction, lab_report, lab_sent, price, status, lab_service', 'ha_service=' . $list['id']);           
            
        endforeach;
        //$service = $this->service->get_all('id, ha_service,day_in, ha_temp, ');
        
        */
        $service = $this->service->get_services($selling_point);

        $data['service'] = $service;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "service_list";
        $this->load->view($this->_container, $data);
    }
    
    public function list_open() {
        
        $service = $this->service->get_all('id, ha_service, day_in, ha_temp, action_service, malfunction, lab_report, lab_sent, price, status, lab_service', ' status = 2');   

        $data['service'] = $service;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "service_list";
        $this->load->view($this->_container, $data);
    }

    public function create() {
        if ($this->input->post('ha_service')) {
            $data['ha_service'] = $this->input->post('ha_service');
            $data['day_in'] = $this->input->post('day_in');
            $data['ha_temp'] = $this->input->post('ha_temp');
            $data['action_service'] = $this->input->post('action_service');
            $data['malfunction'] = $this->input->post('malfunction');
            $data['lab_report'] = $this->input->post('lab_report');
            $data['lab_sent'] = $this->input->post('lab_sent');
            $data['price'] = $this->input->post('price');
            $data['status'] = $this->input->post('status');
            $data['lab_service'] = $this->input->post('lab_service');

            $this->service->insert($data);                      

            redirect('/admin/services' , 'refresh');
        }

        $customers = $this->customer->get_all();
        $stock = $this->stock->get_hearing_aids_with_details(); // Κλήση της μεθόδου από το μοντέλο
        $serstats = $this->service_status->get_all();
        $vendor = $this->vendor->get_all();
        $subcategories = $this->service_subcategory->get_all();
        
        $data['customers'] = $customers;
        $data['subcategories'] = $subcategories;
        $data['stock'] = $stock;
        $data['status'] = $serstats;
        $data['vendor'] = $vendor;
        $data['ser_condition'] = $this->service_condition->get_all();

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "service_create";
        $this->load->view($this->_container, $data);
    }

    public function create_this($id) {
        if ($this->input->post('ha_service')) {
            $data['ha_service']     = $this->input->post('ha_service');
            $data['day_in']         = $this->input->post('day_in');
            $data['ha_temp']        = $this->input->post('ha_temp');
            $data['action_service'] = $this->input->post('action_service');
            $data['malfunction']    = $this->input->post('malfunction');
            $data['lab_report']     = $this->input->post('lab_report');
            $data['lab_sent']       = $this->input->post('lab_sent');
            $data['price']          = $this->input->post('price'); 
            $data['status']         = $this->input->post('status');
             $data['lab_service']   = $this->input->post('lab_service');

            $this->service->insert($data);

            redirect('/admin/stocks/view/' . $id , 'refresh');
        }

        $customers = $this->customer->get_all();
        $stock = $this->stock->get_hearing_aids_with_details(); // Κλήση της μεθόδου από το μοντέλο
        $ha_ser = $this->stock->get($id);
        
        $serstats = $this->service_status->get_all();
        $vendor = $this->vendor->get_all();       
        $subcategories = $this->service_subcategory->get_all();
        
        $data['customers'] = $customers;
        $data['subcategories'] = $subcategories;
        $data['stock'] = $stock;
        $data['status'] = $serstats;
        $data['vendor'] = $vendor;
        $data['ha_ser'] = $ha_ser;
        $data['ser_condition'] = $this->service_condition->get_all();

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "service_create_this";
        $this->load->view($this->_container, $data);
    }

    public function edit($id) {
        if ($this->input->post('ha_service')) {
            $data['ha_service']     = $this->input->post('ha_service');
            $data['day_in']         = $this->input->post('day_in');
            $data['ha_temp']        = $this->input->post('ha_temp');
            $data['action_service'] = $this->input->post('action_service');
            $data['malfunction']    = $this->input->post('malfunction');
            $data['lab_report']     = $this->input->post('lab_report');
            $data['lab_sent']       = $this->input->post('lab_sent');
            $data['price']          = $this->input->post('price');
            $data['status']         = $this->input->post('status');
            $data['lab_service']    = $this->input->post('lab_service');

            $this->service->update($data, $id);

            //redirect('/admin/services/edit/' . ($id+1), 'refresh');
            redirect('/admin/services', 'refresh');
        }

        $service = $this->service->get($id);
        $customers = $this->customer->get_all();
        $stock = $this->stock->get_hearing_aids_with_details(); // Κλήση της μεθόδου από το μοντέλο
    
        $serstats = $this->service_status->get_all();
        $vendor = $this->vendor->get_all();
        $categories = $this->service_category->get_all();        
        $tickets = $this->service_ticket->get_all('service_sub, id', 'ticket=' . $id); 
        
        
        $subcategories = $this->service_subcategory->get($tickets->service_sub);
        
        $data['customers'] = $customers;
        $data['stock'] = $stock;
        $data['status'] = $serstats;
        $data['vendor'] = $vendor;
        $data['service'] = $service; 
        $data['categories'] = $categories;
        $data['ser_condition'] = $this->service_condition->get_all();
        $data['subcategories'] = $subcategories;
        $data['tickets'] = $tickets;

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "service_edit";
        $this->load->view($this->_container, $data);
    }

    public function service_doc($id) {       
    
        $service = $this->service->get($id);
        $vendor = $this->vendor->get($service->lab_sent);
        
        //stock_data
        $stock = $this->stock->get($service->ha_service);
        $stock_model = $this->model->get($stock->ha_model);        
        $series_model = $this->serie->get($stock_model->series);
        $stock_brand = $this->manufacturer->get($series_model->brand);
        $stock_type = $type = $this->ha_type->get($stock_model->ha_type); 
        
        $data['stock'] = $stock;
        $data['stock_model'] = $stock_model;
        $data['series'] = $series_model;
        $data['stock_brand'] = $stock_brand;
        $data['stock_type'] = $stock_type;
        $data['vendor'] = $vendor;
        
        //ha_temp data
        $ha_temp = $this->stock->get($service->ha_temp);
        $ha_temp_model = $this->model->get($ha_temp->ha_model);
        $ha_temp_series = $this->serie->get($ha_temp_model->series);
        $ha_temp_brand = $this->manufacturer->get($ha_temp_series->brand);
        $ha_temp_type = $this->ha_type->get($ha_temp_model->ha_type);
        
        $data['ha_temp'] = $ha_temp;
        $data['ha_temp_model'] = $ha_temp_model;
        $data['ha_temp_series'] = $ha_temp_series;
        $data['ha_temp_brand'] = $ha_temp_brand;
        $data['ha_temp_type'] = $ha_temp_type;
        
        $customers = $this->customer->get($stock->customer_id);
        
        $data['customer'] = $customers;
        $data['service'] = $service;
        $data['lab_sent'] = $this->vendor->get($service->lab_sent);        
               
        $title = 'Δελτίο Επισκευής Ακουστικού';
        
        $html = $this->load->view('deltio_episkeuis', $data, true);
        $this->chart->print_doc($html, $title);
        
    }   
    
    public function service_tickets($id) {
        
      if ($this->input->post('ticket')) {
            $data['ticket']         = $this->input->post('ticket');
            $data['service_sub']    = $this->input->post('service_sub');
            $data['brand_name']     = $this->input->post('brand_name');
            
            $this->service_tickets->insert($data);

            redirect('/admin/services/service_tickets_create_this' . $id, 'refresh');  
      }  
      
      $service = $this->service->get($id);
      $ha_ser = $this->stock->get($service->ha_service);
      $brands = $this->manufacturer->get($ha_ser->manufacturer);
      $customer = $this->customer->get($ha_ser->customer_id);
      $subcategories = $this->service_subcategory->get_all();
      
      $data['service'] = $service;          
      $data['service_id'] = $id;
      $data['ha_ser'] = $ha_ser;
      $data['brands'] = $brands;
      $data['subcategories'] = $subcategories;
      $data['customer'] = $customer;
      
      $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "service_tickets_create_this";
      $this->load->view($this->_container, $data);
    }
    
    public function create_ticket() {
        if ($this->input->post('ticket')) {
            $data['ticket'] = $this->input->post('ticket');
            $data['service_sub'] = $this->input->post('service_sub');
            
            $this->service_tickets->insert($data);                      

            redirect('/admin/services' , 'refresh');
        }       
    }
    
    public function service_stats() {
        // Load necessary models
        $this->load->model('service');

        // Fetch data from the database
        $data['services'] = $this->service->get_services_data();

        // Load the view
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "service_stats_list";
        $this->load->view($this->_container, $data);
    }
    
    public function delete($id) {
        $this->service->delete($id);

        redirect('/admin/services', 'refresh');
    }

}
