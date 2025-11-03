<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Auth as AuthConfig;

class AdminFilter implements FilterInterface
{
    protected $authConfig;

    public function __construct()
    {
        $this->authConfig = new AuthConfig();
    }

    /**
     * Before filter - check if user is admin
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

        // Check if user is admin
        $userModel = new \App\Models\UserModel();
        $isAdmin = $userModel->isInGroup($userId, $this->authConfig->adminGroup);
        
        if (!$isAdmin) {
            session()->setFlashdata('error', $this->authConfig->messages['insufficient_permissions']);
            return redirect()->back();
        }
    }

    /**
     * After filter
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Optional: Log admin actions
    }
}