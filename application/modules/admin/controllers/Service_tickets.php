<?php

class Service_tickets extends Admin_Controller {

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
    }

    public function index() {
        $service = $this->service->get_all();

        $data['service'] = $service;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "service_list";
        $this->load->view($this->_container, $data);
    }

        public function create($ser_id) {
        if ($this->input->post('ticket')) {
            $data['ticket'] = $this->input->post('ticket');
            $data['service_sub'] = $this->input->post('service_sub');
            $data['brand_name']     = $this->input->post('brand_name');
            
            $this->service_ticket->insert($data);                      

            redirect('/admin/services/edit/' . $data['ticket'] , 'refresh');        
            }       
        
        //$data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "service_create";
        //$this->load->view($this->_container, $data);
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

            redirect('/admin/services', 'refresh');
        }

        $service = $this->service->get($id);
        $customers = $this->customer->get_all();
        $stock = $this->stock->get_all();
        $serstats = $this->service_status->get_all();
        $vendor = $this->vendor->get_all();
        $categories = $this->service_category->get_all();
        $subcategories = $this->service_subcategory->get_all();
        
        $data['subcategories'] = $subcategories;
        $data['categories'] = $categories;
        $data['customers'] = $customers;
        $data['stock'] = $stock;
        $data['status'] = $serstats;
        $data['vendor'] = $vendor;
        $data['service'] = $service; 
        $data['ser_condition'] = $this->service_condition->get_all();

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "service_edit";
        $this->load->view($this->_container, $data);
    }
        
    public function delete($id) {
        
        $ticket = $this->service_ticket->get($id);
                
        $this->service_ticket->delete($id);

        redirect('/admin/services/edit/' . $ticket->ticket , 'refresh');
    }
    
    public function service_stats($id = null) {
    // Load manufacturers from the database
    $data['manufacturers'] = $this->manufacturer->get_all(); // Ensure this model method returns all manufacturers

    // If $id is passed, fetch the brand-specific data
    if ($id !== null) {
        $data['brand'] = $this->manufacturer->get($id);
        $data['fittings'] = $this->stock->get_all('id', 'manufacturer=' . $id);
        $data['receivers'] = $this->service_ticket->get_all('ticket, service_sub', 'brand_name=' . $id . ' AND service_sub=' . 5);
        $data['microphones'] = $this->service_ticket->get_all('ticket, service_sub', 'brand_name=' . $id . ' AND service_sub=' . 6);
        $data['amplifiers'] = $this->service_ticket->get_all('ticket, service_sub', 'brand_name=' . $id . ' AND service_sub=' . 9);
        $data['earmolds_redesign'] = $this->service_ticket->get_all('ticket, service_sub', 'brand_name=' . $id . ' AND service_sub=' . 11);
        $data['cleaning'] = $this->service_ticket->get_all('ticket, service_sub', 'brand_name=' . $id . ' AND service_sub=' . 4);
    }

    // Load the view and pass the data
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "service_stats_view";
    $this->load->view($this->_container, $data);
}

    public function service_stats_all() {
        
        $data['brands'] = $this->manufacturer->get_all();
        //$data['brands'] = array(3,6,10);
        
        foreach($data['brands'] as $key=>$list ){
        
        $data['brand'] = $this->manufacturer->get($list['id']);
               
        $data['fittings'] = $this->stock->get_all('id', 'manufacturer=' . $list['id'][0]);
                
        $data['receivers'] = $this->service_ticket->get_all('ticket, service_sub', 'brand_name=' . $list['id'][0] . ' AND service_sub=' . 5);
        $data['microphones'] = $this->service_ticket->get_all('ticket, service_sub', 'brand_name=' . $list['id'] . ' AND service_sub=' . 6);
        $data['amplifiers'] = $this->service_ticket->get_all('ticket, service_sub', 'brand_name=' . $list['id'] . ' AND service_sub=' . 9);
        $data['earmolds_redesign'] = $this->service_ticket->get_all('ticket, service_sub', 'brand_name=' . $list['id'] . ' AND service_sub=' . 11);
        $data['cleaning'] = $this->service_ticket->get_all('ticket, service_sub', 'brand_name=' . $list['id'] . ' AND service_sub=' . 4);
        }
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "service_stats_view_all";
        $this->load->view($this->_container, $data);
    }
    
   public function get_repair_data() {
    $category = $this->input->post('category');
    $category_map = [
        'receivers' => 5,
        'microphones' => 6,
        'amplifiers' => 9,
        'earmolds_redesign' => 11,
        'cleaning' => 4,
    ];

    if (isset($category_map[$category])) {
        $service_sub = $category_map[$category];
        
        // Query to get the repair data per manufacturer and their total fittings
        $this->db->select('manufacturers.name, COUNT(service_tickets.id) AS repair_count, 
                           (SELECT COUNT(stocks.id) FROM stocks WHERE stocks.manufacturer = manufacturers.id) AS total_fittings');
        $this->db->from('service_tickets');
        $this->db->join('manufacturers', 'service_tickets.brand_name = manufacturers.id');
        $this->db->where('service_tickets.service_sub', $service_sub);
        $this->db->group_by('manufacturers.name');
        $query = $this->db->get();

        echo json_encode($query->result());
    } else {
        echo json_encode([]);  // Return empty array if no category matched
    }
}

public function get_series_repair_data() {
    $category = $this->input->post('category');
    $category_map = [
        'receivers' => 5,
        'microphones' => 6,
        'amplifiers' => 9,
        'earmolds_redesign' => 11,
        'cleaning' => 4,
    ];

    if (isset($category_map[$category])) {
        $service_sub = $category_map[$category];

        // Query to get the repair data per series
        $this->db->select('series.series AS series_name, COUNT(service_tickets.id) AS repair_count');
        $this->db->from('service_tickets');
        $this->db->join('services', 'services.id = service_tickets.ticket');
        $this->db->join('stocks', 'stocks.id = services.ha_service');
        $this->db->join('models', 'models.id = stocks.ha_model');
        $this->db->join('series', 'series.id = models.series');
        $this->db->where('service_tickets.service_sub', $service_sub);
        $this->db->group_by('series.series');
        $query = $this->db->get();

        echo json_encode($query->result());
    } else {
        echo json_encode([]);  // Return empty array if no category matched
    }
}





}
