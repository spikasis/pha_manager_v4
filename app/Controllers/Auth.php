<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GroupModel;
use App\Models\LoginAttemptModel;
use Config\Auth as AuthConfig;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $userModel;
    protected $groupModel;
    protected $loginAttemptModel;
    protected $authConfig;
    protected $validation;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->loginAttemptModel = new LoginAttemptModel();
        $this->authConfig = new AuthConfig();
        $this->validation = \Config\Services::validation();
    }

    /**
     * Display login form
     */
    public function login()
    {
        // Redirect if already logged in
        if ($this->isLoggedIn()) {
            return redirect()->to($this->authConfig->loginRedirect);
        }

        $data = [
            'title' => 'Σύνδεση',
            'validation' => session('validation')
        ];

        return view('auth/login', $data);
    }

    /**
     * Process login
     */
    public function attemptLogin()
    {
        $ipAddress = $this->request->getIPAddress();
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember') ? true : false;

        // Check if IP is locked out
        if ($this->loginAttemptModel->isIpLockedOut($ipAddress)) {
            $timeRemaining = $this->loginAttemptModel->getLockoutTimeRemainingForIp($ipAddress);
            session()->setFlashdata('error', "Ο λογαριασμός είναι κλειδωμένος. Δοκιμάστε ξανά σε {$timeRemaining} δευτερόλεπτα.");
            return redirect()->back();
        }

        // Check if login is locked out
        if ($login && $this->loginAttemptModel->isLoginLockedOut($login)) {
            $timeRemaining = $this->loginAttemptModel->getLockoutTimeRemainingForLogin($login);
            session()->setFlashdata('error', "Πολλές αποτυχημένες προσπάθειες. Δοκιμάστε ξανά σε {$timeRemaining} δευτερόλεπτα.");
            return redirect()->back();
        }

        // Validate input
        $rules = [
            'login' => [
                'label' => 'Email/Username',
                'rules' => 'required'
            ],
            'password' => [
                'label' => 'Κωδικός',
                'rules' => 'required'
            ]
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('validation', $this->validator);
            return redirect()->back()->withInput();
        }

        // Find user
        $user = $this->userModel->findByLogin($login);

        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
            // Record failed attempt
            $this->loginAttemptModel->recordAttempt($ipAddress, $login);
            
            session()->setFlashdata('error', $this->authConfig->messages['login_unsuccessful']);
            return redirect()->back()->withInput();
        }

        // Check if user is active
        if (!$user['active']) {
            session()->setFlashdata('error', 'Ο λογαριασμός δεν είναι ενεργός. Επικοινωνήστε με τον διαχειριστή.');
            return redirect()->back();
        }

        // Clear failed attempts for this IP and login
        $this->loginAttemptModel->clearAttemptsForIp($ipAddress);
        $this->loginAttemptModel->clearAttemptsForLogin($login);

        // Set remember me cookie if requested
        if ($remember) {
            $rememberCode = $this->userModel->generateRememberCode();
            $this->userModel->setRememberCode($user['id'], $rememberCode);
            
            $cookieValue = $user['id'] . ':' . $rememberCode;
            $cookie = [
                'name' => $this->authConfig->cookies['remember'],
                'value' => $cookieValue,
                'expire' => $this->authConfig->rememberMeDuration
            ];
            $this->response->setCookie($cookie);
        }

        // Update last login
        $this->userModel->updateLastLogin($user['id']);

        // Set session data
        $this->setUserSession($user);

        session()->setFlashdata('success', $this->authConfig->messages['login_successful']);
        
        // Determine redirect URL based on user role and groups
        $redirectUrl = session('redirect_url') ?? $this->getDashboardRedirectUrl($user);
        session()->remove('redirect_url');
        
        return redirect()->to($redirectUrl);
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $userId = session($this->authConfig->sessionUserIdKey);
        
        if ($userId) {
            // Clear remember me cookie and code
            $this->userModel->clearRememberCode($userId);
            $this->response->deleteCookie($this->authConfig->cookies['remember']);
        }

        // Destroy session
        session()->destroy();

        session()->setFlashdata('success', $this->authConfig->messages['logout_successful']);
        return redirect()->to($this->authConfig->logoutRedirect);
    }

    /**
     * Display registration form
     */
    public function register()
    {
        if (!$this->authConfig->allowRegistration) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Η εγγραφή δεν είναι διαθέσιμη');
        }

        // Redirect if already logged in
        if ($this->isLoggedIn()) {
            return redirect()->to($this->authConfig->loginRedirect);
        }

        $data = [
            'title' => 'Εγγραφή',
            'validation' => session('validation')
        ];

        return view('auth/register', $data);
    }

    /**
     * Process registration
     */
    public function attemptRegister()
    {
        if (!$this->authConfig->allowRegistration) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Η εγγραφή δεν είναι διαθέσιμη');
        }

        $rules = $this->userModel->getUserValidationRules();

        if (!$this->validate($rules)) {
            session()->setFlashdata('validation', $this->validator);
            return redirect()->back()->withInput();
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'company' => $this->request->getPost('company'),
            'phone' => $this->request->getPost('phone'),
            'active' => $this->authConfig->requireEmailActivation ? 0 : 1,
            'created_on' => time()
        ];

        // Generate activation code if required
        if ($this->authConfig->requireEmailActivation) {
            $userData['activation_code'] = $this->userModel->generateActivationCode();
        }

        try {
            $userId = $this->userModel->insert($userData);
            
            if ($userId) {
                // Add user to default group
                $defaultGroup = $this->groupModel->findByName($this->authConfig->defaultGroup);
                if ($defaultGroup) {
                    $this->userModel->addToGroup($userId, $defaultGroup['id']);
                }

                if ($this->authConfig->requireEmailActivation) {
                    // Send activation email (implementation needed)
                    session()->setFlashdata('success', 'Η εγγραφή ολοκληρώθηκε. Ελέγξτε το email σας για ενεργοποίηση.');
                } else {
                    session()->setFlashdata('success', $this->authConfig->messages['registration_successful']);
                }
                
                return redirect()->to('/auth/login');
            } else {
                session()->setFlashdata('error', $this->authConfig->messages['registration_unsuccessful']);
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Σφάλμα κατά την εγγραφή: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Activate user account
     */
    public function activate($code = null)
    {
        if (!$code) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Μη έγκυρος κωδικός ενεργοποίησης');
        }

        $user = $this->userModel->findByActivationCode($code);
        
        if (!$user) {
            session()->setFlashdata('error', 'Μη έγκυρος κωδικός ενεργοποίησης');
            return redirect()->to('/auth/login');
        }

        if ($this->userModel->activateUser($user['id'])) {
            session()->setFlashdata('success', $this->authConfig->messages['activation_successful']);
        } else {
            session()->setFlashdata('error', $this->authConfig->messages['activation_unsuccessful']);
        }

        return redirect()->to('/auth/login');
    }

    /**
     * Display forgot password form
     */
    public function forgotPassword()
    {
        $data = [
            'title' => 'Ξεχάσατε τον κωδικό;',
            'validation' => session('validation')
        ];

        return view('auth/forgot_password', $data);
    }

    /**
     * Process forgot password
     */
    public function resetPasswordEmail()
    {
        $rules = [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email'
            ]
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('validation', $this->validator);
            return redirect()->back()->withInput();
        }

        $email = $this->request->getPost('email');
        $user = $this->userModel->findByEmail($email);

        if ($user) {
            $code = $this->userModel->generateForgottenPasswordCode();
            $this->userModel->update($user['id'], [
                'forgotten_password_code' => $code,
                'forgotten_password_time' => time()
            ]);

            // Send reset email (implementation needed)
            session()->setFlashdata('success', 'Οδηγίες επαναφοράς κωδικού στάλθηκαν στο email σας.');
        } else {
            // Don't reveal if email exists for security
            session()->setFlashdata('success', 'Εάν το email υπάρχει, οδηγίες επαναφοράς θα σταλθούν.');
        }

        return redirect()->to('/auth/login');
    }

    /**
     * Reset password form
     */
    public function resetPassword($code = null)
    {
        if (!$code) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Μη έγκυρος κωδικός επαναφοράς');
        }

        $user = $this->userModel->findByForgottenCode($code);
        
        if (!$user) {
            session()->setFlashdata('error', 'Μη έγκυρος κωδικός επαναφοράς');
            return redirect()->to('/auth/login');
        }

        // Check if code has expired (24 hours)
        if (time() - $user['forgotten_password_time'] > 86400) {
            session()->setFlashdata('error', 'Ο κωδικός επαναφοράς έχει λήξει');
            return redirect()->to('/auth/forgot-password');
        }

        $data = [
            'title' => 'Επαναφορά Κωδικού',
            'code' => $code,
            'validation' => session('validation')
        ];

        return view('auth/reset_password', $data);
    }

    /**
     * Process password reset
     */
    public function updatePassword()
    {
        $code = $this->request->getPost('code');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        $rules = [
            'password' => [
                'label' => 'Νέος Κωδικός',
                'rules' => "required|min_length[{$this->authConfig->minPasswordLength}]"
            ],
            'confirm_password' => [
                'label' => 'Επιβεβαίωση Κωδικού',
                'rules' => 'required|matches[password]'
            ]
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('validation', $this->validator);
            return redirect()->back();
        }

        $user = $this->userModel->findByForgottenCode($code);
        
        if (!$user || time() - $user['forgotten_password_time'] > 86400) {
            session()->setFlashdata('error', 'Μη έγκυρος ή ληγμένος κωδικός επαναφοράς');
            return redirect()->to('/auth/login');
        }

        $updateData = [
            'password' => $password,
            'forgotten_password_code' => null,
            'forgotten_password_time' => null,
            'active' => 1 // Activate user if not active
        ];

        if ($this->userModel->update($user['id'], $updateData)) {
            session()->setFlashdata('success', $this->authConfig->messages['password_change_successful']);
        } else {
            session()->setFlashdata('error', $this->authConfig->messages['password_change_unsuccessful']);
        }

        return redirect()->to('/auth/login');
    }

    /**
     * Check if user is logged in
     */
    public function isLoggedIn(): bool
    {
        $userId = session($this->authConfig->sessionUserIdKey);
        return $userId !== null;
    }

    /**
     * Get current user
     */
    public function user()
    {
        return session($this->authConfig->sessionUserDataKey);
    }

    /**
     * Set user session data
     */
    protected function setUserSession(array $user): void
    {
        // Get user groups
        $groups = $this->userModel->getUserGroups($user['id']);
        
        $sessionData = [
            $this->authConfig->sessionUserIdKey => $user['id'],
            $this->authConfig->sessionUserDataKey => [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'full_name' => trim($user['first_name'] . ' ' . $user['last_name']),
                'company' => $user['company'],
                'phone' => $user['phone'],
                'groups' => $groups,
                'is_admin' => $this->userModel->isInGroup($user['id'], 'admin'),
                'last_login' => $user['last_login']
            ]
        ];

        session()->set($sessionData);
    }

    /**
     * Check remember me cookie
     */
    public function checkRememberMe()
    {
        if ($this->isLoggedIn()) {
            return;
        }

        $cookie = $this->request->getCookie($this->authConfig->cookies['remember']);
        
        if (!$cookie) {
            return;
        }

        $parts = explode(':', $cookie);
        if (count($parts) !== 2) {
            $this->response->deleteCookie($this->authConfig->cookies['remember']);
            return;
        }

        [$userId, $code] = $parts;
        $user = $this->userModel->find($userId);

        if (!$user || !$user['active'] || $user['remember_code'] !== $code) {
            $this->response->deleteCookie($this->authConfig->cookies['remember']);
            return;
        }

        // Auto login user
        $this->userModel->updateLastLogin($userId);
        $this->setUserSession($user);
    }

    /**
     * Get dashboard redirect URL based on user role and groups
     * 
     * @param array $user User data
     * @return string Redirect URL
     */
    protected function getDashboardRedirectUrl(array $user): string
    {
        // Get user groups
        $groups = $this->userModel->getUserGroups($user['id']);
        $groupNames = array_column($groups, 'name');
        
        // Admin users go to main dashboard
        if (in_array('admin', $groupNames)) {
            return base_url('dashboard');
        }
        
        // Branch-specific dashboards
        if (in_array('Thiva', $groupNames)) {
            return base_url('dashboard/thiva');
        }
        
        if (in_array('Levadia', $groupNames)) {
            return base_url('dashboard/levadia');
        }
        
        if (in_array('Service', $groupNames)) {
            return base_url('dashboard/service');
        }
        
        if (in_array('Selling Points', $groupNames)) {
            return base_url('dashboard/selling-points');
        }
        
        // Lab users
        if (stripos($user['username'], 'lab') !== false) {
            return base_url('dashboard/lab');
        }
        
        // Default for members or unknown groups
        return base_url('dashboard');
    }
}