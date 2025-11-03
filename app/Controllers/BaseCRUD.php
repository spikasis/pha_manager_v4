<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Base CRUD Controller
 * 
 * This class provides standard CRUD operations that can be extended by specific controllers.
 * It includes DataTables integration, form validation, and consistent error handling.
 */
class BaseCRUD extends BaseController
{
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form', 'url', 'html'];
    
    /**
     * The model instance for database operations
     * Should be set in child controllers
     *
     * @var object
     */
    protected $model;
    
    /**
     * The table name for the current controller
     * Should be set in child controllers
     *
     * @var string
     */
    protected $tableName;
    
    /**
     * View path for the current controller
     * Should be set in child controllers (e.g., 'customers/', 'users/')
     *
     * @var string
     */
    protected $viewPath;
    
    /**
     * Validation rules for create/update operations
     * Should be set in child controllers
     *
     * @var array
     */
    protected $validationRules = [];
    
    /**
     * Fields that should be excluded from mass assignment
     * Common excluded fields (id, created_at, updated_at, etc.)
     *
     * @var array
     */
    protected $excludedFields = ['id', 'created_at', 'updated_at'];
    
    /**
     * Page title for the current controller
     * Should be set in child controllers
     *
     * @var string
     */
    protected $pageTitle;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        
        // Ensure user is authenticated
        if (!session()->get('logged_in')) {
            return redirect()->to('/safe_login.php');
        }
    }

    /**
     * Display a listing of the resource with DataTables integration
     *
     * @return mixed
     */
    public function index()
    {
        // Check if this is an AJAX request for DataTables
        if ($this->request->isAJAX()) {
            return $this->getDataTablesData();
        }
        
        $data = [
            'title' => $this->pageTitle ?? ucfirst($this->tableName),
            'tableName' => $this->tableName,
            'createUrl' => site_url($this->viewPath . 'create'),
            'ajaxUrl' => site_url($this->viewPath . 'index'),
        ];
        
        return view($this->viewPath . 'index', $data);
    }
    
    /**
     * Get data for DataTables AJAX request
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    protected function getDataTablesData()
    {
        $request = service('request');
        
        // DataTables parameters
        $draw = intval($request->getPost('draw'));
        $start = intval($request->getPost('start'));
        $length = intval($request->getPost('length'));
        $search = $request->getPost('search')['value'];
        $order = $request->getPost('order');
        $columns = $request->getPost('columns');
        
        // Get total count
        $totalRecords = $this->model->countAllResults(false);
        
        // Apply search filter
        if (!empty($search)) {
            $this->applySearchFilter($search);
        }
        
        // Get filtered count
        $filteredRecords = $this->model->countAllResults(false);
        
        // Apply ordering
        if (!empty($order)) {
            $columnIndex = $order[0]['column'];
            $columnName = $columns[$columnIndex]['data'];
            $orderDir = $order[0]['dir'];
            
            if (!empty($columnName) && $columnName !== 'actions') {
                $this->model->orderBy($columnName, $orderDir);
            }
        }
        
        // Apply pagination
        $records = $this->model->findAll($length, $start);
        
        // Prepare data for DataTables
        $data = [];
        foreach ($records as $record) {
            $row = $this->formatRowData($record);
            $row['actions'] = $this->generateActionButtons($record['id'] ?? $record[$this->model->primaryKey]);
            $data[] = $row;
        }
        
        $response = [
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];
        
        return $this->response->setJSON($response);
    }
    
    /**
     * Apply search filter to the model
     * Should be overridden in child controllers for specific search logic
     *
     * @param string $search
     */
    protected function applySearchFilter($search)
    {
        // Default search implementation
        // Child controllers should override this method for custom search logic
        if (method_exists($this->model, 'search')) {
            $this->model->search($search);
        }
    }
    
    /**
     * Format row data for DataTables display
     * Should be overridden in child controllers for custom formatting
     *
     * @param array $record
     * @return array
     */
    protected function formatRowData($record)
    {
        // Default implementation - return record as is
        // Child controllers should override this for custom formatting
        return $record;
    }
    
    /**
     * Generate action buttons for each row
     *
     * @param mixed $id
     * @return string
     */
    protected function generateActionButtons($id)
    {
        $viewUrl = site_url($this->viewPath . 'show/' . $id);
        $editUrl = site_url($this->viewPath . 'edit/' . $id);
        $deleteUrl = site_url($this->viewPath . 'delete/' . $id);
        
        return '
            <div class="btn-group" role="group">
                <a href="' . $viewUrl . '" class="btn btn-info btn-sm" title="Προβολή">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="' . $editUrl . '" class="btn btn-warning btn-sm" title="Επεξεργασία">
                    <i class="fas fa-edit"></i>
                </a>
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $id . ')" title="Διαγραφή">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        ';
    }

    /**
     * Show the form for creating a new resource
     *
     * @return mixed
     */
    public function create()
    {
        $data = [
            'title' => 'Δημιουργία ' . ($this->pageTitle ?? ucfirst($this->tableName)),
            'formAction' => site_url($this->viewPath . 'store'),
            'cancelUrl' => site_url($this->viewPath),
            'formData' => [],
            'errors' => []
        ];
        
        return view($this->viewPath . 'create', $data);
    }

    /**
     * Store a newly created resource in storage
     *
     * @return mixed
     */
    public function store()
    {
        if (!$this->validate($this->validationRules)) {
            return $this->create()->with('errors', $this->validator->getErrors());
        }
        
        try {
            $data = $this->getFormData();
            
            if ($this->model->insert($data)) {
                session()->setFlashdata('success', 'Η εγγραφή δημιουργήθηκε επιτυχώς!');
                return redirect()->to($this->viewPath);
            } else {
                session()->setFlashdata('error', 'Σφάλμα κατά τη δημιουργία της εγγραφής!');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            log_message('error', 'Error creating record: ' . $e->getMessage());
            session()->setFlashdata('error', 'Σφάλμα: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource
     *
     * @param mixed $id
     * @return mixed
     */
    public function show($id)
    {
        $record = $this->model->find($id);
        
        if (!$record) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $data = [
            'title' => 'Προβολή ' . ($this->pageTitle ?? ucfirst($this->tableName)),
            'record' => $record,
            'editUrl' => site_url($this->viewPath . 'edit/' . $id),
            'backUrl' => site_url($this->viewPath),
        ];
        
        return view($this->viewPath . 'show', $data);
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param mixed $id
     * @return mixed
     */
    public function edit($id)
    {
        $record = $this->model->find($id);
        
        if (!$record) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $data = [
            'title' => 'Επεξεργασία ' . ($this->pageTitle ?? ucfirst($this->tableName)),
            'formAction' => site_url($this->viewPath . 'update/' . $id),
            'cancelUrl' => site_url($this->viewPath),
            'formData' => $record,
            'errors' => []
        ];
        
        return view($this->viewPath . 'edit', $data);
    }

    /**
     * Update the specified resource in storage
     *
     * @param mixed $id
     * @return mixed
     */
    public function update($id)
    {
        $record = $this->model->find($id);
        
        if (!$record) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        if (!$this->validate($this->validationRules)) {
            return $this->edit($id)->with('errors', $this->validator->getErrors());
        }
        
        try {
            $data = $this->getFormData();
            
            if ($this->model->update($id, $data)) {
                session()->setFlashdata('success', 'Η εγγραφή ενημερώθηκε επιτυχώς!');
                return redirect()->to($this->viewPath);
            } else {
                session()->setFlashdata('error', 'Σφάλμα κατά την ενημέρωση της εγγραφής!');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            log_message('error', 'Error updating record: ' . $e->getMessage());
            session()->setFlashdata('error', 'Σφάλμα: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage
     *
     * @param mixed $id
     * @return mixed
     */
    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to($this->viewPath);
        }
        
        try {
            $record = $this->model->find($id);
            
            if (!$record) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Η εγγραφή δεν βρέθηκε!'
                ]);
            }
            
            if ($this->model->delete($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Η εγγραφή διαγράφηκε επιτυχώς!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Σφάλμα κατά τη διαγραφή της εγγραφής!'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error deleting record: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Σφάλμα: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Get form data from request, excluding specified fields
     *
     * @return array
     */
    protected function getFormData()
    {
        $data = $this->request->getPost();
        
        // Remove excluded fields
        foreach ($this->excludedFields as $field) {
            unset($data[$field]);
        }
        
        return $data;
    }
    
    /**
     * Get validation rules for the current operation
     *
     * @param string $operation
     * @return array
     */
    protected function getValidationRules($operation = 'create')
    {
        return $this->validationRules;
    }
}