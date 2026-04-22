<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Core\Database;
use App\Core\Auth;
use App\Models\User;
use App\Helpers\Redirect;

// Require admin access
if (!Auth::isLoggedIn() || !Auth::isAdmin()) {
    Redirect::home();
}

try {
    $conn = Database::getInstance();
    $userModel = new User($conn);
    
    $userId = $_GET['id'] ?? null;

    // Check if user_id is provided
    if (!$userId || !is_numeric($userId)) {
        Redirect::to('users_list.php');
    }

    // Prevent self-deletion
    $currentUser = Auth::getCurrentUser();
    if ($userId == $currentUser['id']) {
        Redirect::to('users_list.php?error=Cannot delete yourself');
    }

    // Delete the user
    if ($userModel->delete($userId)) {
        Redirect::to('users_list.php?msg=User deleted successfully');
    } else {
        Redirect::to('users_list.php?error=Error deleting user');
    }
} catch (Exception $e) {
    Redirect::to('users_list.php?error=Error occurred');
}

?>
