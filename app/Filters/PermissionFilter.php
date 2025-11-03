<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Auth as AuthConfig;

class PermissionFilter implements FilterInterface
{
    protected $authConfig;

    public function __construct()
    {
        $this->authConfig = new AuthConfig();
    }

    /**
     * Before filter - check specific permissions
     * Arguments should contain the required permissions in format: 'module.action'
     * Example: 'customers.create', 'reports.read', etc.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // First check if user is authenticated
        $userId = session($this->authConfig->sessionUserIdKey);
        
        if (!$userId) {
            session()->set('redirect_url', current_url());
            session()->setFlashdata('error', 'Πρέπει να συνδεθείτε για να προβάλετε αυτή τη σελίδα.');
            return redirect()->to($this->authConfig->loginUrl);
        }

        // Get required permissions from arguments
        if (!$arguments) {
            return; // No specific permissions required
        }

        $requiredPermissions = is_array($arguments) ? $arguments : [$arguments];
        
        // Check if user has required permissions
        if (!$this->hasPermissions($userId, $requiredPermissions)) {
            session()->setFlashdata('error', $this->authConfig->messages['insufficient_permissions']);
            return redirect()->back();
        }
    }

    /**
     * After filter
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Optional: Log permission-based actions
    }

    /**
     * Check if user has required permissions
     */
    private function hasPermissions(int $userId, array $requiredPermissions): bool
    {
        $userModel = new \App\Models\UserModel();
        $groupModel = new \App\Models\GroupModel();
        
        // Get user groups
        $userGroups = $userModel->getUserGroups($userId);
        
        // Admin has all permissions
        $isAdmin = $userModel->isInGroup($userId, $this->authConfig->adminGroup);
        if ($isAdmin) {
            return true;
        }

        // Check each required permission
        foreach ($requiredPermissions as $permission) {
            $hasPermission = false;
            
            // Parse permission (module.action)
            $parts = explode('.', $permission);
            if (count($parts) !== 2) {
                continue; // Invalid permission format
            }
            
            [$module, $action] = $parts;
            
            // Check permissions for each user group
            foreach ($userGroups as $group) {
                $groupPermissions = $groupModel->getGroupPermissions($group['id']);
                
                if (isset($groupPermissions[$module]) && in_array($action, $groupPermissions[$module])) {
                    $hasPermission = true;
                    break;
                }
            }
            
            if (!$hasPermission) {
                return false;
            }
        }
        
        return true;
    }
}