<?php

namespace App\Core;

/**
 * Router Class
 * 
 * Handles routing and controller/action dispatch
 */
class Router
{
    /**
     * Route request to appropriate controller and action
     * 
     * @return void
     */
    public static function dispatch()
    {
        self::mapPrettyRoute();

        // Get controller and action from request
        $controller = isset($_GET['controller']) ? ucfirst(strtolower($_GET['controller'])) : 'Home';
        $action = isset($_GET['action']) ? strtolower($_GET['action']) : 'index';

        // Build controller class name
        $controllerClass = "App\\Controllers\\{$controller}Controller";

        // Check if controller class exists
        if (!class_exists($controllerClass)) {
            header("HTTP/1.1 404 Not Found");
            echo "Controller not found: {$controller}";
            exit;
        }

        // Create controller instance
        $controllerInstance = new $controllerClass();

        // Build action method name
        $actionMethod = "{$action}Action";

        // Check if action method exists
        if (!method_exists($controllerInstance, $actionMethod)) {
            header("HTTP/1.1 404 Not Found");
            echo "Action not found: {$action}";
            exit;
        }

        // Call the action method
        call_user_func([$controllerInstance, $actionMethod]);
    }

    /**
     * Map path-style URLs onto the existing controller/action query format.
     *
     * @return void
     */
    private static function mapPrettyRoute()
    {
        if (isset($_GET['controller']) || isset($_GET['action'])) {
            return;
        }

        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($requestUri, PHP_URL_PATH) ?: '/';
        $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
        $baseDir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

        if ($baseDir !== '' && str_starts_with($path, $baseDir)) {
            $path = substr($path, strlen($baseDir));
        }

        $path = '/' . trim($path, '/');
        $segments = array_values(array_filter(explode('/', trim($path, '/')), 'strlen'));

        if (empty($segments)) {
            $_GET['controller'] = 'auth';
            $_GET['action'] = 'login';
            return;
        }

        switch ($segments[0]) {
            case 'login':
                $_GET['controller'] = 'auth';
                $_GET['action'] = 'login';
                break;
            case 'logout':
                $_GET['controller'] = 'auth';
                $_GET['action'] = 'logout';
                break;
            case 'home':
                $_GET['controller'] = 'home';
                $_GET['action'] = 'index';
                break;
            case 'subjects':
                $_GET['controller'] = 'subject';
                $_GET['action'] = $segments[1] ?? 'list';
                if (isset($segments[2])) {
                    $_GET['id'] = $segments[2];
                }
                break;
            case 'programs':
                $_GET['controller'] = 'program';
                $_GET['action'] = $segments[1] ?? 'list';
                if (isset($segments[2])) {
                    $_GET['id'] = $segments[2];
                }
                break;
            case 'users':
                $_GET['controller'] = 'user';
                $_GET['action'] = $segments[1] ?? 'list';
                if (isset($segments[2])) {
                    $_GET['id'] = $segments[2];
                }
                break;
            case 'password':
                $_GET['controller'] = 'user';
                $_GET['action'] = 'changePassword';
                break;
        }
    }
}

?>
