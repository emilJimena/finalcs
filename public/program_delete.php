<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Core\Database;
use App\Core\Auth;
use App\Models\Program;
use App\Helpers\Redirect;

// Require admin or staff access
if (!Auth::isLoggedIn() || !Auth::isAdminOrStaff()) {
    Redirect::home();
}

try {
    $conn = Database::getInstance();
    $programModel = new Program($conn);
    
    $programId = $_GET['id'] ?? null;

    // Check if program_id is provided
    if (!$programId || !is_numeric($programId)) {
        Redirect::to('program_list.php');
    }

    // Delete the program
    if ($programModel->delete($programId)) {
        Redirect::to('program_list.php?msg=Program deleted successfully');
    } else {
        Redirect::to('program_list.php?error=Error deleting program');
    }
} catch (Exception $e) {
    Redirect::to('program_list.php?error=Error occurred');
}

?>
