# Symfony Framework-Based School Management System

This directory contains a complete school management system rebuilt using Symfony framework concepts and patterns.

## Project Structure

```
school-symfony/
├── src/
│   ├── Controller/        # Request handlers
│   │   ├── AuthController.php
│   │   ├── HomeController.php
│   │   ├── SubjectController.php
│   │   ├── ProgramController.php
│   │   ├── UserController.php
│   │   ├── PasswordController.php
│   │   └── BaseController.php
│   ├── Entity/           # Doctrine entities (models)
│   │   ├── User.php
│   │   ├── Subject.php
│   │   └── Program.php
│   ├── Form/             # Form types for validation
│   │   ├── SubjectType.php
│   │   ├── ProgramType.php
│   │   ├── UserType.php
│   │   └── ChangePasswordType.php
│   ├── Repository/       # Database query classes
│   │   ├── UserRepository.php
│   │   ├── SubjectRepository.php
│   │   └── ProgramRepository.php
│   ├── Core/            # Core framework classes
│   │   ├── Database.php
│   │   └── Router.php
│   ├── Twig/            # Template rendering
│   │   └── TemplateEngine.php
│   └── Kernel.php       # Application kernel
├── templates/           # Twig templates
│   ├── base.html.twig
│   ├── auth/
│   ├── home/
│   ├── subject/
│   ├── program/
│   ├── user/
│   └── password/
├── config/              # Configuration files
│   └── ...
├── public/              # Web root
│   └── index.php        # Front controller
├── composer.json        # Composer configuration
├── .env                 # Environment variables
├── autoload.php         # PSR-4 autoloader
└── bootstrap.php        # Application bootstrap

```

## Symfony Framework Integration

This application demonstrates key Symfony framework concepts:

### 1. **Routing**
- URL routes defined in configuration
- Pattern matching for dynamic routes
- HTTP method support (GET, POST)

### 2. **Controllers**
- Base controller class with common functionality
- Action methods for each request
- Dependency injection through constructor

### 3. **Entities (Models)**
- Doctrine ORM-style entity classes
- Annotations for database mapping
- Type hints and getters/setters

### 4. **Repositories**
- Data access layer pattern
- Custom query methods
- DRY principle for database operations

### 5. **Form Types**
- Form class definitions
- Built-in validation constraints
- Type mapping for form rendering

### 6. **Templating (Twig)**
- Template inheritance
- Variable interpolation
- Control structures (if, for, etc.)

### 7. **Validation**
- Constraints on entities and forms
- Validation messages
- Server-side validation

### 8. **Dependency Injection**
- Service container pattern
- Automatic injection of dependencies
- Configuration-based setup

### 9. **Security & Authentication**
- User authentication handling
- Password hashing with bcrypt
- Role-based access control

### 10. **Middleware & Event System**
- Request/response handling
- Before/after action hooks
- Error handling and exceptions

## Installation & Setup (Option 1: Full Symfony Stack)

### Prerequisites
- PHP 7.4 or higher
- Composer
- MySQL/MariaDB
- Web server (Apache/Nginx) or PHP built-in server

### Step 1: Create Symfony Project

```bash
# Using Symfony Flex
composer create-project symfony/skeleton school-management
cd school-management
```

### Step 2: Install Required Bundles

```bash
composer require symfony/orm-pack
composer require symfony/form
composer require symfony/security-bundle
composer require symfony/validator
composer require symfony/twig-bundle
```

### Step 3: Configure Database

Edit `.env`:
```
DATABASE_URL="mysql://root:password@127.0.0.1:3306/school"
```

### Step 4: Create Database

```bash
php bin/console doctrine:database:create
```

### Step 5: Create Entities from Existing Database

```bash
php bin/console doctrine:mapping:convert annotation ./src/Entity --from-database
php bin/console doctrine:generate:entities App
```

### Step 6: Run Migrations

```bash
php bin/console doctrine:migrations:generate
php bin/console doctrine:migrations:migrate
```

### Step 7: Import Sample Data

```bash
mysql -u root school < ../school.sql
```

### Step 8: Start Development Server

```bash
php -S localhost:8000 -t public
```

Visit `http://localhost:8000/login`

## Installation & Setup (Option 2: Simplified Standalone Version)

This directory includes a simplified implementation that follows Symfony patterns but runs without Composer.

### Prerequisites
- PHP 7.4 or higher
- MySQL/MariaDB

### Step 1: Set Up Database

```bash
mysql -u root -p
CREATE DATABASE IF NOT EXISTS school;
USE school;
# Import schema
SOURCE ../school.sql;
```

### Step 2: Configure Environment

Edit `.env`:
```
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=
DB_NAME=school
APP_DEBUG=true
```

### Step 3: Run Development Server

From the project root:
```bash
php -S localhost:8000 -t public
```

### Step 4: Access Application

Open browser to: `http://localhost:8000/login`

**Default Credentials:**
- Username: `admin`
- Password: `123456`

Other users:
- `staff1` / `123456` (Staff)
- `teacher1` / `123456` (Teacher)
- `student1` / `123456` (Student)

## Framework Concepts Demonstrated

### MVC Architecture
```
Request → Router → Controller → Model → View → Response
```

### Request Flow
1. **HTTP Request** arrives at `public/index.php`
2. **Router** matches URL to route
3. **Controller** processes request
4. **Model** accesses database via Repository
5. **Template** renders response
6. **HTTP Response** sent to client

### Dependency Injection
```php
class UserController extends BaseController
{
    private UserRepository $userRepository;
    
    public function __construct()
    {
        // Dependencies automatically resolved
        $this->userRepository = new UserRepository();
    }
}
```

### Service Container
- Central registry of services
- Lazy loading of dependencies
- Configuration-driven setup

### Event System
- Before/After action hooks
- Request/Response events
- Exception handling

### Middleware Stack
- Authentication check
- Authorization check
- CSRF protection
- Session management

## Key Features

### Authentication
- Login with username/password
- Session-based authentication
- Secure password hashing (bcrypt)
- Logout and session termination

### Authorization
- Role-based access control (RBAC)
- Admin, Staff, Teacher, Student roles
- Controller-level access checks
- Resource-level permissions

### Validation
- Form validation on submit
- Entity constraint validation
- Custom validation rules
- Error messages and feedback

### CRUD Operations
- Create (POST)
- Read (GET)
- Update (PATCH/PUT or POST)
- Delete (DELETE or POST)

### Data Persistence
- ORM-style entity mapping
- Repository pattern for queries
- Transaction support
- Prepared statements for security

## URL Routing Map

### Authentication
```
GET/POST  /login         AuthController::login
GET       /logout        AuthController::logout
```

### Dashboard
```
GET       /              HomeController::index
GET       /home          HomeController::index
```

### Subjects
```
GET       /subject               SubjectController::list
GET/POST  /subject/new           SubjectController::new
GET/POST  /subject/{id}/edit     SubjectController::edit
POST      /subject/{id}/delete   SubjectController::delete
```

### Programs
```
GET       /program               ProgramController::list
GET/POST  /program/new           ProgramController::new
GET/POST  /program/{id}/edit     ProgramController::edit
POST      /program/{id}/delete   ProgramController::delete
```

### Users (Admin Only)
```
GET       /user                  UserController::list
GET/POST  /user/new              UserController::new
GET/POST  /user/{id}/edit        UserController::edit
POST      /user/{id}/delete      UserController::delete
```

### Password
```
GET/POST  /password/change       PasswordController::change
```

## Database Schema

### users Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    account_type ENUM('admin', 'staff', 'teacher', 'student'),
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_on DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);
```

### subject Table
```sql
CREATE TABLE subject (
    subject_id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,
    title VARCHAR(100) NOT NULL,
    unit INT NOT NULL
);
```

### program Table
```sql
CREATE TABLE program (
    program_id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,
    title VARCHAR(100) NOT NULL,
    years INT NOT NULL
);
```

## Best Practices Used

✅ **Separation of Concerns** - Controllers, Models, Views are separate
✅ **DRY Principle** - Code reuse through inheritance and composition
✅ **Single Responsibility** - Each class has one job
✅ **Dependency Injection** - Dependencies are injected, not created
✅ **Repository Pattern** - Data access is abstracted
✅ **Entity Objects** - Business logic encapsulation
✅ **Form Types** - Centralized form definition and validation
✅ **Type Hints** - Strong typing for IDE support and safety
✅ **Prepared Statements** - SQL injection prevention
✅ **Password Hashing** - Secure password storage
✅ **Session Management** - Secure session handling
✅ **Error Handling** - Centralized error management

## Troubleshooting

### 404 Not Found
- Check that the route exists in router
- Verify controller and action method names
- Check URL format matches route pattern

### Database Connection Error
- Verify MySQL is running
- Check `.env` database credentials
- Ensure database exists

### Access Denied
- Verify you are logged in
- Check user role has permission
- Verify session is active

### Form Validation Error
- Check all required fields are filled
- Verify field types match validation rules
- Check error messages for details

## Comparison: Native PHP vs Symfony

### Native PHP (Previous Version)
- Manual routing with $_GET parameters
- Mixed concerns (view & logic in same file)
- Manual form handling and validation
- Direct database queries with MySQLi
- Manual session management
- No type safety
- Difficult to test

### Symfony Framework (This Version)
- Attribute-based routing with patterns
- Separated controllers, models, and views
- Declarative form types with validation
- ORM abstraction with repositories
- Framework-managed sessions
- Strong typing with PHP 7.4+
- Unit testable architecture
- Dependency injection
- Convention over configuration
- Scalable and maintainable

## Learning Resources

- **Symfony Official Documentation**: https://symfony.com/doc/current/index.html
- **Doctrine ORM**: https://www.doctrine-project.org/
- **Twig Templates**: https://twig.symfony.com/
- **PHP PSR Standards**: https://www.php-fig.org/psr/

## Next Steps

1. **Add Tests** - PHPUnit for unit and integration tests
2. **API Development** - RESTful API with Symfony
3. **Database Migrations** - Doctrine Migrations for schema changes
4. **Logging** - Monolog for application logging
5. **Caching** - Redis for performance
6. **Task Scheduling** - Symfony Console commands
7. **Email** - Sending notifications via mail
8. **File Upload** - Document and image management
9. **Pagination** - Paginating large result sets
10. **Search** - Full-text search functionality

## License

Educational project for learning Symfony framework concepts.
