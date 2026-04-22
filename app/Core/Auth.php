<?php

namespace App\Core;

use App\Models\User;

/**
 * Auth Class
 * 
 * Handles authentication and authorization
 */
class Auth
{
    private $userModel;

    /**
     * Constructor
     * 
     * @param User|null $userModel User model instance
     */
    public function __construct($userModel = null)
    {
        $this->userModel = $userModel;
    }

    /**
     * Login user
     * 
     * @param string $username Username
     * @param string $password Password (plain text)
     * @return bool True if login successful, false otherwise
     */
    public function login($username, $password)
    {
        SessionManager::start();
        $user = $this->userModel->getByUsername($username);
        
        if (!$user) {
            return false;
        }

        if (!$this->verifyPassword($password, $user['password'])) {
            return false;
        }

        // Set session data
        SessionManager::set('user_id', $user['id']);
        SessionManager::set('username', $user['username']);
        SessionManager::set('account_type', $user['account_type']);

        return true;
    }

    /**
     * Logout user
     * 
     * @return void
     */
    public function logout()
    {
        SessionManager::destroy();
    }

    /**
     * Static logout method
     * 
     * @return void
     */
    public static function logoutUser()
    {
        SessionManager::destroy();
    }

    /**
     * Check if user is logged in
     * 
     * @return bool True if logged in, false otherwise
     */
    public static function isLoggedIn()
    {
        return SessionManager::has('user_id');
    }

    /**
     * Get current logged-in user data
     * 
     * @return array|null User data or null if not logged in
     */
    public static function getCurrentUser()
    {
        if (!self::isLoggedIn()) {
            return null;
        }

        return [
            'id' => SessionManager::get('user_id'),
            'username' => SessionManager::get('username'),
            'account_type' => SessionManager::get('account_type')
        ];
    }

    /**
     * Check if current user is admin
     * 
     * @return bool
     */
    public static function isAdmin()
    {
        return SessionManager::get('account_type') === ACCOUNT_TYPE_ADMIN;
    }

    /**
     * Check if current user is staff
     * 
     * @return bool
     */
    public static function isStaff()
    {
        return SessionManager::get('account_type') === ACCOUNT_TYPE_STAFF;
    }

    /**
     * Check if current user is teacher
     * 
     * @return bool
     */
    public static function isTeacher()
    {
        return SessionManager::get('account_type') === ACCOUNT_TYPE_TEACHER;
    }

    /**
     * Check if current user is student
     * 
     * @return bool
     */
    public static function isStudent()
    {
        return SessionManager::get('account_type') === ACCOUNT_TYPE_STUDENT;
    }

    /**
     * Check if current user is admin or staff
     * 
     * @return bool
     */
    public static function isAdminOrStaff()
    {
        return self::isAdmin() || self::isStaff();
    }

    /**
     * Verify password
     * 
     * @param string $plainPassword Plain text password
     * @param string $hashedPassword Hashed password from database
     * @return bool True if password matches, false otherwise
     */
    public static function verifyPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword);
    }

    /**
     * Hash password
     * 
     * @param string $password Plain text password
     * @return string Hashed password
     */
    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}

?>
