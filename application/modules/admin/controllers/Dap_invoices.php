<?php

class Dap_invoices extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/customer'));
        $this->load->model(array('admin/stock'));
        $this->load->model(array('admin/vendor'));
        $this->load->model(array('admin/manufacturer'));
        $this->load->model(array('admin/ha_type'));
        $this->load->model(array('admin/dap_item'));
        $this->load->model(array('admin/dap_invoice'));
        $this->load->model(array('admin/company'));
        
    }

    public function index() {
        $invoice = $this->dap_invoice->get_all();

        $data['invoice'] = $invoice;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dap_list";
        $this->load->view($this->_container, $data);
    }

    public function create() {
        if ($this->input->post('id')) {
            $data['id']          =   $this->input->post('id');
            $data['from']        =   $this->input->post('from');
            $data['to_customer'] =   $this->input->post('to_customer');
            $data['date']        =   $this->input->post('date');            

            $this->dap_invoice->insert($data);                      

            redirect('/admin/dap_invoices' , 'refresh');
        }

        $companies = $this->company->get_all();
        $vendors = $this->vendor->get_all(); 
        $customers_ch = $this->ch_customer->get_all();
        $stock = $this->stock->get_all();
        
        $data['companies'] = $companies;
        $data['vendors'] = $vendors;
        $data['stock'] = $stock;
        $data['ch_customer'] = $customers_ch;
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "dap_create";
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
        $stock = $this->stock->get_all();
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
        if ($this->input->post('id')) {
            $data['id']          =   $this->input->post('id');
            $data['from']        =   $this->input->post('from');
            $data['to_customer'] =   $this->input->post('to_customer');
            $data['date']        =   $this->input->post('date');         

            $this->invoice_dap->update($data, $id);
            
            redirect('/admin/invoices_dap', 'refresh');
        }
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "service_edit";
        $this->load->view($this->_container, $data);
    }

    public function service_doc($id) {       
    
        $service = $this->service->get($id);
        $stock = $this->stock->get($service->ha_service);
        $customers = $this->customer->get($stock->customer_id);
        $ha_temp = $this->stock->get($service->ha_temp);

        $data['stock'] = $stock;
        $data['stock_brand'] = $this->manufacturer->get($stock->manufacturer);
        $data['stock_type'] = $type = $this->ha_type->get($stock->type); 
        
        $data['customer'] = $customers;
        $data['service'] = $service;
        
        $data['ha_temp'] = $ha_temp;
        $data['ha_temp_brand'] = $this->manufacturer->get($ha_temp->manufacturer);
        $data['ha_temp_type'] = $this->ha_type->get($ha_temp->type);
        
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
    
    
    public function delete($id) {
        $this->service->delete($id);

        redirect('/admin/services', 'refresh');
    }

}
