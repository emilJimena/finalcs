<?php

namespace App\Models;

use App\Core\Model;

/**
 * Subject Model Class
 * 
 * Handles subject database operations
 */
class Subject extends Model
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
     * Get all subjects
     * 
     * @param string $orderBy Column to order by
     * @return array Array of subjects
     */
    public function getAll($orderBy = 'code')
    {
        $sql = "SELECT * FROM subject ORDER BY " . $orderBy;
        $result = $this->conn->query($sql);
        $subjects = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $subjects[] = $row;
            }
        }
        return $subjects;
    }

    /**
     * Get subject by ID
     * 
     * @param int $subjectId Subject ID
     * @return array|null Subject data or null if not found
     */
    public function getById($subjectId)
    {
        $sql = "SELECT * FROM subject WHERE subject_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $subjectId);
        $stmt->execute();
        $result = $stmt->get_result();
        $subject = $result->num_rows > 0 ? $result->fetch_assoc() : null;
        $stmt->close();
        return $subject;
    }

    /**
     * Check if code already exists
     * 
     * @param string $code Subject code
     * @param int|null $excludeId Subject ID to exclude from check
     * @return bool True if exists, false otherwise
     */
    public function codeExists($code, $excludeId = null)
    {
        $sql = "SELECT subject_id FROM subject WHERE code = ?";
        if ($excludeId !== null) {
            $sql .= " AND subject_id != ?";
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
     * @param string $title Subject title
     * @param int|null $excludeId Subject ID to exclude from check
     * @return bool True if exists, false otherwise
     */
    public function titleExists($title, $excludeId = null)
    {
        $sql = "SELECT subject_id FROM subject WHERE title = ?";
        if ($excludeId !== null) {
            $sql .= " AND subject_id != ?";
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
     * Create a new subject
     * 
     * @param string $code Subject code
     * @param string $title Subject title
     * @param int $unit Number of units
     * @return bool True if created successfully, false otherwise
     */
    public function create($code, $title, $unit)
    {
        $sql = "INSERT INTO subject (code, title, unit) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $code, $title, $unit);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Update a subject
     * 
     * @param int $subjectId Subject ID
     * @param string $code Subject code
     * @param string $title Subject title
     * @param int $unit Number of units
     * @return bool True if updated successfully, false otherwise
     */
    public function update($subjectId, $code, $title, $unit)
    {
        $sql = "UPDATE subject SET code = ?, title = ?, unit = ? WHERE subject_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii", $code, $title, $unit, $subjectId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Delete a subject
     * 
     * @param int $subjectId Subject ID
     * @return bool True if deleted successfully, false otherwise
     */
    public function delete($subjectId)
    {
        $sql = "DELETE FROM subject WHERE subject_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $subjectId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}

?>
