<?php

class Offers extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/offer')); 
        $this->load->model(array('admin/customer'));
        $this->load->model(array('admin/selling_point'));
        $this->load->model(array('admin/chart'));
    }

    public function index() {
        $offers= $this->offer->get_all();  
        $data['customers'] = $this->customer->get_all();
        

        $data['offers'] = $offers;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "offers_list";
        $this->load->view($this->_container, $data);
    }

    public function create() {
        if ($this->input->post('offer_date')) {
            $data['offer_date'] = $this->input->post('offer_date');
            $data['customer_id'] = $this->input->post('customer_id');
            $data['hearing_aid'] = $this->input->post('hearing_aid');
            $data['price'] = $this->input->post('price');
            $data['quantity'] = $this->input->post('quantity');
            $data['eopyy'] = $this->input->post('eopyy');
            $data['final_price'] = $this->input->post('final_price');

            $this->offer->insert($data);

            redirect('/admin/offers', 'refresh');
        }
        
        $data['customers'] = $this->customer->get_all();
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "offers_create";
        $this->load->view($this->_container, $data);
    }

    public function edit($id) {
        if ($this->input->post('offer_date')) {
            $data['offer_date'] = $this->input->post('offer_date');
            $data['customer_id'] = $this->input->post('customer_id');
            $data['hearing_aid'] = $this->input->post('hearing_aid');
            $data['price'] = $this->input->post('price');
            $data['quantity'] = $this->input->post('quantity');
            $data['eopyy'] = $this->input->post('eopyy');
            $data['final_price'] = $this->input->post('final_price');

            $this->offer->update($data, $id);

            redirect('/admin/offers', 'refresh');
        }

        $offer = $this->offer->get($id); 
        $data['customers'] = $this->customer->get_all();
        
        $data['offers'] = $offer;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "offers_edit";
        $this->load->view($this->_container, $data);
    }

    public function view($id) {

        $offer = $this->offer->get($id); 
        $customer = $this->customer->get($offer->customer_id);
        $selling_point = $this->selling_point->get($customer->selling_point);
        
        //$data['company'] = $company;
        $data['offer'] = $offer;
        $data['customer'] = $customer;
        $data['selling_point'] = $selling_point;
        
        $title = 'Προσφορά Αποκατάστασης Ακοής';
        $html = $this->load->view('offer_doc', $data, true);
        $this->chart->print_doc($html, $title);
        
        /*
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "offer_doc";
        $this->load->view($this->_container, $data, true); 
        

        $mpdf = new Mpdf();
        
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("Hearing Restoration Offer. - Offer");
        $mpdf->SetAuthor("Acme Trading Co.");
        $mpdf->SetWatermarkText("Pikasis Hearing");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');
        
        $mpdf->WriteHTML($html, 2);
        
        $mpdf->Output();
         
         */

    }
    public function delete($id) {
        $this->offer->delete($id);

        redirect('/admin/offers', 'refresh');
    }

}
