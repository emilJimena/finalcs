<?php

namespace App\Core;

/**
 * Database Class
 * 
 * Handles database connection and operations
 */
class Database
{
    private static $instance = null;
    private $connection;

    /**
     * Constructor
     * Private to prevent instantiation
     */
    private function __construct()
    {
    }

    /**
     * Get database connection instance (Singleton)
     * 
     * @return mysqli Database connection
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$instance->connect();
        }
        return self::$instance->connection;
    }

    /**
     * Establish database connection
     * 
     * @return void
     */
    private function connect()
    {
        // Support both env-based and legacy constant-based configuration.
        $dbHost = getenv('DB_HOST');
        if ($dbHost === false || $dbHost === '') {
            $dbHost = defined('DB_HOST') ? DB_HOST : '127.0.0.1';
        }

        $dbUsername = getenv('DB_USERNAME');
        if ($dbUsername === false || $dbUsername === '') {
            $dbUsername = defined('DB_USERNAME') ? DB_USERNAME : 'root';
        }

        $dbPassword = getenv('DB_PASSWORD');
        if ($dbPassword === false) {
            $dbPassword = defined('DB_PASSWORD') ? DB_PASSWORD : '';
        }

        $dbName = getenv('DB_NAME');
        if ($dbName === false || $dbName === '') {
            $dbName = defined('DB_NAME') ? DB_NAME : 'school';
        }

        $this->connection = new \mysqli(
            $dbHost,
            $dbUsername,
            $dbPassword,
            $dbName
        );

        if ($this->connection->connect_error) {
            throw new \RuntimeException("Database connection failed: " . $this->connection->connect_error);
        }

        $this->connection->set_charset("utf8");
    }

    /**
     * Close database connection
     * 
     * @return void
     */
    public static function closeConnection()
    {
        if (self::$instance !== null && self::$instance->connection) {
            self::$instance->connection->close();
        }
    }
}

?>
