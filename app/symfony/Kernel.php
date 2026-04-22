<?php
/**
 * Application Kernel
 * 
 * Symfony-like kernel for bootstrapping the application
 */

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Kernel
{
    private string $environment;
    private bool $debug;
    
    public function __construct(string $environment = 'dev', bool $debug = false)
    {
        $this->environment = $environment;
        $this->debug = $debug;
    }
    
    public function getEnvironment(): string
    {
        return $this->environment;
    }
    
    public function isDebug(): bool
    {
        return $this->debug;
    }
}
