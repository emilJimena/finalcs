# Quick Start Guide - Symfony School Management System

## 5-Minute Setup

### 1. Database Setup
```bash
# Open MySQL client
mysql -u root -p

# Execute
CREATE DATABASE IF NOT EXISTS school;
USE school;
SOURCE ../school.sql;
EXIT;
```

### 2. Start Server
```bash
cd school-symfony
php -S localhost:8000 -t public
```

### 3. Open Application
```
http://localhost:8000/login
```

### 4. Login
```
Username: admin
Password: 123456
```

## Directory Overview

### `/src/` - Application Code
- **Controller/** - Handle HTTP requests (6 files)
- **Entity/** - Data models with ORM (3 files)
- **Form/** - Form definitions & validation (4 files)
- **Repository/** - Database queries (3 files)
- **Core/** - Framework utilities (Database, Router)
- **Twig/** - Template rendering

### `/templates/` - User Interface
- **base.html.twig** - Layout template
- **auth/** - Login page
- **home/** - Dashboard
- **subject/** - Subject pages (list, create, edit)
- **program/** - Program pages (list, create, edit)
- **user/** - User pages (list, create, edit, admin only)
- **password/** - Change password

### `/config/` - Configuration
- Routes, database, security settings

### `/public/` - Web Root
- **index.php** - Front controller & router

## Application Workflow

```
User Request → index.php (Router) → Controller → Repository → Database
                                         ↓
                                   Template Engine
                                         ↓
                                    HTML Response
```

## File Structure Example

### Entity (Model)
```php
// src/Entity/Subject.php
class Subject {
    private ?int $subjectId = null;
    private ?string $code = null;
    private ?string $title = null;
    private ?int $unit = null;
}
```

### Repository (Data Access)
```php
// src/Repository/SubjectRepository.php
public function findAllOrdered(): array {
    return $this->findBy([], ['title' => 'ASC']);
}
```

### Controller (Business Logic)
```php
// src/Controller/SubjectController.php
#[Route('/subject', name: 'app_subject_list')]
public function list(SubjectRepository $repo): Response {
    $subjects = $repo->findAllOrdered();
    return $this->render('subject/list.html.twig', [...]);
}
```

### Form (Validation)
```php
// src/Form/SubjectType.php
public function buildForm(FormBuilder $builder) {
    $builder->add('code', TextType::class);
    $builder->add('title', TextType::class);
    $builder->add('unit', IntegerType::class);
}
```

### Template (View)
```twig
{# templates/subject/list.html.twig #}
<table>
    {% for subject in subjects %}
        <tr>
            <td>{{ subject.code }}</td>
            <td>{{ subject.title }}</td>
            <td>{{ subject.unit }}</td>
        </tr>
    {% endfor %}
</table>
```

## Key Symfony Concepts

### 1. **Routing**
URLs are mapped to controller actions via routes.
```
GET /subject → SubjectController::list()
POST /subject/new → SubjectController::new()
GET /subject/123/edit → SubjectController::edit(123)
```

### 2. **Dependency Injection**
Dependencies are automatically provided to classes.
```php
public function __construct(SubjectRepository $repo) {
    $this->repo = $repo;  // Injected automatically
}
```

### 3. **Service Container**
Centralized registry of services and dependencies.
- Lazy loading
- Configuration-based setup
- Automatic wiring

### 4. **Middleware**
Process request/response:
```
Request → Auth Middleware → Controller → Response Middleware → Response
```

### 5. **Event System**
Hooks for application events:
```php
#[AsEventListener(event: 'kernel.request')]
public function onKernelRequest(RequestEvent $event) { }
```

### 6. **Validation**
Declarative validation rules:
```php
#[Assert\NotBlank]
#[Assert\Length(min: 3)]
private string $code;
```

## Common Tasks

### Adding a New Page
1. Create controller method
2. Add route annotation
3. Create template
4. Add navigation link

### Adding Form Validation
1. Define constraint in entity
2. Add validation in form type
3. Display errors in template

### Adding Database Query
1. Create repository method
2. Use in controller
3. Pass data to template

### Changing Access Rules
1. Add role check in controller
2. Redirect unauthorized users
3. Update template navigation

## Testing the Application

### Test Subjects Module
1. Go to Subjects page
2. Create new subject (staff only)
3. Edit existing subject
4. Delete subject
5. Check validation (empty code)

### Test Programs Module
1. Go to Programs page
2. Create new program
3. Edit program
4. Delete program

### Test Users Module (Admin only)
1. Go to Users page
2. Create new user
3. Edit user account
4. Delete user

### Test Authentication
1. Login as admin
2. Change password
3. Logout
4. Login with new password
5. Try unauthorized access

## Routing Reference

```
GET    /login                    - Login form
POST   /login                    - Process login
GET    /logout                   - Logout

GET    /                         - Home/Dashboard
GET    /home                     - Home (alternative)

GET    /subject                  - List subjects
GET    /subject/new              - New subject form
POST   /subject/new              - Create subject
GET    /subject/{id}/edit        - Edit subject form
POST   /subject/{id}/edit        - Update subject
POST   /subject/{id}/delete      - Delete subject

GET    /program                  - List programs
GET    /program/new              - New program form
POST   /program/new              - Create program
GET    /program/{id}/edit        - Edit program form
POST   /program/{id}/edit        - Update program
POST   /program/{id}/delete      - Delete program

GET    /user                     - List users (admin)
GET    /user/new                 - New user form (admin)
POST   /user/new                 - Create user (admin)
GET    /user/{id}/edit           - Edit user (admin)
POST   /user/{id}/edit           - Update user (admin)
POST   /user/{id}/delete         - Delete user (admin)

GET    /password/change          - Change password form
POST   /password/change          - Change password
```

## Roles & Permissions

### Admin
- ✅ Full access to all modules
- ✅ User management
- ✅ Subject/Program management
- ✅ Change own password

### Staff
- ✅ Subject management
- ✅ Program management
- ✅ Change own password
- ❌ Cannot manage users

### Teacher / Student
- ✅ View subjects and programs
- ✅ Change own password
- ❌ Cannot create/edit/delete
- ❌ Cannot manage users

## Database Tables

### users
```
id          - Primary key
username    - Unique identifier
password    - Hashed password (bcrypt)
account_type - admin|staff|teacher|student
created_on  - Creation timestamp
created_by  - User ID who created
updated_on  - Last update timestamp
updated_by  - User ID who updated
```

### subject
```
subject_id  - Primary key
code        - Unique code (e.g., MATH101)
title       - Subject name
unit        - Credit/Unit value
```

### program
```
program_id  - Primary key
code        - Unique code (e.g., BS-IT)
title       - Program name
years       - Duration in years
```

## Tips & Tricks

### Enable Debug Mode
Edit `.env`:
```
APP_DEBUG=true
```

### Change Database
Edit `.env`:
```
DATABASE_URL="mysql://user:pass@host:port/database"
```

### View PHP Errors
Check browser console or server terminal output.

### Test Form Validation
Leave required field empty and submit.

### Check Session Data
Add to any page:
```php
<?php echo '<pre>'; var_dump($_SESSION); echo '</pre>'; ?>
```

## Troubleshooting

**Page shows 404**
- Check URL format
- Verify controller exists
- Check method name

**Database error**
- Verify MySQL running
- Check credentials in .env
- Ensure database exists

**Form not validating**
- Check entity constraints
- Verify form type fields
- Review error messages

**Cannot login**
- Check username/password
- Verify user exists
- Check account_type value

**Access denied**
- Verify you're logged in
- Check user role
- Check session is active

## Next Steps

1. ✅ Run the application
2. ✅ Test all modules
3. ✅ Study the code structure
4. ✅ Understand Symfony patterns
5. ⬜ Install full Symfony with Composer
6. ⬜ Add unit tests
7. ⬜ Add more features
8. ⬜ Deploy to production

---

**Happy Learning!** 🎓

For detailed information, see `INSTALLATION_GUIDE.md` and `FRAMEWORK_MIGRATION_SUMMARY.md`.
