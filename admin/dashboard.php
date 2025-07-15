<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Add these lines at the very top of dashboard.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is admin
if (!isAdmin()) {
    header('Location: ' . SITE_URL . '/login.php');
    exit();
}

// Make sure you have database connection code similar to this
require_once('../config/database.php'); // or wherever your database config is
// or
$conn = mysqli_connect("localhost", "username", "password", "database_name");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Verify required tables exist
try {
    $required_tables = ['products', 'orders', 'users'];
    foreach ($required_tables as $table) {
        $check = $conn->query("SELECT 1 FROM $table LIMIT 1");
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Get statistics
$total_products = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_orders = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$total_users = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();

// Get recent orders
$recent_orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        .admin-content {
            flex: 1;
            padding: 20px;
            margin-left: 250px;
            background: #f8f9fa;
        }
        .welcome-section {
            text-align: center;
            padding: 40px 20px;
            background: #0d6efd;
            color: white;
            border-radius: 10px;
            margin-bottom: 40px;
        }
        .stats-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 40px;
        }
        .stat-card {
            width: 250px;
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            color: white;
        }
        .stat-card.products { background: #0d6efd; }
        .stat-card.orders { background: #198754; }
        .stat-card.users { background: #0dcaf0; }
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            margin: 15px 0;
        }
        .recent-activity {
            max-width: 800px;
            margin: 0 auto;
        }
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="admin-container">
    <?php include 'sidebar.php'; ?>

    <div class="admin-content">
        <div class="welcome-section">
            <h1>Welcome, Admin User!</h1>
            <p>Manage your store from this admin dashboard.</p>
        </div>

        <div class="stats-container">
            <div class="stat-card products">
                <i class="fas fa-box stat-icon"></i>
                <h3>Total Products</h3>
                <div class="stat-number"><?php echo $total_products; ?></div>
                <a href="products.php" class="btn btn-light">Manage Products</a>
            </div>

            <div class="stat-card orders">
                <i class="fas fa-shopping-cart stat-icon"></i>
                <h3>Total Orders</h3>
                <div class="stat-number"><?php echo $total_orders; ?></div>
                <a href="orders.php" class="btn btn-light">View Orders</a>
            </div>

            <div class="stat-card users">
                <i class="fas fa-users stat-icon"></i>
                <h3>Total Users</h3>
                <div class="stat-number"><?php echo $total_users; ?></div>
                <a href="users.php" class="btn btn-light">Manage Users</a>
            </div>
        </div>

        <div class="recent-activity">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Recent Activity</h3>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach ($recent_orders as $order): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Order #<?php echo $order['id']; ?></h6>
                                        <small class="text-muted">
                                            <?php echo date('F j, Y', strtotime($order['created_at'])); ?>
                                        </small>
                                    </div>
                                    <span class="badge bg-primary">
                                        $<?php echo number_format($order['total_amount'], 2); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
