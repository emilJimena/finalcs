<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Core\Database;
use App\Core\Auth;
use App\Models\Subject;
use App\Helpers\Redirect;

// Require admin or staff access
if (!Auth::isLoggedIn() || !Auth::isAdminOrStaff()) {
    Redirect::home();
}

try {
    $conn = Database::getInstance();
    $subjectModel = new Subject($conn);
    
    $subjectId = $_GET['id'] ?? null;

    // Check if subject_id is provided
    if (!$subjectId || !is_numeric($subjectId)) {
        Redirect::to('subject_list.php');
    }

    // Delete the subject
    if ($subjectModel->delete($subjectId)) {
        Redirect::to('subject_list.php?msg=Subject deleted successfully');
    } else {
        Redirect::to('subject_list.php?error=Error deleting subject');
    }
} catch (Exception $e) {
    Redirect::to('subject_list.php?error=Error occurred');
}

?>
