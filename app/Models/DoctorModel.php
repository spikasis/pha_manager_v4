<?php

namespace App\Models;

use CodeIgniter\Model;

class DoctorModel extends Model
{
    protected $table = 'doctors';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'doc_name',
        'doc_address',
        'doc_phone_work',
        'doc_phone_mobile',
        'doc_city',
        'doc_price'
    ];
    
    // Validation rules for doctors
    protected $validationRules = [
        'doc_name' => 'required|min_length[2]|max_length[255]',
        'doc_phone_work' => 'max_length[255]',
        'doc_phone_mobile' => 'required|max_length[10]',
        'doc_address' => 'max_length[255]',
        'doc_city' => 'max_length[255]',
        'doc_price' => 'decimal|max_length[5,2]'
    ];
    
    protected $validationMessages = [
        'doc_name' => [
            'required' => 'Το όνομα του γιατρού είναι υποχρεωτικό.',
            'min_length' => 'Το όνομα πρέπει να έχει τουλάχιστον 2 χαρακτήρες.'
        ],
        'doc_phone_mobile' => [
            'required' => 'Το κινητό τηλέφωνο είναι υποχρεωτικό.'
        ]
    ];
    
    // No timestamps in original schema
    protected $useTimestamps = false;
    
    /**
     * Get all doctors
     */
    public function getAllDoctors()
    {
        return $this->orderBy('doc_name', 'ASC')->findAll();
    }
    
    /**
     * Search doctors by name or city
     */
    public function searchDoctors($searchTerm)
    {
        return $this->groupStart()
                        ->like('doc_name', $searchTerm)
                        ->orLike('doc_city', $searchTerm)
                        ->orLike('doc_phone_work', $searchTerm)
                        ->orLike('doc_phone_mobile', $searchTerm)
                    ->groupEnd()
                    ->findAll();
    }
    
    /**
     * Get doctors by city
     */
    public function getDoctorsByCity($city)
    {
        return $this->where('doc_city', $city)
                    ->orderBy('doc_name', 'ASC')
                    ->findAll();
    }
    
    /**
     * Get doctor with customer count
     */
    public function getDoctorWithCustomerCount($id)
    {
        $doctor = $this->find($id);
        if ($doctor) {
            $customerModel = new \App\Models\CustomerModel();
            $doctor['customer_count'] = $customerModel->where('doctor', $id)->countAllResults();
        }
        return $doctor;
    }
    
    /**
     * Get doctors statistics for dashboard
     */
    public function getDashboardStats()
    {
        $total = $this->countAllResults();
        $cities = $this->select('doc_city')
                      ->distinct()
                      ->where('doc_city IS NOT NULL')
                      ->findAll();
        
        return [
            'total_doctors' => $total,
            'cities_count' => count($cities)
        ];
    }
}