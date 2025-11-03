<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Auth as AuthConfig;

class AuthFilter implements FilterInterface
{
    protected $authConfig;

    public function __construct()
    {
        $this->authConfig = new AuthConfig();
    }

    /**
     * Before filter - check if user is authenticated
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        $userId = session($this->authConfig->sessionUserIdKey);
        
        if (!$userId) {
            // Store the current URL for redirect after login
            $currentUrl = current_url();
            session()->set('redirect_url', $currentUrl);
            
            // Set flash message
            session()->setFlashdata('error', 'Πρέπει να συνδεθείτε για να προβάλετε αυτή τη σελίδα.');
            
            // Redirect to login page
            return redirect()->to($this->authConfig->loginUrl);
        }

        // Check if user is still active
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);
        
        if (!$user || !$user['active']) {
            // Destroy session and redirect to login
            session()->destroy();
            session()->setFlashdata('error', 'Ο λογαριασμός σας έχει απενεργοποιηθεί. Επικοινωνήστε με τον διαχειριστή.');
            return redirect()->to($this->authConfig->loginUrl);
        }
    }

    /**
     * After filter - can be used for logging, cleanup, etc.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Optional: Log user activity, update last seen, etc.
        $userId = session($this->authConfig->sessionUserIdKey);
        
        if ($userId) {
            // Update user's last activity timestamp
            // This could be implemented in the future for session management
        }
    }
}