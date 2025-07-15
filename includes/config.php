<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'miss_rose_store');

// Site configuration
define('SITE_URL', 'http://localhost/miss-rose-store');
define('SITE_NAME', 'Miss Rose Store');

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $conn = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    
    // Debug: Print connection status
    // echo "Database connected successfully";
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
