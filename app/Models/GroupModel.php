<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends BaseCRUDModel
{
    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];
    
    protected $useTimestamps = false;
    protected $createdField = 'created_on';
    protected $updatedField = 'last_modified';
    
    protected $returnType = 'array';
    
    // Validation rules
    protected $validationRules = [
        'name' => 'required|max_length[100]|is_unique[groups.name,id,{id}]',
        'description' => 'permit_empty|max_length[255]'
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'Το όνομα της ομάδας είναι υποχρεωτικό.',
            'max_length' => 'Το όνομα δεν μπορεί να υπερβαίνει τους 100 χαρακτήρες.',
            'is_unique' => 'Αυτό το όνομα ομάδας χρησιμοποιείται ήδη.'
        ],
        'description' => [
            'max_length' => 'Η περιγραφή δεν μπορεί να υπερβαίνει τους 255 χαρακτήρες.'
        ]
    ];
    
    // Fields that can be searched
    protected $searchableFields = ['name', 'description'];
    
    // Display field for dropdowns
    protected $displayField = 'name';

    public function __construct()
    {
        parent::__construct();
        $this->table = 'groups';
        $this->primaryKey = 'id';
    }

    /**
     * Get groups with user count
     */
    public function getGroupsWithUserCount()
    {
        return $this->select('groups.*, COUNT(users.id) as user_count')
                    ->join('users', 'users.group_id = groups.id', 'left')
                    ->groupBy('groups.id')
                    ->findAll();
    }

    /**
     * Find group by name
     */
    public function findByName(string $name)
    {
        return $this->where('name', $name)->first();
    }



    /**
     * Get group with users
     */
    public function getGroupWithUsers($id)
    {
        $group = $this->find($id);
        if (!$group) return null;
        
        // Get users in this group
        $userModel = new \App\Models\UserModel();
        $users = $userModel->select('id, username, email, first_name, last_name, active')
                          ->where('group_id', $id)
                          ->findAll();
        
        $group['users'] = $users;
        $group['user_count'] = count($users);
        
        return $group;
    }

    /**
     * Add user to group
     */
    public function addUserToGroup(int $groupId, int $userId): bool
    {
        // Check if user is already in group
        $existing = $this->db->table('users_groups')
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

        return $this->db->table('users_groups')->insert($data);
    }

    /**
     * Remove user from group
     */
    public function removeUserFromGroup(int $groupId, int $userId): bool
    {
        return $this->db->table('users_groups')
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
                INNER JOIN users_groups ug ON g.id = ug.group_id
            ")->getRow()->{'COUNT(DISTINCT g.id)'},
            'empty_groups' => $this->db->query("
                SELECT COUNT(g.id) 
                FROM {$this->table} g 
                LEFT JOIN users_groups ug ON g.id = ug.group_id 
                WHERE ug.group_id IS NULL
            ")->getRow()->{'COUNT(g.id)'}
        ];
    }
}