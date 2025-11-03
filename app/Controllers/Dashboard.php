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
            header('Location: /login');
            exit;
        }
    }
    
    public function index()
    {
        // Get current user data
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            session()->destroy();
            return redirect()->to('/login');
        }
        // Initialize models
        $customerModel = new CustomerModel();
        $doctorModel = new DoctorModel();
        $serviceModel = new ServiceModel();
        
        // Get statistics
        $customerStats = $customerModel->getDashboardStats();
        $doctorStats = $doctorModel->getDashboardStats();
        $serviceStats = $serviceModel->getDashboardStats();
        
        // Get recent data
        $recentServices = $serviceModel->getRecentServices(5);
        $customersWithDebt = $customerModel->getCustomersWithDebt();
        $expiringGuarantees = $customerModel->getCustomersWithExpiringGuarantee(30);
        
        $data = [
            'title' => 'Dashboard - PHA Manager v4',
            'user' => $user,
            'customer_stats' => $customerStats,
            'doctor_stats' => $doctorStats,
            'service_stats' => $serviceStats,
            'recent_services' => $recentServices,
            'customers_with_debt' => count($customersWithDebt),
            'expiring_guarantees' => count($expiringGuarantees)
        ];
        
        return view('dashboard/index', $data);
    }
}
