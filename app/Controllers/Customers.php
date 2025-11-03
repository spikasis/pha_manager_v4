<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    protected $customerModel;
    protected $helpers = ['form', 'url'];
    
    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Διαχείριση Πελατών',
            'customers' => $this->customerModel->paginate(20),
            'pager' => $this->customerModel->pager
        ];
        
        return view('customers/index', $data);
    }
    
    public function show($id = null)
    {
        $customer = $this->customerModel->find($id);
        
        if (!$customer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Ο πελάτης δεν βρέθηκε');
        }
        
        $data = [
            'title' => 'Στοιχεία Πελάτη',
            'customer' => $customer
        ];
        
        return view('customers/show', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Νέος Πελάτης',
            'validation' => \Config\Services::validation()
        ];
        
        return view('customers/create', $data);
    }
    
    public function store()
    {
        // Validation rules
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]',
            'phone_home' => 'max_length[255]',
            'phone_mobile' => 'max_length[255]',
            'address' => 'max_length[255]',
            'city' => 'max_length[255]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'birthday' => $this->request->getPost('birthday'),
            'phone_home' => $this->request->getPost('phone_home'),
            'phone_mobile' => $this->request->getPost('phone_mobile'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'amka' => $this->request->getPost('amka'),
            'profession' => $this->request->getPost('profession'),
            'comments' => $this->request->getPost('comments'),
            'status' => 1 // Active by default
        ];
        
        if ($this->customerModel->save($data)) {
            return redirect()->to('/customers')->with('success', 'Ο πελάτης προστέθηκε επιτυχώς');
        } else {
            return redirect()->back()->withInput()->with('error', 'Αποτυχία προσθήκης πελάτη');
        }
    }
    
    public function search()
    {
        $searchTerm = $this->request->getGet('q');
        
        if (empty($searchTerm)) {
            return redirect()->to('/customers');
        }
        
        $data = [
            'title' => 'Αποτελέσματα Αναζήτησης',
            'customers' => $this->customerModel->searchCustomers($searchTerm),
            'search_term' => $searchTerm
        ];
        
        return view('customers/search', $data);
    }
}