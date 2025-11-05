<?php<?php<?php



namespace App\Controllers;



use CodeIgniter\HTTP\RedirectResponse;namespace App\Controllers;namespace App\Controllers;



/**

 * Auth Controller

 * use CodeIgniter\HTTP\RedirectResponse;use App\Models\UserModel;

 * Handles all authentication related functionality:

 * - Login/Logoutuse App\Models\GroupModel;

 * - Session Management

 * - Security Features/**use App\Models\LoginAttemptModel;

 * - User Verification

 */ * Auth Controlleruse Config\Auth as AuthConfig;

class Auth extends BaseController

{ * use CodeIgniter\Controller;

    protected $helpers = ['form', 'url', 'security'];

     * Handles all authentication related functionality:

    /**

     * Main authentication entry point * - Login/Logoutclass Auth extends BaseController

     * Shows login form or dashboard if already authenticated

     */ * - Session Management{

    public function index()

    { * - Security Features    protected $userModel;

        // Check if user is already authenticated

        if ($this->isLoggedIn()) { * - User Verification    protected $groupModel;

            return $this->showAuthenticatedView();

        } */    protected $loginAttemptModel;

        

        return $this->showLoginView();class Auth extends BaseController    protected $authConfig;

    }

    {    protected $validation;

    /**

     * Process login attempt    protected $helpers = ['form', 'url', 'security'];

     */

    public function login()        public function __construct()

    {

        // Handle POST login form submission    /**    {

        if ($this->request->getMethod() === 'POST') {

            return $this->processLoginForm();     * Main authentication entry point        $this->userModel = new UserModel();

        }

             * Shows login form or dashboard if already authenticated        $this->groupModel = new GroupModel();

        // Handle GET direct login (for development/admin)

        return $this->processDirectLogin();     */        $this->loginAttemptModel = new LoginAttemptModel();

    }

        public function index()        $this->authConfig = new AuthConfig();

    /**

     * Logout user and destroy session    {        $this->validation = \Config\Services::validation();

     */

    public function logout(): RedirectResponse        // Check if user is already authenticated    }

    {

        // Clear all session data        if ($this->isLoggedIn()) {

        session()->destroy();

                    return $this->showAuthenticatedView();    /**

        // Set logout message

        session()->setFlashdata('success', 'Αποσυνδεθήκατε επιτυχώς από το σύστημα.');        }     * Display login form

        

        // Redirect to login             */

        return redirect()->to(site_url('auth'));

    }        return $this->showLoginView();    public function login()

    

    /**    }    {

     * Check authentication status (AJAX endpoint)

     */            // Redirect if already logged in

    public function check()

    {    /**        if ($this->isLoggedIn()) {

        $response = [

            'authenticated' => $this->isLoggedIn(),     * Process login attempt            return redirect()->to($this->authConfig->loginRedirect);

            'user' => $this->isLoggedIn() ? $this->getUserData() : null,

            'session_remaining' => $this->isLoggedIn() ? $this->getSessionTimeRemaining() : 0     */        }

        ];

            public function login()

        return $this->response->setJSON($response);

    }    {        $data = [

    

    /**        // Handle POST login form submission            'title' => 'Σύνδεση',

     * Keep session alive (AJAX heartbeat)

     */        if ($this->request->getMethod() === 'POST') {            'validation' => session('validation')

    public function keepAlive()

    {            return $this->processLoginForm();        ];

        if (!$this->isLoggedIn()) {

            return $this->response->setJSON(['status' => 'unauthorized'])->setStatusCode(401);        }

        }

                        return view('auth/login', $data);

        // Update last activity

        session()->set('last_activity', time());        // Handle GET direct login (for development/admin)    }

        

        return $this->response->setJSON([        return $this->processDirectLogin();

            'status' => 'success',

            'session_remaining' => $this->getSessionTimeRemaining()    }    /**

        ]);

    }         * Process login attempt - SIMPLIFIED VERSION

    

    // =====================================    /**     */

    // PRIVATE HELPER METHODS

    // =====================================     * Logout user and destroy session    public function attemptLogin()

    

    /**     */    {

     * Check if user is currently logged in

     */    public function logout(): RedirectResponse        // Basic validation

    private function isLoggedIn(): bool

    {    {        $login = $this->request->getPost('login');

        $userId = session()->get('user_id');

        $loggedIn = session()->get('logged_in');        // Clear all session data        $password = $this->request->getPost('password');

        $lastActivity = session()->get('last_activity');

                session()->destroy();

        // Check basic session data

        if (!$userId || !$loggedIn) {                if (empty($login) || empty($password)) {

            return false;

        }        // Set logout message            session()->setFlashdata('error', 'Παρακαλώ συμπληρώστε όλα τα πεδία');

        

        // Check session timeout (30 minutes)        session()->setFlashdata('success', 'Αποσυνδεθήκατε επιτυχώς από το σύστημα.');            return redirect()->back()->withInput();

        $sessionTimeout = 1800; // 30 minutes

        if ($lastActivity && (time() - $lastActivity) > $sessionTimeout) {                }

            session()->destroy();

            return false;        // Redirect to login

        }

                return redirect()->to(site_url('auth'));        try {

        return true;

    }    }            // Find user

    

    /**                $user = $this->userModel->findByLogin($login);

     * Get current user data from session

     */    /**

    private function getUserData(): array

    {     * Check authentication status (AJAX endpoint)            if (!$user) {

        return [

            'id' => session()->get('user_id'),     */                session()->setFlashdata('error', 'Δεν βρέθηκε χρήστης με αυτά τα στοιχεία');

            'username' => session()->get('username'),

            'email' => session()->get('email'),    public function check()                return redirect()->back()->withInput();

            'full_name' => session()->get('full_name'),

            'role' => session()->get('role'),    {            }

            'login_time' => session()->get('login_time'),

            'last_activity' => session()->get('last_activity')        $response = [

        ];

    }            'authenticated' => $this->isLoggedIn(),            // Verify password

    

    /**            'user' => $this->isLoggedIn() ? $this->getUserData() : null,            if (!password_verify($password, $user['password'])) {

     * Get remaining session time in seconds

     */            'session_remaining' => $this->isLoggedIn() ? $this->getSessionTimeRemaining() : 0                session()->setFlashdata('error', 'Λάθος κωδικός');

    private function getSessionTimeRemaining(): int

    {        ];                return redirect()->back()->withInput();

        $lastActivity = session()->get('last_activity') ?: time();

        $sessionTimeout = 1800; // 30 minutes                    }

        $elapsed = time() - $lastActivity;

                return $this->response->setJSON($response);

        return max(0, $sessionTimeout - $elapsed);

    }    }            // Check if active

    

    /**                if (!$user['active']) {

     * Show authenticated user view

     */    /**                session()->setFlashdata('error', 'Ο λογαριασμός δεν είναι ενεργός');

    private function showAuthenticatedView()

    {     * Keep session alive (AJAX heartbeat)                return redirect()->back();

        $data = [

            'title' => 'Dashboard - PHA Manager v4',     */            }

            'user' => $this->getUserData(),

            'authenticated' => true,    public function keepAlive()

            'session_remaining' => $this->getSessionTimeRemaining()

        ];    {            // Update last login (simple version)

        

        return view('auth/authenticated', $data);        if (!$this->isLoggedIn()) {            try {

    }

                return $this->response->setJSON(['status' => 'unauthorized'])->setStatusCode(401);                $this->userModel->updateLastLogin($user['id']);

    /**

     * Show login form view        }            } catch (\Exception $e) {

     */

    private function showLoginView()                        // Don't fail login if this fails

    {

        $data = [        // Update last activity                log_message('warning', 'Could not update last login: ' . $e->getMessage());

            'title' => 'Σύνδεση - PHA Manager v4',

            'authenticated' => false,        session()->set('last_activity', time());            }

            'csrf_token' => csrf_hash()

        ];        

        

        return view('auth/login', $data);        return $this->response->setJSON([            // Set simple session

    }

                'status' => 'success',            session()->set([

    /**

     * Process login form submission (POST)            'session_remaining' => $this->getSessionTimeRemaining()                'user_id' => $user['id'],

     */

    private function processLoginForm()        ]);                'username' => $user['username'],

    {

        // Validate CSRF token    }                'email' => $user['email'],

        if (!$this->validateCSRF()) {

            session()->setFlashdata('error', 'Μη έγκυρη αίτηση. Δοκιμάστε ξανά.');                    'logged_in' => true

            return redirect()->to(site_url('auth'));

        }    // =====================================            ]);

        

        // Get form data    // PRIVATE HELPER METHODS

        $username = $this->request->getPost('username');

        $password = $this->request->getPost('password');    // =====================================            session()->setFlashdata('success', 'Καλώς ήρθατε!');

        $remember = $this->request->getPost('remember_me');

                        

        // Validate form data

        if (!$username || !$password) {    /**            // Simple redirect to dashboard

            session()->setFlashdata('error', 'Παρακαλώ εισάγετε όνομα χρήστη και κωδικό.');

            return redirect()->to(site_url('auth'));     * Check if user is currently logged in            return redirect()->to('/dashboard');

        }

             */            

        // Authenticate user

        if ($this->authenticateUser($username, $password)) {    private function isLoggedIn(): bool        } catch (\Exception $e) {

            $this->createUserSession($username, $remember);

            session()->setFlashdata('success', 'Καλώς ήρθατε στο PHA Manager v4!');    {            log_message('error', 'Login error: ' . $e->getMessage());

            return redirect()->to(site_url('dashboard'));

        }        $userId = session()->get('user_id');            session()->setFlashdata('error', 'Σφάλμα σύνδεσης: ' . $e->getMessage());

        

        // Authentication failed        $loggedIn = session()->get('logged_in');            return redirect()->back();

        session()->setFlashdata('error', 'Λάθος στοιχεία σύνδεσης. Δοκιμάστε ξανά.');

        return redirect()->to(site_url('auth'));        $lastActivity = session()->get('last_activity');        }

    }

                }

    /**

     * Process direct login (GET) - for admin/development        // Check basic session data

     */

    private function processDirectLogin()        if (!$userId || !$loggedIn) {    private function oldAttemptLoginCode() 

    {

        // Create admin session directly (for development)            return false;    {

        $this->createUserSession('admin', false);

        session()->setFlashdata('success', 'Επιτυχής άμεση σύνδεση στο σύστημα!');        }        /* Old code moved here for reference - COMMENTED OUT DUE TO UNDEFINED VARIABLES

        return redirect()->to(site_url('dashboard'));

    }                // Check if IP is locked out

    

    /**        // Check session timeout (30 minutes)        if ($this->loginAttemptModel->isIpLockedOut($ipAddress)) {

     * Validate CSRF token

     */        $sessionTimeout = 1800; // 30 minutes            $timeRemaining = $this->loginAttemptModel->getLockoutTimeRemainingForIp($ipAddress);

    private function validateCSRF(): bool

    {        if ($lastActivity && (time() - $lastActivity) > $sessionTimeout) {            session()->setFlashdata('error', "Ο λογαριασμός είναι κλειδωμένος. Δοκιμάστε ξανά σε {$timeRemaining} δευτερόλεπτα.");

        $token = $this->request->getPost(csrf_token());

        return csrf_verify($token);            session()->destroy();            return redirect()->back();

    }

                return false;        }

    /**

     * Authenticate user credentials        }

     * For now using hardcoded credentials - will be replaced with database

     */                // Check if login is locked out

    private function authenticateUser(string $username, string $password): bool

    {        return true;        if ($login && $this->loginAttemptModel->isLoginLockedOut($login)) {

        // Hardcoded credentials for development

        $validCredentials = [    }            $timeRemaining = $this->loginAttemptModel->getLockoutTimeRemainingForLogin($login);

            'admin' => 'admin123',

            'spikasis' => 'spikos2024',                session()->setFlashdata('error', "Πολλές αποτυχημένες προσπάθειες. Δοκιμάστε ξανά σε {$timeRemaining} δευτερόλεπτα.");

            'user' => 'user123'

        ];    /**            return redirect()->back();

        

        return isset($validCredentials[$username]) &&      * Get current user data from session        }

               $validCredentials[$username] === $password;

    }     */

    

    /**    private function getUserData(): array        // Validate input

     * Create user session after successful authentication

     */    {        $rules = [

    private function createUserSession(string $username, bool $remember = false): void

    {        return [            'login' => [

        $currentTime = time();

                    'id' => session()->get('user_id'),                'label' => 'Email/Username',

        // Get user data (hardcoded for now)

        $userData = $this->getUserDataByUsername($username);            'username' => session()->get('username'),                'rules' => 'required'

        

        // Set session data            'email' => session()->get('email'),            ],

        $sessionData = [

            'user_id' => $userData['id'],            'full_name' => session()->get('full_name'),            'password' => [

            'username' => $userData['username'],

            'email' => $userData['email'],            'role' => session()->get('role'),                'label' => 'Κωδικός',

            'full_name' => $userData['full_name'],

            'role' => $userData['role'],            'login_time' => session()->get('login_time'),                'rules' => 'required'

            'logged_in' => true,

            'login_time' => $currentTime,            'last_activity' => session()->get('last_activity')            ]

            'last_activity' => $currentTime,

            'ip_address' => $this->request->getIPAddress(),        ];        ];

            'user_agent' => $this->request->getUserAgent()->getAgentString()

        ];    }

        

        session()->set($sessionData);            if (!$this->validate($rules)) {

        

        // Set remember me cookie if requested    /**            session()->setFlashdata('validation', $this->validator);

        if ($remember) {

            $this->setRememberMeCookie($userData['id']);     * Get remaining session time in seconds            return redirect()->back()->withInput();

        }

             */        }

        // Log login attempt (will be added later)

        // $this->logLoginAttempt($username, true);    private function getSessionTimeRemaining(): int

    }

        {        // Find user

    /**

     * Get user data by username (hardcoded for now)        $lastActivity = session()->get('last_activity') ?: time();        $user = $this->userModel->findByLogin($login);

     */

    private function getUserDataByUsername(string $username): array        $sessionTimeout = 1800; // 30 minutes

    {

        $users = [        $elapsed = time() - $lastActivity;        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {

            'admin' => [

                'id' => 1,                    // Record failed attempt

                'username' => 'admin',

                'email' => 'admin@manager.pikasishearing.gr',        return max(0, $sessionTimeout - $elapsed);            $this->loginAttemptModel->recordAttempt($ipAddress, $login);

                'full_name' => 'Administrator',

                'role' => 'Admin'    }            

            ],

            'spikasis' => [                session()->setFlashdata('error', $this->authConfig->messages['login_unsuccessful']);

                'id' => 2,

                'username' => 'spikasis',    /**            return redirect()->back()->withInput();

                'email' => 'spikasis@gmail.com',

                'full_name' => 'Spiros Pikasis',     * Show authenticated user view        }

                'role' => 'Owner'

            ],     */

            'user' => [

                'id' => 3,    private function showAuthenticatedView()        // Check if user is active

                'username' => 'user',

                'email' => 'user@manager.pikasishearing.gr',    {        if (!$user['active']) {

                'full_name' => 'Test User',

                'role' => 'User'        $data = [            session()->setFlashdata('error', 'Ο λογαριασμός δεν είναι ενεργός. Επικοινωνήστε με τον διαχειριστή.');

            ]

        ];            'title' => 'Dashboard - PHA Manager v4',            return redirect()->back();

        

        return $users[$username] ?? $users['admin'];            'user' => $this->getUserData(),        }

    }

                'authenticated' => true,

    /**

     * Set remember me cookie            'session_remaining' => $this->getSessionTimeRemaining()        // Clear failed attempts for this IP and login

     */

    private function setRememberMeCookie(int $userId): void        ];        $this->loginAttemptModel->clearAttemptsForIp($ipAddress);

    {

        $token = bin2hex(random_bytes(32));                $this->loginAttemptModel->clearAttemptsForLogin($login);

        $expiry = time() + (86400 * 30); // 30 days

                return view('auth/authenticated', $data);

        // Set cookie

        setcookie(    }        // Set remember me cookie if requested

            'remember_token',

            $token,            if ($remember) {

            $expiry,

            '/',    /**            $rememberCode = $this->userModel->generateRememberCode();

            '',

            true, // Secure     * Show login form view            $this->userModel->setRememberCode($user['id'], $rememberCode);

            true  // HttpOnly

        );     */            

        

        // Store token in session for validation    private function showLoginView()            $cookieValue = $user['id'] . ':' . $rememberCode;

        session()->set('remember_token', $token);

    }    {            $cookie = [

}
        $data = [                'name' => $this->authConfig->cookies['remember'],

            'title' => 'Σύνδεση - PHA Manager v4',                'value' => $cookieValue,

            'authenticated' => false,                'expire' => $this->authConfig->rememberMeDuration

            'csrf_token' => csrf_hash()            ];

        ];            $this->response->setCookie($cookie);

                }

        return view('auth/login', $data);

    }        // Update last login

            $this->userModel->updateLastLogin($user['id']);

    /**

     * Process login form submission (POST)        // Set session data

     */        $this->setUserSession($user);

    private function processLoginForm()

    {        session()->setFlashdata('success', $this->authConfig->messages['login_successful']);

        // Validate CSRF token        

        if (!$this->validateCSRF()) {        // Determine redirect URL based on user role and groups

            session()->setFlashdata('error', 'Μη έγκυρη αίτηση. Δοκιμάστε ξανά.');        $redirectUrl = session('redirect_url') ?? $this->getDashboardRedirectUrl($user);

            return redirect()->to(site_url('auth'));        session()->remove('redirect_url');

        }        

                // NO REDIRECT - Just show success message

        // Get form data        echo "<!DOCTYPE html><html><head><title>Login Success</title></head><body>";

        $username = $this->request->getPost('username');        echo "<h1>✅ LOGIN SUCCESSFUL!</h1>";

        $password = $this->request->getPost('password');        echo "<p>Username: " . ($user['username'] ?? 'Unknown') . "</p>";

        $remember = $this->request->getPost('remember_me');        echo "<p>Email: " . ($user['email'] ?? 'Unknown') . "</p>";

                echo "<p>User ID: " . ($user['id'] ?? 'Unknown') . "</p>";

        // Validate form data        echo "<p>Session set successfully!</p>";

        if (!$username || !$password) {        echo "<h2>Manual Navigation:</h2>";

            session()->setFlashdata('error', 'Παρακαλώ εισάγετε όνομα χρήστη και κωδικό.');        echo "<ul>";

            return redirect()->to(site_url('auth'));        echo "<li><a href='/simple-test'>Simple Test</a></li>";

        }        echo "<li><a href='/dashboard'>Dashboard</a></li>";

                echo "<li><a href='/'>Home</a></li>";

        // Authenticate user        echo "</ul>";

        if ($this->authenticateUser($username, $password)) {        echo "</body></html>";

            $this->createUserSession($username, $remember);        exit;

            session()->setFlashdata('success', 'Καλώς ήρθατε στο PHA Manager v4!');        

            return redirect()->to(site_url('dashboard'));        // Original redirect code (commented for now)

        }        // return redirect()->to($redirectUrl);

                */

        // Authentication failed    }

        session()->setFlashdata('error', 'Λάθος στοιχεία σύνδεσης. Δοκιμάστε ξανά.');

        return redirect()->to(site_url('auth'));    /**

    }     * Logout user

         */

    /**    public function logout()

     * Process direct login (GET) - for admin/development    {

     */        $userId = session($this->authConfig->sessionUserIdKey);

    private function processDirectLogin()        

    {        if ($userId) {

        // Create admin session directly (for development)            // Clear remember me cookie and code

        $this->createUserSession('admin', false);            $this->userModel->clearRememberCode($userId);

        session()->setFlashdata('success', 'Επιτυχής άμεση σύνδεση στο σύστημα!');            $this->response->deleteCookie($this->authConfig->cookies['remember']);

        return redirect()->to(site_url('dashboard'));        }

    }

            // Destroy session

    /**        session()->destroy();

     * Validate CSRF token

     */        session()->setFlashdata('success', $this->authConfig->messages['logout_successful']);

    private function validateCSRF(): bool        return redirect()->to($this->authConfig->logoutRedirect);

    {    }

        $token = $this->request->getPost(csrf_token());

        return csrf_verify($token);    /**

    }     * Display registration form

         */

    /**    public function register()

     * Authenticate user credentials    {

     * For now using hardcoded credentials - will be replaced with database        if (!$this->authConfig->allowRegistration) {

     */            throw new \CodeIgniter\Exceptions\PageNotFoundException('Η εγγραφή δεν είναι διαθέσιμη');

    private function authenticateUser(string $username, string $password): bool        }

    {

        // Hardcoded credentials for development        // Redirect if already logged in

        $validCredentials = [        if ($this->isLoggedIn()) {

            'admin' => 'admin123',            return redirect()->to($this->authConfig->loginRedirect);

            'spikasis' => 'spikos2024',        }

            'user' => 'user123'

        ];        $data = [

                    'title' => 'Εγγραφή',

        return isset($validCredentials[$username]) &&             'validation' => session('validation')

               $validCredentials[$username] === $password;        ];

    }

            return view('auth/register', $data);

    /**    }

     * Create user session after successful authentication

     */    /**

    private function createUserSession(string $username, bool $remember = false): void     * Process registration

    {     */

        $currentTime = time();    public function attemptRegister()

            {

        // Get user data (hardcoded for now)        if (!$this->authConfig->allowRegistration) {

        $userData = $this->getUserDataByUsername($username);            throw new \CodeIgniter\Exceptions\PageNotFoundException('Η εγγραφή δεν είναι διαθέσιμη');

                }

        // Set session data

        $sessionData = [        $rules = $this->userModel->getUserValidationRules();

            'user_id' => $userData['id'],

            'username' => $userData['username'],        if (!$this->validate($rules)) {

            'email' => $userData['email'],            session()->setFlashdata('validation', $this->validator);

            'full_name' => $userData['full_name'],            return redirect()->back()->withInput();

            'role' => $userData['role'],        }

            'logged_in' => true,

            'login_time' => $currentTime,        $userData = [

            'last_activity' => $currentTime,            'username' => $this->request->getPost('username'),

            'ip_address' => $this->request->getIPAddress(),            'email' => $this->request->getPost('email'),

            'user_agent' => $this->request->getUserAgent()->getAgentString()            'password' => $this->request->getPost('password'),

        ];            'first_name' => $this->request->getPost('first_name'),

                    'last_name' => $this->request->getPost('last_name'),

        session()->set($sessionData);            'company' => $this->request->getPost('company'),

                    'phone' => $this->request->getPost('phone'),

        // Set remember me cookie if requested            'active' => $this->authConfig->requireEmailActivation ? 0 : 1,

        if ($remember) {            'created_on' => time()

            $this->setRememberMeCookie($userData['id']);        ];

        }

                // Generate activation code if required

        // Log login attempt (will be added later)        if ($this->authConfig->requireEmailActivation) {

        // $this->logLoginAttempt($username, true);            $userData['activation_code'] = $this->userModel->generateActivationCode();

    }        }

    

    /**        try {

     * Get user data by username (hardcoded for now)            $userId = $this->userModel->insert($userData);

     */            

    private function getUserDataByUsername(string $username): array            if ($userId) {

    {                // Add user to default group

        $users = [                $defaultGroup = $this->groupModel->findByName($this->authConfig->defaultGroup);

            'admin' => [                if ($defaultGroup) {

                'id' => 1,                    $this->userModel->addToGroup($userId, $defaultGroup['id']);

                'username' => 'admin',                }

                'email' => 'admin@manager.pikasishearing.gr',

                'full_name' => 'Administrator',                if ($this->authConfig->requireEmailActivation) {

                'role' => 'Admin'                    // Send activation email (implementation needed)

            ],                    session()->setFlashdata('success', 'Η εγγραφή ολοκληρώθηκε. Ελέγξτε το email σας για ενεργοποίηση.');

            'spikasis' => [                } else {

                'id' => 2,                    session()->setFlashdata('success', $this->authConfig->messages['registration_successful']);

                'username' => 'spikasis',                }

                'email' => 'spikasis@gmail.com',                

                'full_name' => 'Spiros Pikasis',                return redirect()->to('/auth/login');

                'role' => 'Owner'            } else {

            ],                session()->setFlashdata('error', $this->authConfig->messages['registration_unsuccessful']);

            'user' => [                return redirect()->back()->withInput();

                'id' => 3,            }

                'username' => 'user',        } catch (\Exception $e) {

                'email' => 'user@manager.pikasishearing.gr',            session()->setFlashdata('error', 'Σφάλμα κατά την εγγραφή: ' . $e->getMessage());

                'full_name' => 'Test User',            return redirect()->back()->withInput();

                'role' => 'User'        }

            ]    }

        ];

            /**

        return $users[$username] ?? $users['admin'];     * Activate user account

    }     */

        public function activate($code = null)

    /**    {

     * Set remember me cookie        if (!$code) {

     */            throw new \CodeIgniter\Exceptions\PageNotFoundException('Μη έγκυρος κωδικός ενεργοποίησης');

    private function setRememberMeCookie(int $userId): void        }

    {

        $token = bin2hex(random_bytes(32));        $user = $this->userModel->findByActivationCode($code);

        $expiry = time() + (86400 * 30); // 30 days        

                if (!$user) {

        // Set cookie            session()->setFlashdata('error', 'Μη έγκυρος κωδικός ενεργοποίησης');

        setcookie(            return redirect()->to('/auth/login');

            'remember_token',        }

            $token,

            $expiry,        if ($this->userModel->activateUser($user['id'])) {

            '/',            session()->setFlashdata('success', $this->authConfig->messages['activation_successful']);

            '',        } else {

            true, // Secure            session()->setFlashdata('error', $this->authConfig->messages['activation_unsuccessful']);

            true  // HttpOnly        }

        );

                return redirect()->to('/auth/login');

        // Store token in session for validation    }

        session()->set('remember_token', $token);

    }    /**

}     * Display forgot password form
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
            return base_url('/');
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
        return base_url('/');
    }
}