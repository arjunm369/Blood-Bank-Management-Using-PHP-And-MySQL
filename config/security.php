<?php
/**
 * Security Functions
 * Provides utility functions for input validation, sanitization, and database safety
 */

/**
 * Sanitize user input
 */
function sanitizeInput($input) {
    return trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
}

/**
 * Validate email format
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate phone number (basic)
 */
function validatePhone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    return strlen($phone) >= 10 && strlen($phone) <= 12;
}

/**
 * Hash password securely
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verify password against hash
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Execute prepared statement safely
 */
function executeQuery($con, $query, $types = "", $params = array()) {
    $stmt = $con->prepare($query);
    if (!$stmt) {
        error_log("Query prepare failed: " . $con->error);
        return false;
    }
    
    if ($types && count($params) > 0) {
        if (!$stmt->bind_param($types, ...$params)) {
            error_log("Bind param failed: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }
    
    if (!$stmt->execute()) {
        error_log("Query execution failed: " . $stmt->error);
        $stmt->close();
        return false;
    }
    
    return $stmt;
}

/**
 * Get single row result from query
 */
function getRow($con, $query, $types = "", $params = array()) {
    $stmt = executeQuery($con, $query, $types, $params);
    if (!$stmt) return false;
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    
    return $row;
}

/**
 * Get all rows from query
 */
function getRows($con, $query, $types = "", $params = array()) {
    $stmt = executeQuery($con, $query, $types, $params);
    if (!$stmt) return array();
    
    $result = $stmt->get_result();
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $stmt->close();
    
    return $rows;
}

/**
 * Insert data safely
 */
function insertRecord($con, $table, $columns, $types, $values) {
    $col_names = implode(", ", $columns);
    $placeholders = implode(", ", array_fill(0, count($columns), "?"));
    $query = "INSERT INTO $table ($col_names) VALUES ($placeholders)";
    
    $stmt = executeQuery($con, $query, $types, $values);
    if ($stmt) {
        $stmt->close();
        return true;
    }
    return false;
}

/**
 * Update data safely
 */
function updateRecord($con, $table, $updates, $types, $values, $where_col, $where_val) {
    $set_clause = implode(", ", array_map(fn($col) => "$col = ?", $updates));
    $query = "UPDATE $table SET $set_clause WHERE $where_col = ?";
    
    // Add where value to types and values
    $types .= 's';
    $values[] = $where_val;
    
    $stmt = executeQuery($con, $query, $types, $values);
    if ($stmt) {
        $stmt->close();
        return true;
    }
    return false;
}

/**
 * Delete data safely
 */
function deleteRecord($con, $table, $where_col, $where_val) {
    $query = "DELETE FROM $table WHERE $where_col = ?";
    $stmt = executeQuery($con, $query, "s", array($where_val));
    if ($stmt) {
        $stmt->close();
        return true;
    }
    return false;
}

/**
 * Validate blood group
 */
function isValidBloodGroup($blood_group) {
    $valid_groups = array('O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-');
    return in_array($blood_group, $valid_groups);
}

/**
 * Validate password strength (optional enhancement)
 */
function validatePasswordStrength($password) {
    // At least 6 characters
    if (strlen($password) < 6) {
        return false;
    }
    return true;
}

?>
