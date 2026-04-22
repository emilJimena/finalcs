# Native PHP vs Symfony Framework - Detailed Comparison

## Project Structure

### Native PHP Approach

```
public/
├── login.php
├── logout.php
├── home.php
├── subject_list.php
├── subject_new.php
├── subject_edit.php
├── subject_delete.php
├── program_list.php
├── program_new.php
├── program_edit.php
├── program_delete.php
├── users_list.php
├── users_new.php
├── users_edit.php
├── users_delete.php
└── change_password.php

app/
├── Models/
│   ├── User.php
│   ├── Subject.php
│   └── Program.php
├── Controllers/
│   └── (No separate files, logic in public files)
├── Core/
│   └── (Auth, Database, Router, etc.)
└── views/
    └── (Mixed with controller logic)
```

### Symfony Framework Approach

```
src/
├── Controller/
│   ├── AuthController.php (one class for all auth)
│   ├── HomeController.php
│   ├── SubjectController.php (one class, multiple methods)
│   ├── ProgramController.php
│   ├── UserController.php
│   └── PasswordController.php
├── Entity/ (ORM models)
│   ├── User.php
│   ├── Subject.php
│   └── Program.php
├── Form/ (Declarative validation)
│   ├── SubjectType.php
│   ├── ProgramType.php
│   ├── UserType.php
│   └── ChangePasswordType.php
├── Repository/ (Data access layer)
│   ├── UserRepository.php
│   ├── SubjectRepository.php
│   └── ProgramRepository.php
└── Core/
    ├── Database.php
    └── Router.php

templates/ (Separate from logic)
├── base.html.twig
├── auth/
│   └── login.html.twig
├── subject/
│   ├── list.html.twig
│   ├── new.html.twig
│   └── edit.html.twig
└── ... (other templates)

public/
└── index.php (single entry point - front controller)
```

## File Comparison

### Routing

**Native PHP:**
```php
// public/subject_list.php
if ($_GET['controller'] === 'subject' && $_GET['action'] === 'list') {
    // Load controller
    // Process request
    // Include view
}
```

**Symfony:**
```php
// src/Controller/SubjectController.php
#[Route('/subject', name: 'app_subject_list')]
public function list(SubjectRepository $repo): Response {
    return $this->render('subject/list.html.twig', [
        'subjects' => $repo->findAllOrdered()
    ]);
}
```

### Database Access

**Native PHP:**
```php
// Direct queries
$result = $conn->query("SELECT * FROM users WHERE username = '" . $username . "'");
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
}
```

**Symfony:**
```php
// Repository pattern
$user = $userRepository->findByUsername($username);
```

### Validation

**Native PHP:**
```php
// Inline validation
$errors = [];
if (empty($code)) {
    $errors[] = "Code is required";
}
if (strlen($code) > 20) {
    $errors[] = "Code must not exceed 20 characters";
}
if ($subjectRepository->codeExists($code)) {
    $errors[] = "Code already exists";
}
```

**Symfony:**
```php
// Declarative validation in Form Type
class SubjectType extends AbstractType {
    public function buildForm(FormBuilder $builder) {
        $builder->add('code', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Length(['max' => 20])
            ]
        ]);
    }
}
```

### Password Hashing

**Native PHP:**
```php
// Manual hashing
if (isset($_POST['password'])) {
    $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $conn->query("UPDATE users SET password = '" . $hashedPassword . "'");
}
```

**Symfony:**
```php
// Framework-managed
$hashedPassword = $passwordHasher->hashPassword($user, $password);
$user->setPassword($hashedPassword);
$em->flush();
```

### Templates

**Native PHP:**
```php
<!-- public/subject_list.php -->
<?php
include 'app/views/layouts/header.php';
?>
<table>
    <?php foreach ($subjects as $subject): ?>
        <tr>
            <td><?php echo htmlspecialchars($subject['code']); ?></td>
            <!-- ... -->
        </tr>
    <?php endforeach; ?>
</table>
<?php include 'app/views/layouts/footer.php'; ?>
```

**Symfony:**
```twig
{# templates/subject/list.html.twig #}
{% extends "base.html.twig" %}

{% block content %}
<table>
    {% for subject in subjects %}
        <tr>
            <td>{{ subject.code }}</td>
            <!-- ... -->
        </tr>
    {% endfor %}
</table>
{% endblock %}
```

## Code Metrics

| Metric | Native PHP | Symfony |
|--------|-----------|---------|
| Total PHP Files | 20+ | 15 |
| Lines of Code (avg) | 300-500 per file | 100-200 per file |
| Template Files | 15 | 11 |
| Code Duplication | High | Low |
| Testability | Difficult | Easy |
| Maintainability | Hard | Easy |
| Scalability | Limited | Excellent |

## Feature Comparison

### Login Flow

**Native PHP:**
```
1. POST to login.php
2. login.php validates input
3. login.php queries database
4. login.php sets session
5. login.php redirects
```

**Symfony:**
```
1. POST to /login
2. Router dispatches to AuthController
3. AuthController validates input via form
4. Form validates via constraints
5. AuthController queries via repository
6. AuthController sets session via framework
7. AuthController redirects
```

### Subject Creation

**Native PHP:**
```
POST subject_new.php
└── Validate input (inline)
└── Check uniqueness (inline)
└── Insert to database (direct SQL)
└── Return to list
```

**Symfony:**
```
POST /subject/new
└── SubjectController::new()
    └── Create SubjectType form
        └── Validate via constraints
        └── Check uniqueness via repository
    └── Persist via EntityManager
    └── Redirect with flash message
```

## Security Comparison

### SQL Injection Prevention

**Native PHP (Vulnerable):**
```php
// BAD: SQL injection risk
$result = $conn->query("SELECT * FROM users WHERE username = '" . $_POST['username'] . "'");
```

**Native PHP (Safe):**
```php
// GOOD: Prepared statement
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $_POST['username']);
$stmt->execute();
```

**Symfony (Secure by Default):**
```php
// Automatically safe via query builder
$user = $userRepository->findByUsername($username);
```

### Password Security

**Native PHP:**
```php
// Manual implementation required
$hashed = password_hash($password, PASSWORD_BCRYPT);
// Need to remember to use this everywhere
```

**Symfony:**
```php
// Framework-provided
$hashedPassword = $passwordHasher->hashPassword($user, $password);
// Consistent across application
```

### CSRF Protection

**Native PHP:**
```php
// Manual implementation
session_start();
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
// Must verify on every form submission
```

**Symfony:**
```php
// Automatic via framework
// Hidden field automatically added to all forms
// Verification happens automatically
```

## Error Handling

**Native PHP:**
```php
try {
    // Custom error handling
    if (!$result) {
        throw new Exception("Query failed");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

**Symfony:**
```php
try {
    // Standardized handling
    $user = $userRepository->find($userId);
    if (!$user) {
        throw $this->createNotFoundException('User not found');
    }
} catch (NotFoundHttpException $e) {
    // Automatically handles 404
}
```

## Performance

| Aspect | Native PHP | Symfony |
|--------|-----------|---------|
| Initial Load | Faster | Slightly slower due to DI |
| Cached Load | Same | Faster with service container |
| Query Performance | Same | Same (depends on queries) |
| Memory Usage | Lower | Moderate (DI container) |
| Scalability | Limited | Excellent |

## Maintenance

### Adding a New Field to Subject

**Native PHP:**
1. Add column to database
2. Update Subject model
3. Update subject_new.php
4. Update subject_edit.php
5. Update subject_list.php view
6. Update validation in each file
7. Update repository queries
= **Multiple files to update**

**Symfony:**
1. Add property to Subject entity
2. Add field to SubjectType form
3. Add validation constraint
4. Update template (if needed)
= **Centralized changes**

## Learning Curve

**Native PHP:**
- ✅ Easy to start
- ✅ Can see immediate results
- ❌ Patterns not enforced
- ❌ Scalability issues later
- ❌ Security pitfalls

**Symfony:**
- ❌ Steeper initial learning curve
- ⚠️ Requires understanding of patterns
- ✅ Best practices enforced
- ✅ Scales with project
- ✅ Security by default

## When to Use Native PHP

- Simple scripts (< 1000 LOC)
- One-off tasks
- Rapid prototyping
- Learning PHP basics
- Legacy system integration

## When to Use Symfony

- Production applications
- Large teams
- Long-term projects
- API development
- Enterprise systems
- Scalability required
- Code reusability important

## Migration Path

```
Native PHP Application
    ↓
Review Symfony Patterns
    ↓
Create Service Layer
    ↓
Implement Repositories
    ↓
Add Form Types
    ↓
Implement Full Symfony
    ↓
Production-Ready Framework App
```

## Development Timeline

### Native PHP Project (15K LOC)
- Week 1: Core setup
- Week 2-3: Features
- Week 4: Testing & fixes
- Issue: Refactoring becomes difficult

### Symfony Project (same features)
- Week 1: Framework learning + setup
- Week 2: Entities & repositories
- Week 3: Controllers & forms
- Week 4: Templates & testing
- Benefit: Easy to extend and maintain

## Real-World Comparison

### Scenario: Add New Module (e.g., Grades)

**Native PHP:**
```
1. Create grades.php
2. Create grades_list.php
3. Create grades_new.php
4. Create grades_edit.php
5. Create grades_delete.php
6. Create views (3-4 files)
7. Update navigation (5+ files)
8. Add Grade model
9. Add validation (multiple places)
10. Add database queries
Total: 20+ files changed/created
Risk: High (changes spread across)
```

**Symfony:**
```
1. Create Grade entity
2. Create GradeType form
3. Create GradeRepository
4. Create GradeController
5. Create templates (3-4 files)
6. Update base template navigation
Total: 9 files changed/created
Risk: Low (changes isolated)
```

## Conclusion

| Aspect | Native PHP | Symfony |
|--------|-----------|---------|
| **Speed to MVP** | Fast | Medium |
| **Long-term Maintainability** | Difficult | Easy |
| **Scalability** | Limited | Excellent |
| **Team Productivity** | Decreases | Increases |
| **Security** | Manual | Built-in |
| **Testing** | Difficult | Easy |
| **Code Reuse** | Low | High |
| **Learning Curve** | Low | Medium |
| **Production Readiness** | Low | High |

**For educational projects and small scripts**: Native PHP is fine.
**For professional applications**: Use a framework like Symfony.

---

This comparison shows why frameworks are essential for professional development, while native PHP remains useful for learning and simple tasks.
