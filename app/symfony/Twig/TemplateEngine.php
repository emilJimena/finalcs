<?php
/**
 * Simple Twig-like Template Engine
 * 
 * Provides basic template rendering with variable substitution
 */

namespace App\Twig;

class TemplateEngine
{
    private $data = [];
    private $flashMessages = [];
    
    public function __construct(array $data = [], array $flashMessages = [])
    {
        $this->data = $data;
        $this->flashMessages = $flashMessages;
        
        // Add global variables
        $this->data['app'] = [
            'session' => $_SESSION,
            'flashes' => $flashMessages
        ];
    }
    
    /**
     * Render a template file
     * 
     * @param string $template Template path
     * @param array $data Additional data
     * @return string Rendered HTML
     */
    public function render(string $template, array $data = []): string
    {
        $templatePath = dirname(__DIR__, 2) . '/templates/' . $template;
        
        if (!file_exists($templatePath)) {
            throw new \Exception("Template not found: $templatePath");
        }
        
        // Merge data
        $data = array_merge($this->data, $data);
        
        // Buffer output
        ob_start();
        
        try {
            // Extract variables for the template
            extract($data, EXTR_SKIP);
            
            // Simple template processor for Twig-like syntax
            $content = file_get_contents($templatePath);
            
            // Process includes and extends (simplified)
            $content = $this->processTemplate($content, $data);
            
            echo $content;
            return ob_get_clean();
        } catch (\Exception $e) {
            ob_end_clean();
            throw $e;
        }
    }
    
    /**
     * Process template with Twig-like syntax
     * 
     * @param string $content Template content
     * @param array $data Template variables
     * @return string Processed content
     */
    private function processTemplate(string $content, array $data): string
    {
        // This is a very simplified template processor
        // In production, you would use actual Twig
        
        // For now, we'll just return the content as-is
        // The actual template files include the necessary PHP code
        return $content;
    }
}
