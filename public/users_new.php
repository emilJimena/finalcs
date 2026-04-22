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
    
    $errors = [];
    $formData = [
        'username' => '',
        'account_type' => 'student'
    ];

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $accountType = trim($_POST['account_type'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');

        $formData['username'] = $username;
        $formData['account_type'] = $accountType;

        // Validation
        if (empty($username)) {
            $errors[] = "Username is required.";
        } elseif (strlen($username) < 3) {
            $errors[] = "Username must be at least 3 characters.";
        }

        if (empty($accountType)) {
            $errors[] = "Account type is required.";
        } elseif (!in_array($accountType, ['admin', 'staff', 'teacher', 'student'])) {
            $errors[] = "Invalid account type.";
        }

        if (empty($password)) {
            $errors[] = "Password is required.";
        } elseif (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters.";
        }

        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }

        // Check if username already exists
        if (empty($errors) && $userModel->usernameExists($username)) {
            $errors[] = "Username already exists.";
        }

        // Insert if no errors
        if (empty($errors)) {
            $currentUser = Auth::getCurrentUser();
            if ($userModel->create($username, $password, $accountType, $currentUser['id'])) {
                Redirect::to('users_list.php');
            } else {
                $errors[] = "Error creating user. Please try again.";
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
    <title>Create New User - School Encoding Module</title>
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
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-size: 1em;
        }

        input:focus,
        select:focus {
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
        <a href="users_list.php" class="back-link">&lt; Back to Users</a>

        <h1>Add New User</h1>
        <p class="subtitle">Create a new user account</p>

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
                <label for="username">Username *</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($formData['username']); ?>" required>
            </div>

            <div class="form-group">
                <label for="account_type">Account Type *</label>
                <select id="account_type" name="account_type" required>
                    <option value="student" <?php echo $formData['account_type'] === 'student' ? 'selected' : ''; ?>>Student</option>
                    <option value="teacher" <?php echo $formData['account_type'] === 'teacher' ? 'selected' : ''; ?>>Teacher</option>
                    <option value="staff" <?php echo $formData['account_type'] === 'staff' ? 'selected' : ''; ?>>Staff</option>
                    <option value="admin" <?php echo $formData['account_type'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password *</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="button-group">
                <button type="submit">Add User</button>
                <a href="users_list.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
