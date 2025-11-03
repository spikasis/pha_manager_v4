<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\DoctorModel;
use App\Models\ServiceModel;

class Dashboard extends BaseController
{
    public function index()
    {
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
