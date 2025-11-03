<?php

namespace App\Controllers;

/**
 * Doctors Controller
 * 
 * Manages doctor records with full CRUD operations
 * Handles contact information, pricing, and customer relationships
 */
class Doctors extends BaseCRUD
{
    protected $modelName = 'App\\Models\\DoctorModel';
    protected $module = 'doctors';
    protected $moduleTitle = 'Γιατροί';
    protected $moduleTitleSingle = 'Γιατρός';
    
    // Define the fields for the CRUD operations
    protected $crudFields = [
        'doc_name' => [
            'label' => 'Όνομα Γιατρού',
            'type' => 'text',
            'required' => true,
            'attributes' => ['maxlength' => '255', 'class' => 'form-control']
        ],
        'doc_address' => [
            'label' => 'Διεύθυνση',
            'type' => 'text',
            'required' => false,
            'attributes' => ['maxlength' => '255', 'class' => 'form-control']
        ],
        'doc_phone_work' => [
            'label' => 'Τηλέφωνο Εργασίας',
            'type' => 'text',
            'required' => false,
            'attributes' => ['maxlength' => '255', 'class' => 'form-control', 'placeholder' => 'π.χ. 2261080444']
        ],
        'doc_phone_mobile' => [
            'label' => 'Κινητό Τηλέφωνο',
            'type' => 'text',
            'required' => false,
            'attributes' => ['maxlength' => '10', 'class' => 'form-control', 'placeholder' => 'π.χ. 6932964813']
        ],
        'doc_city' => [
            'label' => 'Πόλη',
            'type' => 'text',
            'required' => false,
            'attributes' => ['maxlength' => '255', 'class' => 'form-control']
        ],
        'doc_price' => [
            'label' => 'Τιμή (€)',
            'type' => 'number',
            'required' => false,
            'attributes' => ['step' => '0.01', 'min' => '0', 'class' => 'form-control']
        ]
    ];
    
    // DataTables column configuration
    protected $datatableColumns = [
        [
            'data' => 'id',
            'name' => 'id',
            'title' => 'ID',
            'orderable' => true,
            'searchable' => false,
            'width' => '60px'
        ],
        [
            'data' => 'doc_name',
            'name' => 'doc_name',
            'title' => 'Όνομα Γιατρού',
            'orderable' => true,
            'searchable' => true
        ],
        [
            'data' => 'doc_city',
            'name' => 'doc_city', 
            'title' => 'Πόλη',
            'orderable' => true,
            'searchable' => true
        ],
        [
            'data' => 'doc_phone_work',
            'name' => 'doc_phone_work',
            'title' => 'Τηλ. Εργασίας',
            'orderable' => false,
            'searchable' => true
        ],
        [
            'data' => 'doc_phone_mobile',
            'name' => 'doc_phone_mobile',
            'title' => 'Κινητό',
            'orderable' => false,
            'searchable' => true
        ],
        [
            'data' => 'doc_price',
            'name' => 'doc_price',
            'title' => 'Τιμή',
            'orderable' => true,
            'searchable' => false,
            'width' => '100px'
        ],
        [
            'data' => 'actions',
            'name' => 'actions',
            'title' => 'Ενέργειες',
            'orderable' => false,
            'searchable' => false,
            'width' => '120px'
        ]
    ];
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        // Initialize model
        $this->model = new \App\Models\DoctorModel();
    }
    
    /**
     * Display doctors list
     */
    public function index()
    {
        $data = [
            'title' => $this->moduleTitle,
            'module' => $this->module,
            'moduleTitle' => $this->moduleTitle,
            'moduleTitleSingle' => $this->moduleTitleSingle,
            'createUrl' => base_url($this->module . '/create'),
            'datatableColumns' => $this->datatableColumns,
            'datatableUrl' => base_url($this->module . '/getData')
        ];
        
        return view($this->module . '/index', $data);
    }
    
    /**
     * Show doctor details with relationships
     */
    public function show($id)
    {
        $doctor = $this->model->getDoctorWithCustomers($id);
        
        if (!$doctor) {
            session()->setFlashdata('error', 'Ο γιατρός δεν βρέθηκε.');
            return redirect()->to(base_url($this->module));
        }
        
        // Get related customers
        $relatedCustomers = $this->model->getRelatedCustomers($id, 10);
        
        $data = [
            'title' => $this->moduleTitle . ' - ' . $doctor['doc_name'],
            'module' => $this->module,
            'moduleTitle' => $this->moduleTitle,
            'moduleTitleSingle' => $this->moduleTitleSingle,
            'doctor' => $doctor,
            'relatedCustomers' => $relatedCustomers,
            'editUrl' => base_url($this->module . '/edit/' . $id),
            'listUrl' => base_url($this->module),
            'deleteUrl' => base_url($this->module . '/delete/' . $id)
        ];
        
        return view($this->module . '/show', $data);
    }
    
    /**
     * Get doctors statistics for dashboard
     */
    public function getStatistics()
    {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        
        $stats = $this->model->getStatistics();
        
        return $this->response->setJSON($stats);
    }
    
    /**
     * Get doctors for select dropdown
     */
    public function getForSelect()
    {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        
        $doctors = $this->model->getForSelect();
        
        return $this->response->setJSON($doctors);
    }
    
    /**
     * Get data for DataTables AJAX
     */
    public function getData()
    {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        
        // DataTables parameters
        $draw = intval($this->request->getPost('draw'));
        $start = intval($this->request->getPost('start'));
        $length = intval($this->request->getPost('length'));
        $search = $this->request->getPost('search')['value'];
        $order = $this->request->getPost('order');
        $columns = $this->request->getPost('columns');
        
        // Get total count
        $totalRecords = $this->model->countAllResults(false);
        
        // Build query with search
        $query = $this->model;
        if (!empty($search)) {
            $query = $query->groupStart();
            $query = $query->like('doc_name', $search);
            $query = $query->orLike('doc_city', $search);
            $query = $query->orLike('doc_phone_work', $search);
            $query = $query->orLike('doc_phone_mobile', $search);
            $query = $query->orLike('doc_address', $search);
            $query = $query->groupEnd();
        }
        
        // Get filtered count
        $filteredRecords = $query->countAllResults(false);
        
        // Apply ordering
        if (!empty($order)) {
            $columnIndex = $order[0]['column'];
            $columnName = $this->datatableColumns[$columnIndex]['data'];
            $orderDir = $order[0]['dir'];
            
            if ($columnName !== 'actions') {
                $query = $query->orderBy($columnName, $orderDir);
            }
        } else {
            $query = $query->orderBy('doc_name', 'ASC');
        }
        
        // Get the data
        $data = $query->findAll($length, $start);
        
        // Format the data for display
        foreach ($data as &$row) {
            // Format price
            if (isset($row['doc_price']) && $row['doc_price'] !== null) {
                $row['doc_price'] = '€' . number_format($row['doc_price'], 2);
            } else {
                $row['doc_price'] = '-';
            }
            
            // Format phone numbers
            if (empty($row['doc_phone_work'])) {
                $row['doc_phone_work'] = '-';
            }
            if (empty($row['doc_phone_mobile'])) {
                $row['doc_phone_mobile'] = '-';
            }
            
            // Format city
            if (empty($row['doc_city'])) {
                $row['doc_city'] = '-';
            }
            
            // Add action buttons
            $row['actions'] = sprintf(
                '<div class="btn-group btn-group-sm" role="group">
                    <a href="%s" class="btn btn-info btn-sm" title="Προβολή">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="%s" class="btn btn-warning btn-sm" title="Επεξεργασία">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteRecord(%d)" title="Διαγραφή">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>',
                base_url($this->module . '/show/' . $row['id']),
                base_url($this->module . '/edit/' . $row['id']),
                $row['id']
            );
        }
        
        $result = [
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];
        
        return $this->response->setJSON($result);
    }
    
    /**
     * Override beforeSave for additional processing
     */
    protected function beforeSave($data, $id = null)
    {
        // Clean phone numbers (remove spaces and special chars)
        if (isset($data['doc_phone_work'])) {
            $data['doc_phone_work'] = preg_replace('/[^0-9+]/', '', $data['doc_phone_work']);
        }
        
        if (isset($data['doc_phone_mobile'])) {
            $data['doc_phone_mobile'] = preg_replace('/[^0-9+]/', '', $data['doc_phone_mobile']);
        }
        
        // Capitalize first letter of name and city
        if (isset($data['doc_name'])) {
            $data['doc_name'] = ucwords(strtolower(trim($data['doc_name'])));
        }
        
        if (isset($data['doc_city'])) {
            $data['doc_city'] = ucwords(strtolower(trim($data['doc_city'])));
        }
        
        return $data;
    }
    
    /**
     * Override beforeDelete to check relationships
     */
    protected function beforeDelete($id)
    {
        // Check if doctor has customers
        $customerModel = new \App\Models\CustomerModel();
        $customerCount = $customerModel->where('doctor_id', $id)->countAllResults();
        
        if ($customerCount > 0) {
            session()->setFlashdata('error', 
                "Δεν μπορείτε να διαγράψετε τον γιατρό γιατί έχει {$customerCount} πελάτες. " .
                "Παρακαλώ μεταφέρετε πρώτα τους πελάτες σε άλλο γιατρό."
            );
            return false;
        }
        
        return true;
    }
}