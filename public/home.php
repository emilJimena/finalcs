<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Core\Database;
use App\Core\SessionManager;
use App\Core\Auth;
use App\Helpers\Redirect;

// Check if user is logged in
if (!Auth::isLoggedIn()) {
    Redirect::login();
}

// Handle logout
if (isset($_GET['logout'])) {
    Auth::logoutUser();
    Redirect::to('login.php');
}

$user = Auth::getCurrentUser();
$accessDenied = SessionManager::get('access_denied', false);
if ($accessDenied) {
    SessionManager::remove('access_denied');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - School Encoding Module</title>
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

        .header-left h2 {
            color: #2c3e50;
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            color: #7f8c8d;
            text-align: right;
            font-size: 0.95em;
        }

        .user-info strong {
            color: #2c3e50;
            display: block;
        }

        .logout-btn {
            padding: 8px 16px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .logout-btn:hover {
            background: #c0392b;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            border-left: 4px solid;
        }

        .alert-danger {
            background: #fee;
            color: #c33;
            border-color: #c33;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 2em;
            font-weight: 600;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .card h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.3em;
        }

        .card-content {
            color: #7f8c8d;
            font-size: 0.9em;
            margin-bottom: 15px;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.9em;
        }

        .btn:hover {
            background: #2980b9;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .btn-secondary {
            background: #95a5a6;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
        }

        .hidden {
            display: none;
        }

        .welcome-section {
            background: white;
            padding: 30px;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .welcome-section h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .welcome-section p {
            color: #7f8c8d;
            font-size: 0.95em;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <h2>School Encoding Module</h2>
        </div>
        <div class="header-right">
            <div class="user-info">
                <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                <span>(<?php echo ucfirst(htmlspecialchars($user['account_type'])); ?>)</span>
            </div>
            <a href="?logout=1" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <?php if ($accessDenied): ?>
            <div class="alert alert-danger">
                You do not have permission to access that resource.
            </div>
        <?php endif; ?>

        <div class="welcome-section">
            <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
            <p>Select a module from the menu below to manage your school data.</p>
        </div>

        <h1>Modules</h1>

        <div class="grid">
            <!-- Subject Management -->
            <div class="card">
                <h3>Subjects</h3>
                <div class="card-content">
                    Manage course subjects
                </div>
                <div class="btn-group">
                    <a href="subject_list.php" class="btn">View All</a>
                    <?php if (Auth::isAdminOrStaff()): ?>
                        <a href="subject_new.php" class="btn btn-secondary">Add New</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Program Management -->
            <div class="card">
                <h3>Programs</h3>
                <div class="card-content">
                    Manage degree programs
                </div>
                <div class="btn-group">
                    <a href="program_list.php" class="btn">View All</a>
                    <?php if (Auth::isAdminOrStaff()): ?>
                        <a href="program_new.php" class="btn btn-secondary">Add New</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- User Management -->
            <?php if (Auth::isAdmin()): ?>
            <div class="card">
                <h3>Users</h3>
                <div class="card-content">
                    Manage system users
                </div>
                <div class="btn-group">
                    <a href="users_list.php" class="btn">View All</a>
                    <a href="users_new.php" class="btn btn-secondary">Add New</a>
                </div>
            </div>
            <?php endif; ?>

            <!-- Password Management -->
            <div class="card">
                <h3>Password</h3>
                <div class="card-content">
                    Change your password
                </div>
                <div class="btn-group">
                    <a href="change_password.php" class="btn">Change Password</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
