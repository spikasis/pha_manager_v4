<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Auth as AuthConfig;

class GroupModel extends Model
{
    protected $table;
    protected $primaryKey;
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['name', 'description'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = '';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[50]|is_unique[groups.name]',
        'description' => 'permit_empty|max_length[255]'
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'Το όνομα της ομάδας είναι υποχρεωτικό',
            'min_length' => 'Το όνομα πρέπει να έχει τουλάχιστον 2 χαρακτήρες',
            'max_length' => 'Το όνομα δεν μπορεί να υπερβαίνει τους 50 χαρακτήρες',
            'is_unique' => 'Το όνομα της ομάδας υπάρχει ήδη'
        ],
        'description' => [
            'max_length' => 'Η περιγραφή δεν μπορεί να υπερβαίνει τους 255 χαρακτήρες'
        ]
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = ['checkGroupUsage'];
    protected $afterDelete = [];

    protected $authConfig;

    public function __construct()
    {
        parent::__construct();
        $this->authConfig = new AuthConfig();
        $this->table = $this->authConfig->tables['groups'];
        $this->primaryKey = $this->authConfig->columns['groups']['id'];
    }

    /**
     * Check if group is being used before deletion
     */
    protected function checkGroupUsage(array $data)
    {
        if (isset($data['id'])) {
            $groupId = is_array($data['id']) ? $data['id'] : [$data['id']];
            
            foreach ($groupId as $id) {
                $userCount = $this->db->table($this->authConfig->tables['users_groups'])
                                     ->where('group_id', $id)
                                     ->countAllResults();
                
                if ($userCount > 0) {
                    throw new \RuntimeException("Cannot delete group ID {$id} - it has {$userCount} users assigned");
                }
            }
        }
        
        return $data;
    }

    /**
     * Find group by name
     */
    public function findByName(string $name)
    {
        return $this->where('name', $name)->first();
    }

    /**
     * Get all groups with user count
     */
    public function getGroupsWithUserCount(): array
    {
        $builder = $this->db->table($this->table . ' g');
        $builder->select('g.*, COUNT(ug.user_id) as user_count');
        $builder->join($this->authConfig->tables['users_groups'] . ' ug', 'g.id = ug.group_id', 'left');
        $builder->groupBy('g.id');
        $builder->orderBy('g.name', 'ASC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get group users
     */
    public function getGroupUsers(int $groupId): array
    {
        $builder = $this->db->table($this->authConfig->tables['users'] . ' u');
        $builder->select('u.*');
        $builder->join($this->authConfig->tables['users_groups'] . ' ug', 'u.id = ug.user_id');
        $builder->where('ug.group_id', $groupId);
        $builder->where('u.active', 1);
        $builder->orderBy('u.last_name, u.first_name', 'ASC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Add user to group
     */
    public function addUserToGroup(int $groupId, int $userId): bool
    {
        // Check if user is already in group
        $existing = $this->db->table($this->authConfig->tables['users_groups'])
                            ->where('group_id', $groupId)
                            ->where('user_id', $userId)
                            ->get()
                            ->getRowArray();

        if ($existing) {
            return true; // Already in group
        }

        $data = [
            'group_id' => $groupId,
            'user_id' => $userId
        ];

        return $this->db->table($this->authConfig->tables['users_groups'])->insert($data);
    }

    /**
     * Remove user from group
     */
    public function removeUserFromGroup(int $groupId, int $userId): bool
    {
        return $this->db->table($this->authConfig->tables['users_groups'])
                       ->where('group_id', $groupId)
                       ->where('user_id', $userId)
                       ->delete();
    }

    /**
     * Get group permissions (for future implementation)
     */
    public function getGroupPermissions(int $groupId): array
    {
        // This would be implemented if we add a permissions system
        // For now, return basic permissions based on group name
        $group = $this->find($groupId);
        
        if (!$group) {
            return [];
        }

        switch ($group['name']) {
            case 'admin':
                return [
                    'customers' => ['create', 'read', 'update', 'delete', 'export'],
                    'services' => ['create', 'read', 'update', 'delete', 'export'],
                    'products' => ['create', 'read', 'update', 'delete', 'export'],
                    'financial' => ['create', 'read', 'update', 'delete', 'export'],
                    'reports' => ['create', 'read', 'export'],
                    'users' => ['create', 'read', 'update', 'delete'],
                    'groups' => ['create', 'read', 'update', 'delete'],
                    'system' => ['read', 'update']
                ];
                
            case 'manager':
                return [
                    'customers' => ['create', 'read', 'update', 'export'],
                    'services' => ['create', 'read', 'update', 'export'],
                    'products' => ['create', 'read', 'update', 'export'],
                    'financial' => ['read', 'export'],
                    'reports' => ['read', 'export'],
                    'users' => ['read'],
                    'groups' => ['read']
                ];
                
            case 'employee':
                return [
                    'customers' => ['create', 'read', 'update'],
                    'services' => ['create', 'read', 'update'],
                    'products' => ['read', 'update'],
                    'reports' => ['read']
                ];
                
            case 'members':
            default:
                return [
                    'customers' => ['read'],
                    'services' => ['read'],
                    'products' => ['read']
                ];
        }
    }

    /**
     * Create default groups
     */
    public function createDefaultGroups(): bool
    {
        $defaultGroups = [
            [
                'name' => 'admin',
                'description' => 'Διαχειριστές - Πλήρη δικαιώματα στο σύστημα'
            ],
            [
                'name' => 'manager',
                'description' => 'Διευθυντές - Δικαιώματα διαχείρισης και αναφορών'
            ],
            [
                'name' => 'employee',
                'description' => 'Υπάλληλοι - Βασικά δικαιώματα εργασίας'
            ],
            [
                'name' => 'members',
                'description' => 'Μέλη - Περιορισμένα δικαιώματα ανάγνωσης'
            ]
        ];

        foreach ($defaultGroups as $group) {
            // Check if group already exists
            $existing = $this->findByName($group['name']);
            if (!$existing) {
                $this->insert($group);
            }
        }

        return true;
    }

    /**
     * Get group validation rules
     */
    public function getGroupValidationRules(bool $isUpdate = false, int $groupId = null): array
    {
        $rules = [
            'name' => [
                'label' => 'Όνομα Ομάδας',
                'rules' => 'required|min_length[2]|max_length[50]'
            ],
            'description' => [
                'label' => 'Περιγραφή',
                'rules' => 'permit_empty|max_length[255]'
            ]
        ];

        if (!$isUpdate) {
            $rules['name']['rules'] .= '|is_unique[groups.name]';
        } elseif ($groupId) {
            $rules['name']['rules'] .= "|is_unique[groups.name,id,{$groupId}]";
        }

        return $rules;
    }

    /**
     * Get group statistics
     */
    public function getGroupStatistics(): array
    {
        return [
            'total_groups' => $this->countAll(),
            'groups_with_users' => $this->db->query("
                SELECT COUNT(DISTINCT g.id) 
                FROM {$this->table} g 
                INNER JOIN {$this->authConfig->tables['users_groups']} ug ON g.id = ug.group_id
            ")->getRow()->{'COUNT(DISTINCT g.id)'},
            'empty_groups' => $this->db->query("
                SELECT COUNT(g.id) 
                FROM {$this->table} g 
                LEFT JOIN {$this->authConfig->tables['users_groups']} ug ON g.id = ug.group_id 
                WHERE ug.group_id IS NULL
            ")->getRow()->{'COUNT(g.id)'}
        ];
    }
}