<?php

/**
 * Authentication Helper
 * 
 * Provides authentication-related helper functions for views and controllers
 */

if (!function_exists('is_logged_in')) {
    /**
     * Check if user is logged in
     */
    function is_logged_in(): bool
    {
        return session()->has('user_id') && session()->get('user_id') !== null;
    }
}

if (!function_exists('current_user_id')) {
    /**
     * Get current user ID
     */
    function current_user_id(): ?int
    {
        return session()->get('user_id');
    }
}

if (!function_exists('current_user_name')) {
    /**
     * Get current user full name
     */
    function current_user_name(): string
    {
        $firstName = session()->get('first_name') ?? '';
        $lastName = session()->get('last_name') ?? '';
        return trim($firstName . ' ' . $lastName);
    }
}

if (!function_exists('current_user_email')) {
    /**
     * Get current user email
     */
    function current_user_email(): string
    {
        return session()->get('email') ?? '';
    }
}

if (!function_exists('current_user_group')) {
    /**
     * Get current user group
     */
    function current_user_group(): string
    {
        return session()->get('user_group') ?? 'guest';
    }
}

if (!function_exists('is_admin')) {
    /**
     * Check if current user is admin
     */
    function is_admin(): bool
    {
        return session()->get('user_group') === 'admin';
    }
}

if (!function_exists('is_manager')) {
    /**
     * Check if current user is manager or admin
     */
    function is_manager(): bool
    {
        $group = session()->get('user_group');
        return $group === 'admin' || $group === 'manager';
    }
}

if (!function_exists('has_permission')) {
    /**
     * Check if user has specific permission
     */
    function has_permission(string $permission): bool
    {
        $userPermissions = session()->get('user_permissions') ?? [];
        return in_array($permission, $userPermissions);
    }
}

if (!function_exists('redirect_if_not_logged_in')) {
    /**
     * Redirect to login if user is not logged in
     */
    function redirect_if_not_logged_in(string $redirectTo = '/login'): void
    {
        if (!is_logged_in()) {
            header('Location: ' . $redirectTo);
            exit;
        }
    }
}

if (!function_exists('redirect_if_not_admin')) {
    /**
     * Redirect if user is not admin
     */
    function redirect_if_not_admin(string $redirectTo = '/dashboard'): void
    {
        if (!is_admin()) {
            header('Location: ' . $redirectTo);
            exit;
        }
    }
}

if (!function_exists('format_user_last_login')) {
    /**
     * Format last login time for display
     */
    function format_user_last_login(?int $timestamp = null): string
    {
        if (!$timestamp) {
            $timestamp = session()->get('last_login');
        }
        
        if (!$timestamp) {
            return 'Ποτέ';
        }
        
        $date = new DateTime();
        $date->setTimestamp($timestamp);
        
        return $date->format('d/m/Y H:i');
    }
}

if (!function_exists('get_user_avatar')) {
    /**
     * Get user avatar URL or default
     */
    function get_user_avatar(string $email = ''): string
    {
        if (!$email) {
            $email = current_user_email();
        }
        
        // Use Gravatar as default
        $hash = md5(strtolower(trim($email)));
        $default = urlencode(base_url('public/sbadmin2/img/undraw_profile.svg'));
        
        return "https://www.gravatar.com/avatar/{$hash}?d={$default}&s=60";
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Generate CSRF token for forms
     */
    function csrf_token(): string
    {
        return csrf_hash();
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate CSRF hidden field for forms
     */
    function csrf_field(): string
    {
        return '<input type="hidden" name="' . csrf_token() . '" value="' . csrf_hash() . '">';
    }
}