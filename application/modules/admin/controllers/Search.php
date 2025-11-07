<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends Admin_Controller 
{
    // Model and library properties to avoid PHP 8.2+ deprecation warnings
    public $customer;
    public $stock;
    public $form_validation;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/customer');
        $this->load->model('admin/stock');
        $this->load->library('form_validation');
    }

    /**
     * Main search page
     */
    public function index()
    {
        $query = $this->input->get('q');
        $data = [];
        
        if (!empty($query)) {
            $data['query'] = $query;
            $data['customers'] = $this->search_customers($query);
            $data['stocks'] = $this->search_stocks($query);
            $data['total_results'] = count($data['customers']) + count($data['stocks']);
        } else {
            $data['query'] = '';
            $data['customers'] = [];
            $data['stocks'] = [];
            $data['total_results'] = 0;
        }
        
        $data['page_title'] = 'Αναζήτηση';
        $data['page'] = $this->config->item('ci_my_admin_template_dir_admin') . "search_results";
        $this->load->view($this->_container, $data);
    }

    /**
     * AJAX search for live results
     */
    public function ajax_search()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $query = $this->input->post('query');
        
        if (empty($query) || strlen($query) < 2) {
            echo json_encode([
                'success' => false,
                'message' => 'Παρακαλώ εισάγετε τουλάχιστον 2 χαρακτήρες'
            ]);
            return;
        }

        $customers = $this->search_customers($query, 5); // Limit to 5 results for dropdown
        $stocks = $this->search_stocks($query, 5);

        $results = [
            'success' => true,
            'customers' => $customers,
            'stocks' => $stocks,
            'total_count' => count($customers) + count($stocks)
        ];

        echo json_encode($results);
    }

    /**
     * Search in customers table
     */
    private function search_customers($query, $limit = null)
    {
        $this->db->select('id, name, phone_home, phone_mobile, city, first_visit');
        $this->db->from('customers');
        
        // Search in multiple fields
        $this->db->group_start();
        $this->db->like('name', $query);
        $this->db->or_like('phone_home', $query);
        $this->db->or_like('phone_mobile', $query);
        $this->db->or_like('city', $query);
        $this->db->or_like('address', $query);
        $this->db->group_end();
        
        $this->db->order_by('name', 'ASC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $customers = $this->db->get()->result_array();
        
        // Add result type for display
        foreach ($customers as &$customer) {
            $customer['result_type'] = 'customer';
            $customer['display_title'] = $customer['name'];
            $customer['display_subtitle'] = $customer['city'] . ' • ' . $customer['phone_home'];
            $customer['view_url'] = base_url('admin/customers/view/' . $customer['id']);
        }
        
        return $customers;
    }

    /**
     * Search in stocks table with joins
     */
    private function search_stocks($query, $limit = null)
    {
        $this->db->select('
            s.id, s.serial, s.day_in, s.day_out, s.status,
            c.name AS customer_name, c.id AS customer_id,
            v.name AS vendor_name,
            m.name AS manufacturer_name,
            mo.model AS model_name,
            se.series AS series_name
        ');
        
        $this->db->from('stocks s');
        $this->db->join('customers c', 's.customer_id = c.id', 'left');
        $this->db->join('vendors v', 's.vendor = v.id', 'left');
        $this->db->join('models mo', 's.ha_model = mo.id', 'left');
        $this->db->join('series se', 'mo.series = se.id', 'left');
        $this->db->join('manufacturers m', 'se.brand = m.id', 'left');
        
        // Search in multiple fields
        $this->db->group_start();
        $this->db->like('s.serial', $query);
        $this->db->or_like('c.name', $query);
        $this->db->or_like('m.name', $query);
        $this->db->or_like('mo.model', $query);
        $this->db->or_like('se.series', $query);
        $this->db->group_end();
        
        $this->db->order_by('s.day_in', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $stocks = $this->db->get()->result_array();
        
        // Add result type for display
        foreach ($stocks as &$stock) {
            $stock['result_type'] = 'stock';
            $stock['display_title'] = 'Serial: ' . $stock['serial'];
            $stock['display_subtitle'] = $stock['customer_name'] . ' • ' . $stock['manufacturer_name'] . ' ' . $stock['model_name'];
            $stock['view_url'] = base_url('admin/stock/view/' . $stock['id']);
        }
        
        return $stocks;
    }

    /**
     * Quick customer search for autocomplete
     */
    public function customers_autocomplete()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $query = $this->input->get('term');
        
        if (strlen($query) < 2) {
            echo json_encode([]);
            return;
        }

        $this->db->select('id, name, phone_home, city');
        $this->db->from('customers');
        $this->db->like('name', $query);
        $this->db->order_by('name', 'ASC');
        $this->db->limit(10);
        
        $customers = $this->db->get()->result_array();
        
        $results = [];
        foreach ($customers as $customer) {
            $results[] = [
                'id' => $customer['id'],
                'label' => $customer['name'] . ' (' . $customer['city'] . ')',
                'value' => $customer['name'],
                'phone' => $customer['phone_home']
            ];
        }
        
        echo json_encode($results);
    }
}