<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Database;
use App\Models\User;

/**
 * UserController
 * 
 * Handles user management operations
 */
class UserController extends Controller
{
    /**
     * List all users
     */
    public function listAction()
    {
        $this->requireLogin();
        $this->requireAdmin();

        try {
            $conn = Database::getInstance();
            $userModel = new User($conn);
            
            // Fetch all users
            $users = $userModel->getAll();
        } catch (\Exception $e) {
            $users = [];
        }

        $user = Auth::getCurrentUser();

        // Render view
        $this->render('users/list', [
            'users' => $users,
            'user' => $user
        ]);
    }

    /**
     * Show new user form
     */
    public function newAction()
    {
        $this->requireLogin();
        $this->requireAdmin();

        $errors = [];
        $username = '';
        $password = '';
        $password_confirm = '';
        $accountType = '';

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $password_confirm = trim($_POST['password_confirm'] ?? '');
            $accountType = trim($_POST['account_type'] ?? '');

            // Validation
            if (empty($username)) {
                $errors[] = "Username is required.";
            }
            if (empty($password)) {
                $errors[] = "Password is required.";
            }
            if (empty($password_confirm)) {
                $errors[] = "Password confirmation is required.";
            }
            if ($password !== $password_confirm) {
                $errors[] = "Passwords do not match.";
            }
            if (empty($accountType)) {
                $errors[] = "Account type is required.";
            }

            // Check if username exists
            if (empty($errors)) {
                $conn = Database::getInstance();
                $userModel = new User($conn);
                
                if ($userModel->usernameExists($username)) {
                    $errors[] = "Username already exists.";
                }
            }

            // Create if no errors
            if (empty($errors)) {
                try {
                    $conn = Database::getInstance();
                    $userModel = new User($conn);
                    $currentUser = Auth::getCurrentUser();
                    
                    if ($userModel->create($username, $password, $accountType, $currentUser['id'])) {
                        self::redirectToAction('user', 'list');
                    } else {
                        $errors[] = "Failed to create user.";
                    }
                } catch (\Exception $e) {
                    $errors[] = "An error occurred: " . $e->getMessage();
                }
            }
        }

        // Render view
        $this->render('users/new', [
            'errors' => $errors,
            'username' => $username,
            'password' => $password,
            'password_confirm' => $password_confirm,
            'accountType' => $accountType
        ]);
    }

    /**
     * Show edit user form
     */
    public function editAction()
    {
        $this->requireLogin();
        $this->requireAdmin();

        $userId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $errors = [];
        $user = null;

        // Get user data
        try {
            $conn = Database::getInstance();
            $userModel = new User($conn);
            $user = $userModel->getById($userId);

            if (!$user) {
                $errors[] = "User not found.";
            }
        } catch (\Exception $e) {
            $errors[] = "An error occurred.";
        }

        $username = $user['username'] ?? '';
        $accountType = $user['account_type'] ?? '';

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $accountType = trim($_POST['account_type'] ?? '');

            // Validation
            if (empty($username)) {
                $errors[] = "Username is required.";
            }
            if (empty($accountType)) {
                $errors[] = "Account type is required.";
            }

            // Check if username exists (excluding this user)
            if (empty($errors)) {
                $conn = Database::getInstance();
                $userModel = new User($conn);
                
                if ($userModel->usernameExists($username, $userId)) {
                    $errors[] = "Username already exists.";
                }
            }

            // Update if no errors
            if (empty($errors)) {
                try {
                    $conn = Database::getInstance();
                    $userModel = new User($conn);
                    $currentUser = Auth::getCurrentUser();
                    
                    if ($userModel->update($userId, $username, $accountType, $currentUser['id'])) {
                        self::redirectToAction('user', 'list');
                    } else {
                        $errors[] = "Failed to update user.";
                    }
                } catch (\Exception $e) {
                    $errors[] = "An error occurred: " . $e->getMessage();
                }
            }
        }

        // Render view
        $this->render('users/edit', [
            'errors' => $errors,
            'userId' => $userId,
            'username' => $username,
            'accountType' => $accountType
        ]);
    }

    /**
     * Delete user
     */
    public function deleteAction()
    {
        $this->requireLogin();
        $this->requireAdmin();

        $userId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $errors = [];

        // Handle confirmation
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $conn = Database::getInstance();
                $userModel = new User($conn);
                
                if ($userModel->delete($userId)) {
                    self::redirectToAction('user', 'list');
                } else {
                    $errors[] = "Failed to delete user.";
                }
            } catch (\Exception $e) {
                $errors[] = "An error occurred: " . $e->getMessage();
            }
        }

        // Get user data
        try {
            $conn = Database::getInstance();
            $userModel = new User($conn);
            $user = $userModel->getById($userId);

            if (!$user) {
                $errors[] = "User not found.";
            }
        } catch (\Exception $e) {
            $errors[] = "An error occurred.";
        }

        // Render view
        $this->render('users/delete', [
            'errors' => $errors,
            'userId' => $userId,
            'user' => $user ?? null
        ]);
    }

    /**
     * Show change password form
     */
    public function changePasswordAction()
    {
        $this->requireLogin();

        $errors = [];
        $currentUser = Auth::getCurrentUser();

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = trim($_POST['current_password'] ?? '');
            $newPassword = trim($_POST['new_password'] ?? '');
            $newPasswordConfirm = trim($_POST['new_password_confirm'] ?? '');

            // Validation
            if (empty($currentPassword)) {
                $errors[] = "Current password is required.";
            }
            if (empty($newPassword)) {
                $errors[] = "New password is required.";
            }
            if (empty($newPasswordConfirm)) {
                $errors[] = "Password confirmation is required.";
            }
            if ($newPassword !== $newPasswordConfirm) {
                $errors[] = "New passwords do not match.";
            }

            // Verify current password
            if (empty($errors)) {
                try {
                    $conn = Database::getInstance();
                    $userModel = new User($conn);
                    $user = $userModel->getById($currentUser['id']);

                    if (!$user || !User::verifyPassword($currentPassword, $user['password'])) {
                        $errors[] = "Current password is incorrect.";
                    }
                } catch (\Exception $e) {
                    $errors[] = "An error occurred.";
                }
            }

            // Update if no errors
            if (empty($errors)) {
                try {
                    $conn = Database::getInstance();
                    $userModel = new User($conn);
                    
                    if ($userModel->updatePassword($currentUser['id'], $newPassword)) {
                        // Redirect with success message
                        self::redirectToAction('user', 'changePassword');
                    } else {
                        $errors[] = "Failed to change password.";
                    }
                } catch (\Exception $e) {
                    $errors[] = "An error occurred: " . $e->getMessage();
                }
            }
        }

        // Render view
        $this->render('users/change_password', [
            'errors' => $errors,
            'currentUser' => $currentUser
        ]);
    }
}

?>
