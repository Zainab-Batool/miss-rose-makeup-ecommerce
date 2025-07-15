<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if user is admin
if (!isAdmin()) {
    header('Location: ' . SITE_URL . '/login.php');
    exit();
}

// Redirect to dashboard
header('Location: ' . SITE_URL . '/admin/dashboard.php');
exit();
