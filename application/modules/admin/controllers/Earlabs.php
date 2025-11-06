<?php

class Earlabs extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/earlab'));
        $this->load->model(array('admin/customer'));
        $this->load->model(array('admin/vendor'));
        $this->load->model(array('admin/lab_status'));
        $this->load->model(array('admin/lab_type'));
        $this->load->model(array('admin/stock'));
    }

    public function index() {
        //$earlab = $this->earlab->get_all();
        $earlab = $this->earlab->get_earlabs_by_selling_point();
        $customers = $this->customer->get_all();
        

        $data['earlabs'] = $earlab;
        $data['customers'] =  $customers;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "earlab_list";
        $this->load->view($this->_container, $data);
    }  
    
    public function list_open($selling_point = NULL) {
        //$earlab = $this->earlab->get_all('*', 'date_delivery=0');
        
        //$earlab = $this->earlab->get_earlabs_date_sp($selling_point, 0);

        $earlab = $this->earlab->get_earlabs_by_sp_and_delivery($selling_point);
        
        $data['earlabs'] = $earlab;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "earlab_list_open";
        $this->load->view($this->_container, $data);
    }

    public function create() {
        if ($this->input->post('customer_id')) {
            $data['customer_id'] = $this->input->post('customer_id');
            $data['vendor_id'] = $this->input->post('vendor_id');            
            $data['type'] = $this->input->post('type'); 
            $data['vent'] = $this->input->post('vent');
            $data['date_order'] = $this->input->post('date_order');
            $data['date_delivery'] = $this->input->post('date_delivery');
            $data['comments'] = $this->input->post('comments');
            $data['status'] = $this->input->post('status');            
            $data['cost'] = $this->input->post('cost');
            $data['side'] = $this->input->post('side');
            $data['material'] = $this->input->post('material');
            $data['receiver'] = $this->input->post('receiver');
            $data['hearing_aid'] = $this->input->post('hearing_aid');
            $data['filter'] = $this->input->post('filter');
            $data['date_fit'] = $this->input->post('date_fit');
            $data['remake'] = $this->input->post('remake');

            $this->earlab->insert($data);

            redirect('/admin/earlabs', 'refresh');
        }
        
        $stock = $this->stock->get_all();
        $customers = $this->customer->get_all();
        $vendor = $this->vendor->get_all();        
        $lab_statuses = $this->lab_status->get_all();
        $lab_types = $this->lab_type->get_all();

        $data['lab_statuses'] = $lab_statuses;
        $data['lab_types'] = $lab_types;

        $data['customers'] = $customers;
        $data['vendors'] = $vendor;
        $data['stock'] = $stock;
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "earlab_create";
        $this->load->view($this->_container, $data);
    }

    public function edit($id) {
        if ($this->input->post('customer_id')) {
            $data['customer_id'] = $this->input->post('customer_id');
            $data['vendor_id'] = $this->input->post('vendor_id');            
            $data['type'] = $this->input->post('type'); 
            $data['vent'] = $this->input->post('vent');
            $data['date_order'] = $this->input->post('date_order');
            $data['date_delivery'] = $this->input->post('date_delivery');
            $data['comments'] = $this->input->post('comments');
            $data['status'] = $this->input->post('status');            
            $data['cost'] = $this->input->post('cost');
            $data['side'] = $this->input->post('side');
            $data['material'] = $this->input->post('material');
            $data['receiver'] = $this->input->post('receiver');
            $data['hearing_aid'] = $this->input->post('hearing_aid');
            $data['filter'] = $this->input->post('filter');
            $data['date_fit'] = $this->input->post('date_fit');
            $data['remake'] = $this->input->post('remake');
            
            $this->earlab->update($data, $id);

            redirect('/admin/earlabs', 'refresh');
        }

        $earlab = $this->earlab->get($id);
        $customers = $this->customer->get_all();
        $stock = $this->stock->get_all();
        $lab_statuses = $this->lab_status->get_all();
        $lab_types = $this->lab_type->get_all();
        $vendor = $this->vendor->get_all();

        $data['lab_statuses'] = $lab_statuses;
        $data['lab_types'] = $lab_types; 
        $data['customers'] = $customers;
        $data['stock'] = $stock;
        $data['vendors'] = $vendor;        
        $data['earlab'] = $earlab;
        

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "earlab_edit";
        $this->load->view($this->_container, $data);
    }

    public function earlab_doc($id) {
    
        $earlab = $this->earlab->get($id);
        $lab_type = $this->lab_type->get($earlab->type);        
        $hearing_aid = $this->stock ->get($earlab->hearing_aid);
        $customers = $this->customer->get($hearing_aid['customer_id']);

        $data['lab_types'] = $lab_type;
        $data['customer'] = $customers;
        $data['earlab'] = $earlab;
        $data['hearing_aid'] = $hearing_aid;
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "earlab_doc";
        $this->load->view($this->_container, $data);
        
        /*
        $html = $this->load->view('themes/default/earlab_doc', $data);        

        $pdfFilePath = "lab_construction.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);         
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
        
        */
    }
    public function list_sp($selling_point = NULL){
        
        
        $earlab = $this->earlab->get_earlabs_by_selling_point($selling_point);
        $customers = $this->customer->get_all();

        $data['earlabs'] = $earlab;
        $data['customers'] =  $customers;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "earlab_list";
        $this->load->view($this->_container, $data);
    }

    public function delete($id) {
        $this->earlab->delete($id);

        redirect('/admin/earlabs', 'refresh');
    }

}
