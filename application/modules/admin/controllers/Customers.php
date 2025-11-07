<?php

class Customers extends Admin_Controller {

    // Model properties to avoid PHP 8.2+ deprecation warnings
    public $ion_auth_model;
    public $customer;
    public $stock;
    public $doctor;
    public $selling_point;
    public $customer_status;
    public $insurance;
    public $chart;
    public $pay;
    public $earlab;
    public $model;
    public $serie;
    public $manufacturer;
    public $ha_type;
    public $vendor;
    public $lab_type;
   
    function __construct() {
        parent::__construct();

        $this->load->model(array('admin/customer'));
        $this->load->model(array('admin/stock'));        
        $this->load->model(array('admin/doctor'));
        $this->load->model(array('admin/selling_point'));
        $this->load->model(array('admin/customer_status'));
        $this->load->model(array('admin/insurance'));
        $this->load->model(array('admin/chart'));
        $this->load->model(array('admin/pay'));
        $this->load->model(array('admin/earlab'));
        $this->load->model(array('admin/model'));
        $this->load->model(array('admin/serie'));
        $this->load->model(array('admin/manufacturer'));
        $this->load->model(array('admin/ha_type'));
        $this->load->model(array('admin/vendor'));
        $this->load->model(array('admin/lab_type'));
    }

    
    public function index() {
        $customers = $this->customer->get_all();

        $data['title'] = 'Πελατολόγιο Πλήρες' ;
        $data['customers'] = $customers;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "customers_list";
        $this->load->view($this->_container, $data);
    }

    public function create() {
        if ($this->input->post('name')) {
            $data['name'] = $this->input->post('name');
            $data['birthday'] = $this->input->post('birthday');
            $data['phone_home'] = $this->input->post('phone_home');
            $data['phone_mobile'] = $this->input->post('phone_mobile');
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            //$data['vat_id'] = $this->input->post('vat_id');
            $data['insurance'] = $this->input->post('insurance');
            $data['old_user'] = $this->input->post('old_user');
            $data['selling_point'] = $this->input->post('selling_point');
            $data['status'] = $this->input->post('status');
            $data['doctor'] = $this->input->post('doctor');
            $data['first_visit'] = $this->input->post('first_visit');
            //$data['first_fit'] = $this->input->post('first_fit');
            //$data['guarantee_end'] = $this->input->post('guarantee_end');
            //$data['ha_price'] = $this->input->post('ha_price');
            $data['customer_id'] = $this->input->post('customer_id');
            $data['profession'] = $this->input->post('profession');
            $data['comments'] = $this->input->post('comments');
            $data['amka'] = $this->input->post('amka');
            $data['pending'] = $this->input->post('pending');
            $this->customer->insert($data);

            redirect('/admin/customers', 'refresh');
        }

        $doctors = $this->doctor->get_all();
        $selling_points = $this->selling_point->get_all();
        $customer_status = $this->customer_status->get_all();
        $insurance = $this->insurance->get_all();

        $data['doctors'] = $doctors;
        $data['selling_points'] = $selling_points;
        $data['customer_status'] = $customer_status;
        $data['insurances'] = $insurance;

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "customers_create";
        $this->load->view($this->_container, $data);
    }

    public function edit($id) {
        if ($this->input->post('name')) {
            $data['name'] = $this->input->post('name');
            $data['birthday'] = $this->input->post('birthday');
            $data['amka'] = $this->input->post('amka');
            $data['phone_home'] = $this->input->post('phone_home');
            $data['phone_mobile'] = $this->input->post('phone_mobile');
            $data['address'] = $this->input->post('address');
            $data['city'] = $this->input->post('city');
            $data['insurance'] = $this->input->post('insurance');
            $data['old_user'] = $this->input->post('old_user');
            $data['selling_point'] = $this->input->post('selling_point');
            $data['status'] = $this->input->post('status');
            $data['doctor'] = $this->input->post('doctor');
            $data['first_visit'] = $this->input->post('first_visit');
            $data['customer_id'] = $this->input->post('customer_id');
            $data['profession'] = $this->input->post('profession');
            $data['comments'] = $this->input->post('comments');
            $data['pending'] = $this->input->post('pending');
            
            $this->customer->update($data, $id);

            redirect('/admin/customers/view/' . $id, 'refresh');
        }

        $customer = $this->customer->get($id);
        $doctors = $this->doctor->get_all();
        $selling_points = $this->selling_point->get_all();
        $customer_status = $this->customer_status->get_all();
        $insurances = $this->insurance->get_all();

        $data['doctors'] = $doctors;
        $data['selling_points'] = $selling_points;
        $data['customer_status'] = $customer_status;
        $data['insurances'] = $insurances;
        $data['customer'] = $customer;
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "customers_edit";
        $this->load->view($this->_container, $data);
    }
    
    public function view($id) {
        
        $customer = $this->customer->get($id);        
        //$pays = $this->pay->get_all('id, customer, date, pay','customer = ' . $id);
        
        
        $data['doctor'] = $this->doctor->get($customer->doctor);
        $data['selling_points'] = $this->selling_point->get($customer->selling_point);
        $data['customer_status'] = $this->customer_status->get($customer->status);
        $data['insurance'] = $this->insurance->get($customer->insurance);
        $data['stocks'] = $this->stock->get_all('id, serial, manufacturer, model, type, day_out, guarantee_end, comments, ha_model', 'customer_id=' . $id);
        
        //$data['pay'] = $pays;        
        $data['customer'] = $customer; 
        //$data['sum'] = 0;
        // Get earlabs and preprocess the data
        $earlabs = $this->earlab->get_all('id, customer_id, vendor_id, date_order, date_delivery, side, cost, type, vent', 'customer_id=' . $id);
        
        // Preprocess earlab data with vendor and lab type info
        $processed_earlabs = [];
        foreach ($earlabs as $earlab) {
            $lab = $this->vendor->get($earlab['vendor_id']);
            $type = $this->lab_type->get($earlab['type']);
            
            $earlab['vendor_name'] = $lab ? $lab->name : '-';
            $earlab['type_name'] = $type ? $type->type : '-';
            $earlab['vent'] = isset($earlab['vent']) ? $earlab['vent'] : '-';
            
            $processed_earlabs[] = $earlab;
        }
        
        $data['earlabs'] = $processed_earlabs;
        
        //$title = 'Καρτέλα Πελάτη';
        //$html = $this->load->view('customers_view_old', $data, true);
        //$this->chart->print_doc($html, $title);
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "customers_view_old";
        $this->load->view($this->_container, $data);
    }
    
    public function export_customer($stock_id) {
        // Φόρτωμα των στοιχείων του ακουστικού και του πελάτη
        $stock_details = $this->stock->get($stock_id);
        
        if (!$stock_details) {
            show_404(); // Αν δεν βρεθεί το στοιχείο
        }
        
       // Συλλογή πρόσθετων δεδομένων
    $customer = $this->customer->get($stock_details->customer_id);
    $stock_model = $this->model->get($stock_details->ha_model);
    $series_model = $this->serie->get($stock_model->series);
    $manufacturer = $this->manufacturer->get($series_model->brand);
    $ha_type = $this->ha_type->get($stock_model->ha_type);

    // Δημιουργία πίνακα δεδομένων για το PDF
    $data['stock'] = $stock_details;
    $data['customer'] = $customer;
    $data['stock_model'] = $stock_model;
    $data['series'] = $series_model;
    $data['type'] = $ha_type;
    $data['manufacturer'] = $manufacturer;
    $data['doctor'] = $this->doctor->get($stock_details->doctor_id);
    $data['selling_points'] = $this->selling_point->get($stock_details->selling_point);

    // Τίτλος για το PDF
    $title = 'Καρτέλα Πελάτη';

    $html = $this->load->view('customer_card', $data, true);
    $this->chart->print_doc($html, $title);
    }

    public function delete($id) {
        $this->customer->delete($id);

        redirect('/admin/customers', 'refresh');
    }
    public function get_sold($selling_point = NULL) {
        
        //$customers = $this->customer->get_all('id, name, address, city, phone_home, phone_mobile, first_visit, selling_point','status = 1 AND selling_point=' . $selling_point);
        $customers = $this->customer->get_customers(1, $selling_point);

       
        $data['customers'] = $customers;
        $data['title'] = 'Πωλήσεις' ;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "customers_list";
        $this->load->view($this->_container, $data);
    }
    public function get_interested() {
        $customers = $this->customer->get_all('id, name, address, city, phone_home, first_visit','status <> 1');

        $data['customers'] = $customers;
        $data['title'] = 'Πελατολόγιο Ενδιαφερομένων' ;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "customers_list";
        $this->load->view($this->_container, $data);
    }
    public function get_interested_sp($selling_point = NULL) {
        //$customers = $this->customer->get_all('id, name, address, city, phone_home, first_visit','status <> 1 AND selling_point=' . $selling_point);
        $customers = $this->customer->get_customers(3, $selling_point);

        $data['customers'] = $customers;
        $data['title'] = 'Πελατολόγιο Ενδιαφερομένων' ;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "customers_list";
        $this->load->view($this->_container, $data);
    }
    
    public function get_interested_list($year, $selling_point) {
        $customers = $this->customer->get_all('id, name, address, city, phone_home, phone_mobile, first_visit','status = 3 AND YEAR(first_visit) =' . $year . ' AND selling_point =' . $selling_point);

        $data['customers'] = $customers;
        $data['title'] = 'Πελατολόγιο Ενδιαφερομένων έτους ' . $year;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "customers_list";
        $this->load->view($this->_container, $data);
    }
        public function get_onhold($selling_point = NULL) {
        //$customers = $this->customer->get_all('id, name, address, city, phone_home, phone_mobile, first_visit','pending=pending AND selling_point=' . $selling_point);
        $customers = $this->customer->get_customers(null, $selling_point, 'pending');

        $data['customers'] = $customers;
        $data['title'] = 'Σε Εκκρεμότητα' ;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "customers_list";
        $this->load->view($this->_container, $data);
    } 
    
    public function get_onhold_full() {
        $customers = $this->customer->get_all('id, name, address, city, phone_home, phone_mobile, first_visit','pending=pending');

        $data['customers'] = $customers;
        $data['title'] = 'Σε Εκκρεμότητα' ;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "customers_list";
        $this->load->view($this->_container, $data);
    } 
    public function get_all_pays() {
        $pays = $this->customer->get_all('id, name, address, city, phone_home, first_visit','debt_flag<>0');
        
        $data['customers'] = $pays;
        $data['title'] = 'Πληρωμές' ;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "customers_list";
        $this->load->view($this->_container, $data);
        
    }
    public function get_pays($name) {
        $pays = $this->pay->get_all('id, customer, date, pay','customer = ' . $name);
        $customers = $this->customer->get($name);
        
        $data['customer'] = $customers;
        $data['pay'] = $pays;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "pay_view";
        $this->load->view($this->_container, $data);
    } 
    
    public function view_customer_list($year, $selling_point) {
        $customers = $this->customer->get_all('id, name, address, city, phone_home, phone_mobile, first_visit', 'status = 1 AND YEAR(first_visit) =' . $year . ' AND selling_point =' . $selling_point);
        $selling_point_name = $this->selling_point->get($selling_point);

        $data['title'] = 'Πελάτες Έτους ' . $year . ' στη ' . $selling_point_name->city;
        $data['customers'] = $customers;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "customers_list";
        $this->load->view($this->_container, $data);
    } 
    
    public function view_doctors_customers($doctor, $year) {
        $customers = $this->customer->get_all('', 'YEAR(first_visit) =' . $year . ' AND doctor =' . $doctor);
        //$selling_point_name = $this->selling_point->get($selling_point);
        $doctor_name = $this->doctor->get($doctor);
        $doc_name = $doctor_name->doc_name;

        $data['title'] = 'Περιστατικά έτους  ' . $year . ' απο κ. ' . $doc_name;
        $data['customers'] = $customers;
        $data['doctors'] = $doctor;
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "customers_list";
        $this->load->view($this->_container, $data);
    }    
    
    
    public function get_customer($id) {
        // Set JSON header
        header('Content-Type: application/json');
        
        // Εύρεση του πελάτη από τη βάση δεδομένων
        $customer = $this->customer->get($id);
        
        if ($customer) {
            // Επιστροφή των δεδομένων του πελάτη σε μορφή JSON
            echo json_encode($customer);
        } else {
            // Αν δεν βρεθεί πελάτης, επιστροφή σφάλματος
            http_response_code(404);
            echo json_encode(['error' => 'Ο πελάτης δεν βρέθηκε']);
        }
        exit(); // Prevent further output
    }

public function update_pending_status() {
    $customerId = $this->input->post('id');
    $pending = $this->input->post('pending');

    // Ενημέρωση του πεδίου pending για τον συγκεκριμένο πελάτη
    $data = array(
        'pending' => $pending
    );

    $this->db->where('id', $customerId);
    $this->db->update('customers', $data);

    echo json_encode(['success' => true]);
}


}
