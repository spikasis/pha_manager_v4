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
     * Get doctors for select dropdown
     */
    public function getForSelect(): array
    {
        return $this->select('id, doc_name')
                    ->where('doc_name IS NOT NULL')
                    ->where('doc_name !=', '')
                    ->where('doc_name !=', 'NoDoctor')
                    ->orderBy('doc_name', 'ASC')
                    ->findAll();
    }
    
    /**
     * Get doctor statistics
     */
    public function getStatistics(): array
    {
        $stats = [];
        
        // Total doctors
        $stats['total'] = $this->countAllResults();
        
        // Active doctors (not NoDoctor and have name)
        $stats['active'] = $this->where('doc_name IS NOT NULL')
                               ->where('doc_name !=', '')
                               ->where('doc_name !=', 'NoDoctor')
                               ->countAllResults(false);
        
        // Doctors with complete contact info
        $stats['complete_contact'] = $this->where('doc_name IS NOT NULL')
                                         ->where('doc_address IS NOT NULL')
                                         ->where('doc_phone_mobile !=', '')
                                         ->countAllResults(false);
        
        // Doctors by city
        $stats['by_city'] = $this->select('doc_city, COUNT(*) as count')
                                ->where('doc_city IS NOT NULL')
                                ->where('doc_city !=', '')
                                ->groupBy('doc_city')
                                ->orderBy('count', 'DESC')
                                ->limit(5)
                                ->findAll();
        
        // Average price
        $avgPrice = $this->select('AVG(doc_price) as avg_price')
                        ->where('doc_price IS NOT NULL')
                        ->where('doc_price >', 0)
                        ->first();
        $stats['avg_price'] = $avgPrice ? round($avgPrice['avg_price'], 2) : 0;
        
        return $stats;
    }
    
    /**
     * Get doctor with customer count
     */
    public function getDoctorWithCustomers(int $id): ?array
    {
        $doctor = $this->find($id);
        if (!$doctor) {
            return null;
        }
        
        // Get customer count for this doctor
        $customerModel = new \App\Models\CustomerModel();
        $customerCount = $customerModel->where('doctor_id', $id)->countAllResults();
        
        $doctor['customer_count'] = $customerCount;
        
        return $doctor;
    }
    
    /**
     * Get related customers for a doctor
     */
    public function getRelatedCustomers(int $doctorId, int $limit = 10): array
    {
        $customerModel = new \App\Models\CustomerModel();
        
        return $customerModel->select('id, surname, name, phone')
                           ->where('doctor_id', $doctorId)
                           ->orderBy('surname', 'ASC')
                           ->limit($limit)
                           ->findAll();
    }
    
    /**
     * Legacy methods for backward compatibility
     */
    public function getAllDoctors()
    {
        return $this->orderBy('doc_name', 'ASC')->findAll();
    }
    
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
    
    public function getDoctorsByCity($city)
    {
        return $this->where('doc_city', $city)
                    ->orderBy('doc_name', 'ASC')
                    ->findAll();
    }
    
    public function getDoctorWithCustomerCount($id)
    {
        return $this->getDoctorWithCustomers($id);
    }
    
    public function getDashboardStats()
    {
        return $this->getStatistics();
    }
    
    public function getActiveDoctors()
    {
        return $this->getForSelect();
    }
}