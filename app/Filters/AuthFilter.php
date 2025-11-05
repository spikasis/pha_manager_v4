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
        // Check if user is logged in - support both methods
        $userId = session($this->authConfig->sessionUserIdKey);
        $isLoggedIn = session('logged_in') || session('is_logged_in');
        
        if (!$userId && !$isLoggedIn) {
            // Store the current URL for redirect after login
            $currentUrl = current_url();
            session()->set('redirect_url', $currentUrl);
            
            // Set flash message
            session()->setFlashdata('error', 'Πρέπει να συνδεθείτε για να προβάλετε αυτή τη σελίδα.');
            
            // Redirect to login page
            return redirect()->to($this->authConfig->loginUrl);
        }

        // If we have a user ID, check if user is still active (skip for direct login)
        if ($userId && $userId > 0) {
            try {
                $userModel = new \App\Models\UserModel();
                $user = $userModel->find($userId);
                
                if (!$user || (isset($user['active']) && !$user['active'])) {
                    // Destroy session and redirect to login
                    session()->destroy();
                    session()->setFlashdata('error', 'Ο λογαριασμός σας έχει απενεργοποιηθεί. Επικοινωνήστε με τον διαχειριστή.');
                    return redirect()->to($this->authConfig->loginUrl);
                }
            } catch (\Exception $e) {
                // If there's a database error, allow direct login to work
                if (!$isLoggedIn) {
                    return redirect()->to($this->authConfig->loginUrl);
                }
            }
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