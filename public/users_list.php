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
    
    // Fetch all users
    $users = $userModel->getAll();
} catch (Exception $e) {
    die("Error: " . htmlspecialchars($e->getMessage()));
}

$user = Auth::getCurrentUser();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - School Encoding Module</title>
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
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: 1.8em;
            font-weight: 600;
        }

        .page-subtitle {
            color: #7f8c8d;
            margin-bottom: 30px;
            font-size: 0.95em;
        }

        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 16px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        th {
            background: #ecf0f1;
            color: #2c3e50;
            font-weight: 600;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 0.85em;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-small:hover {
            background: #2980b9;
        }

        .btn-delete {
            background: #e74c3c;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .empty-message {
            text-align: center;
            color: #7f8c8d;
            padding: 40px 20px;
            font-size: 1.1em;
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

        .badge {
            display: inline-block;
            padding: 4px 8px;
            background: #ecf0f1;
            color: #2c3e50;
            border-radius: 3px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .badge-admin {
            background: #c0392b;
            color: white;
        }

        .badge-staff {
            background: #e74c3c;
            color: white;
        }

        .badge-teacher {
            background: #3498db;
            color: white;
        }

        .badge-student {
            background: #95a5a6;
            color: white;
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

        <h1>Users</h1>
        <p class="page-subtitle">Manage all users in the system</p>

        <div class="action-bar">
            <div></div>
            <a href="users_new.php" class="btn">+ Add New User</a>
        </div>

        <?php if (count($users) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Account Type</th>
                        <th>Created On</th>
                        <th>Updated On</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $usr): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usr['username']); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $usr['account_type']; ?>">
                                    <?php echo ucfirst(htmlspecialchars($usr['account_type'])); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($usr['created_on']); ?></td>
                            <td><?php echo $usr['updated_on'] ? htmlspecialchars($usr['updated_on']) : 'N/A'; ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="users_edit.php?id=<?php echo $usr['id']; ?>" class="btn-small">Edit</a>
                                    <?php if ($usr['id'] != $user['id']): ?>
                                        <a href="users_delete.php?id=<?php echo $usr['id']; ?>" class="btn-small btn-delete" onclick="return confirm('Are you sure?');">Delete</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-message">
                No users found. <a href="users_new.php">Create one</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
