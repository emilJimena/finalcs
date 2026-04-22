<?php
/**
 * Create a complete, working front controller
 * that implements Symfony-style routing and dependency injection
 */

// Get project root
$projectRoot = dirname(__DIR__);

// Set up error handling
error_reporting(E_ALL);
if (getenv('APP_DEBUG') === 'true' || getenv('APP_DEBUG') === '1') {
    ini_set('display_errors', '1');
} else {
    ini_set('display_errors', '0');
}

// Load environment
$envFile = $projectRoot . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $value = trim($value, '"\'');
            if (!getenv($key)) {
                putenv("{$key}={$value}");
            }
        }
    }
}

// Set defaults
if (!getenv('DB_HOST')) putenv('DB_HOST=localhost');
if (!getenv('DB_USER')) putenv('DB_USER=root');
if (!getenv('DB_PASSWORD')) putenv('DB_PASSWORD=');
if (!getenv('DB_NAME')) putenv('DB_NAME=school');
if (!getenv('APP_DEBUG')) putenv('APP_DEBUG=true');

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load PSR-4 autoloader
require $projectRoot . '/autoload.php';

// Handle request routing
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = parse_url($_SERVER['SCRIPT_NAME'], PHP_URL_PATH);
$basePath = str_replace(basename($scriptName), '', $scriptName);
$path = substr($requestUri, strlen($basePath) ?: 1);

// Trim trailing slashes but keep root
if ($path !== '/' && substr($path, -1) === '/') {
    $path = rtrim($path, '/');
}

// Define routes
$routes = [
    '/login' => ['GET', 'POST', 'App\\Controller\\AuthController', 'login'],
    '/logout' => ['GET', 'App\\Controller\\AuthController', 'logout'],
    '/' => ['GET', 'App\\Controller\\HomeController', 'index'],
    '/home' => ['GET', 'App\\Controller\\HomeController', 'index'],
    '/subject' => ['GET', 'App\\Controller\\SubjectController', 'list'],
    '/subject/new' => ['GET', 'POST', 'App\\Controller\\SubjectController', 'new'],
    '/subject/{id}/edit' => ['GET', 'POST', 'App\\Controller\\SubjectController', 'edit'],
    '/subject/{id}/delete' => ['POST', 'App\\Controller\\SubjectController', 'delete'],
    '/program' => ['GET', 'App\\Controller\\ProgramController', 'list'],
    '/program/new' => ['GET', 'POST', 'App\\Controller\\ProgramController', 'new'],
    '/program/{id}/edit' => ['GET', 'POST', 'App\\Controller\\ProgramController', 'edit'],
    '/program/{id}/delete' => ['POST', 'App\\Controller\\ProgramController', 'delete'],
    '/user' => ['GET', 'App\\Controller\\UserController', 'list'],
    '/user/new' => ['GET', 'POST', 'App\\Controller\\UserController', 'new'],
    '/user/{id}/edit' => ['GET', 'POST', 'App\\Controller\\UserController', 'edit'],
    '/user/{id}/delete' => ['POST', 'App\\Controller\\UserController', 'delete'],
    '/password/change' => ['GET', 'POST', 'App\\Controller\\PasswordController', 'change'],
];

// Match route
$matched = false;
$method = $_SERVER['REQUEST_METHOD'];

foreach ($routes as $pattern => $config) {
    // Extract allowed methods from config
    $allowedMethods = [];
    $i = 0;
    while ($i < count($config) && is_string($config[$i])) {
        $allowedMethods[] = $config[$i];
        $i++;
    }
    
    $controller = $config[$i] ?? null;
    $action = $config[$i + 1] ?? null;
    
    // Convert route pattern to regex
    $regex = preg_replace('/{id}/', '(\d+)', preg_quote($pattern, '#'));
    $regex = '#^' . $regex . '$#';
    
    if (preg_match($regex, $path, $matches) && in_array($method, $allowedMethods)) {
        // Extract ID from route
        $id = $matches[1] ?? null;
        
        try {
            if (!class_exists($controller)) {
                throw new \Exception("Controller $controller not found");
            }
            
            $controllerInstance = new $controller();
            $actionMethod = $action . 'Action';
            
            if (!method_exists($controllerInstance, $actionMethod)) {
                throw new \Exception("Action $actionMethod not found in $controller");
            }
            
            // Call controller action with ID if present
            if ($id !== null) {
                $controllerInstance->$actionMethod((int)$id);
            } else {
                $controllerInstance->$actionMethod();
            }
            
            $matched = true;
            break;
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'redirect') === 0) {
                // Handle redirects
                throw $e;
            }
            http_response_code(500);
            echo "Error: " . $e->getMessage();
            if (getenv('APP_DEBUG')) {
                echo "\n\n" . $e->getTraceAsString();
            }
            exit;
        }
    }
}

// If no route matched, redirect to login or show 404
if (!$matched) {
    if ($path === '/' || $path === '') {
        header('Location: /login');
        exit;
    }
    
    if (isset($_SESSION['user_id'])) {
        http_response_code(404);
        echo "404 - Page Not Found";
    } else {
        header('Location: /login');
    }
    exit;
}
