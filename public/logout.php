<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Core\Auth;
use App\Helpers\Redirect;

// Logout user
Auth::logoutUser();

// Redirect to login
Redirect::to('login.php');

?>
