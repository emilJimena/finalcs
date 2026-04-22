<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;

/**
 * HomeController
 * 
 * Handles home page
 */
class HomeController extends Controller
{
    /**
     * Show home page
     */
    public function indexAction()
    {
        // Check if user is logged in
        $this->requireLogin();

        $user = Auth::getCurrentUser();

        // Render home view
        $this->render('home/index', [
            'user' => $user
        ]);
    }
}

?>
