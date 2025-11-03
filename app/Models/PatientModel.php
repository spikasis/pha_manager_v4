<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false; // No soft deletes in original schema
    
    protected $allowedFields = [
        'name',
        'birthday',
        'phone_home',
        'phone_mobile',
        'address',
        'city',
        'vat_id',
        'insurance',
        'vivliario',
        'old_user',
        'selling_point',
        'status',
        'doctor',
        'first_visit',
        'first_fit',
        'guarantee_end',
        'ha_price',
        'customer_id',
        'profession',
        'comments',
        'debt_flag',
        'amka',
        'pending'
    ];
    
    // Validation rules for hearing aid customers
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[255]',
        'birthday' => 'valid_date',
        'phone_home' => 'max_length[255]',
        'phone_mobile' => 'max_length[255]',
        'address' => 'max_length[255]',
        'city' => 'max_length[255]',
        'vat_id' => 'integer|max_length[10]',
        'amka' => 'max_length[11]'
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'Το όνομα του πελάτη είναι υποχρεωτικό.',
            'min_length' => 'Το όνομα πρέπει να έχει τουλάχιστον 2 χαρακτήρες.'
        ],
        'birthday' => [
            'valid_date' => 'Η ημερομηνία γέννησης δεν είναι έγκυρη.'
        ]
    ];
    
    // No timestamps in original schema
    protected $useTimestamps = false;
    
    /**
     * Get all active customers
     */
    public function getActiveCustomers()
    {
        return $this->where('status', 1)
                    ->findAll();
    }
    
    /**
     * Search customers by name or phone
     */
    public function searchCustomers($searchTerm)
    {
        return $this->groupStart()
                        ->like('name', $searchTerm)
                        ->orLike('phone_home', $searchTerm)
                        ->orLike('phone_mobile', $searchTerm)
                        ->orLike('amka', $searchTerm)
                        ->orLike('customer_id', $searchTerm)
                    ->groupEnd()
                    ->findAll();
    }
    
    /**
     * Get customers by status
     */
    public function getCustomersByStatus($status)
    {
        return $this->where('status', $status)->findAll();
    }
    
    /**
     * Get customers count by status
     */
    public function getCustomerCountByStatus()
    {
        return [
            'active' => $this->where('status', 1)->countAllResults(),
            'inactive' => $this->where('status', 2)->countAllResults(),
            'pending' => $this->where('pending IS NOT NULL')->countAllResults()
        ];
    }
    
    /**
     * Get customers with debt flag
     */
    public function getCustomersWithDebt()
    {
        return $this->where('debt_flag', 1)->findAll();
    }
    
    /**
     * Get customers by doctor
     */
    public function getCustomersByDoctor($doctorId)
    {
        return $this->where('doctor', $doctorId)->findAll();
    }
    
    /**
     * Get customers by selling point
     */
    public function getCustomersBySellingPoint($sellingPointId)
    {
        return $this->where('selling_point', $sellingPointId)->findAll();
    }
    
    /**
     * Get customers with upcoming guarantee expiration
     */
    public function getCustomersWithExpiringGuarantee($days = 30)
    {
        $futureDate = date('Y-m-d', strtotime("+$days days"));
        return $this->where('guarantee_end <=', $futureDate)
                    ->where('guarantee_end >=', date('Y-m-d'))
                    ->findAll();
    }
    
    /**
     * Get customer statistics for dashboard
     */
    public function getDashboardStats()
    {
        $total = $this->countAllResults();
        $active = $this->where('status', 1)->countAllResults();
        $withDebt = $this->where('debt_flag', 1)->countAllResults();
        $pending = $this->where('pending IS NOT NULL')->countAllResults();
        
        return [
            'total_customers' => $total,
            'active_customers' => $active,
            'customers_with_debt' => $withDebt,
            'pending_customers' => $pending
        ];
    }
}