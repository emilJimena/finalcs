# 📚 Documentation Index - Symfony School Management System

## Start Here

### For the Impatient (5 Minutes)
👉 **[QUICKSTART.md](QUICKSTART.md)**
- Get running in 5 minutes
- Default users and passwords
- Basic troubleshooting
- Essential commands

### For Complete Overview
👉 **[PROJECT_SUMMARY.md](PROJECT_SUMMARY.md)**
- What was built
- Complete feature list
- Quick start
- Final checklist

## Documentation by Purpose

### 🚀 Installation & Setup

| Document | For | Time |
|---|---|---|
| [QUICKSTART.md](QUICKSTART.md) | Quick setup | 5 min |
| [INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md) | Detailed setup | 15 min |
| [.env](.env) | Configuration | 2 min |

**Steps:**
1. Start with QUICKSTART
2. Use INSTALLATION_GUIDE for details
3. Edit .env for your setup

### 📖 Learning & Understanding

| Document | Topic | Level |
|---|---|---|
| [README.md](README.md) | Overview | Beginner |
| [FRAMEWORK_MIGRATION_SUMMARY.md](FRAMEWORK_MIGRATION_SUMMARY.md) | Architecture | Intermediate |
| [NATIVE_PHP_VS_SYMFONY.md](NATIVE_PHP_VS_SYMFONY.md) | Comparison | Advanced |

**Learning Path:**
1. Read README.md for features
2. Study FRAMEWORK_MIGRATION_SUMMARY for patterns
3. Compare with NATIVE_PHP_VS_SYMFONY

### 💻 Development Reference

| File | Purpose |
|---|---|
| src/Controller/*.php | Request handlers |
| src/Entity/*.php | Data models |
| src/Form/*.php | Validation rules |
| src/Repository/*.php | Database queries |
| templates/*.html.twig | User interface |

**How to use:**
- Understand controllers first
- Study entity structure
- Learn form validation
- Explore templates

### 🔧 Troubleshooting

**Common Issues:**
- Page not loading → [QUICKSTART.md - Troubleshooting](QUICKSTART.md#troubleshooting)
- Database error → [INSTALLATION_GUIDE.md - Database](INSTALLATION_GUIDE.md)
- Access denied → [FRAMEWORK_MIGRATION_SUMMARY.md - Access Control](FRAMEWORK_MIGRATION_SUMMARY.md)
- Form validation → [NATIVE_PHP_VS_SYMFONY.md - Validation](NATIVE_PHP_VS_SYMFONY.md)

## File Structure

```
school-symfony/
├── 📖 Documentation
│   ├── INDEX.md (you are here)
│   ├── QUICKSTART.md ⭐ Start here
│   ├── PROJECT_SUMMARY.md (overview)
│   ├── INSTALLATION_GUIDE.md (detailed setup)
│   ├── FRAMEWORK_MIGRATION_SUMMARY.md (architecture)
│   ├── NATIVE_PHP_VS_SYMFONY.md (comparison)
│   └── README.md (features)
│
├── 🏗️ Application Code
│   └── src/
│       ├── Controller/ (6 files)
│       ├── Entity/ (3 files)
│       ├── Form/ (4 files)
│       ├── Repository/ (3 files)
│       └── Core/ (utilities)
│
├── 🎨 User Interface
│   └── templates/
│       ├── base.html.twig
│       ├── auth/
│       ├── home/
│       ├── subject/
│       ├── program/
│       ├── user/
│       └── password/
│
├── 🔌 Web Root
│   └── public/
│       └── index.php (front controller)
│
└── ⚙️ Configuration
    ├── composer.json
    ├── .env
    └── autoload.php
```

## Quick Navigation

### I want to...

#### Get the app running
→ [QUICKSTART.md](QUICKSTART.md) (5 min read)

#### Understand what was built
→ [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md) (10 min read)

#### Learn how to use it
→ [INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md) (15 min read)

#### Understand the architecture
→ [FRAMEWORK_MIGRATION_SUMMARY.md](FRAMEWORK_MIGRATION_SUMMARY.md) (20 min read)

#### Compare native PHP vs Symfony
→ [NATIVE_PHP_VS_SYMFONY.md](NATIVE_PHP_VS_SYMFONY.md) (30 min read)

#### Fix a problem
→ [QUICKSTART.md - Troubleshooting](QUICKSTART.md#troubleshooting) (5 min read)

#### Learn a specific feature
1. Find feature in [README.md](README.md)
2. Look at controller in [src/Controller/](src/Controller/)
3. Review entity in [src/Entity/](src/Entity/)
4. Check form in [src/Form/](src/Form/)
5. Study template in [templates/](templates/)

#### Understand database structure
→ [INSTALLATION_GUIDE.md - Database Schema](INSTALLATION_GUIDE.md#database-schema)

#### See code examples
→ [NATIVE_PHP_VS_SYMFONY.md - File Comparison](NATIVE_PHP_VS_SYMFONY.md#file-comparison)

## Reading Order Recommendations

### Path 1: Impatient Developer ⚡
1. [QUICKSTART.md](QUICKSTART.md) - Get it running (5 min)
2. Click around the app (10 min)
3. Done! You can explore code as needed

### Path 2: Curious Learner 📚
1. [README.md](README.md) - What is this? (5 min)
2. [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md) - What was built? (10 min)
3. [QUICKSTART.md](QUICKSTART.md) - Get it running (5 min)
4. [FRAMEWORK_MIGRATION_SUMMARY.md](FRAMEWORK_MIGRATION_SUMMARY.md) - How does it work? (20 min)
5. Study source code in [src/](src/)

### Path 3: Thorough Professional 🎓
1. [README.md](README.md) - Features overview (5 min)
2. [QUICKSTART.md](QUICKSTART.md) - Get it running (5 min)
3. [INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md) - Detailed setup (15 min)
4. [FRAMEWORK_MIGRATION_SUMMARY.md](FRAMEWORK_MIGRATION_SUMMARY.md) - Architecture (20 min)
5. [NATIVE_PHP_VS_SYMFONY.md](NATIVE_PHP_VS_SYMFONY.md) - Comparison (30 min)
6. Deep dive into source code (1+ hours)

## Document Descriptions

### QUICKSTART.md
**What**: 5-minute getting started guide
**When**: Read when you want to start immediately
**Length**: 5-10 minutes
**Contains**: Setup steps, test users, common tasks

### PROJECT_SUMMARY.md
**What**: High-level overview of everything built
**When**: Read first to understand scope
**Length**: 10 minutes
**Contains**: What was built, checklist, statistics

### INSTALLATION_GUIDE.md
**What**: Detailed installation and setup instructions
**When**: Read for complete setup
**Length**: 15-20 minutes
**Contains**: Step-by-step installation, database setup, concepts

### FRAMEWORK_MIGRATION_SUMMARY.md
**What**: Architecture and migration details
**When**: Read to understand Symfony patterns
**Length**: 20-30 minutes
**Contains**: Components, features, improvements, learning path

### NATIVE_PHP_VS_SYMFONY.md
**What**: Side-by-side comparison of approaches
**When**: Read to understand why frameworks
**Length**: 30-40 minutes
**Contains**: Code examples, metrics, analysis

### README.md
**What**: Features and general information
**When**: Read for overview
**Length**: 5-10 minutes
**Contains**: Features, tech stack, default users

## Code Navigation

### Controller Structure
```
src/Controller/
├── AuthController.php      → Login/Logout
├── HomeController.php      → Dashboard
├── SubjectController.php   → Subject CRUD
├── ProgramController.php   → Program CRUD
├── UserController.php      → User Management
├── PasswordController.php  → Change Password
└── BaseController.php      → Base class
```

### Entity Structure
```
src/Entity/
├── User.php       → User model
├── Subject.php    → Subject model
└── Program.php    → Program model
```

### Form Structure
```
src/Form/
├── SubjectType.php              → Subject validation
├── ProgramType.php              → Program validation
├── UserType.php                 → User validation
└── ChangePasswordType.php        → Password validation
```

### Repository Structure
```
src/Repository/
├── UserRepository.php       → User queries
├── SubjectRepository.php    → Subject queries
└── ProgramRepository.php    → Program queries
```

### Template Structure
```
templates/
├── base.html.twig                  → Main layout
├── auth/login.html.twig            → Login page
├── home/index.html.twig            → Dashboard
├── subject/list.html.twig          → Subject list
├── subject/new.html.twig           → Create subject
├── subject/edit.html.twig          → Edit subject
├── program/list.html.twig          → Program list
├── program/new.html.twig           → Create program
├── program/edit.html.twig          → Edit program
├── user/list.html.twig             → User list
├── user/new.html.twig              → Create user
├── user/edit.html.twig             → Edit user
└── password/change.html.twig        → Change password
```

## Common Tasks

### Task: Add a New Field to Subject
1. Edit `src/Entity/Subject.php` - add property
2. Edit `src/Form/SubjectType.php` - add form field
3. Edit `templates/subject/new.html.twig` - if needed
4. Run migrations (in full Symfony setup)

### Task: Change Validation Rules
1. Edit `src/Form/SubjectType.php` - update constraints
2. The form validation updates automatically

### Task: Add New Database Query
1. Edit `src/Repository/SubjectRepository.php` - add method
2. Use in controller: `$repo->newMethod()`

### Task: Add New Route
1. Add to controller as method with Route attribute
2. Create corresponding template
3. Update navigation if needed

## Keyboard Shortcuts

### Running the App
```bash
cd school-symfony
php -S localhost:8000 -t public
```

### Default URL
```
http://localhost:8000/login
```

### Default Users
```
Username: admin    | Password: 123456
Username: staff1   | Password: 123456
Username: teacher1 | Password: 123456
Username: student1 | Password: 123456
```

## Getting Help

### If you're stuck on...

**Installation**
→ [INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md)

**How to use the app**
→ [QUICKSTART.md](QUICKSTART.md)

**Understanding code**
→ [FRAMEWORK_MIGRATION_SUMMARY.md](FRAMEWORK_MIGRATION_SUMMARY.md)

**Why do it this way**
→ [NATIVE_PHP_VS_SYMFONY.md](NATIVE_PHP_VS_SYMFONY.md)

**Specific error**
→ [QUICKSTART.md - Troubleshooting](QUICKSTART.md#troubleshooting)

## External Resources

- **Symfony Official**: https://symfony.com/doc/current/index.html
- **Doctrine ORM**: https://www.doctrine-project.org/
- **Twig Templates**: https://twig.symfony.com/
- **PHP Best Practices**: https://phptherightway.com/

## Document Versions

| Document | Status | Last Updated |
|---|---|---|
| INDEX.md | ✅ Ready | 2024 |
| QUICKSTART.md | ✅ Ready | 2024 |
| PROJECT_SUMMARY.md | ✅ Ready | 2024 |
| INSTALLATION_GUIDE.md | ✅ Ready | 2024 |
| FRAMEWORK_MIGRATION_SUMMARY.md | ✅ Ready | 2024 |
| NATIVE_PHP_VS_SYMFONY.md | ✅ Ready | 2024 |
| README.md | ✅ Ready | 2024 |

---

## TL;DR (Too Long; Didn't Read)

1. Open terminal
2. Run: `php -S localhost:8000 -t public` (in school-symfony directory)
3. Visit: http://localhost:8000/login
4. Login: admin / 123456
5. Explore the app

**That's it!** Everything else is learning material.

---

**Happy coding! 🚀**

For any questions, refer to the appropriate documentation above.
