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
    
    $errors = [];
    $program = null;
    $programId = $_GET['id'] ?? null;

    // Check if program_id is provided
    if (!$programId || !is_numeric($programId)) {
        Redirect::to('program_list.php');
    }

    // Fetch the program record
    $program = $programModel->getById($programId);
    if (!$program) {
        Redirect::to('program_list.php');
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $code = trim($_POST['code'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $years = trim($_POST['years'] ?? '');

        // Validation
        if (empty($code)) {
            $errors[] = "Program code is required.";
        }
        if (empty($title)) {
            $errors[] = "Program title is required.";
        }
        if (empty($years)) {
            $errors[] = "Years is required.";
        } elseif (!is_numeric($years) || $years <= 0) {
            $errors[] = "Years must be a positive number.";
        }

        // Check for duplicate code (excluding current record)
        if (!empty($code) && $code !== $program['code']) {
            if ($programModel->codeExists($code, $programId)) {
                $errors[] = "Program code already exists. Please use a different code.";
            }
        }

        // Check for duplicate title (excluding current record)
        if (!empty($title) && $title !== $program['title']) {
            if ($programModel->titleExists($title, $programId)) {
                $errors[] = "Program title already exists. Please use a different title.";
            }
        }

        // If no errors, update the database
        if (empty($errors)) {
            if ($programModel->update($programId, $code, $title, $years)) {
                Redirect::to('program_list.php?msg=Program updated successfully');
            } else {
                $errors[] = "Error updating program.";
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
    <title>Edit Program - School Encoding Module</title>
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
        <a href="program_list.php" class="back-link">&lt; Back to Programs</a>

        <h1>Edit Program</h1>
        <p class="subtitle">Update program information</p>

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
                <label for="code">Program Code *</label>
                <input type="text" id="code" name="code" value="<?php echo htmlspecialchars($program['code']); ?>" required>
            </div>

            <div class="form-group">
                <label for="title">Program Title *</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($program['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="years">Years *</label>
                <input type="number" id="years" name="years" value="<?php echo htmlspecialchars($program['years']); ?>" min="1" required>
            </div>

            <div class="button-group">
                <button type="submit">Update Program</button>
                <a href="program_list.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
