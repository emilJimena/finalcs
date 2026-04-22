<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Core\Database;
use App\Core\SessionManager;
use App\Core\Auth;
use App\Models\User;
use App\Helpers\Redirect;

// If already logged in, redirect to home
if (Auth::isLoggedIn()) {
    Redirect::to('home.php');
}

$errors = [];
$username = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validation
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // Check credentials
    if (empty($errors)) {
        try {
            $conn = Database::getInstance();
            $userModel = new User($conn);
            $auth = new Auth($userModel);

            if ($auth->login($username, $password)) {
                Redirect::to('home.php');
            } else {
                $errors[] = "Invalid username or password.";
            }
        } catch (Exception $e) {
            $errors[] = "An error occurred. Please try again.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - School Encoding Module</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 400px;
            width: 100%;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            text-align: center;
            font-size: 1.8em;
            font-weight: 600;
        }

        .subtitle {
            color: #7f8c8d;
            text-align: center;
            margin-bottom: 30px;
            font-size: 0.95em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #34495e;
            font-weight: 500;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #2c3e50;
            box-shadow: 0 0 5px rgba(44, 62, 80, 0.1);
        }

        .error-messages {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }

        .error-messages ul {
            margin: 0;
            padding-left: 20px;
        }

        .error-messages li {
            margin: 5px 0;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background: #34495e;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        button:active {
            transform: scale(0.98);
        }

        .info {
            margin-top: 20px;
            padding: 12px;
            background: #ecf0f1;
            border-radius: 4px;
            font-size: 0.85em;
            color: #34495e;
            text-align: center;
        }

        .info strong {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login Page</h1>
        <p class="subtitle">Login to your account</p>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="info">
            <strong>Demo Credentials:</strong>
            Username: admin<br>
            Password: 123456
        </div>
    </div>
</body>
</html>
