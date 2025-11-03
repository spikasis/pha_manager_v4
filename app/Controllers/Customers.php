<?php

namespace App\Controllers;

use App\Controllers\BaseCRUD;
use App\Models\CustomerModel;
use App\Models\DoctorModel;

class Customers extends BaseCRUD
{
    protected $customerModel;
    protected $doctorModel;
    protected $model;
    protected $tableName = 'customers';
    protected $viewPath = 'customers/';
    protected $pageTitle = 'Πελάτες';
    
    // Validation rules for BaseCRUD
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[255]',
        'phone_home' => 'permit_empty|max_length[255]',
        'phone_mobile' => 'permit_empty|max_length[255]',
        'address' => 'permit_empty|max_length[255]',
        'city' => 'permit_empty|max_length[255]',
        'vat_id' => 'permit_empty|integer',
        'insurance' => 'permit_empty|integer',
        'doctor' => 'permit_empty|integer',
        'ha_price' => 'permit_empty|decimal',
        'amka' => 'permit_empty|max_length[11]',
        'birthday' => 'permit_empty|valid_date',
        'first_visit' => 'permit_empty|valid_date',
        'first_fit' => 'permit_empty|valid_date',
        'guarantee_end' => 'permit_empty|valid_date',
    ];

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->doctorModel = new DoctorModel();
        $this->model = $this->customerModel; // For BaseCRUD compatibility
    }

    public function index()
    {
        // Get search and filter parameters
        $search = $this->request->getGet('search');
        $filters = [
            'city' => $this->request->getGet('city'),
            'status' => $this->request->getGet('status'),
            'doctor_id' => $this->request->getGet('doctor_id')
        ];

        // Handle export
        $export = $this->request->getGet('export');
        if ($export) {
            return $this->exportCustomers($export, $search, $filters);
        }

        // Get customers with search and filters
        $customers = $this->customerModel->getCustomersWithSearch($search, $filters, 20);
        
        // Get statistics
        $stats = $this->customerModel->getCustomerStatistics($search, $filters);
        
        // Get data for filters
        $cities = $this->customerModel->getDistinctCities();
        $doctors = $this->doctorModel->getActiveDoctors();

        $data = [
            'title' => 'Διαχείριση Πελατών',
            'customers' => $customers['data'] ?? [],
            'pager' => $customers['pager'] ?? null,
            'search' => $search,
            'filters' => $filters,
            'stats' => $stats,
            'cities' => $cities,
            'doctors' => $doctors
        ];

        return view('customers/index', $data);
    }

    public function show($id = null)
    {
        $customer = $this->customerModel->getCustomerWithDetails($id);
        
        if (!$customer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Ο πελάτης δεν βρέθηκε');
        }

        $data = [
            'title' => 'Προφίλ Πελάτη - ' . $customer['name'],
            'customer' => $customer
        ];

        return view('customers/show', $data);
    }

    public function create()
    {
        $doctors = $this->doctorModel->findAll();
        
        $data = [
            'title' => 'Νέος Πελάτης',
            'doctors' => $doctors,
            'customer' => null,
            'validation' => \Config\Services::validation()
        ];

        return view('customers/create', $data);
    }

    public function store()
    {
        $rules = $this->customerModel->getCustomerValidationRules();
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->getCustomerDataFromRequest();
        
        try {
            $customerId = $this->customerModel->insert($data);
            
            session()->setFlashdata('success', 'Ο πελάτης δημιουργήθηκε επιτυχώς!');
            return redirect()->to(base_url('customers/' . $customerId));
            
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Σφάλμα κατά τη δημιουργία του πελάτη: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id = null)
    {
        $customer = $this->customerModel->find($id);
        
        if (!$customer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Ο πελάτης δεν βρέθηκε');
        }

        $doctors = $this->doctorModel->findAll();
        
        $data = [
            'title' => 'Επεξεργασία Πελάτη - ' . $customer['name'],
            'customer' => $customer,
            'doctors' => $doctors,
            'validation' => \Config\Services::validation()
        ];

        return view('customers/edit', $data);
    }

    public function update($id = null)
    {
        $customer = $this->customerModel->find($id);
        
        if (!$customer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Ο πελάτης δεν βρέθηκε');
        }

        $rules = $this->customerModel->getCustomerValidationRules($id);
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->getCustomerDataFromRequest();
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        try {
            $this->customerModel->update($id, $data);
            
            session()->setFlashdata('success', 'Ο πελάτης ενημερώθηκε επιτυχώς!');
            return redirect()->to(base_url('customers/' . $id));
            
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Σφάλμα κατά την ενημέρωση του πελάτη: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function delete($id = null)
    {
        $customer = $this->customerModel->find($id);
        
        if (!$customer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Ο πελάτης δεν βρέθηκε');
        }

        try {
            // Soft delete by setting status to 0
            $this->customerModel->update($id, [
                'status' => 0,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            session()->setFlashdata('success', 'Ο πελάτης απενεργοποιήθηκε επιτυχώς!');
            
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Σφάλμα κατά την απενεργοποίηση του πελάτη: ' . $e->getMessage());
        }

        return redirect()->to(base_url('customers'));
    }

    public function search()
    {
        $searchTerm = $this->request->getGet('q');
        
        if (empty($searchTerm)) {
            return redirect()->to('/customers');
        }
        
        // Redirect to index with search parameter
        return redirect()->to('/customers?search=' . urlencode($searchTerm));
    }

    private function getCustomerDataFromRequest()
    {
        return [
            'name' => $this->request->getPost('name'),
            'father_name' => $this->request->getPost('father_name'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'postal_code' => $this->request->getPost('postal_code'),
            'phone_mobile' => $this->request->getPost('phone_mobile'),
            'phone_landline' => $this->request->getPost('phone_landline'),
            'email' => $this->request->getPost('email'),
            'birth_date' => $this->request->getPost('birth_date') ?: null,
            'amka' => $this->request->getPost('amka'),
            'amka_expire_date' => $this->request->getPost('amka_expire_date') ?: null,
            'identity_number' => $this->request->getPost('identity_number'),
            'identity_expire_date' => $this->request->getPost('identity_expire_date') ?: null,
            'doctor_id' => $this->request->getPost('doctor_id') ?: null,
            'insurance_id' => $this->request->getPost('insurance_id') ?: null,
            'notes' => $this->request->getPost('notes'),
            'status' => $this->request->getPost('status') ? 1 : 0
        ];
    }

    private function exportCustomers($format, $search = null, $filters = [])
    {
        // Get all customers matching criteria (no pagination for export)
        $customers = $this->customerModel->getCustomersWithSearch($search, $filters, null);
        
        if ($format === 'excel') {
            return $this->exportToExcel($customers['data'] ?? []);
        } elseif ($format === 'pdf') {
            return $this->exportToPdf($customers['data'] ?? []);
        }
        
        return redirect()->back();
    }

    private function exportToExcel($customers)
    {
        // Simplified Excel export - would need PhpSpreadsheet for full implementation
        $filename = 'customers_' . date('Y-m-d') . '.csv';
        
        $output = fopen('php://output', 'w');
        
        // Set headers for file download
        header('Content-Type: application/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // BOM for UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Headers
        fputcsv($output, [
            'ID', 'Όνομα', 'Πατρώνυμο', 'Διεύθυνση', 'Πόλη', 'Τηλέφωνο Κινητό', 
            'Τηλέφωνο Σταθερό', 'Email', 'ΑΜΚΑ', 'Κατάσταση', 'Γιατρός'
        ]);
        
        // Data rows
        foreach ($customers as $customer) {
            fputcsv($output, [
                $customer['id'],
                $customer['name'],
                $customer['father_name'] ?? '',
                $customer['address'] ?? '',
                $customer['city'] ?? '',
                $customer['phone_mobile'] ?? '',
                $customer['phone_landline'] ?? '',
                $customer['email'] ?? '',
                $customer['amka'] ?? '',
                $customer['status'] ? 'Ενεργός' : 'Ανενεργός',
                $customer['doctor_name'] ?? ''
            ]);
        }
        
        fclose($output);
        exit;
    }

    private function exportToPdf($customers)
    {
        // PDF export would need a PDF library like TCPDF or mPDF
        // For now, return a simple response
        session()->setFlashdata('info', 'Η εξαγωγή PDF θα υλοποιηθεί σύντομα.');
        return redirect()->back();
    }
}