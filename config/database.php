<?php
/**
 * Database Configuration
 * This file handles all database connections securely
 */

// Check if .env file exists, if not use defaults
$env_file = __DIR__ . '/../.env';
$db_config = array(
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'database' => 'db_hemoconnect'
);

// Try to load from .env if it exists
if (file_exists($env_file)) {
    $env_vars = parse_ini_file($env_file);
    if ($env_vars) {
        $db_config = array(
            'host' => $env_vars['DB_HOST'] ?? $db_config['host'],
            'user' => $env_vars['DB_USER'] ?? $db_config['user'],
            'password' => $env_vars['DB_PASSWORD'] ?? $db_config['password'],
            'database' => $env_vars['DB_NAME'] ?? $db_config['database']
        );
    }
}

// Create connection
$con = mysqli_connect(
    $db_config['host'],
    $db_config['user'],
    $db_config['password'],
    $db_config['database']
);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($con, "utf8");

// Enable error reporting in development
error_reporting(E_ALL);
ini_set('display_errors', 0);  // Don't display in production
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Set session configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
