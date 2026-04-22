<?php
/**
 * Base Controller Class
 * 
 * All application controllers extend this class
 */

namespace App\Controller;

use App\Core\Database;

abstract class BaseController
{
    protected Database $db;
    public $container;
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    
    /**
     * Render a Twig template
     * 
     * @param string $template Template path (e.g., 'home/index.html.twig')
     * @param array $data Data to pass to template
     * @return void
     */
    protected function render(string $template, array $data = []): void
    {
        $templatePath = dirname(__DIR__, 2) . '/templates/' . $template;
        
        if (!file_exists($templatePath)) {
            throw new \Exception("Template not found: $template");
        }
        
        // Make data available to template
        extract($data);
        
        // Start output buffering
        ob_start();
        require $templatePath;
        $content = ob_get_clean();
        
        echo $content;
    }
    
    /**
     * Redirect to a route
     * 
     * @param string $route Route name or path
     * @return void
     */
    protected function redirect(string $route): void
    {
        header("Location: $route");
        exit;
    }
    
    /**
     * Get current session
     * 
     * @return array
     */
    protected function getSession(): array
    {
        return $_SESSION;
    }
    
    /**
     * Add flash message
     * 
     * @param string $type Message type (success, danger, warning, info)
     * @param string $message Message text
     * @return void
     */
    protected function addFlash(string $type, string $message): void
    {
        if (!isset($_SESSION['_flash'])) {
            $_SESSION['_flash'] = [];
        }
        if (!isset($_SESSION['_flash'][$type])) {
            $_SESSION['_flash'][$type] = [];
        }
        $_SESSION['_flash'][$type][] = $message;
    }
    
    /**
     * Create form helper (simplified)
     * 
     * @param string $formClass Form class name
     * @param object $data Data object
     * @param array $options Form options
     * @return array Form data
     */
    protected function createForm(string $formClass, object $data = null, array $options = []): array
    {
        return [];
    }
}
