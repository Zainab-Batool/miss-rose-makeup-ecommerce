<?php
require_once '../includes/config.php';

// Create a simple admin user with a known password
$admin_email = 'admin@missrose.com';
$admin_password = 'admin123';
$admin_hash = password_hash($admin_password, PASSWORD_DEFAULT);

try {
    // First, check if admin exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$admin_email]);
    $existing_admin = $stmt->fetch();

    if ($existing_admin) {
        echo "Admin user already exists.<br>";
        echo "Email: admin@missrose.com<br>";
        echo "Password: admin123<br>";
    } else {
        // Create new admin user
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, is_admin) VALUES (?, ?, ?, 1)");
        $stmt->execute(['Admin User', $admin_email, $admin_hash]);
        
        echo "New admin user created successfully!<br>";
        echo "Email: admin@missrose.com<br>";
        echo "Password: admin123<br>";
    }

    // Verify users table structure
    echo "<br>Users table structure:<br>";
    $stmt = $conn->query("DESCRIBE users");
    while ($row = $stmt->fetch()) {
        print_r($row);
        echo "<br>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} 