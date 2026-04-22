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
    
    $errors = [];
    $subject = null;
    $subjectId = $_GET['id'] ?? null;

    // Check if subject_id is provided
    if (!$subjectId || !is_numeric($subjectId)) {
        Redirect::to('subject_list.php');
    }

    // Fetch the subject record
    $subject = $subjectModel->getById($subjectId);
    if (!$subject) {
        Redirect::to('subject_list.php');
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $code = trim($_POST['code'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $unit = trim($_POST['unit'] ?? '');

        // Validation
        if (empty($code)) {
            $errors[] = "Subject code is required.";
        }
        if (empty($title)) {
            $errors[] = "Subject title is required.";
        }
        if (empty($unit)) {
            $errors[] = "Unit is required.";
        } elseif (!is_numeric($unit) || $unit <= 0) {
            $errors[] = "Unit must be a positive number.";
        }

        // Check for duplicate code (excluding current record)
        if (!empty($code) && $code !== $subject['code']) {
            if ($subjectModel->codeExists($code, $subjectId)) {
                $errors[] = "Subject code already exists. Please use a different code.";
            }
        }

        // Check for duplicate title (excluding current record)
        if (!empty($title) && $title !== $subject['title']) {
            if ($subjectModel->titleExists($title, $subjectId)) {
                $errors[] = "Subject title already exists. Please use a different title.";
            }
        }

        // If no errors, update the database
        if (empty($errors)) {
            if ($subjectModel->update($subjectId, $code, $title, $unit)) {
                Redirect::to('subject_list.php?msg=Subject updated successfully');
            } else {
                $errors[] = "Error updating subject.";
            }
        }
    }
} catch (Exception $e) {
    $errors[] = "Error: " . htmlspecialchars($e->getMessage());
}

$user = Auth::getCurrentUser();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject - School Encoding Module</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Segoe UI', sans-serif;
            background: #f0f0f0;
            padding: 20px;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            border-radius: 4px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 1.6em;
            font-weight: 600;
        }

        .subtitle {
            color: #7f8c8d;
            margin-bottom: 25px;
            font-size: 0.95em;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 3px;
            border-left: 4px solid #c0392b;
            background: #fee;
            color: #c33;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert li {
            margin: 5px 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #34495e;
            font-weight: 500;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-size: 1em;
        }

        input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.2);
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: space-between;
        }

        button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1em;
        }

        button[type="submit"] {
            background: #3498db;
            color: white;
        }

        button[type="submit"]:hover {
            background: #2980b9;
        }

        .btn-cancel {
            background: #95a5a6;
            color: white;
            text-decoration: none;
            border: none;
            display: inline-block;
            text-align: center;
        }

        .btn-cancel:hover {
            background: #7f8c8d;
        }

        .back-link {
            color: #3498db;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>School Encoding Module</h2>
    </div>

    <div class="container">
        <a href="subject_list.php" class="back-link">&lt; Back to Subjects</a>

        <h1>Edit Subject</h1>
        <p class="subtitle">Update subject information</p>

        <?php if (!empty($errors)): ?>
            <div class="alert">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="code">Subject Code *</label>
                <input type="text" id="code" name="code" value="<?php echo htmlspecialchars($subject['code']); ?>" required>
            </div>

            <div class="form-group">
                <label for="title">Subject Title *</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($subject['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="unit">Units *</label>
                <input type="number" id="unit" name="unit" value="<?php echo htmlspecialchars($subject['unit']); ?>" min="1" required>
            </div>

            <div class="button-group">
                <button type="submit">Update Subject</button>
                <a href="subject_list.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
