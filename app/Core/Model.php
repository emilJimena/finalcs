<?php

namespace App\Core;

/**
 * Base Model Class
 * 
 * Provides common functionality for all models
 */
abstract class Model
{
    protected $conn;

    /**
     * Constructor
     * 
     * @param mysqli $connection Database connection
     */
    public function __construct($connection = null)
    {
        if ($connection === null) {
            $this->conn = Database::getInstance();
        } else {
            $this->conn = $connection;
        }
    }

    /**
     * Get database connection
     * 
     * @return mysqli
     */
    public function getConnection()
    {
        return $this->conn;
    }
}

?>
