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
            'title' => 'Patients Management',
            'patients' => $this->patientModel->paginate(10),
            'pager' => $this->patientModel->pager
        ];
        
        return view('patients/index', $data);
    }
    
    public function show($id = null)
    {
        $patient = $this->patientModel->find($id);
        
        if (!$patient) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Patient not found');
        }
        
        $data = [
            'title' => 'Patient Details',
            'patient' => $patient
        ];
        
        return view('patients/show', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Add New Patient',
            'validation' => \Config\Services::validation()
        ];
        
        return view('patients/create', $data);
    }
    
    public function store()
    {
        // Validation rules
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|valid_email|is_unique[patients.email]',
            'phone' => 'required|min_length[10]|max_length[15]',
            'birth_date' => 'required|valid_date'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'birth_date' => $this->request->getPost('birth_date'),
            'address' => $this->request->getPost('address'),
            'medical_history' => $this->request->getPost('medical_history'),
            'status' => 'active'
        ];
        
        if ($this->patientModel->save($data)) {
            return redirect()->to('/patients')->with('success', 'Patient added successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add patient');
        }
    }
    
    public function edit($id = null)
    {
        $patient = $this->patientModel->find($id);
        
        if (!$patient) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Patient not found');
        }
        
        $data = [
            'title' => 'Edit Patient',
            'patient' => $patient,
            'validation' => \Config\Services::validation()
        ];
        
        return view('patients/edit', $data);
    }
    
    public function update($id = null)
    {
        $patient = $this->patientModel->find($id);
        
        if (!$patient) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Patient not found');
        }
        
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
            'email' => "required|valid_email|is_unique[patients.email,id,{$id}]",
            'phone' => 'required|min_length[10]|max_length[15]',
            'birth_date' => 'required|valid_date'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'birth_date' => $this->request->getPost('birth_date'),
            'address' => $this->request->getPost('address'),
            'medical_history' => $this->request->getPost('medical_history')
        ];
        
        if ($this->patientModel->update($id, $data)) {
            return redirect()->to('/patients')->with('success', 'Patient updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update patient');
        }
    }
    
    public function delete($id = null)
    {
        $patient = $this->patientModel->find($id);
        
        if (!$patient) {
            return redirect()->to('/patients')->with('error', 'Patient not found');
        }
        
        if ($this->patientModel->delete($id)) {
            return redirect()->to('/patients')->with('success', 'Patient deleted successfully');
        } else {
            return redirect()->to('/patients')->with('error', 'Failed to delete patient');
        }
    }
    
    public function search()
    {
        $searchTerm = $this->request->getGet('q');
        
        if (empty($searchTerm)) {
            return redirect()->to('/patients');
        }
        
        $data = [
            'title' => 'Search Results',
            'patients' => $this->patientModel->searchPatients($searchTerm),
            'search_term' => $searchTerm
        ];
        
        return view('patients/search', $data);
    }
}