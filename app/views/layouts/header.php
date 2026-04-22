<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>School Encoding Module</title>
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

        .header h2 {
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
            font-size: 0.9em;
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
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #c0392b;
        }

        .nav-menu {
            background: white;
            padding: 15px;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .nav-menu ul {
            list-style: none;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .nav-menu a {
            display: inline-block;
            padding: 8px 16px;
            background: #34495e;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            transition: background 0.3s;
        }

        .nav-menu a:hover {
            background: #2c3e50;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .content {
            background: white;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 1.8em;
        }

        .page-subtitle {
            color: #7f8c8d;
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
        input[type="password"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #bdc3c7;
            border-radius: 3px;
            font-size: 1em;
            font-family: inherit;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.1);
        }

        .error-messages {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 3px;
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

        .success-message {
            background: #efe;
            color: #3c3;
            padding: 12px;
            border-radius: 3px;
            margin-bottom: 20px;
            border-left: 4px solid #3c3;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #2980b9;
        }

        .btn-secondary {
            background: #95a5a6;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
        }

        .btn-danger {
            background: #e74c3c;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
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
            transition: background 0.3s;
        }

        .btn-small:hover {
            background: #2980b9;
        }

        .btn-small-danger {
            background: #e74c3c;
        }

        .btn-small-danger:hover {
            background: #c0392b;
        }

        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 15px;
            flex-wrap: wrap;
        }

        .search-box {
            display: flex;
            gap: 10px;
        }

        .search-box input {
            padding: 10px;
            border: 1px solid #bdc3c7;
            border-radius: 3px;
            width: 200px;
        }

        .search-box button {
            padding: 10px 16px;
            background: #95a5a6;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-weight: 600;
        }

        .search-box button:hover {
            background: #7f8c8d;
        }

        .empty-state {
            text-align: center;
            color: #7f8c8d;
            padding: 40px 20px;
        }

        .empty-state p {
            margin-bottom: 20px;
        }

        .no-results {
            text-align: center;
            color: #7f8c8d;
            padding: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                gap: 20px;
            }

            .nav-menu ul {
                flex-direction: column;
            }

            .action-bar {
                flex-direction: column;
            }

            .search-box {
                flex-direction: column;
            }

            .search-box input {
                width: 100%;
            }
        }
    </style>
</head>
<body>
