<?php

namespace App\Models;

use App\Models\BaseCRUDModel;

class UserModel extends BaseCRUDModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $displayField = 'full_name';
    
    public function getDashboardStats()
    {
        return [
            'total_users' => 0,
            'active_users' => 0,
            'inactive_users' => 0
        ];
    }
}
