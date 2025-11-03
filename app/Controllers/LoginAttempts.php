<?php

namespace App\Controllers;

use App\Controllers\BaseCRUD;
use App\Models\LoginAttemptModel;
use App\Models\UserModel;

class LoginAttempts extends BaseCRUD
{
    protected $modelName = LoginAttemptModel::class;
    protected $viewPath = 'login_attempts';
    protected $pageTitle = 'Προσπάθειες Σύνδεσης';
    protected $entityName = 'Προσπάθεια';
    protected $entityNamePlural = 'Προσπάθειες Σύνδεσης';
    
    // This is a READ-ONLY CRUD for security monitoring
    protected $readOnly = true;
    
    public function __construct()
    {
        $this->model = new LoginAttemptModel();
    }

    /**
     * Display login attempts index with DataTables
     */
    public function index()
    {
        $data = [
            'title' => $this->pageTitle,
            'entity_name' => $this->entityNamePlural,
            'ajax_url' => site_url('login-attempts/getData'),
            'create_url' => null, // Read-only, no create
            'show_create_button' => false,
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => site_url('dashboard')],
                ['title' => $this->pageTitle, 'url' => '']
            ]
        ];

        return view('login_attempts/index', $data);
    }

    /**
     * Get data for DataTables AJAX
     */
    public function getData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(404);
        }

        $searchValue = $this->request->getGet('search')['value'] ?? '';
        $start = (int)($this->request->getGet('start') ?? 0);
        $length = (int)($this->request->getGet('length') ?? 10);
        $orderColumnIndex = (int)($this->request->getGet('order')[0]['column'] ?? 0);
        $orderDirection = $this->request->getGet('order')[0]['dir'] ?? 'desc';

        $columns = ['id', 'time', 'ip_address', 'login', 'success', 'user_agent'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'time';

        // Base query with user information
        $builder = $this->model->builder();
        $builder->select('login_attempts.*, users.first_name, users.last_name, users.email')
                ->join('users', 'users.username = login_attempts.login OR users.email = login_attempts.login', 'left')
                ->orderBy($orderColumn, $orderDirection);

        // Search functionality
        if (!empty($searchValue)) {
            $builder->groupStart()
                   ->like('login_attempts.ip_address', $searchValue)
                   ->orLike('login_attempts.login', $searchValue)
                   ->orLike('users.first_name', $searchValue)
                   ->orLike('users.last_name', $searchValue)
                   ->orLike('users.email', $searchValue)
                   ->groupEnd();
        }

        // Get total records (before pagination)
        $totalRecords = $this->model->countAll();
        $filteredQuery = clone $builder;
        $filteredRecords = $filteredQuery->countAllResults(false);

        // Apply pagination
        $builder->limit($length, $start);
        $records = $builder->get()->getResultArray();

        // Format data for DataTables
        $data = [];
        foreach ($records as $record) {
            $actions = $this->generateActionButtons($record['id']);
            
            // Format timestamp
            $timeFormatted = date('d/m/Y H:i:s', $record['time']);
            $timeAgo = $this->timeAgo($record['time']);
            
            // Determine success status
            $success = $this->determineSuccess($record);
            $successBadge = $success 
                ? '<span class="badge badge-success">Επιτυχής</span>'
                : '<span class="badge badge-danger">Αποτυχημένη</span>';
            
            // User information
            $userInfo = '';
            if ($record['first_name'] && $record['last_name']) {
                $userInfo = esc($record['first_name'] . ' ' . $record['last_name']);
                if ($record['email']) {
                    $userInfo .= '<br><small class="text-muted">' . esc($record['email']) . '</small>';
                }
            } else {
                $userInfo = '<em class="text-muted">Άγνωστος χρήστης</em>';
            }

            // Location info (placeholder for IP geolocation)
            $locationInfo = $this->getLocationInfo($record['ip_address']);

            $data[] = [
                'id' => $record['id'],
                'time' => $timeFormatted . '<br><small class="text-muted">' . $timeAgo . '</small>',
                'ip_address' => $record['ip_address'] . '<br><small class="text-muted">' . $locationInfo . '</small>',
                'login' => '<strong>' . esc($record['login']) . '</strong>',
                'user_info' => $userInfo,
                'success' => $successBadge,
                'actions' => $actions
            ];
        }

        return $this->response->setJSON([
            'draw' => (int)($this->request->getGet('draw') ?? 1),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }

    /**
     * Show login attempt details (READ-ONLY)
     */
    public function show($id)
    {
        $attempt = $this->model->find($id);
        
        if (!$attempt) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Η προσπάθεια σύνδεσης με ID $id δεν βρέθηκε");
        }

        // Get user information if available
        $userModel = new UserModel();
        $user = $userModel->where('username', $attempt['login'])
                         ->orWhere('email', $attempt['login'])
                         ->first();

        // Get related attempts from same IP
        $relatedAttempts = $this->model->where('ip_address', $attempt['ip_address'])
                                     ->where('id !=', $id)
                                     ->orderBy('time', 'DESC')
                                     ->limit(10)
                                     ->findAll();

        // Get related attempts from same login
        $loginAttempts = $this->model->where('login', $attempt['login'])
                                   ->where('id !=', $id)
                                   ->orderBy('time', 'DESC')
                                   ->limit(10)
                                   ->findAll();

        $data = [
            'title' => 'Προβολή Προσπάθειας Σύνδεσης #' . $id,
            'entity_name' => $this->entityName,
            'record' => $attempt,
            'user' => $user,
            'related_ip_attempts' => $relatedAttempts,
            'related_login_attempts' => $loginAttempts,
            'back_url' => site_url('login-attempts'),
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => site_url('dashboard')],
                ['title' => $this->pageTitle, 'url' => site_url('login-attempts')],
                ['title' => 'Προβολή #' . $id, 'url' => '']
            ]
        ];

        return view('login_attempts/show', $data);
    }

    /**
     * Get security statistics (AJAX)
     */
    public function getStatistics()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(404);
        }

        $stats = [];
        
        // Total attempts
        $stats['total_attempts'] = $this->model->countAll();
        
        // Recent attempts (last 24 hours)
        $oneDayAgo = time() - (24 * 60 * 60);
        $stats['recent_attempts'] = $this->model->where('time >=', $oneDayAgo)->countAllResults();
        
        // Failed attempts (estimated based on non-existing users)
        $userModel = new UserModel();
        $allUsers = $userModel->select('username, email')->findAll();
        $validLogins = array_merge(
            array_column($allUsers, 'username'),
            array_column($allUsers, 'email')
        );
        
        $allAttempts = $this->model->select('login')->findAll();
        $failedCount = 0;
        foreach ($allAttempts as $attempt) {
            if (!in_array($attempt['login'], $validLogins)) {
                $failedCount++;
            }
        }
        $stats['failed_attempts'] = $failedCount;
        
        // Top IPs
        $topIps = $this->model->select('ip_address, COUNT(*) as count')
                             ->groupBy('ip_address')
                             ->orderBy('count', 'DESC')
                             ->limit(5)
                             ->findAll();
        $stats['top_ips'] = $topIps;

        return $this->response->setJSON($stats);
    }

    /**
     * Clean old login attempts (older than specified days)
     */
    public function cleanup()
    {
        // Only allow POST for security
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Μόνο POST αιτήματα επιτρέπονται'
            ]);
        }

        $days = $this->request->getPost('days') ?? 90; // Default 90 days
        $cutoffTime = time() - ($days * 24 * 60 * 60);
        
        try {
            $deletedCount = $this->model->where('time <', $cutoffTime)->delete();
            
            return $this->response->setJSON([
                'success' => true,
                'message' => "Διαγράφηκαν {$deletedCount} παλιές προσπάθειες σύνδεσης"
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Σφάλμα κατά τον καθαρισμό: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Generate action buttons for DataTable rows (READ-ONLY)
     */
    protected function generateActionButtons($id)
    {
        return '
            <div class="btn-group" role="group">
                <a href="' . site_url('login-attempts/show/' . $id) . '" 
                   class="btn btn-info btn-sm" title="Προβολή">
                    <i class="fas fa-eye"></i>
                </a>
            </div>
        ';
    }

    /**
     * Determine if login attempt was successful (heuristic)
     */
    protected function determineSuccess($record)
    {
        // This is a heuristic - in a real system you'd have a success field
        $userModel = new UserModel();
        $user = $userModel->where('username', $record['login'])
                         ->orWhere('email', $record['login'])
                         ->first();
        
        return !empty($user); // Assume success if user exists
    }

    /**
     * Get human-readable time ago
     */
    protected function timeAgo($timestamp)
    {
        $diff = time() - $timestamp;
        
        if ($diff < 60) return 'Μόλις τώρα';
        if ($diff < 3600) return floor($diff / 60) . ' λεπτά πριν';
        if ($diff < 86400) return floor($diff / 3600) . ' ώρες πριν';
        if ($diff < 2592000) return floor($diff / 86400) . ' ημέρες πριν';
        
        return date('d/m/Y', $timestamp);
    }

    /**
     * Get location information from IP (placeholder)
     */
    protected function getLocationInfo($ip)
    {
        // Placeholder - in production you'd use a geolocation service
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return 'Εξωτερική IP';
        } else {
            return 'Τοπικό δίκτυο';
        }
    }

    // Override parent methods to prevent create/edit/delete operations
    public function create() { return redirect()->to('login-attempts')->with('error', 'Η δημιουργία δεν επιτρέπεται'); }
    public function store() { return redirect()->to('login-attempts')->with('error', 'Η δημιουργία δεν επιτρέπεται'); }
    public function edit($id) { return redirect()->to('login-attempts')->with('error', 'Η επεξεργασία δεν επιτρέπεται'); }
    public function update($id) { return redirect()->to('login-attempts')->with('error', 'Η επεξεργασία δεν επιτρέπεται'); }
    public function delete($id) { return redirect()->to('login-attempts')->with('error', 'Η διαγραφή δεν επιτρέπεται'); }
}