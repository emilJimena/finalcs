<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Database;
use App\Models\User;

/**
 * AuthController
 * 
 * Handles authentication operations
 */
class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function loginAction()
    {
        // If already logged in, redirect to home
        if (Auth::isLoggedIn()) {
            self::redirectToAction('home', 'index');
        }

        $errors = [];
        $username = '';

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // Validation
            if (empty($username)) {
                $errors[] = "Username is required.";
            }
            if (empty($password)) {
                $errors[] = "Password is required.";
            }

            // Check credentials
            if (empty($errors)) {
                try {
                    $conn = Database::getInstance();
                    $userModel = new User($conn);
                    $auth = new Auth($userModel);

                    if ($auth->login($username, $password)) {
                        self::redirectToAction('home', 'index');
                    } else {
                        $errors[] = "Invalid username or password.";
                    }
                } catch (\Exception $e) {
                    $errors[] = "An error occurred. Please try again.";
                }
            }
        }

        // Render login view
        $this->render('auth/login', [
            'errors' => $errors,
            'username' => $username
        ]);
    }

    /**
     * Handle logout
     */
    public function logoutAction()
    {
        Auth::logoutUser();
        self::redirectToAction('auth', 'login');
    }
}

?>
