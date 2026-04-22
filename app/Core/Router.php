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
}

?>
