<?php
/**
 * Database Connection Manager
 * 
 * Handles database connections using MySQLi with connection pooling
 */

namespace App\Core;

class Database
{
    private static ?self $instance = null;
    private ?\mysqli $connection = null;
    
    private function __construct()
    {
        $host = getenv('DB_HOST') ?: 'localhost';
        $user = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASSWORD') ?: '';
        $database = getenv('DB_NAME') ?: 'school';
        
        try {
            $this->connection = new \mysqli($host, $user, $password, $database);
            
            if ($this->connection->connect_error) {
                throw new \Exception("Connection failed: " . $this->connection->connect_error);
            }
            
            $this->connection->set_charset("utf8mb4");
            
        } catch (\Exception $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            throw new \Exception("Failed to connect to database");
        }
    }
    
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection(): \mysqli
    {
        if ($this->connection === null) {
            throw new \Exception("Database connection is not established");
        }
        return $this->connection;
    }
    
    public function __destruct()
    {
        if ($this->connection instanceof \mysqli) {
            $this->connection->close();
        }
    }
}
