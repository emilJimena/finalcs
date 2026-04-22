# School Management System - Symfony Framework Version

A modern PHP web application built with Symfony framework for managing subjects, programs, and users with role-based access control.

## Features

- **Authentication**: Login/Logout with session management
- **User Management**: Admin can manage user accounts
- **Subject Management**: Add, edit, and view subjects
- **Program Management**: Add, edit, and view programs
- **Password Management**: Users can change their own password
- **Role-Based Access Control**: Admin, Staff, Teacher, Student roles

## Requirements

- PHP 7.4+
- MySQL/MariaDB
- Composer

## Installation

### 1. Clone or create the project

### 2. Install dependencies
```bash
composer install
```

### 3. Set up database
```bash
# Import the database schema
mysql -u root < ../school.sql
```

### 4. Configure environment
Edit `.env` to match your database credentials:
```
DATABASE_URL="mysql://root:password@127.0.0.1:3306/school"
```

### 5. Run the application
```bash
php -S localhost:8000 -t public
```

Visit `http://localhost:8000` in your browser.

## Default Users

All users have password: `123456`

- **admin** - Admin account
- **staff1** - Staff account
- **teacher1** - Teacher account  
- **student1** - Student account

## Project Structure

```
src/
├── Controller/      # Request handlers
├── Entity/         # Doctrine entities (ORM models)
├── Form/           # Form types for validation
└── Repository/     # Database queries

templates/
├── auth/           # Authentication templates
├── home/           # Home page templates
├── subject/        # Subject management templates
├── program/        # Program management templates
├── user/           # User management templates
└── layouts/        # Base layout templates

config/
├── routes.yaml     # Route definitions
└── security.yaml   # Security configuration

public/
└── index.php       # Application entry point
```

## Application Features

### Authentication
- Login page with credential validation
- Session-based authentication
- Logout functionality
- Redirect to login for unauthorized access

### Dashboard
- Welcome page with user information
- Role-based navigation
- Quick links to main modules

### Subjects Module
- List all subjects with sorting
- Add new subject with validation
- Edit existing subjects
- Delete subjects (admin/staff)

### Programs Module
- List all programs
- Add new program with validation
- Edit existing programs
- Delete programs (admin/staff)

### Users Module (Admin Only)
- List all users
- Add new user with unique username validation
- Edit user information
- Delete users
- Account type assignment

### Password Management
- Change password functionality for all users
- Current password verification
- Password confirmation validation

## Access Control Rules

### Guest Users
- Can only access login page
- Redirected to login for all other pages

### Admin
- Full access to all modules
- Can manage users
- Can manage subjects and programs

### Staff
- Cannot access user management
- Can manage subjects and programs
- Can change own password

### Teacher / Student
- Cannot access user management or admin pages
- Can view subjects and programs (read-only)
- Can change own password

## Technologies Used

- **Framework**: Symfony 6.4
- **Database ORM**: Doctrine ORM
- **Templating**: Twig
- **Form Framework**: Symfony Form Component
- **Security**: Symfony Security Component
- **Validation**: Symfony Validator

## Development

### Create a new entity
```bash
php bin/console make:entity
```

### Create a new controller
```bash
php bin/console make:controller
```

### Create a new form type
```bash
php bin/console make:form
```

## License

This project is for educational purposes.
