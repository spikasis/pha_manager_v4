<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'ha_service',
        'day_in',
        'ha_temp',
        'action_service',
        'malfunction',
        'lab_report',
        'lab_sent',
        'price',
        'status',
        'lab_service'
    ];
    
    // Validation rules for services
    protected $validationRules = [
        'ha_service' => 'integer',
        'day_in' => 'valid_date',
        'ha_temp' => 'integer',
        'action_service' => 'integer',
        'malfunction' => 'string',
        'lab_report' => 'string',
        'lab_sent' => 'integer',
        'status' => 'required|integer'
    ];
    
    protected $validationMessages = [
        'status' => [
            'required' => 'Η κατάσταση της υπηρεσίας είναι υποχρεωτική.'
        ]
    ];
    
    // No timestamps in original schema
    protected $useTimestamps = false;
    
    /**
     * Get services by status
     */
    public function getServicesByStatus($status)
    {
        return $this->where('status', $status)
                    ->orderBy('day_in', 'DESC')
                    ->findAll();
    }
    
    /**
     * Get active services
     */
    public function getActiveServices()
    {
        return $this->where('status', 1)
                    ->orderBy('day_in', 'DESC')
                    ->findAll();
    }
    
    /**
     * Get services with customer and hearing aid details
     */
    public function getServicesWithDetails($limit = null)
    {
        $builder = $this->db->table('services s');
        $builder->select('s.*, st.serial_number, c.name as customer_name')
                ->join('stocks st', 's.ha_service = st.id', 'left')
                ->join('customers c', 'st.customer = c.id', 'left')
                ->orderBy('s.day_in', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->get()->getResultArray();
    }
    
    /**
     * Get recent services (last 30 days)
     */
    public function getRecentServices($limit = 10)
    {
        return $this->where('day_in >=', date('Y-m-d', strtotime('-30 days')))
                    ->orderBy('day_in', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
    
    /**
     * Get services statistics for dashboard
     */
    public function getDashboardStats()
    {
        $total = $this->countAllResults();
        $active = $this->where('status', 1)->countAllResults();
        $thisMonth = $this->where('day_in >=', date('Y-m-01'))
                          ->where('day_in <=', date('Y-m-t'))
                          ->countAllResults();
        
        return [
            'total_services' => $total,
            'active_services' => $active,
            'services_this_month' => $thisMonth,
            'completed_services' => $total - $active
        ];
    }
}