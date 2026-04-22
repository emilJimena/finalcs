<?php

namespace App\Helpers;

/**
 * Redirect Class
 * 
 * Handles HTTP redirects
 */
class Redirect
{
    /**
     * Redirect to a page
     * 
     * @param string $location Location to redirect to
     * @param int $statusCode HTTP status code (default: 302)
     * @return void
     */
    public static function to($location, $statusCode = 302)
    {
        header("Location: " . $location, true, $statusCode);
        exit();
    }

    /**
     * Redirect to home page
     * 
     * @param string $path Path to prepend (default: empty)
     * @return void
     */
    public static function home($path = '')
    {
        if ($path && substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }
        self::to('home.php' . $path);
    }

    /**
     * Redirect to login page
     * 
     * @return void
     */
    public static function login()
    {
        self::to('login.php');
    }

    /**
     * Redirect with status code 301 (permanent)
     * 
     * @param string $location Location to redirect to
     * @return void
     */
    public static function permanently($location)
    {
        self::to($location, 301);
    }

    /**
     * Back redirect (uses referer)
     * 
     * @param string $fallback Fallback page if no referer
     * @return void
     */
    public static function back($fallback = 'home.php')
    {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;
        self::to($referer);
    }
}

?>
