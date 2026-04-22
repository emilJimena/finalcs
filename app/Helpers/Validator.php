<?php

namespace App\Helpers;

/**
 * Validator Class
 * 
 * Provides input validation methods
 */
class Validator
{
    /**
     * Validate required field
     * 
     * @param string $value Value to validate
     * @return bool True if not empty, false otherwise
     */
    public static function required($value)
    {
        return !empty(trim($value));
    }

    /**
     * Validate email
     * 
     * @param string $email Email address to validate
     * @return bool True if valid email, false otherwise
     */
    public static function email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate minimum length
     * 
     * @param string $value Value to validate
     * @param int $minLength Minimum length required
     * @return bool True if valid, false otherwise
     */
    public static function minLength($value, $minLength)
    {
        return strlen(trim($value)) >= $minLength;
    }

    /**
     * Validate maximum length
     * 
     * @param string $value Value to validate
     * @param int $maxLength Maximum length allowed
     * @return bool True if valid, false otherwise
     */
    public static function maxLength($value, $maxLength)
    {
        return strlen(trim($value)) <= $maxLength;
    }

    /**
     * Validate string length range
     * 
     * @param string $value Value to validate
     * @param int $minLength Minimum length
     * @param int $maxLength Maximum length
     * @return bool True if valid, false otherwise
     */
    public static function lengthBetween($value, $minLength, $maxLength)
    {
        $length = strlen(trim($value));
        return $length >= $minLength && $length <= $maxLength;
    }

    /**
     * Validate numeric value
     * 
     * @param mixed $value Value to validate
     * @return bool True if numeric, false otherwise
     */
    public static function numeric($value)
    {
        return is_numeric($value);
    }

    /**
     * Validate positive integer
     * 
     * @param mixed $value Value to validate
     * @return bool True if positive integer, false otherwise
     */
    public static function positiveInteger($value)
    {
        return is_numeric($value) && intval($value) > 0;
    }

    /**
     * Validate match with another value
     * 
     * @param string $value1 First value
     * @param string $value2 Second value
     * @return bool True if values match, false otherwise
     */
    public static function match($value1, $value2)
    {
        return $value1 === $value2;
    }

    /**
     * Sanitize input
     * 
     * @param string $input Input to sanitize
     * @return string Sanitized input
     */
    public static function sanitize($input)
    {
        return htmlspecialchars(trim($input));
    }
}

?>
