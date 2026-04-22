<?php

namespace App\Core;

/**
 * Base Controller Class
 * 
 * Provides common functionality for all controllers
 */
abstract class Controller
{
    /**
     * View data
     * 
     * @var array
     */
    protected $data = [];

    /**
     * Render a view
     * 
     * @param string $view View file path (relative to views folder)
     * @param array $data Data to pass to view
     * @return void
     */
    public function render($view, $data = [])
    {
        // Merge controller data with passed data
        $this->data = array_merge($this->data, $data);

        // Extract data into variables for the view
        extract($this->data);

        // Build the view file path
        $viewFile = __DIR__ . '/../../app/views/' . $view . '.php';

        // Check if view file exists
        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found: {$viewFile}");
        }

        // Include the view file
        include $viewFile;
    }

    /**
     * Set view data
     * 
     * @param array $data
     * @return void
     */
    public function setData($data)
    {
        $this->data = array_merge($this->data, $data);
    }

    /**
     * Get view data
     * 
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Redirect to another page
     * 
     * @param string $url URL to redirect to
     * @return void
     */
    public static function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Redirect to a controller action
     * 
     * @param string $controller Controller name
     * @param string $action Action name
     * @param array $params Query parameters
     * @return void
     */
    public static function redirectToAction($controller, $action, $params = [])
    {
        $url = "?controller={$controller}&action={$action}";
        foreach ($params as $key => $value) {
            $url .= "&{$key}={$value}";
        }
        self::redirect($url);
    }

    /**
     * Check access - must be logged in
     * 
     * @return void
     */
    protected function requireLogin()
    {
        if (!Auth::isLoggedIn()) {
            self::redirectToAction('auth', 'login');
        }
    }

    /**
     * Check access - must be admin
     * 
     * @return void
     */
    protected function requireAdmin()
    {
        if (!Auth::isAdmin()) {
            header("HTTP/1.1 403 Forbidden");
            echo "Access Denied";
            exit;
        }
    }

    /**
     * Check access - must be admin or staff
     * 
     * @return void
     */
    protected function requireAdminOrStaff()
    {
        if (!Auth::isAdminOrStaff()) {
            header("HTTP/1.1 403 Forbidden");
            echo "Access Denied";
            exit;
        }
    }
}

?>
