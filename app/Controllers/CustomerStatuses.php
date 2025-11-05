<?php

namespace App\Controllers;

use App\Controllers\BaseCRUD;
use App\Models\CustomerStatusModel;

class CustomerStatuses extends BaseCRUD
{
    protected $modelName = CustomerStatusModel::class;
    protected $viewPath = 'customer_statuses';
    
    public function __construct()
    {
        // Check authentication
        if (!session()->get('logged_in')) {
            redirect()->to('/directlogin')->send();
            exit;
        }
        
        // Initialize model
        $this->model = new CustomerStatusModel();
    }
    
    /**
     * Display customer statuses list
     */
    public function index()
    {
        try {
            $data = [
                'title' => 'Καταστάσεις Πελατών',
                'subtitle' => 'Διαχείριση καταστάσεων και κατηγοριοποίησης πελατών',
                'breadcrumbs' => [
                    'Dashboard' => site_url('dashboard'),
                    'Καταστάσεις Πελατών' => ''
                ],
                'entity_config' => $this->model->getEntityConfig(),
                'display_columns' => $this->model->getDisplayColumns(),
                'can_create' => true,
                'can_edit' => true,
                'can_delete' => true,
                'ajax_url' => site_url('customer-statuses/data'),
                'create_url' => site_url('customer-statuses/create'),
                'edit_url' => site_url('customer-statuses/edit'),
                'delete_url' => site_url('customer-statuses/delete')
            ];
            
            return view('layouts/main', [
                'content' => view($this->viewPath . '/index', $data),
                'title' => $data['title']
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'CustomerStatuses::index - ' . $e->getMessage());
            session()->setFlashdata('error', 'Σφάλμα φόρτωσης καταστάσεων πελατών: ' . $e->getMessage());
            return redirect()->to('dashboard');
        }
    }
    
    /**
     * Create new customer status
     */
    public function create()
    {
        try {
            $data = [
                'title' => 'Νέα Κατάσταση Πελάτη',
                'subtitle' => 'Δημιουργία νέας κατάστασης πελάτη',
                'breadcrumbs' => [
                    'Dashboard' => site_url('dashboard'),
                    'Καταστάσεις Πελατών' => site_url('customer-statuses'),
                    'Νέα Κατάσταση' => ''
                ],
                'entity_config' => $this->model->getEntityConfig(),
                'form_fields' => $this->model->getFormFields(),
                'form_action' => site_url('customer-statuses/store'),
                'cancel_url' => site_url('customer-statuses'),
                'form_data' => [],
                'is_edit' => false
            ];
            
            return view('layouts/main', [
                'content' => view($this->viewPath . '/form', $data),
                'title' => $data['title']
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'CustomerStatuses::create - ' . $e->getMessage());
            session()->setFlashdata('error', 'Σφάλμα φόρτωσης φόρμας: ' . $e->getMessage());
            return redirect()->to('customer-statuses');
        }
    }
    
    /**
     * Store new customer status
     */
    public function store()
    {
        try {
            if (!$this->request->isAJAX() && $this->request->getMethod() !== 'post') {
                throw new \Exception('Μη έγκυρη αίτημα');
            }
            
            $data = $this->request->getPost();
            
            // Validate and save
            if (!$this->model->save($data)) {
                $errors = $this->model->errors();
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'errors' => $errors,
                        'message' => 'Σφάλμα επικύρωσης δεδομένων'
                    ]);
                } else {
                    session()->setFlashdata('errors', $errors);
                    session()->setFlashdata('form_data', $data);
                    return redirect()->back();
                }
            }
            
            $message = 'Η κατάσταση πελάτη δημιουργήθηκε επιτυχώς';
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => $message,
                    'redirect' => site_url('customer-statuses')
                ]);
            } else {
                session()->setFlashdata('success', $message);
                return redirect()->to('customer-statuses');
            }
            
        } catch (\Exception $e) {
            log_message('error', 'CustomerStatuses::store - ' . $e->getMessage());
            
            $errorMsg = 'Σφάλμα αποθήκευσης: ' . $e->getMessage();
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $errorMsg
                ]);
            } else {
                session()->setFlashdata('error', $errorMsg);
                return redirect()->back();
            }
        }
    }
    
    /**
     * Edit customer status
     */
    public function edit($id = null)
    {
        try {
            if (empty($id)) {
                throw new \Exception('Μη έγκυρο ID');
            }
            
            $status = $this->model->find($id);
            if (!$status) {
                throw new \Exception('Η κατάσταση πελάτη δεν βρέθηκε');
            }
            
            $data = [
                'title' => 'Επεξεργασία Κατάστασης Πελάτη',
                'subtitle' => 'Επεξεργασία κατάστασης: ' . $status['name'],
                'breadcrumbs' => [
                    'Dashboard' => site_url('dashboard'),
                    'Καταστάσεις Πελατών' => site_url('customer-statuses'),
                    'Επεξεργασία' => ''
                ],
                'entity_config' => $this->model->getEntityConfig(),
                'form_fields' => $this->model->getFormFields(),
                'form_action' => site_url('customer-statuses/update/' . $id),
                'cancel_url' => site_url('customer-statuses'),
                'form_data' => $status,
                'is_edit' => true,
                'record_id' => $id
            ];
            
            return view('layouts/main', [
                'content' => view($this->viewPath . '/form', $data),
                'title' => $data['title']
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'CustomerStatuses::edit - ' . $e->getMessage());
            session()->setFlashdata('error', 'Σφάλμα φόρτωσης κατάστασης: ' . $e->getMessage());
            return redirect()->to('customer-statuses');
        }
    }
    
    /**
     * Update customer status
     */
    public function update($id = null)
    {
        try {
            if (empty($id)) {
                throw new \Exception('Μη έγκυρο ID');
            }
            
            if (!$this->request->isAJAX() && $this->request->getMethod() !== 'post') {
                throw new \Exception('Μη έγκυρη αίτημα');
            }
            
            $status = $this->model->find($id);
            if (!$status) {
                throw new \Exception('Η κατάσταση πελάτη δεν βρέθηκε');
            }
            
            $data = $this->request->getPost();
            
            // Validate and update
            if (!$this->model->update($id, $data)) {
                $errors = $this->model->errors();
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'errors' => $errors,
                        'message' => 'Σφάλμα επικύρωσης δεδομένων'
                    ]);
                } else {
                    session()->setFlashdata('errors', $errors);
                    session()->setFlashdata('form_data', $data);
                    return redirect()->back();
                }
            }
            
            $message = 'Η κατάσταση πελάτη ενημερώθηκε επιτυχώς';
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => $message,
                    'redirect' => site_url('customer-statuses')
                ]);
            } else {
                session()->setFlashdata('success', $message);
                return redirect()->to('customer-statuses');
            }
            
        } catch (\Exception $e) {
            log_message('error', 'CustomerStatuses::update - ' . $e->getMessage());
            
            $errorMsg = 'Σφάλμα ενημέρωσης: ' . $e->getMessage();
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $errorMsg
                ]);
            } else {
                session()->setFlashdata('error', $errorMsg);
                return redirect()->back();
            }
        }
    }
    
    /**
     * Delete customer status
     */
    public function delete($id = null)
    {
        try {
            if (!$this->request->isAJAX()) {
                throw new \Exception('Μη έγκυρη αίτημα');
            }
            
            if (empty($id)) {
                throw new \Exception('Μη έγκυρο ID');
            }
            
            $status = $this->model->find($id);
            if (!$status) {
                throw new \Exception('Η κατάσταση πελάτη δεν βρέθηκε');
            }
            
            // Check if status is used by customers
            $customers = $this->model->getCustomersByStatus($id);
            if (!empty($customers)) {
                throw new \Exception('Δεν μπορείτε να διαγράψετε αυτήν την κατάσταση. Χρησιμοποιείται από ' . count($customers) . ' πελάτες.');
            }
            
            if (!$this->model->delete($id)) {
                throw new \Exception('Σφάλμα διαγραφής από τη βάση δεδομένων');
            }
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Η κατάσταση πελάτη διαγράφηκε επιτυχώς'
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'CustomerStatuses::delete - ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Σφάλμα διαγραφής: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Show customer status details
     */
    public function show($id = null)
    {
        try {
            if (empty($id)) {
                throw new \Exception('Μη έγκυρο ID');
            }
            
            $status = $this->model->find($id);
            if (!$status) {
                throw new \Exception('Η κατάσταση πελάτη δεν βρέθηκε');
            }
            
            // Get customers using this status
            $customers = $this->model->getCustomersByStatus($id);
            
            $data = [
                'title' => 'Κατάσταση Πελάτη: ' . $status['name'],
                'subtitle' => 'Προβολή στοιχείων κατάστασης πελάτη',
                'breadcrumbs' => [
                    'Dashboard' => site_url('dashboard'),
                    'Καταστάσεις Πελατών' => site_url('customer-statuses'),
                    $status['name'] => ''
                ],
                'status' => $status,
                'customers' => $customers,
                'edit_url' => site_url('customer-statuses/edit/' . $id),
                'back_url' => site_url('customer-statuses')
            ];
            
            return view('layouts/main', [
                'content' => view($this->viewPath . '/show', $data),
                'title' => $data['title']
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'CustomerStatuses::show - ' . $e->getMessage());
            session()->setFlashdata('error', 'Σφάλμα φόρτωσης κατάστασης: ' . $e->getMessage());
            return redirect()->to('customer-statuses');
        }
    }
    
    /**
     * AJAX Data for DataTables
     */
    public function getData()
    {
        try {
            if (!$this->request->isAJAX()) {
                throw new \Exception('Μη έγκυρη αίτημα');
            }
            
            $request = $this->request->getGet();
            
            // DataTables parameters
            $draw = intval($request['draw'] ?? 1);
            $start = intval($request['start'] ?? 0);
            $length = intval($request['length'] ?? 10);
            $searchValue = $request['search']['value'] ?? '';
            $orderColumn = intval($request['order'][0]['column'] ?? 0);
            $orderDir = $request['order'][0]['dir'] ?? 'asc';
            
            // Column mapping
            $columns = ['id', 'name', 'description', 'color', 'is_active'];
            $orderBy = $columns[$orderColumn] ?? 'id';
            
            // Build query
            $builder = $this->model->builder();
            
            // Search functionality
            if (!empty($searchValue)) {
                $builder->groupStart()
                        ->like('name', $searchValue)
                        ->orLike('description', $searchValue)
                        ->groupEnd();
            }
            
            // Total records (without filtering)
            $totalRecords = $this->model->countAllResults(false);
            
            // Filtered records count
            $filteredRecords = $builder->countAllResults(false);
            
            // Get data with pagination and ordering
            $data = $builder->orderBy($orderBy, $orderDir)
                           ->limit($length, $start)
                           ->get()
                           ->getResultArray();
            
            // Format data for DataTables
            $formattedData = [];
            foreach ($data as $row) {
                $actions = '
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="' . site_url('customer-statuses/show/' . $row['id']) . '" 
                           class="btn btn-info" title="Προβολή">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . site_url('customer-statuses/edit/' . $row['id']) . '" 
                           class="btn btn-warning" title="Επεξεργασία">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger delete-btn" 
                                data-id="' . $row['id'] . '" 
                                data-name="' . htmlspecialchars($row['name']) . '" 
                                title="Διαγραφή">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                ';
                
                $colorDisplay = !empty($row['color']) ? 
                    '<span class="badge" style="background-color: ' . $row['color'] . '; color: white;">' . $row['color'] . '</span>' : 
                    '<span class="text-muted">-</span>';
                
                $statusDisplay = $row['is_active'] ? 
                    '<span class="badge badge-success">Ενεργή</span>' : 
                    '<span class="badge badge-secondary">Ανενεργή</span>';
                
                $formattedData[] = [
                    $row['id'],
                    htmlspecialchars($row['name']),
                    htmlspecialchars($row['description'] ?? ''),
                    $colorDisplay,
                    $statusDisplay,
                    $actions
                ];
            }
            
            return $this->response->setJSON([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $formattedData
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'CustomerStatuses::getData - ' . $e->getMessage());
            return $this->response->setJSON([
                'draw' => 1,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Σφάλμα φόρτωσης δεδομένων: ' . $e->getMessage()
            ]);
        }
    }
}