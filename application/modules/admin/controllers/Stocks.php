<?php

class Stocks extends Admin_Controller {

    function __construct() {
        parent::__construct();

        // Load multiple models in a single call
        $models = array(
            'admin/stock',
            'admin/doctor',
            'admin/customer',
            'admin/manufacturer',
            'admin/vendor',
            'admin/stock_status',
            'admin/ch_customer',
            'admin/company',
            'admin/pay',
            'admin/selling_point',
            'admin/ha_type',
            'admin/service',
            'admin/balance_view',
            'admin/debt_view',
            'admin/invoice_view',
            'admin/chart',
            'admin/model',
            'admin/serie',
            'admin/battery_type',
            'admin/earlab'
        );

        $this->load->model($models);
        }

    public function index() {
        $chart_data = $this->stock->fetchChartData(2024, 2);
        $data['chart_data'] = $chart_data;
        
        $data['title'] = 'Αποθήκη Ακουστικών';
        
        //$stock = $this->stock->get_all('serial, customer_id, day_in, day_out');
        $stock = $this->stock->getStocksWithDetails();
        $data['stats'] = $this->stock->get_stats('2023');       

        $data['stock'] = $stock;         
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list";
        $this->load->view($this->_container, $data);
    }

    public function list_sp($selling_point = null) {
        // Check if $selling_point is provided
        
        if ($selling_point !== null) {
        // Call getStocksWithDetails() with the provided selling point
            $stock = $this->stock->getStocksWithDetails($selling_point);
            } else {
                // Call getStocksWithDetails() without filtering by selling point
        
                $stock = $this->stock->getStocksWithDetails();
                }
        
        $data['title'] = 'Αποθήκη Ακουστικών';
        
        $year = date('Y');  
        
        $chart_data = $this->stock->fetchChartData($year, $selling_point);
        $data['chart_data'] = $chart_data;

        $data['stock'] = $stock;       
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list";
        $this->load->view($this->_container, $data);
    }
    
    public function create() {
    // Αρχικοποίηση των πεδίων με null
    $data = [
        'serial' => null,
        'day_in' => null,
        'day_out' => null,
        'first_fit' => null,
        'guarantee_end' => null,
        'type' => null,
        'manufacturer' => null,
        'model' => null,
        'vendor' => null,
        'status' => null,
        'comments' => null,
        'customer_id' => null,
        'doctor_id' => null,
        'ha_price' => null,
        'ha_id' => null,
        'ekapty_code' => null,
        'eopyy' => null,
        'selling_point' => null,
        'on_test' => null,
        'ha_model' => null,
        'ektelesi_eopyy' => null,
    ];

    if ($this->input->post('serial')) {
        // Ενημέρωση των πεδίων με τις τιμές από το post
        $data['serial'] = $this->input->post('serial');
        $data['day_in'] = $this->input->post('day_in');
        $data['day_out'] = $this->input->post('day_out');
        $data['first_fit'] = $this->input->post('first_fit');
        $data['guarantee_end'] = $this->input->post('guarantee_end');
        $data['type'] = $this->input->post('type');
        $data['manufacturer'] = $this->input->post('manufacturer');
        $data['model'] = $this->input->post('model');
        $data['vendor'] = $this->input->post('vendor');
        $data['status'] = $this->input->post('status');
        $data['comments'] = $this->input->post('comments');
        $data['customer_id'] = $this->input->post('customer_id');
        $data['doctor_id'] = $this->input->post('doctor_id');
        $data['ha_price'] = $this->input->post('ha_price');
        $data['ha_id'] = $this->input->post('ha_id');
        $data['ekapty_code'] = $this->input->post('ekapty_code');
        $data['eopyy'] = $this->input->post('eopyy');
        $data['selling_point'] = $this->input->post('selling_point');
        $data['on_test'] = $this->input->post('on_test');
        $data['ha_model'] = $this->input->post('ha_model');
        $data['ektelesi_eopyy'] = $this->input->post('ektelesi_eopyy');

        $this->stock->insert($data);
        redirect('/admin/stocks', 'refresh');
    }

    // Αποκτήστε τις απαραίτητες πληροφορίες
    $manufacturers = $this->manufacturer->get_all();
    $customers = $this->customer->get_all();
    $vendors = $this->vendor->get_all();
    $stock_status = $this->stock_status->get_all();
    $ch_customer = $this->ch_customer->get_all();
    $selling_point = $this->selling_point->get_all();
    $ha_type = $this->ha_type->get_all();
    $ha_models = $this->model->get_all();
    $doctors = $this->doctor->get_all();

    
    // Δημιουργία του πίνακα δεδομένων
    $data['stock_status'] = $stock_status;
    $data['manufacturers'] = $manufacturers;
    $data['customers'] = $customers;
    $data['ch_customer'] = $ch_customer;
    $data['vendors'] = $vendors;       
    $data['selling_point'] = $selling_point;
    $data['ha_type'] = $ha_type;
    $data['ha_models'] = $ha_models;
    $data['doctors'] = $doctors;

    $data['models'] = $this->model->get_all_models_with_details();
    
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_create";
    $this->load->view($this->_container, $data);
}

public function create_modal() {
    // Αρχικοποίηση των πεδίων με null
    $data = [
        'serial' => null,
        'day_in' => null,
        'day_out' => null,
        'first_fit' => null,
        'guarantee_end' => null,
        'type' => null,
        'manufacturer' => null,
        'model' => null,
        'vendor' => null,
        'status' => null,
        'comments' => null,
        'customer_id' => null,
        'doctor_id' => null,
        'ha_price' => null,
        'ha_id' => null,
        'ekapty_code' => null,
        'eopyy' => null,
        'selling_point' => null,
        'on_test' => null,
        'ha_model' => null,
        'ektelesi_eopyy' => null,
    ];

    // Αν είναι POST, τότε επεξεργασία της προσθήκης
    if ($this->input->post('serial')) {
        // Ενημέρωση των πεδίων με τις τιμές από το post
        $data['serial'] = $this->input->post('serial');
        $data['day_in'] = $this->input->post('day_in');
        $data['day_out'] = $this->input->post('day_out');
        $data['first_fit'] = $this->input->post('first_fit');
        $data['guarantee_end'] = $this->input->post('guarantee_end');
        //$data['type'] = $this->input->post('type');
        //$data['manufacturer'] = $this->input->post('manufacturer');
        //$data['model'] = $this->input->post('model');
        //$data['vendor'] = $this->input->post('vendor');
        $data['status'] = $this->input->post('status');
        $data['comments'] = $this->input->post('comments');
        $data['customer_id'] = $this->input->post('customer_id');
        $data['doctor_id'] = $this->input->post('doctor_id');
        $data['ha_price'] = $this->input->post('ha_price');
        $data['ha_id'] = $this->input->post('ha_id');
        $data['ekapty_code'] = $this->input->post('ekapty_code');
        $data['eopyy'] = $this->input->post('eopyy');
        $data['selling_point'] = $this->input->post('selling_point');
        $data['on_test'] = $this->input->post('on_test');
        $data['ha_model'] = $this->input->post('ha_model');
        $data['ektelesi_eopyy'] = $this->input->post('ektelesi_eopyy');

        
        // Ελέγχει αν όλα τα πεδία είναι σωστά
        log_message('debug', "Creating acoustic with data: " . print_r($data, true));

        // Έλεγχος για έγκυρες τιμές
        if (empty($data['manufacturer']) || empty($data['model'])) {
            echo json_encode(['success' => false, 'message' => 'Παρακαλώ επιλέξτε έγκυρο κατασκευαστή και μοντέλο.']);
            return;
        }
        
         // Insert into database
    if ($this->stock->insert($data)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
        
        // Επιστροφή JSON επιτυχίας
        echo json_encode(['success' => true]);
        return; // Σταματάει τη μέθοδο εδώ
    }

    // Δεν απαιτείται να κάνεις κάτι εδώ αν δεν είναι POST
}



    public function edit($id) {
    // Κλήση της διαδικασίας για την ενημέρωση του υπολοίπου
    //$this->db->query("CALL update_balance($id)");

    // Έλεγχος αν υπάρχουν δεδομένα από το POST
    if ($this->input->post()) {
        $data = $this->get_post_data();
        $this->stock->update($data, $id);

        redirect('/admin/stocks/view/' . $id, 'refresh');
    }

    // Ανάκτηση της υπάρχουσας πληροφορίας του stock
    $stock = $this->stock->get($id);
    
    // Ανάκτηση όλων των απαιτούμενων δεδομένων
    $data = [
        'ha_type' => $this->ha_type->get_all(),
        'manufacturers' => $this->manufacturer->get_all(),
        'customers' => $this->customer->get_all(),
        'vendors' => $this->vendor->get_all(),
        'stock' => $stock,
        'stock_status' => $this->stock_status->get_all(),
        'selling_point' => $this->selling_point->get_all(),
        'ha_models' => $this->model->get_all(),
        'doctors' => $this->doctor->get_all(),
        'page' => $this->config->item('ci_my_admin_template_dir_admin') . "stock_edit",
    ];

    $this->load->view($this->_container, $data);
}

// Βοηθητική μέθοδος για την ανάκτηση δεδομένων από το POST
private function get_post_data() {
    $fields = [
        'serial', 'day_in', 'day_out', 'first_fit', 'guarantee_end',
        'type', 'manufacturer', 'model', 'vendor', 'status',
        'comments', 'customer_id', 'doctor_id', 'ha_price', 
        'ha_id', 'ekapty_code', 'eopyy', 'selling_point', 
        'on_test', 'ha_model', 'ektelesi_eopyy'
    ];

    $data = [];
    foreach ($fields as $field) {
        $data[$field] = $this->input->post($field);
    }

    return $data;
}


    public function delete($id) {
        $this->stock->delete($id);

        redirect('/admin/stocks', 'refresh');
    }

    
    public function get_onstock() {
        //$stock = $this->stock->get_all('id, serial, customer_id, day_out, day_in, guarantee_end, type, manufacturer, model, status, selling_point, ha_model, ekapty_code', 'status=1');
        
        $stock = $this->stock->getStocksWithDetails(null, null, '1');

        $data['title'] = 'Διαθέσιμα Αποθήκης';
        $data['stock'] = $stock;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list";
        $this->load->view($this->_container, $data);
    }
    
    public function get_sold_thisYear_sp($year, $selling_point) {
        //$stock = $this->stock->get_all('id, serial, customer_id, day_out, day_in, guarantee_end, type, manufacturer, model, status, selling_point, ha_model, ekapty_code', 'status=4 AND YEAR(day_out)=' . $year . ' AND selling_point=' . $selling_point);
        $stock = $this->stock->getStocksWithDetails($selling_point, $year);
        $data['title'] = 'Πωλήσεις Έτους';
        $data['stock'] = $stock;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list";
        $this->load->view($this->_container, $data);
    }

    public function get_demo($status, $selling_point = null) {
    // Εάν το $selling_point είναι null, τότε δεν το συμπεριλαμβάνουμε στο query
    if ($selling_point === null) {
        $data['stock_on_test_no'] = $this->stock->get_stocks_with_conditions($status, 0, null);
        $data['stock_on_test_yes'] = $this->stock->get_stocks_with_conditions($status, 1, null);
    } else {
        $data['stock_on_test_no'] = $this->stock->get_stocks_with_conditions($status, 0, $selling_point);
        $data['stock_on_test_yes'] = $this->stock->get_stocks_with_conditions($status, 1, $selling_point);
    }

    // Φόρτωση των πελατών για το dropdown
    $this->load->model('customer');
    $data['customers'] = $this->customer->get_all();

    $data['title'] = 'Προς Δοκιμή';
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list_demo";
    $this->load->view($this->_container, $data);
}


// Update "on_test" status
public function update_otf()
{
    $id = $this->input->post('id');
    $on_test = $this->input->post('on_test');
    
    

    if ($id) {
        $this->stock->update_otf($id, ['on_test' => $on_test]);
        log_message('debug', 'update_otf called with ID: ' . $id . ', on_test: ' . $on_test);
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid stock ID']);
    }
}

// Update customer
public function update_customer() {
    $id = $this->input->post('id');  // Get the stock ID
    $customer_id = $this->input->post('customer_id');  // Get the new customer ID

    // Validate the received data
    if ($id && $customer_id) {
        // Prepare the data for the update
        $update_data = ['customer_id' => $customer_id];

        // Call the model's update method
        if ($this->stock->update_otf($id, $update_data)) {
            log_message('debug', 'Customer updated successfully for stock ID: ' . $id);
            echo json_encode(['status' => 'success']);
        } else {
            log_message('error', 'Failed to update customer for stock ID: ' . $id);
            echo json_encode(['status' => 'error', 'message' => 'Failed to update customer']);
        }
    } else {
        log_message('error', 'Invalid stock ID or customer ID provided');
        echo json_encode(['status' => 'error', 'message' => 'Invalid stock or customer ID']);
    }
}


// Update "day_out" field
public function update_day_out()
{
    $id = $this->input->post('id');
    $day_out = $this->input->post('day_out');

    if ($id) {
        $this->stock->update_otf($id, ['day_out' => $day_out]);
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid stock ID']);
    }
}



    //endof controller for demolist
    
    public function get_returns() {
        //$stock = $this->stock->get_all('id, serial, customer_id, day_out, day_in, guarantee_end, type, manufacturer, model, ha_model, status, selling_point', '(status=5 OR status=6)');
        
        $stock = $this->stock->getStocksWithDetails(null, null, '7');

        $data['title'] = 'Επιστροφές Ακουστικών';
        $data['stock'] = $stock;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list";
        $this->load->view($this->_container, $data);
    }
    
    public function get_available_serial() {
        //$stock = $this->stock->get_all('id, serial, customer_id, day_in, day_out, guarantee_end, type, manufacturer, model, ha_model, status, selling_point', 'status=3');
        
        $stock = $this->stock->getStocksWithDetails(null, null, '3');

        $data['title'] = 'Διαθέσιμα serial';
        $data['stock'] = $stock;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list";
        $this->load->view($this->_container, $data);
    }

    public function get_stockblack() {
        //$stock = $this->stock->get_all('id, serial, customer_id, day_in, day_out, guarantee_end, type, manufacturer, model, ha_model, status, selling_point', 'status=2');
        $stock = $this->stock->getStocksWithDetails(null, null, '2');

        $data['title'] = 'Διαθέσιμα Black Only';
        $data['stock'] = $stock;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list";
        $this->load->view($this->_container, $data);
    }

    public function eopyy_doc($id) {
    
        $stock = $this->stock->get($id);
        $manufacturers = $this->manufacturer->get($stock->manufacturer);
        $customers = $this->customer->get($stock->customer_id);
        $companies = $this->company->get(1);
        
        $data['company'] = $companies;
        $data['stock'] = $stock;
        $data['manufacturer'] = $manufacturers;
        $data['customer'] = $customers;
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "eopyy_doc";
        
        $html = $this->load->view($this->_container, $data); 
        $pdfFilePath = '' . $stock->serial . '-' . $customers->name . '.pdf';
    
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }
    
    public function eggyisi_doc($id) {
    
        $stock = $this->stock->get($id);        
        $customers = $this->customer->get($stock->customer_id);
        $companies = $this->company->get(1);   
        $ha_model = $this->model->get($stock->ha_model);
        $ha_series = $this->serie->get($ha_model->series);
        $manufacturers = $this->manufacturer->get($ha_series->brand);
        $ha_type = $this->ha_type->get($ha_model->ha_type);
        
        $data['company'] = $companies;
        $data['stock'] = $stock;
        $data['manufacturer'] = $manufacturers;
        $data['customer'] = $customers;
        $data['ha_model'] = $this->model->get($ha_model->id);
        $data['ha_series'] = $ha_series;
        $data['type'] = $ha_type;
        
        $title = 'Εγγύηση Ακουστικού Βαρηκοΐας';
        $html = $this->load->view('eggyisi_doc_final', $data, true);
        $this->chart->print_doc($html, $title);
        
        
    }
        
    public function epistrofi_doc($id) {
    
        $stock = $this->stock->get($id);
        $manufacturers = $this->manufacturer->get($stock->manufacturer);
        $customers = $this->customer->get($stock->customer_id);
        $companies = $this->company->get(1);        
        
        $data['company'] = $companies;
        $data['stock'] = $stock;
        $data['manufacturer'] = $manufacturers;
        $data['customer'] = $customers;
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "ekapty/epistrofi_doc";       
        $this->load->view($this->_container, $data);        
    }
    
    public function daneismos_doc($id) {
    
        $stock = $this->stock->get($id);
        $manufacturers = $this->manufacturer->get($stock->manufacturer);
        $customers = $this->customer->get($stock->customer_id);
        $companies = $this->company->get(1);        
        
        $data['company'] = $companies;
        $data['stock'] = $stock;
        $data['manufacturer'] = $manufacturers;
        $data['customer'] = $customers;
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "ekapty/daneismos_doc";       
        $this->load->view($this->_container, $data);        
    }
    
    public function view($id) {
    

        $stock = $this->stock->get($id);
        $ha_model = $this->model->get($stock->ha_model);
        $series = $this->serie->get($ha_model->series);
        
        $manufacturers = $this->manufacturer->get($series->brand);
        if(isset($stock->customer_id))
        {
            $customers = $this->customer->get($stock->customer_id);            
        }
        $vendors = $this->vendor->get($stock->vendor);
        $status = $this->stock_status->get($stock->status);
        $services = $this->service->get_all('*', 'ha_service=' . $stock->id);
        $type = $this->ha_type->get($stock->type);
        $balance = $this->balance_view->get_all('hearing_aid, day_out, price, eopyy, sum_pays', 'hearing_aid = ' . $stock->id);
        $pays = $this->pay->get_all('id, customer, ,hearing_aid, date, pay','hearing_aid = ' . $stock->id);
        $sum_pays = $this->balance_view->get_all('(SUM(price)-SUM(eopyy)-SUM(sum_pays)) AS balance', 'hearing_aid=' . $stock->id);
        $earlabs = $this->earlab->get_all('id, customer_id, vendor_id, date_order, date_delivery, side, cost, type', 'customer_id=' . $stock->customer_id);
        
        $data['stock'] = $stock;
        
        $data['ha_model'] = $ha_model;
        $data['series'] = $series;
        
        $data['manufacturer'] = $manufacturers;
        $data['customer'] = $customers;
        $data['vendor'] = $vendors;
        $data['status'] = $status;
        $data['services'] = $services;
        $data['ha_type'] = $type;
        $data['pays'] = $pays;
        $data['sum_pays'] = $sum_pays;
        $data['balance'] = ($balance[0]['price'] - $balance[0]['eopyy'] - $balance[0]['sum_pays']);
        $data['earlabs'] = $earlabs;
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_view";
        $this->load->view($this->_container, $data);
        
    }
    
    public function pays($id) {
        
        //$this->db->query("CALL update_balance($id)");
        //$this->db->query("CALL update_debt()");
        
        $stock = $this->stock->get($id);
        $pays = $this->pay->get_all('id, customer, ,hearing_aid, date, pay','hearing_aid = ' . $id);
        $manufacturers = $this->manufacturer->get($stock->manufacturer);
        if(isset($stock->customer_id))
        {
          $customers = $this->customer->get($stock->customer_id);              
        }
        
        $vendors = $this->vendor->get($stock->vendor);
        $status = $this->stock_status->get($stock->status);
        //$balance = $this->balance_view->get_all('price, eopyy, sum_pays', 'hearing_aid = ' . $stock->id);
        $sum_pays = $this->balance_view->get_all('(SUM(price)-SUM(eopyy)-SUM(sum_pays)) AS balance', 'hearing_aid=' . $stock->id);
        
        $data['stock'] = $stock;
        $data['manufacturer'] = $manufacturers;
        $data['customer'] = $customers;
        $data['vendor'] = $vendors;
        $data['status'] = $status;
        $data['pay'] = $pays;              
        $data['balance'] = $sum_pays;
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "customers_view_pays";
        $this->load->view($this->_container, $data);        
    }
    
    public function on_debt($selling_point = null)
{
    // Δημιουργία αρχικής συνθήκης για το balance
    $condition = 'balance > 0';
    
    // Προσθήκη συνθήκης για selling_point εάν υπάρχει τιμή
    if ($selling_point !== null) {
        $condition .= ' AND selling_point = ' . $this->db->escape($selling_point);
    }
    
    // Εκτέλεση του ερωτήματος με την συνθήκη
    $data['stock'] = $this->debt_view->get_all('', $condition);

    $data['title'] = 'Μή Εξωφλημένα Ακουστικά';
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list";
    
    // Φόρτωση του view
    $this->load->view($this->_container, $data);
}


    public function on_debt_old($year_now)
    {
        $data['stock'] = $this->debt_view->get_all('id, serial, customer_id, day_in, day_out, status, selling_point', 'balance<>0 AND YEAR(day_out)<' . $year_now);
        
        $data['title'] = 'Μή Εξωφλημένα Ακουστικά';
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list";
        $this->load->view($this->_container, $data);
    }
    
    public function view_stock_on_debt($year = null, $selling_point = null) {
    // Εάν η τιμή του selling_point είναι 'selling_point', ορίζουμε την ως null
    if ($selling_point === 'selling_point') {
        $selling_point = null;
    }

    // Ετοιμάζουμε τα δεδομένα για το query με έλεγχο null
    $condition = 'balance<>0';
    
    // Προσθήκη φίλτρου για το έτος αν υπάρχει
    if ($year) {
        $condition .= ' AND YEAR(day_out) =' . $year;
    }
    
    // Προσθήκη φίλτρου για το selling_point αν υπάρχει
    if ($selling_point) {
        $condition .= ' AND selling_point =' . $selling_point;
    }

    // Κλήση του μοντέλου για να φέρουμε τα δεδομένα
    $stocks = $this->stock->getStocksWithDetails($selling_point, $year, 3, 'non_zero');
    
    // Εύρεση του ονόματος του selling_point, αν υπάρχει
    $selling_point_name = $this->selling_point->get($selling_point);

    // Δημιουργία τίτλου σε περίπτωση που υπάρχει selling_point
    if ($selling_point_name) {
        $data['title'] = 'Οφειλές Έτους ' . $year . ' στη ' . $selling_point_name->city;
    } else {
        $data['title'] = 'Οφειλές Έτους ' . $year;
    }

    // Αποθήκευση δεδομένων για προβολή
    $data['stock'] = $stocks;
    
    // Φόρτωση της σελίδας
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list";
    $this->load->view($this->_container, $data);
}


    public function get_ha_types($year, $selling_point, $type)
    {
               
        $types = $this->stock->get_all('*', ' type =' . $type . ' AND YEAR(day_out) =' . $year . ' AND selling_point =' . $selling_point);
       
       return $types;
   
    }
    
    public function view_vendors_stock($vendor, $year) {
        //$stocks = $this->stock->get_all('*', 'YEAR(day_in) =' . $year . ' AND vendor =' . $vendor);
        $stocks = $this->stock->getStocksWithDetails(null, $year, null, null, $vendor);
        
        //$selling_point_name = $this->selling_point->get($selling_point);
        $vendor_data = $this->vendor->get($vendor);
        $name = $vendor_data->name;

        $data['title'] = 'Τεμάχια έτους  ' . $year . ' απο ' . $name;
        $data['stock'] = $stocks;
        //$data['doctors'] = $doctor;
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list";
        $this->load->view($this->_container, $data);
    }
    
    public function view_barcodes_pending($sp = null, $year) {
        
        $stocks = $this->stock->getStocksWithDetails($sp, $year, null, null, null, null, false);
        //$stocks = $this->stock->get_all('*','ekapty_code<>0 AND ektelesi_eopyy=0 AND YEAR(day_in)>=' . $year . ' AND status=4 OR status=1');
        
        $data['title'] = 'Κατάσταση Ελεύθερων Barcodes ' . date("Y");
        $data['stock'] = $stocks;        
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list";
        $this->load->view($this->_container, $data);
    }
    
    public function view_free_barcodes($year) {
        
        $stocks = $this->stock->getStocksWithDetails(null, $year, 4, null, null, true, false);
        //$stocks = $this->stock->get_all('*','ekapty_code<>0 AND ektelesi_eopyy=0 AND YEAR(day_in)>=' . $year . ' AND status=4 OR status=1');
        
        $data['title'] = 'Κατάσταση Ελεύθερων Barcodes ' . date("Y");
        $data['stock'] = $stocks;        
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list";
        $this->load->view($this->_container, $data);
    }
    
    public function invoices_eopyy($selling_point, $year)
    { 
        $invoice = $this->invoice_view->get_all('','selling_point =' . $selling_point . ' AND year>=' . $year);
        $data['invoices'] = $invoice;
        $data['title'] = "Λιστα Τιμολογίων" ; 
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "invoice_list";
        $this->load->view($this->_container, $data);
    }
    
    public function ha_doc($id)
    { 
        $stock = $this->stock->get($id);
        $customer = $this->customer->get($stock->customer_id);
        $ha_model = $this->model->get($stock->ha_model);
        $series = $this->serie->get($ha_model->series);
        $brand = $this->manufacturer->get($series->brand);
        $battery = $this->battery_type->get($ha_model->battery);
        $type = $this->ha_type->get($ha_model->type);
        
        
        
        $data['stock']      = $stock;
        $data['customer']   = $customer;
        $data['ha_model']   = $ha_model;
        $data['series']     = $series;
        $data['brand']      = $brand;
        $data['battery']    = $battery;
        $data['type']       = $type;
        
        $title = 'Στοιχεία Ακουστικού Βαρηκοΐας';
        //$data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "hearing_aid_doc";
        //$this->load->view($this->_container, $data);
        
        $html = $this->load->view('hearing_aid_doc', $data, true);
        $this->chart->print_doc($html, $title);
    }
    
    public function get_by_customer($customer_id) {
    // Φόρτωση του μοντέλου stock
    $this->load->model('stock');

    // Πάρε τα ακουστικά για τον συγκεκριμένο πελάτη
    $acoustics = $this->stock->get_by_customer($customer_id);

    // Επιστροφή των αποτελεσμάτων σε μορφή JSON για χρήση από το AJAX
    echo json_encode($acoustics);
    
    }
    
    public function get_acoustic($id) {
        //$this->load->model('stock');  // Φόρτωση του μοντέλου stock
        $acoustic = $this->stock->get_stock_by_id($id);  // Ανάκτηση του ακουστικού από το μοντέλο
        
        if ($acoustic) {
            echo json_encode($acoustic);  // Επιστροφή δεδομένων σε μορφή JSON
            } 
            else 
            {
                echo json_encode(['error' => 'Ακουστικό δεν βρέθηκε.']);
                }               
            }

    // Μέθοδος για εμφάνιση των stocks με υπόλοιπο
    public function view_stock_on_debt_full($selling_point = null) {
    // Call the model function with $selling_point as a parameter
    $stocks = $this->stock->getStocksWithRemainingBalance($selling_point);
    
    $selling_point_name = $this->selling_point->get($selling_point);

    // Set the page title based on the selling point
    $data['title'] = 'Οφειλές στη ' . ($selling_point_name ? $selling_point_name->city : 'Όλα τα Σημεία');
    
    // Pass the stock data to the view
    $data['stock'] = $stocks;
    
    // Load the view
    $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "stock_list_debt";
    $this->load->view($this->_container, $data);
}

public function get_payments($stock_id) {
    // Κλήση στο model για να επιστρέψει τις πληρωμές
    $payments = $this->pay->getPaymentsByStockId($stock_id);

    // Επιστροφή των δεδομένων σε μορφή JSON
    echo json_encode($payments);
}


}
