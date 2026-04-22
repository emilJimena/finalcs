<?php
/**
 * Application Bootstrap
 * 
 * This file initializes the Symfony-based application
 */

// Define the application root
define('ROOT_DIR', __DIR__);
define('PUBLIC_DIR', ROOT_DIR . '/public');

// Load legacy application constants when available.
$configFile = ROOT_DIR . '/config/config.php';
if (file_exists($configFile)) {
    require_once $configFile;
}

// PSR-4 Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = ROOT_DIR . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Load environment variables
$envFile = ROOT_DIR . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value, ' "\'');
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

// Parse DATABASE_URL and set individual database environment variables
$databaseUrl = getenv('DATABASE_URL');
if ($databaseUrl) {
    // Format: mysql://root:password@127.0.0.1:3306/school?serverVersion=8.0
    $url = parse_url($databaseUrl);
    
    $dbHost = isset($url['host']) ? $url['host'] : '127.0.0.1';
    $dbUsername = isset($url['user']) ? $url['user'] : 'root';
    $dbPassword = isset($url['pass']) ? $url['pass'] : '';
    $dbName = isset($url['path']) ? ltrim($url['path'], '/') : 'school';
    
    // Set individual environment variables
    putenv("DB_HOST=$dbHost");
    putenv("DB_USERNAME=$dbUsername");
    putenv("DB_PASSWORD=$dbPassword");
    putenv("DB_NAME=$dbName");
    
    $_ENV['DB_HOST'] = $dbHost;
    $_ENV['DB_USERNAME'] = $dbUsername;
    $_ENV['DB_PASSWORD'] = $dbPassword;
    $_ENV['DB_NAME'] = $dbName;
}

// Keep legacy constant-based code working with env-backed configuration.
$compatConstants = [
    'DB_HOST' => getenv('DB_HOST') ?: '127.0.0.1',
    'DB_USERNAME' => getenv('DB_USERNAME') ?: 'root',
    'DB_PASSWORD' => getenv('DB_PASSWORD') ?: '',
    'DB_NAME' => getenv('DB_NAME') ?: 'school',
    'APP_NAME' => getenv('APP_NAME') ?: 'School Encoding Module',
    'ACCOUNT_TYPE_ADMIN' => 'admin',
    'ACCOUNT_TYPE_STAFF' => 'staff',
    'ACCOUNT_TYPE_TEACHER' => 'teacher',
    'ACCOUNT_TYPE_STUDENT' => 'student',
    'SESSION_TIMEOUT' => 3600,
];

foreach ($compatConstants as $name => $value) {
    if (!defined($name)) {
        define($name, $value);
    }
}

// Session configuration (must be before session_start())
$sessionPath = ROOT_DIR . '/var/sessions';
if (!is_dir($sessionPath)) {
    mkdir($sessionPath, 0777, true);
}
session_save_path($sessionPath);
ini_set('session.gc_maxlifetime', 3600);
session_start();

// Error reporting
if (getenv('APP_DEBUG') === 'true') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
}

// Timezone
date_default_timezone_set('UTC');

// CSRF Protection token generation
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
