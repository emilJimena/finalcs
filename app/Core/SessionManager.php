<?php

namespace App\Core;

/**
 * SessionManager Class
 * 
 * Handles session management
 */
class SessionManager
{
    /**
     * Start session if not already started
     * 
     * @return void
     */
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Set session value
     * 
     * @param string $key Session key
     * @param mixed $value Session value
     * @return void
     */
    public static function set($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Get session value
     * 
     * @param string $key Session key
     * @param mixed $default Default value if key doesn't exist
     * @return mixed Session value or default
     */
    public static function get($key, $default = null)
    {
        self::start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * Check if session key exists
     * 
     * @param string $key Session key
     * @return bool True if key exists, false otherwise
     */
    public static function has($key)
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Remove session value
     * 
     * @param string $key Session key
     * @return void
     */
    public static function remove($key)
    {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Destroy entire session
     * 
     * @return void
     */
    public static function destroy()
    {
        self::start();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }

    /**
     * Get all session data
     * 
     * @return array Session data
     */
    public static function all()
    {
        self::start();
        return $_SESSION;
    }

    /**
     * Clear all session data
     * 
     * @return void
     */
    public static function clear()
    {
        self::start();
        $_SESSION = [];
    }
}

?>
