<?php
require_once '../includes/config.php';

$admin_password = 'admin123'; // Change this to your desired password
$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

// Insert admin user into database
try {
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, is_admin) VALUES (?, ?, ?, 1)");
    $stmt->execute(['Admin User', 'admin@missrose.com', $hashed_password]);
    echo "Admin user created successfully!<br>";
    echo "Email: admin@missrose.com<br>";
    echo "Password: " . $admin_password . "<br>";
    echo "Hashed Password: " . $hashed_password;
} catch(PDOException $e) {
    echo "Error creating admin: " . $e->getMessage();
} 