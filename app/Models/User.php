<?php

namespace App\Models;

use App\Core\Model;

/**
 * User Model Class
 * 
 * Handles user database operations
 */
class User extends Model
{
    /**
     * Constructor
     * 
     * @param mysqli $connection Database connection (optional)
     */
    public function __construct($connection = null)
    {
        parent::__construct($connection);
    }

    /**
     * Get all users
     * 
     * @param string $orderBy Column to order by
     * @return array Array of users
     */
    public function getAll($orderBy = 'created_on DESC')
    {
        $sql = "SELECT id, username, account_type, created_on, updated_on FROM users ORDER BY " . $orderBy;
        $result = $this->conn->query($sql);
        $users = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    /**
     * Get user by ID
     * 
     * @param int $userId User ID
     * @return array|null User data or null if not found
     */
    public function getById($userId)
    {
        $sql = "SELECT id, username, password, account_type FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->num_rows > 0 ? $result->fetch_assoc() : null;
        $stmt->close();
        return $user;
    }

    /**
     * Get user by username
     * 
     * @param string $username Username
     * @return array|null User data or null if not found
     */
    public function getByUsername($username)
    {
        $sql = "SELECT id, username, password, account_type FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->num_rows > 0 ? $result->fetch_assoc() : null;
        $stmt->close();
        return $user;
    }

    /**
     * Check if username already exists
     * 
     * @param string $username Username
     * @param int|null $excludeId User ID to exclude from check
     * @return bool True if exists, false otherwise
     */
    public function usernameExists($username, $excludeId = null)
    {
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($excludeId !== null) {
            $sql .= " AND id != ?";
        }
        $stmt = $this->conn->prepare($sql);
        if ($excludeId !== null) {
            $stmt->bind_param("si", $username, $excludeId);
        } else {
            $stmt->bind_param("s", $username);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    /**
     * Create a new user
     * 
     * @param string $username Username
     * @param string $password Password (will be hashed)
     * @param string $accountType Account type
     * @param int $createdBy User ID who created this
     * @return bool True if created successfully, false otherwise
     */
    public function create($username, $password, $accountType, $createdBy)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $updatedBy = null;
        
        $sql = "INSERT INTO users (username, password, account_type, created_on, created_by, updated_on, updated_by) 
                VALUES (?, ?, ?, NOW(), ?, NULL, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssii", $username, $hashedPassword, $accountType, $createdBy, $updatedBy);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Update a user
     * 
     * @param int $userId User ID
     * @param string $username Username
     * @param string $accountType Account type
     * @param int $updatedBy User ID who updated this
     * @return bool True if updated successfully, false otherwise
     */
    public function update($userId, $username, $accountType, $updatedBy)
    {
        $sql = "UPDATE users SET username = ?, account_type = ?, updated_on = NOW(), updated_by = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii", $username, $accountType, $updatedBy, $userId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Update user password
     * 
     * @param int $userId User ID
     * @param string $newPassword New password (will be hashed)
     * @return bool True if updated successfully, false otherwise
     */
    public function updatePassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $hashedPassword, $userId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Delete a user
     * 
     * @param int $userId User ID
     * @return bool True if deleted successfully, false otherwise
     */
    public function delete($userId)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Verify user password
     * 
     * @param string $plainPassword Plain text password
     * @param string $hashedPassword Hashed password from database
     * @return bool True if password matches, false otherwise
     */
    public static function verifyPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}

?>
