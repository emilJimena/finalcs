<?php

require_once __DIR__ . '/bootstrap.php';

use App\Core\Auth;
use App\Helpers\Redirect;

// If logged in, go to home
if (Auth::isLoggedIn()) {
    Redirect::to('public/home.php');
}

// If not logged in, go to login
Redirect::to('public/login.php');

?>
