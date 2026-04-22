<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Database;
use App\Models\Program;

/**
 * ProgramController
 * 
 * Handles program management operations
 */
class ProgramController extends Controller
{
    /**
     * List all programs
     */
    public function listAction()
    {
        $this->requireLogin();

        try {
            $conn = Database::getInstance();
            $programModel = new Program($conn);
            
            // Fetch all programs
            $programs = $programModel->getAll();
            
            // Filter by search term if provided
            $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
            if (!empty($searchTerm)) {
                $programs = array_filter($programs, function($program) use ($searchTerm) {
                    return stripos($program['code'], $searchTerm) !== false ||
                           stripos($program['title'], $searchTerm) !== false;
                });
            }
        } catch (\Exception $e) {
            $programs = [];
            $searchTerm = '';
        }

        $user = Auth::getCurrentUser();

        // Render view
        $this->render('programs/list', [
            'programs' => $programs,
            'searchTerm' => $searchTerm,
            'user' => $user
        ]);
    }

    /**
     * Show new program form
     */
    public function newAction()
    {
        $this->requireLogin();
        $this->requireAdminOrStaff();

        $errors = [];
        $code = '';
        $title = '';
        $years = '';

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = trim($_POST['code'] ?? '');
            $title = trim($_POST['title'] ?? '');
            $years = trim($_POST['years'] ?? '');

            // Validation
            if (empty($code)) {
                $errors[] = "Code is required.";
            }
            if (empty($title)) {
                $errors[] = "Title is required.";
            }
            if (empty($years) || !is_numeric($years) || $years <= 0) {
                $errors[] = "Years must be a positive number.";
            }

            // Check for duplicates
            if (empty($errors)) {
                $conn = Database::getInstance();
                $programModel = new Program($conn);
                
                if ($programModel->codeExists($code)) {
                    $errors[] = "Program code already exists.";
                }
                if ($programModel->titleExists($title)) {
                    $errors[] = "Program title already exists.";
                }
            }

            // Create if no errors
            if (empty($errors)) {
                try {
                    $conn = Database::getInstance();
                    $programModel = new Program($conn);
                    
                    if ($programModel->create($code, $title, $years)) {
                        self::redirectToAction('program', 'list');
                    } else {
                        $errors[] = "Failed to create program.";
                    }
                } catch (\Exception $e) {
                    $errors[] = "An error occurred: " . $e->getMessage();
                }
            }
        }

        // Render view
        $this->render('programs/new', [
            'errors' => $errors,
            'code' => $code,
            'title' => $title,
            'years' => $years
        ]);
    }

    /**
     * Show edit program form
     */
    public function editAction()
    {
        $this->requireLogin();
        $this->requireAdminOrStaff();

        $programId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $errors = [];
        $program = null;

        // Get program data
        try {
            $conn = Database::getInstance();
            $programModel = new Program($conn);
            $program = $programModel->getById($programId);

            if (!$program) {
                $errors[] = "Program not found.";
            }
        } catch (\Exception $e) {
            $errors[] = "An error occurred.";
        }

        $code = $program['code'] ?? '';
        $title = $program['title'] ?? '';
        $years = $program['years'] ?? '';

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = trim($_POST['code'] ?? '');
            $title = trim($_POST['title'] ?? '');
            $years = trim($_POST['years'] ?? '');

            // Validation
            if (empty($code)) {
                $errors[] = "Code is required.";
            }
            if (empty($title)) {
                $errors[] = "Title is required.";
            }
            if (empty($years) || !is_numeric($years) || $years <= 0) {
                $errors[] = "Years must be a positive number.";
            }

            // Check for duplicates
            if (empty($errors)) {
                $conn = Database::getInstance();
                $programModel = new Program($conn);
                
                if ($programModel->codeExists($code, $programId)) {
                    $errors[] = "Program code already exists.";
                }
                if ($programModel->titleExists($title, $programId)) {
                    $errors[] = "Program title already exists.";
                }
            }

            // Update if no errors
            if (empty($errors)) {
                try {
                    $conn = Database::getInstance();
                    $programModel = new Program($conn);
                    
                    if ($programModel->update($programId, $code, $title, $years)) {
                        self::redirectToAction('program', 'list');
                    } else {
                        $errors[] = "Failed to update program.";
                    }
                } catch (\Exception $e) {
                    $errors[] = "An error occurred: " . $e->getMessage();
                }
            }
        }

        // Render view
        $this->render('programs/edit', [
            'errors' => $errors,
            'programId' => $programId,
            'code' => $code,
            'title' => $title,
            'years' => $years
        ]);
    }

    /**
     * Delete program
     */
    public function deleteAction()
    {
        $this->requireLogin();
        $this->requireAdminOrStaff();

        $programId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $errors = [];

        // Handle confirmation
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $conn = Database::getInstance();
                $programModel = new Program($conn);
                
                if ($programModel->delete($programId)) {
                    self::redirectToAction('program', 'list');
                } else {
                    $errors[] = "Failed to delete program.";
                }
            } catch (\Exception $e) {
                $errors[] = "An error occurred: " . $e->getMessage();
            }
        }

        // Get program data
        try {
            $conn = Database::getInstance();
            $programModel = new Program($conn);
            $program = $programModel->getById($programId);

            if (!$program) {
                $errors[] = "Program not found.";
            }
        } catch (\Exception $e) {
            $errors[] = "An error occurred.";
        }

        // Render view
        $this->render('programs/delete', [
            'errors' => $errors,
            'programId' => $programId,
            'program' => $program ?? null
        ]);
    }
}

?>
