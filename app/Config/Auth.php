<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Auth extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Authentication Settings
     * --------------------------------------------------------------------------
     */
    
    /**
     * Default user group
     */
    public string $defaultGroup = 'members';
    
    /**
     * Admin group name
     */
    public string $adminGroup = 'admin';
    
    /**
     * Session key for user ID
     */
    public string $sessionUserIdKey = 'user_id';
    
    /**
     * Session key for user data
     */
    public string $sessionUserDataKey = 'user_data';
    
    /**
     * Login redirect URL
     */
    public string $loginRedirect = 'dashboard';
    
    /**
     * Logout redirect URL
     */
    public string $logoutRedirect = 'auth/login';
    
    /**
     * Login URL
     */
    public string $loginUrl = '/auth/login';
    
    /**
     * Registration enabled
     */
    public bool $allowRegistration = true;
    
    /**
     * Email activation required
     */
    public bool $requireEmailActivation = false;
    
    /**
     * Remember me functionality
     */
    public bool $allowRememberMe = true;
    
    /**
     * Remember me duration (seconds)
     */
    public int $rememberMeDuration = 2592000; // 30 days
    
    /**
     * Maximum login attempts before lockout
     */
    public int $maxLoginAttempts = 5;
    
    /**
     * Lockout duration in seconds
     */
    public int $lockoutDuration = 900; // 15 minutes
    
    /**
     * Password minimum length
     */
    public int $minPasswordLength = 8;
    
    /**
     * Password requires uppercase letter
     */
    public bool $passwordRequireUppercase = true;
    
    /**
     * Password requires lowercase letter
     */
    public bool $passwordRequireLowercase = true;
    
    /**
     * Password requires number
     */
    public bool $passwordRequireNumber = true;
    
    /**
     * Password requires special character
     */
    public bool $passwordRequireSpecial = false;
    
    /**
     * Hash algorithm for passwords
     */
    public string $hashAlgorithm = 'bcrypt';
    
    /**
     * Bcrypt cost
     */
    public int $bcryptCost = 12;
    
    /**
     * Tables configuration
     */
    public array $tables = [
        'users'          => 'users',
        'groups'         => 'groups',
        'users_groups'   => 'users_groups',
        'login_attempts' => 'login_attempts',
    ];
    
    /**
     * Users table columns
     */
    public array $columns = [
        'users' => [
            'id'               => 'id',
            'username'         => 'username',
            'email'           => 'email',
            'password'        => 'password',
            'first_name'      => 'first_name',
            'last_name'       => 'last_name',
            'company'         => 'company',
            'phone'           => 'phone',
            'active'          => 'active',
            'activation_code' => 'activation_code',
            'forgotten_password_code' => 'forgotten_password_code',
            'forgotten_password_time' => 'forgotten_password_time',
            'remember_code'   => 'remember_code',
            'created_on'      => 'created_on',
            'last_login'      => 'last_login',
        ],
        'groups' => [
            'id'          => 'id',
            'name'        => 'name',
            'description' => 'description',
        ],
        'users_groups' => [
            'id'       => 'id',
            'user_id'  => 'user_id',
            'group_id' => 'group_id',
        ],
        'login_attempts' => [
            'id'         => 'id',
            'ip_address' => 'ip_address',
            'login'      => 'login',
            'time'       => 'time',
        ],
    ];
    
    /**
     * Cookie names
     */
    public array $cookies = [
        'remember' => 'ci_remember_me',
    ];
    
    /**
     * Messages configuration
     */
    public array $messages = [
        'login_successful'           => 'Επιτυχής σύνδεση',
        'login_unsuccessful'         => 'Λάθος στοιχεία σύνδεσης',
        'login_timeout'             => 'Η συνεδρία έληξε',
        'logout_successful'         => 'Αποσυνδεθήκατε επιτυχώς',
        'account_locked'            => 'Ο λογαριασμός είναι κλειδωμένος',
        'password_change_successful' => 'Ο κωδικός άλλαξε επιτυχώς',
        'password_change_unsuccessful' => 'Αποτυχία αλλαγής κωδικού',
        'forgot_password_successful' => 'Email επαναφοράς στάλθηκε',
        'forgot_password_unsuccessful' => 'Αποτυχία επαναφοράς κωδικού',
        'registration_successful'    => 'Επιτυχής εγγραφή',
        'registration_unsuccessful'  => 'Αποτυχία εγγραφής',
        'activation_successful'      => 'Ο λογαριασμός ενεργοποιήθηκε',
        'activation_unsuccessful'    => 'Αποτυχία ενεργοποίησης',
        'deactivation_successful'    => 'Ο λογαριασμός απενεργοποιήθηκε',
        'deactivation_unsuccessful'  => 'Αποτυχία απενεργοποίησης',
        'delete_successful'          => 'Ο χρήστης διαγράφηκε',
        'delete_unsuccessful'        => 'Αποτυχία διαγραφής',
        'group_creation_successful'  => 'Η ομάδα δημιουργήθηκε',
        'group_already_exists'       => 'Η ομάδα υπάρχει ήδη',
        'group_update_successful'    => 'Η ομάδα ενημερώθηκε',
        'group_delete_successful'    => 'Η ομάδα διαγράφηκε',
        'insufficient_permissions'   => 'Ανεπαρκή δικαιώματα',
        'access_denied'             => 'Άρνηση πρόσβασης',
    ];
}