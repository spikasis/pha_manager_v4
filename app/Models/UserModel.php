<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Auth as AuthConfig;

class UserModel extends Model
{
    protected $table;
    protected $primaryKey;
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'username', 'email', 'password', 'first_name', 'last_name', 
        'company', 'phone', 'active', 'activation_code', 
        'forgotten_password_code', 'forgotten_password_time', 
        'remember_code', 'last_login'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_on';
    protected $updatedField = false;
    protected $deletedField = false;

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['hashPassword'];
    protected $afterInsert = [];
    protected $beforeUpdate = ['hashPassword'];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    protected $authConfig;

    public function __construct()
    {
        parent::__construct();
        $this->authConfig = new AuthConfig();
        $this->table = $this->authConfig->tables['users'];
        $this->primaryKey = $this->authConfig->columns['users']['id'];
    }

    /**
     * Hash password before insert/update
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * Find user by email or username
     */
    public function findByLogin(string $login)
    {
        return $this->where('email', $login)
                   ->orWhere('username', $login)
                   ->first();
    }

    /**
     * Find user by email
     */
    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Find user by username
     */
    public function findByUsername(string $username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Find user by remember code
     */
    public function findByRememberCode(string $code)
    {
        return $this->where('remember_code', $code)->first();
    }

    /**
     * Find user by activation code
     */
    public function findByActivationCode(string $code)
    {
        return $this->where('activation_code', $code)->first();
    }

    /**
     * Find user by forgotten password code
     */
    public function findByForgottenCode(string $code)
    {
        return $this->where('forgotten_password_code', $code)->first();
    }

    /**
     * Verify password
     */
    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Generate activation code
     */
    public function generateActivationCode(): string
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * Generate remember code
     */
    public function generateRememberCode(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Generate forgotten password code
     */
    public function generateForgottenPasswordCode(): string
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * Set remember code
     */
    public function setRememberCode(int $userId, string $code): bool
    {
        return $this->update($userId, ['remember_code' => $code]);
    }

    /**
     * Clear remember code
     */
    public function clearRememberCode(int $userId): bool
    {
        return $this->update($userId, ['remember_code' => null]);
    }

    /**
     * Update last login
     */
    public function updateLastLogin(int $userId): bool
    {
        return $this->update($userId, ['last_login' => time()]);
    }

    /**
     * Activate user
     */
    public function activateUser(int $userId): bool
    {
        return $this->update($userId, [
            'active' => 1,
            'activation_code' => null
        ]);
    }

    /**
     * Deactivate user
     */
    public function deactivateUser(int $userId): bool
    {
        return $this->update($userId, ['active' => 0]);
    }

    /**
     * Get active users
     */
    public function getActiveUsers()
    {
        return $this->where('active', 1)->findAll();
    }

    /**
     * Get users with groups
     */
    public function getUsersWithGroups()
    {
        $builder = $this->db->table($this->table . ' u');
        $builder->select('u.*, g.name as group_name, g.description as group_description');
        $builder->join($this->authConfig->tables['users_groups'] . ' ug', 'u.id = ug.user_id', 'left');
        $builder->join($this->authConfig->tables['groups'] . ' g', 'ug.group_id = g.id', 'left');
        $builder->where('u.active', 1);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get user groups
     */
    public function getUserGroups(int $userId): array
    {
        $builder = $this->db->table($this->authConfig->tables['users_groups'] . ' ug');
        $builder->select('g.*');
        $builder->join($this->authConfig->tables['groups'] . ' g', 'ug.group_id = g.id');
        $builder->where('ug.user_id', $userId);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Check if user is in group
     */
    public function isInGroup(int $userId, $groupId): bool
    {
        $builder = $this->db->table($this->authConfig->tables['users_groups']);
        
        if (is_string($groupId)) {
            // Group name provided
            $builder->join($this->authConfig->tables['groups'] . ' g', 'users_groups.group_id = g.id');
            $builder->where('g.name', $groupId);
        } else {
            // Group ID provided
            $builder->where('group_id', $groupId);
        }
        
        $builder->where('user_id', $userId);
        
        return $builder->countAllResults() > 0;
    }

    /**
     * Add user to group
     */
    public function addToGroup(int $userId, int $groupId): bool
    {
        if ($this->isInGroup($userId, $groupId)) {
            return true; // Already in group
        }

        $data = [
            'user_id' => $userId,
            'group_id' => $groupId
        ];

        return $this->db->table($this->authConfig->tables['users_groups'])->insert($data);
    }

    /**
     * Remove user from group
     */
    public function removeFromGroup(int $userId, int $groupId): bool
    {
        return $this->db->table($this->authConfig->tables['users_groups'])
                       ->where('user_id', $userId)
                       ->where('group_id', $groupId)
                       ->delete();
    }

    /**
     * Get user validation rules
     */
    public function getUserValidationRules(bool $isUpdate = false): array
    {
        $rules = [
            'first_name' => [
                'label' => 'Όνομα',
                'rules' => 'required|min_length[2]|max_length[100]'
            ],
            'last_name' => [
                'label' => 'Επώνυμο',
                'rules' => 'required|min_length[2]|max_length[100]'
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|max_length[150]'
            ],
            'phone' => [
                'label' => 'Τηλέφωνο',
                'rules' => 'permit_empty|min_length[10]|max_length[15]'
            ],
            'company' => [
                'label' => 'Εταιρεία',
                'rules' => 'permit_empty|max_length[100]'
            ]
        ];

        if (!$isUpdate) {
            $rules['username'] = [
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[50]|is_unique[users.username]'
            ];
            $rules['email']['rules'] .= '|is_unique[users.email]';
            $rules['password'] = [
                'label' => 'Κωδικός',
                'rules' => "required|min_length[{$this->authConfig->minPasswordLength}]"
            ];
            $rules['confirm_password'] = [
                'label' => 'Επιβεβαίωση Κωδικού',
                'rules' => 'required|matches[password]'
            ];
        }

        return $rules;
    }

    /**
     * Get user statistics
     */
    public function getUserStatistics(): array
    {
        return [
            'total_users' => $this->countAll(),
            'active_users' => $this->where('active', 1)->countAllResults(),
            'inactive_users' => $this->where('active', 0)->countAllResults(),
            'recent_registrations' => $this->where('created_on >', date('Y-m-d H:i:s', strtotime('-30 days')))->countAllResults()
        ];
    }

    /**
     * Search users
     */
    public function searchUsers(string $search, int $limit = 20, int $offset = 0): array
    {
        $builder = $this->builder();
        $builder->groupStart()
                ->like('first_name', $search)
                ->orLike('last_name', $search)
                ->orLike('email', $search)
                ->orLike('username', $search)
                ->orLike('company', $search)
                ->groupEnd();
        
        return $builder->limit($limit, $offset)->get()->getResultArray();
    }
}