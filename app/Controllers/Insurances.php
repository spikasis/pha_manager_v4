<?php

namespace App\Controllers;

use App\Models\InsuranceModel;

class Insurances extends BaseCRUD
{
    protected $modelName = InsuranceModel::class;
    
    public function __construct()
    {
        $this->model = new InsuranceModel();
    }
    
    /**
     * Display insurance list
     */
    public function index()
    {
        // Check authentication
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Διαχείριση Ασφαλιστικών Ταμείων - PHA Manager v4',
            'page_title' => 'Ασφαλιστικά Ταμεία',
            'page_description' => 'Διαχείριση ασφαλιστικών ταμείων και οργανισμών',
            'breadcrumbs' => ['Ασφαλιστικά Ταμεία'],
            'page_actions' => '<a href="' . base_url('insurances/create') . '" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Νέο Ασφαλιστικό Ταμείο
                              </a>'
        ];
        
        return view('insurances/index', $data);
    }
    
    /**
     * Show create form
     */
    public function create()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Νέο Ασφαλιστικό Ταμείο - PHA Manager v4',
            'page_title' => 'Νέο Ασφαλιστικό Ταμείο',
            'page_description' => 'Προσθήκη νέου ασφαλιστικού ταμείου',
            'breadcrumbs' => ['Ασφαλιστικά Ταμεία', 'Νέο'],
            'form_fields' => $this->model->getFormFields(),
            'form_action' => base_url('insurances'),
            'cancel_url' => base_url('insurances')
        ];
        
        return view('insurances/form', $data);
    }
    
    /**
     * Show edit form
     */
    public function edit($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        if ($id === null) {
            return redirect()->to('insurances')->with('error', 'Μη έγκυρο ID ασφαλιστικού ταμείου');
        }
        
        $insurance = $this->model->find($id);
        if (!$insurance) {
            return redirect()->to('insurances')->with('error', 'Το ασφαλιστικό ταμείο δεν βρέθηκε');
        }
        
        $data = [
            'title' => 'Επεξεργασία Ασφαλιστικού Ταμείου - PHA Manager v4',
            'page_title' => 'Επεξεργασία Ασφαλιστικού Ταμείου',
            'page_description' => 'Επεξεργασία στοιχείων ασφαλιστικού ταμείου',
            'breadcrumbs' => ['Ασφαλιστικά Ταμεία', 'Επεξεργασία'],
            'form_fields' => $this->model->getFormFields(),
            'form_data' => $insurance,
            'form_action' => base_url('insurances/' . $id),
            'form_method' => 'PUT',
            'cancel_url' => base_url('insurances')
        ];
        
        return view('insurances/form', $data);
    }
    
    /**
     * Display insurance details
     */
    public function show($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        if ($id === null) {
            return redirect()->to('insurances')->with('error', 'Μη έγκυρο ID ασφαλιστικού ταμείου');
        }
        
        $insurance = $this->model->find($id);
        if (!$insurance) {
            return redirect()->to('insurances')->with('error', 'Το ασφαλιστικό ταμείο δεν βρέθηκε');
        }
        
        // Get customers for this insurance
        $customers = $this->model->getCustomersByInsurance($id);
        
        $data = [
            'title' => 'Προβολή Ασφαλιστικού Ταμείου - PHA Manager v4',
            'page_title' => 'Ασφαλιστικό Ταμείο: ' . $insurance['name'],
            'page_description' => 'Πληροφορίες και πελάτες ασφαλιστικού ταμείου',
            'breadcrumbs' => ['Ασφαλιστικά Ταμεία', $insurance['name']],
            'insurance' => $insurance,
            'customers' => $customers,
            'page_actions' => '<a href="' . base_url('insurances/' . $id . '/edit') . '" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Επεξεργασία
                              </a>
                              <a href="' . base_url('insurances') . '" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Επιστροφή
                              </a>'
        ];
        
        return view('insurances/show', $data);
    }
    
    /**
     * Get data for DataTables AJAX
     */
    public function getData()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }
        
        try {
            $request = \Config\Services::request();
            
            // DataTables parameters
            $draw = $request->getPost('draw');
            $start = $request->getPost('start') ?: 0;
            $length = $request->getPost('length') ?: 10;
            $searchValue = $request->getPost('search')['value'] ?? '';
            
            // Build query
            $builder = $this->model->builder();
            
            // Search
            if (!empty($searchValue)) {
                $builder->like('name', $searchValue);
            }
            
            // Count total records
            $totalRecords = $this->model->countAllResults(false);
            
            // Count filtered records
            $filteredRecords = $builder->countAllResults(false);
            
            // Get records
            $records = $builder->limit($length, $start)
                              ->orderBy('name', 'ASC')
                              ->get()
                              ->getResultArray();
            
            // Format data for DataTables
            $data = [];
            foreach ($records as $record) {
                $actions = '
                    <div class="btn-group" role="group">
                        <a href="' . base_url('insurances/' . $record['id']) . '" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . base_url('insurances/' . $record['id'] . '/edit') . '" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteRecord(' . $record['id'] . ')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                ';
                
                $data[] = [
                    $record['id'],
                    $record['name'],
                    $actions
                ];
            }
            
            return $this->response->setJSON([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Insurances::getData - ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Server error']);
        }
    }
    
    /**
     * Get insurances for select dropdown (AJAX)
     */
    public function getForSelect()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }
        
        try {
            $options = $this->model->getForSelect();
            return $this->response->setJSON(['success' => true, 'options' => $options]);
            
        } catch (\Exception $e) {
            log_message('error', 'Insurances::getForSelect - ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Server error']);
        }
    }
}