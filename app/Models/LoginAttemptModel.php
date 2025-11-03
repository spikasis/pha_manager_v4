<?php

namespace App\Models;

use App\Models\BaseCRUDModel;
use Config\Auth as AuthConfig;

class LoginAttemptModel extends BaseCRUDModel
{
    protected $table = 'login_attempts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['ip_address', 'login', 'time'];
    
    protected $useTimestamps = false;
    protected $createdField = 'time';
    protected $updatedField = false;
    
    protected $returnType = 'array';
    
    // Validation rules  
    protected $validationRules = [
        'ip_address' => 'required|valid_ip',
        'login' => 'required|max_length[255]',
        'time' => 'required|integer'
    ];
    
    protected $validationMessages = [
        'ip_address' => [
            'required' => 'Η IP διεύθυνση είναι υποχρεωτική.',
            'valid_ip' => 'Μη έγκυρη IP διεύθυνση.'
        ],
        'login' => [
            'required' => 'Το login είναι υποχρεωτικό.',
            'max_length' => 'Το login δεν μπορεί να υπερβαίνει τους 255 χαρακτήρες.'
        ]
    ];
    
    // Fields that can be searched
    protected $searchableFields = ['ip_address', 'login'];
    
    // Display field for dropdowns (not applicable for login attempts)
    protected $displayField = 'login';

    protected $authConfig;

    public function __construct()
    {
        parent::__construct();
        $this->authConfig = new AuthConfig();
        $this->table = $this->authConfig->tables['login_attempts'];
        $this->primaryKey = $this->authConfig->columns['login_attempts']['id'];
    }

    /**
     * Record a login attempt
     */
    public function recordAttempt(string $ipAddress, string $login): bool
    {
        $data = [
            'ip_address' => $ipAddress,
            'login' => $login,
            'time' => time()
        ];

        return $this->insert($data) !== false;
    }

    /**
     * Get attempts count for IP address
     */
    public function getAttemptsCountByIp(string $ipAddress, int $timeWindow = null): int
    {
        $timeWindow = $timeWindow ?? $this->authConfig->lockoutDuration;
        $cutoffTime = time() - $timeWindow;

        return $this->where('ip_address', $ipAddress)
                   ->where('time >', $cutoffTime)
                   ->countAllResults();
    }

    /**
     * Get attempts count for login (email/username)
     */
    public function getAttemptsCountByLogin(string $login, int $timeWindow = null): int
    {
        $timeWindow = $timeWindow ?? $this->authConfig->lockoutDuration;
        $cutoffTime = time() - $timeWindow;

        return $this->where('login', $login)
                   ->where('time >', $cutoffTime)
                   ->countAllResults();
    }

    /**
     * Check if IP is locked out
     */
    public function isIpLockedOut(string $ipAddress): bool
    {
        $attemptCount = $this->getAttemptsCountByIp($ipAddress);
        return $attemptCount >= $this->authConfig->maxLoginAttempts;
    }

    /**
     * Check if login is locked out
     */
    public function isLoginLockedOut(string $login): bool
    {
        $attemptCount = $this->getAttemptsCountByLogin($login);
        return $attemptCount >= $this->authConfig->maxLoginAttempts;
    }

    /**
     * Get lockout time remaining for IP
     */
    public function getLockoutTimeRemainingForIp(string $ipAddress): int
    {
        $cutoffTime = time() - $this->authConfig->lockoutDuration;
        
        $lastAttempt = $this->where('ip_address', $ipAddress)
                           ->where('time >', $cutoffTime)
                           ->orderBy('time', 'DESC')
                           ->first();

        if (!$lastAttempt) {
            return 0;
        }

        $timeRemaining = ($lastAttempt['time'] + $this->authConfig->lockoutDuration) - time();
        return max(0, $timeRemaining);
    }

    /**
     * Get lockout time remaining for login
     */
    public function getLockoutTimeRemainingForLogin(string $login): int
    {
        $cutoffTime = time() - $this->authConfig->lockoutDuration;
        
        $lastAttempt = $this->where('login', $login)
                           ->where('time >', $cutoffTime)
                           ->orderBy('time', 'DESC')
                           ->first();

        if (!$lastAttempt) {
            return 0;
        }

        $timeRemaining = ($lastAttempt['time'] + $this->authConfig->lockoutDuration) - time();
        return max(0, $timeRemaining);
    }

    /**
     * Clear attempts for IP address
     */
    public function clearAttemptsForIp(string $ipAddress): bool
    {
        return $this->where('ip_address', $ipAddress)->delete();
    }

    /**
     * Clear attempts for login
     */
    public function clearAttemptsForLogin(string $login): bool
    {
        return $this->where('login', $login)->delete();
    }

    /**
     * Clear old attempts (older than lockout duration)
     */
    public function clearOldAttempts(): bool
    {
        $cutoffTime = time() - ($this->authConfig->lockoutDuration * 2); // Keep for 2x lockout duration
        return $this->where('time <', $cutoffTime)->delete();
    }

    /**
     * Get recent attempts for monitoring
     */
    public function getRecentAttempts(int $limit = 50): array
    {
        return $this->orderBy('time', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    /**
     * Get attempts statistics
     */
    public function getAttemptsStatistics(): array
    {
        $now = time();
        $last24Hours = $now - 86400; // 24 hours
        $lastHour = $now - 3600;     // 1 hour

        return [
            'total_attempts' => $this->countAll(),
            'last_24_hours' => $this->where('time >', $last24Hours)->countAllResults(),
            'last_hour' => $this->where('time >', $lastHour)->countAllResults(),
            'unique_ips_24h' => $this->db->query("
                SELECT COUNT(DISTINCT ip_address) as count 
                FROM {$this->table} 
                WHERE time > {$last24Hours}
            ")->getRow()->count ?? 0,
            'top_attempted_logins' => $this->db->query("
                SELECT login, COUNT(*) as attempts 
                FROM {$this->table} 
                WHERE time > {$last24Hours}
                GROUP BY login 
                ORDER BY attempts DESC 
                LIMIT 10
            ")->getResultArray(),
            'top_attempting_ips' => $this->db->query("
                SELECT ip_address, COUNT(*) as attempts 
                FROM {$this->table} 
                WHERE time > {$last24Hours}
                GROUP BY ip_address 
                ORDER BY attempts DESC 
                LIMIT 10
            ")->getResultArray()
        ];
    }

    /**
     * Get attempts by IP address
     */
    public function getAttemptsByIp(string $ipAddress, int $limit = 20): array
    {
        return $this->where('ip_address', $ipAddress)
                   ->orderBy('time', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    /**
     * Get attempts by login
     */
    public function getAttemptsByLogin(string $login, int $limit = 20): array
    {
        return $this->where('login', $login)
                   ->orderBy('time', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    /**
     * Check if this is a brute force attack pattern
     */
    public function detectBruteForcePattern(string $ipAddress, int $timeWindow = 300): array
    {
        $cutoffTime = time() - $timeWindow; // Default 5 minutes
        
        $attempts = $this->where('ip_address', $ipAddress)
                        ->where('time >', $cutoffTime)
                        ->orderBy('time', 'ASC')
                        ->findAll();

        if (count($attempts) < 3) {
            return ['is_brute_force' => false];
        }

        $uniqueLogins = array_unique(array_column($attempts, 'login'));
        $avgTimeBetweenAttempts = 0;
        
        if (count($attempts) > 1) {
            $totalTime = end($attempts)['time'] - $attempts[0]['time'];
            $avgTimeBetweenAttempts = $totalTime / (count($attempts) - 1);
        }

        return [
            'is_brute_force' => count($attempts) >= 5 && count($uniqueLogins) >= 3,
            'total_attempts' => count($attempts),
            'unique_logins_tried' => count($uniqueLogins),
            'avg_time_between_attempts' => $avgTimeBetweenAttempts,
            'time_span' => count($attempts) > 1 ? end($attempts)['time'] - $attempts[0]['time'] : 0,
            'risk_level' => $this->calculateRiskLevel($attempts)
        ];
    }

    /**
     * Calculate risk level based on attempt patterns
     */
    private function calculateRiskLevel(array $attempts): string
    {
        $count = count($attempts);
        $uniqueLogins = count(array_unique(array_column($attempts, 'login')));
        
        if ($count >= 10 && $uniqueLogins >= 5) {
            return 'HIGH';
        } elseif ($count >= 5 && $uniqueLogins >= 3) {
            return 'MEDIUM';
        } elseif ($count >= 3) {
            return 'LOW';
        }
        
        return 'NORMAL';
    }
}