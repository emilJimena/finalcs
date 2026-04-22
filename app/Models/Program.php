<?php

namespace App\Models;

use App\Core\Model;

/**
 * Program Model Class
 * 
 * Handles program database operations
 */
class Program extends Model
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
     * Get all programs
     * 
     * @param string $orderBy Column to order by
     * @return array Array of programs
     */
    public function getAll($orderBy = 'code')
    {
        $sql = "SELECT * FROM program ORDER BY " . $orderBy;
        $result = $this->conn->query($sql);
        $programs = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $programs[] = $row;
            }
        }
        return $programs;
    }

    /**
     * Get program by ID
     * 
     * @param int $programId Program ID
     * @return array|null Program data or null if not found
     */
    public function getById($programId)
    {
        $sql = "SELECT * FROM program WHERE program_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $programId);
        $stmt->execute();
        $result = $stmt->get_result();
        $program = $result->num_rows > 0 ? $result->fetch_assoc() : null;
        $stmt->close();
        return $program;
    }

    /**
     * Check if code already exists
     * 
     * @param string $code Program code
     * @param int|null $excludeId Program ID to exclude from check
     * @return bool True if exists, false otherwise
     */
    public function codeExists($code, $excludeId = null)
    {
        $sql = "SELECT program_id FROM program WHERE code = ?";
        if ($excludeId !== null) {
            $sql .= " AND program_id != ?";
        }
        $stmt = $this->conn->prepare($sql);
        if ($excludeId !== null) {
            $stmt->bind_param("si", $code, $excludeId);
        } else {
            $stmt->bind_param("s", $code);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    /**
     * Check if title already exists
     * 
     * @param string $title Program title
     * @param int|null $excludeId Program ID to exclude from check
     * @return bool True if exists, false otherwise
     */
    public function titleExists($title, $excludeId = null)
    {
        $sql = "SELECT program_id FROM program WHERE title = ?";
        if ($excludeId !== null) {
            $sql .= " AND program_id != ?";
        }
        $stmt = $this->conn->prepare($sql);
        if ($excludeId !== null) {
            $stmt->bind_param("si", $title, $excludeId);
        } else {
            $stmt->bind_param("s", $title);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    /**
     * Create a new program
     * 
     * @param string $code Program code
     * @param string $title Program title
     * @param int $years Number of years
     * @return bool True if created successfully, false otherwise
     */
    public function create($code, $title, $years)
    {
        $sql = "INSERT INTO program (code, title, years) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $code, $title, $years);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Update a program
     * 
     * @param int $programId Program ID
     * @param string $code Program code
     * @param string $title Program title
     * @param int $years Number of years
     * @return bool True if updated successfully, false otherwise
     */
    public function update($programId, $code, $title, $years)
    {
        $sql = "UPDATE program SET code = ?, title = ?, years = ? WHERE program_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii", $code, $title, $years, $programId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Delete a program
     * 
     * @param int $programId Program ID
     * @return bool True if deleted successfully, false otherwise
     */
    public function delete($programId)
    {
        $sql = "DELETE FROM program WHERE program_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $programId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}

?>
