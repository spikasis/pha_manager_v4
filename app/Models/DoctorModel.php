<?php

namespace App\Models;

/**
 * Doctor Model
 * 
 * Handles doctors table operations for managing doctor records
 * with contact information and pricing
 */
class DoctorModel extends BaseCRUDModel
{
    protected $table = 'doctors';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'doc_name',
        'doc_address', 
        'doc_phone_work',
        'doc_phone_mobile',
        'doc_city',
        'doc_price'
    ];
    
    protected $useTimestamps = false;
    
    // Validation rules
    protected $validationRules = [
        'doc_name' => [
            'label' => 'Όνομα Γιατρού',
            'rules' => 'required|min_length[2]|max_length[255]'
        ],
        'doc_address' => [
            'label' => 'Διεύθυνση',
            'rules' => 'permit_empty|max_length[255]'
        ],
        'doc_phone_work' => [
            'label' => 'Τηλέφωνο Εργασίας',
            'rules' => 'permit_empty|max_length[255]'
        ],
        'doc_phone_mobile' => [
            'label' => 'Κινητό Τηλέφωνο',
            'rules' => 'permit_empty|max_length[10]'
        ],
        'doc_city' => [
            'label' => 'Πόλη',
            'rules' => 'permit_empty|max_length[255]'
        ],
        'doc_price' => [
            'label' => 'Τιμή',
            'rules' => 'permit_empty|decimal|greater_than_equal_to[0]'
        ]
    ];
    
    protected $validationMessages = [
        'doc_name' => [
            'required' => 'Το όνομα του γιατρού είναι υποχρεωτικό',
            'min_length' => 'Το όνομα πρέπει να έχει τουλάχιστον 2 χαρακτήρες',
            'max_length' => 'Το όνομα δεν μπορεί να υπερβαίνει τους 255 χαρακτήρες'
        ],
        'doc_address' => [
            'max_length' => 'Η διεύθυνση δεν μπορεί να υπερβαίνει τους 255 χαρακτήρες'
        ],
        'doc_phone_work' => [
            'max_length' => 'Το τηλέφωνο εργασίας δεν μπορεί να υπερβαίνει τους 255 χαρακτήρες'
        ],
        'doc_phone_mobile' => [
            'max_length' => 'Το κινητό τηλέφωνο δεν μπορεί να υπερβαίνει τους 10 χαρακτήρες'
        ],
        'doc_city' => [
            'max_length' => 'Η πόλη δεν μπορεί να υπερβαίνει τους 255 χαρακτήρες'
        ],
        'doc_price' => [
            'decimal' => 'Η τιμή πρέπει να είναι έγκυρος αριθμός',
            'greater_than_equal_to' => 'Η τιμή δεν μπορεί να είναι αρνητική'
        ]
    ];
    
    // Fields that can be searched
    protected $searchableFields = [
        'doc_name',
        'doc_address',
        'doc_phone_work', 
        'doc_phone_mobile',
        'doc_city'
    ];
    
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

    /**
     * Get active doctors for dropdowns
     */
    public function getActiveDoctors()
    {
        return $this->select('id, name, doc_city, doc_phone')
                   ->where('status', 1)
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }
}