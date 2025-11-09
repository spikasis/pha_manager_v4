<?php

class Pays extends Admin_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->model('admin/Pay_model', 'pay');
        $this->load->model('admin/Stock_model', 'stock');
        $this->load->model('admin/Customer_model', 'customer');
        $this->load->model('admin/Chart_model', 'chart');
        $this->load->model('admin/Selling_point_model', 'selling_point');
        
        // Role-based access control
        $this->_check_pays_access();
    }
    
    /**
     * Check if user has access to payments
     */
    private function _check_pays_access() {
        $user_id = $this->ion_auth->get_user_id();
        $group = $this->ion_auth->get_users_groups($user_id)->row();
        $group_id = $group ? $group->id : null;
        
        // Service group (6) has no access to payments
        if ($group_id == 6) {
            show_error('Δεν έχετε δικαίωμα πρόσβασης στη διαχείριση πληρωμών', 403, 'Μη Εξουσιοδοτημένη Πρόσβαση');
        }
    }
    
    /**
     * Get user's allowed selling point filter
     */
    private function _get_selling_point_filter() {
        $user_id = $this->ion_auth->get_user_id();
        $group = $this->ion_auth->get_users_groups($user_id)->row();
        $group_id = $group ? $group->id : 1;
        
        // Admin (1) sees all
        if ($group_id == 1) {
            return null;
        }
        
        // Branch users (2, 4, 5) see only their branch
        if (in_array($group_id, [2, 4, 5])) {
            // TODO: Get user's selling point from user profile
            // For now, return null (admin access) until selling point assignment is implemented
            return null;
        }
        
        return null;
    }

    public function index() {
        $selling_point_filter = $this->_get_selling_point_filter();
        
        // Get payments with role-based filtering
        if ($selling_point_filter) {
            $stock = $this->pay->get_by_selling_point($selling_point_filter);
        } else {
            $stock = $this->pay->get_all();
        }
        
        $year_now = date('Y');
        
        // Generate monthly stats
        $pay_month_stats = [];
        for($month = 1; $month <= 12; $month++) {
            $pay_month_stats[] = $this->chart->get_pays_monthly_stats($month, $selling_point_filter);
        }
        
        $series_data = $pay_month_stats;
        $series_data1 = $this->chart->clean_column(json_encode($series_data));
        $series_data2 = str_replace('], [', ', ', $series_data1);
        
        $pay = $series_data2;
        
        $data['pays'] = $pay;
        $data['year_now'] = $year_now;
        $data['pay'] = $stock;
        $data['selling_point_filter'] = $selling_point_filter;
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "pay_list";
        $this->load->view($this->_container, $data);
    }
    
    public function get_pays_sp($selling_point = NULL)    
    {
        
        $data['sp'] = $this->selling_point->get($selling_point);
        $data['debts'] = $this->pay->get_customer_debts($selling_point);
        
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "debt_list";
        $this->load->view($this->_container, $data);
    }

    public function create() {
        if ($this->input->post('date')) {
            $data['customer'] = $this->input->post('customer');
            $data['hearing_aid'] = $this->input->post('hearing_aid');           
            $data['date'] = $this->input->post('date');
            $data['pay'] = $this->input->post('pay');
        
            $this->pay->insert($data);

            redirect('/admin/pays', 'refresh');
        }
        //$stock = $this->stock->get($id);

        $customers = $this->customer->get_all();

        $data['customers'] = $customers;

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "pay_create";
        $this->load->view($this->_container, $data);
    }

    public function create_specific($id) {                    
        if ($this->input->post('date')) {
            $data['customer'] = $id;
            $data['hearing_aid'] = $this->input->post('hearing_aid');           
            $data['date'] = $this->input->post('date');
            $data['pay'] = $this->input->post('pay');

        
            $this->pay->insert($data);

            redirect('/admin/stocks/pays/' . $data['hearing_aid'], 'refresh');
        }       

        $data['customers'] = $this->customer->get($id);
        $data['stock'] = $this->stock->get_all('id, serial, manufacturer, model, type, day_out, guarantee_end, comments', 'customer_id=' . $id);

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "pay_create_specific";
        $this->load->view($this->_container, $data);
    }
    
        public function create_specific_ha($id) {                    
            $stock = $this->stock->get($id);
            
            if ($this->input->post('date')) 
                {
                $data['customer'] = $stock->customer_id;
                $data['hearing_aid'] = $stock->id;           
                $data['date'] = $this->input->post('date');
                $data['pay'] = $this->input->post('pay');
                
                
                $this->pay->insert($data);

            redirect('/admin/stocks/view/' . $stock->id, 'refresh');
        }       

        //$data['customers'] = $this->customer->get($id);
        
        $data['customers'] = $this->customer->get($stock->customer_id);
        $data['stock'] = $stock;

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "pay_create_specific_ha";
        $this->load->view($this->_container, $data);
    }
    
    public function edit($id) {
        if ($this->input->post('customer')) {
            $data['customer'] = $this->input->post('customer');
            $data['hearing_aid'] = $this->input->post('hearing_aid');
            $data['date'] = $this->input->post('date');
            $data['pay'] = $this->input->post('pay');
            $this->pay->update($data, $id);

            redirect('/admin/pays', 'refresh');
        }
        $pays = $this->pay->get($id);

        $customers = $this->customer->get_all();
        $stocks = $this->stock->get_all('id, serial, model, type','customer_id=' . $pays->customer);
        
        $data['pay'] = $pays;
        $data['customers'] = $customers;
        $data['stock'] = $stocks;

        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "pay_edit";
        $this->load->view($this->_container, $data);
    }

    public function delete($id) {
        $this->pay->delete($id);

        redirect('/admin/pays', 'refresh');
    }
    
    public function view($id) {
    
        $pay = $this->pay->get($id);
        $customers = $this->customer->get($pay->customer);

        $data['pay'] = $pay;
        $data['customer'] = $customers;
         
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "pay_view";
        $this->load->view($this->_container, $data);
    }   
}
