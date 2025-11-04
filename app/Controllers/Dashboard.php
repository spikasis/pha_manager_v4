<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\DoctorModel;
use App\Models\ServiceModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        // Check if user is logged in (will be handled by AuthFilter)
        if (!session()->get('user_id')) {
            return redirect()->to(base_url('auth/login'));
        }
    }
    
    public function index()
    {
        // Simple check if logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Get current user data
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return redirect()->to('/login');
        }
        
        try {
            $user = $this->userModel->find($userId);
            
            if (!$user) {
                session()->destroy();
                return redirect()->to('/login');
            }
            
            // Simple data for dashboard
            $data = [
                'title' => 'Dashboard - PHA Manager',
                'user' => $user,
                'customer_count' => 0, // Will add later
                'doctor_count' => 0,   // Will add later
                'service_count' => 0   // Will add later
            ];
            
            // Try to get basic stats
            try {
                $customerModel = new CustomerModel();
                $data['customer_count'] = $customerModel->countAllResults();
            } catch (\Exception $e) {
                log_message('warning', 'Could not get customer count: ' . $e->getMessage());
            }
            
            try {
                $doctorModel = new DoctorModel();
                $data['doctor_count'] = $doctorModel->countAllResults();
            } catch (\Exception $e) {
                log_message('warning', 'Could not get doctor count: ' . $e->getMessage());
            }
            
            return view('dashboard/simple', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Dashboard error: ' . $e->getMessage());
            return view('dashboard/simple', $data);
        }
    }

    /**
     * Thiva branch dashboard
     */
    public function thiva()
    {
        return $this->branchDashboard('Thiva', 'Dashboard Θήβας');
    }

    /**
     * Levadia branch dashboard
     */
    public function levadia()
    {
        return $this->branchDashboard('Levadia', 'Dashboard Λιβαδειάς');
    }

    /**
     * Service department dashboard
     */
    public function service()
    {
        return $this->branchDashboard('Service', 'Dashboard Τμήματος Service');
    }

    /**
     * Selling points dashboard
     */
    public function sellingPoints()
    {
        return $this->branchDashboard('Selling Points', 'Dashboard Σημείων Πώλησης');
    }

    /**
     * Lab dashboard
     */
    public function lab()
    {
        return $this->branchDashboard('Lab', 'Dashboard Εργαστηρίου');
    }

    /**
     * Generic branch dashboard method
     */
    protected function branchDashboard(string $branchType, string $title)
    {
        // Get current user data
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            session()->destroy();
            return redirect()->to('/login');
        }
        
        // Get user data from session
        $userData = session()->get('user_data');
        $userGroups = $userData['groups'] ?? [];
        $groupNames = array_column($userGroups, 'name');
        
        // Check if user has access to this branch
        if (!in_array('admin', $groupNames) && 
            !in_array($branchType, $groupNames) && 
            !($branchType === 'Lab' && stripos($user['username'], 'lab') !== false)) {
            return redirect()->to('/dashboard')->with('error', 'Δεν έχετε πρόσβαση σε αυτό το dashboard.');
        }
        
        // Initialize models
        $customerModel = new CustomerModel();
        $doctorModel = new DoctorModel();
        $serviceModel = new ServiceModel();
        
        // Get branch-specific statistics (TODO: Add branch filtering in models)
        $branchFilter = $this->getBranchFilter([$branchType], $user['username']);
        $customerStats = $customerModel->getDashboardStats();
        $doctorStats = $doctorModel->getDashboardStats();
        $serviceStats = $serviceModel->getDashboardStats();
        
        // Get recent data for this branch (TODO: Add branch filtering in models)
        $recentServices = $serviceModel->getRecentServices(10);
        $customersWithDebt = $customerModel->getCustomersWithDebt();
        $expiringGuarantees = $customerModel->getCustomersWithExpiringGuarantee(30);
        
        $data = [
            'title' => $title . ' - PHA Manager v4',
            'user' => $user,
            'user_data' => $userData,
            'branch_name' => $title,
            'branch_type' => $branchType,
            'customer_stats' => $customerStats,
            'doctor_stats' => $doctorStats,
            'service_stats' => $serviceStats,
            'recent_services' => $recentServices,
            'customers_with_debt' => count($customersWithDebt),
            'expiring_guarantees' => count($expiringGuarantees)
        ];
        
        return view('dashboard/branch', $data);
    }

    /**
     * Get branch filter for database queries
     */
    protected function getBranchFilter(array $groupNames, string $username): ?string
    {
        // Admin users see all data
        if (in_array('admin', $groupNames)) {
            return null;
        }
        
        // Branch-specific filters
        if (in_array('Thiva', $groupNames)) {
            return 'Thiva';
        }
        
        if (in_array('Levadia', $groupNames)) {
            return 'Levadia';
        }
        
        if (in_array('Service', $groupNames)) {
            return 'Service';
        }
        
        if (in_array('Selling Points', $groupNames)) {
            return 'Selling Points';
        }
        
        if (stripos($username, 'lab') !== false) {
            return 'Lab';
        }
        
        return null; // No filter for unknown users
    }

    /**
     * Get branch display name
     */
    protected function getBranchName(array $groupNames, string $username): string
    {
        if (in_array('admin', $groupNames)) {
            return 'Κεντρική Διοίκηση';
        }
        
        if (in_array('Thiva', $groupNames)) {
            return 'Υποκατάστημα Θήβας';
        }
        
        if (in_array('Levadia', $groupNames)) {
            return 'Υποκατάστημα Λιβαδειάς';
        }
        
        if (in_array('Service', $groupNames)) {
            return 'Τμήμα Service';
        }
        
        if (in_array('Selling Points', $groupNames)) {
            return 'Σημεία Πώλησης';
        }
        
        if (stripos($username, 'lab') !== false) {
            return 'Εργαστήριο';
        }
        
        return 'Γενικός Χρήστης';
    }
}
