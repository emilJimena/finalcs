<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Database;
use App\Models\Subject;

/**
 * SubjectController
 * 
 * Handles subject management operations
 */
class SubjectController extends Controller
{
    /**
     * List all subjects
     */
    public function listAction()
    {
        $this->requireLogin();

        try {
            $conn = Database::getInstance();
            $subjectModel = new Subject($conn);
            
            // Fetch all subjects
            $subjects = $subjectModel->getAll();
            
            // Filter by search term if provided
            $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
            if (!empty($searchTerm)) {
                $subjects = array_filter($subjects, function($subject) use ($searchTerm) {
                    return stripos($subject['code'], $searchTerm) !== false ||
                           stripos($subject['title'], $searchTerm) !== false;
                });
            }
        } catch (\Exception $e) {
            $subjects = [];
            $searchTerm = '';
        }

        $user = Auth::getCurrentUser();

        // Render view
        $this->render('subjects/list', [
            'subjects' => $subjects,
            'searchTerm' => $searchTerm,
            'user' => $user
        ]);
    }

    /**
     * Show new subject form
     */
    public function newAction()
    {
        $this->requireLogin();
        $this->requireAdminOrStaff();

        $errors = [];
        $code = '';
        $title = '';
        $unit = '';

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = trim($_POST['code'] ?? '');
            $title = trim($_POST['title'] ?? '');
            $unit = trim($_POST['unit'] ?? '');

            // Validation
            if (empty($code)) {
                $errors[] = "Code is required.";
            }
            if (empty($title)) {
                $errors[] = "Title is required.";
            }
            if (empty($unit) || !is_numeric($unit) || $unit <= 0) {
                $errors[] = "Unit must be a positive number.";
            }

            // Check for duplicates
            if (empty($errors)) {
                $conn = Database::getInstance();
                $subjectModel = new Subject($conn);
                
                if ($subjectModel->codeExists($code)) {
                    $errors[] = "Subject code already exists.";
                }
                if ($subjectModel->titleExists($title)) {
                    $errors[] = "Subject title already exists.";
                }
            }

            // Create if no errors
            if (empty($errors)) {
                try {
                    $conn = Database::getInstance();
                    $subjectModel = new Subject($conn);
                    
                    if ($subjectModel->create($code, $title, $unit)) {
                        self::redirectToAction('subject', 'list');
                    } else {
                        $errors[] = "Failed to create subject.";
                    }
                } catch (\Exception $e) {
                    $errors[] = "An error occurred: " . $e->getMessage();
                }
            }
        }

        // Render view
        $this->render('subjects/new', [
            'errors' => $errors,
            'code' => $code,
            'title' => $title,
            'unit' => $unit
        ]);
    }

    /**
     * Show edit subject form
     */
    public function editAction()
    {
        $this->requireLogin();
        $this->requireAdminOrStaff();

        $subjectId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $errors = [];
        $subject = null;

        // Get subject data
        try {
            $conn = Database::getInstance();
            $subjectModel = new Subject($conn);
            $subject = $subjectModel->getById($subjectId);

            if (!$subject) {
                $errors[] = "Subject not found.";
            }
        } catch (\Exception $e) {
            $errors[] = "An error occurred.";
        }

        $code = $subject['code'] ?? '';
        $title = $subject['title'] ?? '';
        $unit = $subject['unit'] ?? '';

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = trim($_POST['code'] ?? '');
            $title = trim($_POST['title'] ?? '');
            $unit = trim($_POST['unit'] ?? '');

            // Validation
            if (empty($code)) {
                $errors[] = "Code is required.";
            }
            if (empty($title)) {
                $errors[] = "Title is required.";
            }
            if (empty($unit) || !is_numeric($unit) || $unit <= 0) {
                $errors[] = "Unit must be a positive number.";
            }

            // Check for duplicates
            if (empty($errors)) {
                $conn = Database::getInstance();
                $subjectModel = new Subject($conn);
                
                if ($subjectModel->codeExists($code, $subjectId)) {
                    $errors[] = "Subject code already exists.";
                }
                if ($subjectModel->titleExists($title, $subjectId)) {
                    $errors[] = "Subject title already exists.";
                }
            }

            // Update if no errors
            if (empty($errors)) {
                try {
                    $conn = Database::getInstance();
                    $subjectModel = new Subject($conn);
                    
                    if ($subjectModel->update($subjectId, $code, $title, $unit)) {
                        self::redirectToAction('subject', 'list');
                    } else {
                        $errors[] = "Failed to update subject.";
                    }
                } catch (\Exception $e) {
                    $errors[] = "An error occurred: " . $e->getMessage();
                }
            }
        }

        // Render view
        $this->render('subjects/edit', [
            'errors' => $errors,
            'subjectId' => $subjectId,
            'code' => $code,
            'title' => $title,
            'unit' => $unit
        ]);
    }

    /**
     * Delete subject
     */
    public function deleteAction()
    {
        $this->requireLogin();
        $this->requireAdminOrStaff();

        $subjectId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $errors = [];

        // Handle confirmation
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $conn = Database::getInstance();
                $subjectModel = new Subject($conn);
                
                if ($subjectModel->delete($subjectId)) {
                    self::redirectToAction('subject', 'list');
                } else {
                    $errors[] = "Failed to delete subject.";
                }
            } catch (\Exception $e) {
                $errors[] = "An error occurred: " . $e->getMessage();
            }
        }

        // Get subject data
        try {
            $conn = Database::getInstance();
            $subjectModel = new Subject($conn);
            $subject = $subjectModel->getById($subjectId);

            if (!$subject) {
                $errors[] = "Subject not found.";
            }
        } catch (\Exception $e) {
            $errors[] = "An error occurred.";
        }

        // Render view
        $this->render('subjects/delete', [
            'errors' => $errors,
            'subjectId' => $subjectId,
            'subject' => $subject ?? null
        ]);
    }
}

?>
