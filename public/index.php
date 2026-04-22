<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Core\Router;

// Dispatch to appropriate controller and action
Router::dispatch();

?>
