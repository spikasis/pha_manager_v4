<?php

namespace App\Models;

use App\Models\BaseCRUDModel;

class CustomerModel extends BaseCRUDModel
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
     * Get dashboard statistics
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

    /**
     * Get customers with search and filters
     */
    public function getCustomersWithSearch($search = null, $filters = [], $perPage = 20)
    {
        $builder = $this->db->table('customers c');
        $builder->select('c.*, d.name as doctor_name');
        $builder->join('doctors d', 'd.id = c.doctor_id', 'left');
        
        // Apply search
        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('c.name', $search);
            $builder->orLike('c.phone_mobile', $search);
            $builder->orLike('c.phone_landline', $search);
            $builder->orLike('c.email', $search);
            $builder->orLike('c.amka', $search);
            $builder->orLike('c.city', $search);
            $builder->groupEnd();
        }
        
        // Apply filters
        if (!empty($filters['city'])) {
            $builder->where('c.city', $filters['city']);
        }
        
        if (isset($filters['status']) && $filters['status'] !== '') {
            $builder->where('c.status', $filters['status']);
        }
        
        if (!empty($filters['doctor_id'])) {
            $builder->where('c.doctor_id', $filters['doctor_id']);
        }
        
        $builder->orderBy('c.created_at', 'DESC');
        
        if ($perPage) {
            $request = \Config\Services::request();
            $page = $request->getVar('page') ?? 1;
            
            // Get total count
            $totalBuilder = clone $builder;
            $total = $totalBuilder->countAllResults();
            
            // Get paginated data
            $offset = ($page - 1) * $perPage;
            $data = $builder->limit($perPage, $offset)->get()->getResultArray();
            
            // Create pager manually
            $pager = \Config\Services::pager();
            $pager->store('default', $page, $perPage, $total);
            
            return [
                'data' => $data,
                'pager' => $pager
            ];
        } else {
            return [
                'data' => $builder->get()->getResultArray(),
                'pager' => null
            ];
        }
    }

    /**
     * Get customer statistics
     */
    public function getCustomerStatistics($search = null, $filters = [])
    {
        $builder = $this->db->table('customers c');
        
        // Apply same filters as main query
        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('c.name', $search);
            $builder->orLike('c.phone_mobile', $search);
            $builder->orLike('c.phone_landline', $search);
            $builder->orLike('c.email', $search);
            $builder->orLike('c.amka', $search);
            $builder->orLike('c.city', $search);
            $builder->groupEnd();
        }
        
        if (!empty($filters['city'])) {
            $builder->where('c.city', $filters['city']);
        }
        
        if (!empty($filters['doctor_id'])) {
            $builder->where('c.doctor_id', $filters['doctor_id']);
        }
        
        $total = $builder->countAllResults(false);
        
        // Active customers
        $activeBuilder = clone $builder;
        $active = $activeBuilder->where('c.status', 1)->countAllResults();
        
        // Customers with debt (assuming debt_flag exists)
        $debtBuilder = clone $builder;
        $withDebt = $debtBuilder->where('c.debt_flag', 1)->countAllResults();
        
        // New customers (last 30 days)
        $newBuilder = clone $builder;
        $newCustomers = $newBuilder->where('c.created_at >=', date('Y-m-d', strtotime('-30 days')))->countAllResults();
        
        return [
            'total' => $total,
            'active' => $active,
            'with_debt' => $withDebt,
            'new_customers' => $newCustomers
        ];
    }

    /**
     * Get distinct cities
     */
    public function getDistinctCities()
    {
        return $this->db->table('customers')
                       ->select('city')
                       ->where('city IS NOT NULL')
                       ->where('city !=', '')
                       ->distinct()
                       ->orderBy('city')
                       ->get()
                       ->getResultArray();
    }

    /**
     * Get customer with detailed information
     */
    public function getCustomerWithDetails($id)
    {
        $builder = $this->db->table('customers c');
        $builder->select('c.*, d.name as doctor_name, d.phone as doctor_phone');
        $builder->join('doctors d', 'd.id = c.doctor_id', 'left');
        $builder->where('c.id', $id);
        
        return $builder->get()->getRowArray();
    }

    /**
     * Get searchable fields for DataTables
     */
    protected function getSearchableFields()
    {
        return [
            'name',
            'phone_home',
            'phone_mobile',
            'address',
            'city',
            'customer_id',
            'profession',
            'amka',
            'comments'
        ];
    }
    
    /**
     * Get customers with related data (insurance, doctor, status)
     * 
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getWithRelations($limit = null, $offset = 0)
    {
        $builder = $this->select([
            'customers.*',
            'insurances.name as insurance_name',
            'doctors.doc_name as doctor_name',
            'customer_statuses.status as status_name',
            'selling_points.city as selling_point_name'
        ])
        ->join('insurances', 'customers.insurance = insurances.id', 'left')
        ->join('doctors', 'customers.doctor = doctors.id', 'left')
        ->join('customer_statuses', 'customers.status = customer_statuses.id', 'left')
        ->join('selling_points', 'customers.selling_point = selling_points.id', 'left');
        
        if ($limit) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->get()->getResultArray();
    }
    
    /**
     * Calculate customer age
     * 
     * @param string $birthday
     * @return int|null
     */
    public function calculateAge($birthday)
    {
        if (empty($birthday)) {
            return null;
        }
        
        $birthDate = new \DateTime($birthday);
        $today = new \DateTime();
        $age = $today->diff($birthDate);
        
        return $age->y;
    }
    
    /**
     * Get validation rules for customers
     */
    public function getCustomerValidationRules($id = null)
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]',
            'father_name' => 'max_length[255]',
            'address' => 'max_length[500]',
            'city' => 'max_length[100]',
            'postal_code' => 'max_length[10]',
            'phone_mobile' => 'max_length[20]',
            'phone_landline' => 'max_length[20]',
            'email' => 'permit_empty|valid_email|max_length[255]',
            'birth_date' => 'permit_empty|valid_date',
            'amka' => 'permit_empty|max_length[11]',
            'amka_expire_date' => 'permit_empty|valid_date',
            'identity_number' => 'permit_empty|max_length[20]',
            'identity_expire_date' => 'permit_empty|valid_date',
            'notes' => 'permit_empty|max_length[1000]'
        ];
        
        // Add unique rules if creating new customer
        if (!$id) {
            $request = \Config\Services::request();
            if (!empty($request->getPost('email'))) {
                $rules['email'] .= '|is_unique[customers.email]';
            }
            if (!empty($request->getPost('amka'))) {
                $rules['amka'] .= '|is_unique[customers.amka]';
            }
        }
        
        return $rules;
    }
}