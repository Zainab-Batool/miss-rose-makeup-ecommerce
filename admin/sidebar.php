<div class="admin-sidebar">
    <div class="sidebar-header">
        <h3>Admin Panel</h3>
    </div>
    <ul class="list-unstyled">
        <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
            <a href="<?php echo SITE_URL; ?>/admin/dashboard.php">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'products.php') ? 'active' : ''; ?>">
            <a href="<?php echo SITE_URL; ?>/admin/products.php">
                <i class="fas fa-box"></i> Products
            </a>
        </li>
        <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'orders.php') ? 'active' : ''; ?>">
            <a href="<?php echo SITE_URL; ?>/admin/orders.php">
                <i class="fas fa-shopping-cart"></i> Orders
            </a>
        </li>
        <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'users.php') ? 'active' : ''; ?>">
            <a href="<?php echo SITE_URL; ?>/admin/users.php">
                <i class="fas fa-users"></i> Users
            </a>
        </li>
    </ul>
</div>

<style>
.admin-sidebar {
    background: #2c3e50;
    min-height: 100vh;
    padding: 20px 0;
    width: 250px;
    position: fixed;
    left: 0;
    top: 0;
}

.sidebar-header {
    padding: 20px;
    color: white;
    text-align: center;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.admin-sidebar ul li {
    padding: 10px 20px;
}

.admin-sidebar ul li a {
    color: #ecf0f1;
    text-decoration: none;
    display: block;
    padding: 10px;
    border-radius: 5px;
    transition: all 0.3s;
}

.admin-sidebar ul li a i {
    margin-right: 10px;
}

.admin-sidebar ul li.active a,
.admin-sidebar ul li a:hover {
    background: #34495e;
}

.admin-content {
    margin-left: 250px;
    padding: 20px;
}
</style>
