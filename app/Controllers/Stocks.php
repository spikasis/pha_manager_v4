<?php

namespace App\Controllers;

use App\Controllers\BaseCRUD;
use App\Models\StockModel;

class Stocks extends BaseCRUD
{
    protected $modelName = StockModel::class;
    protected $viewPath = 'stocks';
    
    public function __construct()
    {
        // Check authentication
        if (!session()->get('logged_in')) {
            redirect()->to('/directlogin')->send();
            exit;
        }
        
        // Initialize model
        $this->model = new StockModel();
    }
    
    /**
     * Display stocks list with inventory overview
     */
    public function index()
    {
        try {
            // Get inventory statistics
            $inventoryStats = $this->model->getInventoryStats();
            $lowStockItems = $this->model->getLowStockItems();
            
            $data = [
                'title' => 'Διαχείριση Αποθεμάτων',
                'subtitle' => 'Διαχείριση προϊόντων και αποθεμάτων',
                'breadcrumbs' => [
                    'Dashboard' => site_url('dashboard'),
                    'Αποθέματα' => ''
                ],
                'entity_config' => $this->model->getEntityConfig(),
                'display_columns' => $this->model->getDisplayColumns(),
                'inventory_stats' => $inventoryStats,
                'low_stock_items' => $lowStockItems,
                'can_create' => true,
                'can_edit' => true,
                'can_delete' => true,
                'ajax_url' => site_url('stocks/data'),
                'create_url' => site_url('stocks/create'),
                'edit_url' => site_url('stocks/edit'),
                'delete_url' => site_url('stocks/delete'),
                'low_stock_url' => site_url('stocks/low-stock')
            ];
            
            return view('layouts/main', [
                'content' => view($this->viewPath . '/index', $data),
                'title' => $data['title']
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Stocks::index - ' . $e->getMessage());
            session()->setFlashdata('error', 'Σφάλμα φόρτωσης αποθεμάτων: ' . $e->getMessage());
            return redirect()->to('dashboard');
        }
    }
    
    /**
     * Create new stock item
     */
    public function create()
    {
        try {
            $data = [
                'title' => 'Νέο Προϊόν Αποθήκης',
                'subtitle' => 'Προσθήκη νέου προϊόντος στην αποθήκη',
                'breadcrumbs' => [
                    'Dashboard' => site_url('dashboard'),
                    'Αποθέματα' => site_url('stocks'),
                    'Νέο Προϊόν' => ''
                ],
                'entity_config' => $this->model->getEntityConfig(),
                'form_fields' => $this->model->getFormFields(),
                'form_action' => site_url('stocks/store'),
                'cancel_url' => site_url('stocks'),
                'form_data' => [],
                'is_edit' => false
            ];
            
            return view('layouts/main', [
                'content' => view($this->viewPath . '/form', $data),
                'title' => $data['title']
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Stocks::create - ' . $e->getMessage());
            session()->setFlashdata('error', 'Σφάλμα φόρτωσης φόρμας: ' . $e->getMessage());
            return redirect()->to('stocks');
        }
    }
    
    /**
     * Store new stock item
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
            
            $message = 'Το προϊόν προστέθηκε επιτυχώς στην αποθήκη';
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => $message,
                    'redirect' => site_url('stocks')
                ]);
            } else {
                session()->setFlashdata('success', $message);
                return redirect()->to('stocks');
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Stocks::store - ' . $e->getMessage());
            
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
     * Edit stock item
     */
    public function edit($id = null)
    {
        try {
            if (empty($id)) {
                throw new \Exception('Μη έγκυρο ID');
            }
            
            $stock = $this->model->find($id);
            if (!$stock) {
                throw new \Exception('Το προϊόν δεν βρέθηκε');
            }
            
            $data = [
                'title' => 'Επεξεργασία Προϊόντος',
                'subtitle' => 'Επεξεργασία: ' . $stock['name'],
                'breadcrumbs' => [
                    'Dashboard' => site_url('dashboard'),
                    'Αποθέματα' => site_url('stocks'),
                    'Επεξεργασία' => ''
                ],
                'entity_config' => $this->model->getEntityConfig(),
                'form_fields' => $this->model->getFormFields(),
                'form_action' => site_url('stocks/update/' . $id),
                'cancel_url' => site_url('stocks'),
                'form_data' => $stock,
                'is_edit' => true,
                'record_id' => $id,
                'needs_restocking' => $this->model->needsRestocking($id)
            ];
            
            return view('layouts/main', [
                'content' => view($this->viewPath . '/form', $data),
                'title' => $data['title']
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Stocks::edit - ' . $e->getMessage());
            session()->setFlashdata('error', 'Σφάλμα φόρτωσης προϊόντος: ' . $e->getMessage());
            return redirect()->to('stocks');
        }
    }
    
    /**
     * Update stock item
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
            
            $stock = $this->model->find($id);
            if (!$stock) {
                throw new \Exception('Το προϊόν δεν βρέθηκε');
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
            
            $message = 'Το προϊόν ενημερώθηκε επιτυχώς';
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => $message,
                    'redirect' => site_url('stocks')
                ]);
            } else {
                session()->setFlashdata('success', $message);
                return redirect()->to('stocks');
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Stocks::update - ' . $e->getMessage());
            
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
     * Delete stock item
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
            
            $stock = $this->model->find($id);
            if (!$stock) {
                throw new \Exception('Το προϊόν δεν βρέθηκε');
            }
            
            // Check if item has quantity (optional warning)
            if ($stock['quantity'] > 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Δεν μπορείτε να διαγράψετε προϊόν με υπάρχουσα ποσότητα (' . $stock['quantity'] . ' τεμάχια). Μηδενίστε πρώτα την ποσότητα.'
                ]);
            }
            
            if (!$this->model->delete($id)) {
                throw new \Exception('Σφάλμα διαγραφής από τη βάση δεδομένων');
            }
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Το προϊόν διαγράφηκε επιτυχώς'
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Stocks::delete - ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Σφάλμα διαγραφής: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Show stock item details
     */
    public function show($id = null)
    {
        try {
            if (empty($id)) {
                throw new \Exception('Μη έγκυρο ID');
            }
            
            $stock = $this->model->find($id);
            if (!$stock) {
                throw new \Exception('Το προϊόν δεν βρέθηκε');
            }
            
            // Calculate additional info
            $profitMargin = 0;
            if ($stock['cost_price'] > 0 && $stock['unit_price'] > 0) {
                $profitMargin = (($stock['unit_price'] - $stock['cost_price']) / $stock['cost_price']) * 100;
            }
            
            $totalValue = $stock['cost_price'] * $stock['quantity'];
            $needsRestocking = $this->model->needsRestocking($id);
            
            $data = [
                'title' => 'Προϊόν: ' . $stock['name'],
                'subtitle' => 'Προβολή στοιχείων προϊόντος αποθήκης',
                'breadcrumbs' => [
                    'Dashboard' => site_url('dashboard'),
                    'Αποθέματα' => site_url('stocks'),
                    $stock['name'] => ''
                ],
                'stock' => $stock,
                'profit_margin' => round($profitMargin, 2),
                'total_value' => round($totalValue, 2),
                'needs_restocking' => $needsRestocking,
                'edit_url' => site_url('stocks/edit/' . $id),
                'back_url' => site_url('stocks'),
                'quantity_update_url' => site_url('stocks/update-quantity/' . $id)
            ];
            
            return view('layouts/main', [
                'content' => view($this->viewPath . '/show', $data),
                'title' => $data['title']
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Stocks::show - ' . $e->getMessage());
            session()->setFlashdata('error', 'Σφάλμα φόρτωσης προϊόντος: ' . $e->getMessage());
            return redirect()->to('stocks');
        }
    }
    
    /**
     * Update quantity (AJAX)
     */
    public function updateQuantity($id = null)
    {
        try {
            if (!$this->request->isAJAX()) {
                throw new \Exception('Μη έγκυρη αίτημα');
            }
            
            if (empty($id)) {
                throw new \Exception('Μη έγκυρο ID');
            }
            
            $stock = $this->model->find($id);
            if (!$stock) {
                throw new \Exception('Το προϊόν δεν βρέθηκε');
            }
            
            $newQuantity = intval($this->request->getPost('quantity'));
            $reason = $this->request->getPost('reason') ?: 'Χειροκίνητη ενημέρωση';
            
            if ($newQuantity < 0) {
                throw new \Exception('Η ποσότητα δεν μπορεί να είναι αρνητική');
            }
            
            if (!$this->model->updateQuantity($id, $newQuantity, $reason)) {
                throw new \Exception('Σφάλμα ενημέρωσης ποσότητας');
            }
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Η ποσότητα ενημερώθηκε επιτυχώς',
                'new_quantity' => $newQuantity,
                'needs_restocking' => $this->model->needsRestocking($id)
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Stocks::updateQuantity - ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Σφάλμα ενημέρωσης: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Low stock report
     */
    public function lowStock()
    {
        try {
            $lowStockItems = $this->model->getLowStockItems();
            
            $data = [
                'title' => 'Αναφορά Χαμηλού Αποθέματος',
                'subtitle' => 'Προϊόντα που χρειάζονται αναπλήρωση',
                'breadcrumbs' => [
                    'Dashboard' => site_url('dashboard'),
                    'Αποθέματα' => site_url('stocks'),
                    'Χαμηλό Απόθεμα' => ''
                ],
                'low_stock_items' => $lowStockItems,
                'back_url' => site_url('stocks')
            ];
            
            return view('layouts/main', [
                'content' => view($this->viewPath . '/low-stock', $data),
                'title' => $data['title']
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Stocks::lowStock - ' . $e->getMessage());
            session()->setFlashdata('error', 'Σφάλμα φόρτωσης αναφοράς: ' . $e->getMessage());
            return redirect()->to('stocks');
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
            $columns = ['id', 'name', 'sku', 'category', 'manufacturer', 'quantity', 'unit_price', 'location', 'is_active'];
            $orderBy = $columns[$orderColumn] ?? 'id';
            
            // Build query
            $builder = $this->model->builder();
            
            // Search functionality
            if (!empty($searchValue)) {
                $builder->groupStart()
                        ->like('name', $searchValue)
                        ->orLike('sku', $searchValue)
                        ->orLike('category', $searchValue)
                        ->orLike('manufacturer', $searchValue)
                        ->orLike('location', $searchValue)
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
                        <a href="' . site_url('stocks/show/' . $row['id']) . '" 
                           class="btn btn-info" title="Προβολή">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . site_url('stocks/edit/' . $row['id']) . '" 
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
                
                // Format quantity with low stock indicator
                $quantityDisplay = $row['quantity'];
                if ($this->model->needsRestocking($row['id'])) {
                    $quantityDisplay = '<span class="badge badge-warning">' . $row['quantity'] . '</span>';
                } elseif ($row['quantity'] == 0) {
                    $quantityDisplay = '<span class="badge badge-danger">' . $row['quantity'] . '</span>';
                } else {
                    $quantityDisplay = '<span class="badge badge-success">' . $row['quantity'] . '</span>';
                }
                
                $priceDisplay = $row['unit_price'] > 0 ? '€' . number_format($row['unit_price'], 2) : '-';
                
                $statusDisplay = $row['is_active'] ? 
                    '<span class="badge badge-success">Ενεργό</span>' : 
                    '<span class="badge badge-secondary">Ανενεργό</span>';
                
                $formattedData[] = [
                    $row['id'],
                    htmlspecialchars($row['name']),
                    htmlspecialchars($row['sku'] ?? ''),
                    htmlspecialchars($row['category'] ?? ''),
                    htmlspecialchars($row['manufacturer'] ?? ''),
                    $quantityDisplay,
                    $priceDisplay,
                    htmlspecialchars($row['location'] ?? ''),
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
            log_message('error', 'Stocks::getData - ' . $e->getMessage());
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