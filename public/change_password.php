<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Core\Database;
use App\Core\Auth;
use App\Core\SessionManager;
use App\Models\User;
use App\Helpers\Redirect;

// Require login
if (!Auth::isLoggedIn()) {
    Redirect::login();
}
if (!Auth::isLoggedIn()) {
    Redirect::login();
}

try {
    $conn = Database::getInstance();
    $userModel = new User($conn);
    
    $errors = [];
    $successMessage = '';
    $currentUser = Auth::getCurrentUser();

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentPassword = trim($_POST['current_password'] ?? '');
        $newPassword = trim($_POST['new_password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');

        // Validation
        if (empty($currentPassword)) {
            $errors[] = "Current password is required.";
        }

        if (empty($newPassword)) {
            $errors[] = "New password is required.";
        } elseif (strlen($newPassword) < 6) {
            $errors[] = "New password must be at least 6 characters.";
        }

        if ($newPassword !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }

        // Verify current password
        if (empty($errors)) {
            $user = $userModel->getByUsername($currentUser['username']);
            if (!$user || !User::verifyPassword($currentPassword, $user['password'])) {
                $errors[] = "Current password is incorrect.";
            }
        }

        // Update password if no errors
        if (empty($errors)) {
            if ($userModel->updatePassword($currentUser['id'], $newPassword)) {
                $successMessage = "Password changed successfully!";
            } else {
                $errors[] = "Error changing password. Please try again.";
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
    <title>Change Password - School Encoding Module</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Segoe UI', sans-serif;
            background: #f0f0f0;
            min-height: 100vh;
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

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            color: #7f8c8d;
            text-align: right;
            font-size: 0.9em;
        }

        .logout-btn {
            padding: 8px 16px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
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
            border-left: 4px solid;
            font-size: 0.95em;
        }

        .alert-error {
            border-color: #c0392b;
            background: #fee;
            color: #c33;
        }

        .alert-success {
            border-color: #27ae60;
            background: #efe;
            color: #2c3;
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

        input[type="password"] {
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
        <div class="header-right">
            <div class="user-info">
                <strong><?php echo htmlspecialchars($user['username']); ?></strong><br>
                (<?php echo ucfirst(htmlspecialchars($user['account_type'])); ?>)
            </div>
            <a href="home.php" class="logout-btn">Back to Home</a>
        </div>
    </div>

    <div class="container">
        <a href="home.php" class="back-link">&lt; Back to Home</a>

        <h1>Change Password</h1>
        <p class="subtitle">Update your account password</p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="current_password">Current Password *</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>

            <div class="form-group">
                <label for="new_password">New Password *</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm New Password *</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="button-group">
                <button type="submit">Change Password</button>
                <a href="home.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
