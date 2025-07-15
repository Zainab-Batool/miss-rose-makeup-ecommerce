<?php
// Authentication functions
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

// Database helper functions
function getProducts($limit = null) {
    global $conn;
    
    // Add all products with their images
    $products = [
        [
            'id' => 1,
            'name' => 'Red Lipstick',
            'price' => 19.99,
            'image' => 'lipstick-red.jpg',
            'description' => 'Long-lasting matte lipstick'
        ],
        [
            'id' => 2,
            'name' => 'Black Mascara',
            'price' => 15.99,
            'image' => 'mascara-black.jpg',
            'description' => 'Volumizing mascara'
        ],
        [
            'id' => 3,
            'name' => 'Medium Foundation',
            'price' => 29.99,
            'image' => 'foundation-medium.jpg',
            'description' => 'Full coverage foundation'
        ],
        [
            'id' => 4,
            'name' => 'Eyeshadow Palette',
            'price' => 45.99,
            'image' => 'eyeshadow-palette.jpg',
            'description' => 'Professional eyeshadow palette'
        ],
        [
            'id' => 5,
            'name' => 'Makeup Brush Set',
            'price' => 39.99,
            'image' => 'makeup-brush-set.jpg',
            'description' => 'Professional brush set'
        ],
        [
            'id' => 6,
            'name' => 'Face Powder',
            'price' => 24.99,
            'image' => 'face-powder.jpg',
            'description' => 'Translucent setting powder'
        ]
    ];
    
    // Make sure your images match these exact names in assets/images folder:
    // - lipstick-red.jpg
    // - mascara-black.jpg
    // - foundation-medium.jpg
    // - eyeshadow-palette.jpg
    // - makeup-brush-set.jpg
    // - face-powder.jpg
    
    if ($limit) {
        return array_slice($products, 0, $limit);
    }
    
    return $products;
}

function getProduct($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getCategories() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM categories");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Cart functions
function addToCart($product_id, $quantity = 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
}

function getCartItems() {
    global $conn;
    $items = [];
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $product = getProduct($product_id);
            if ($product) {
                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }
    }
    return $items;
}

function getCartTotal() {
    $total = 0;
    $items = getCartItems();
    foreach ($items as $item) {
        $total += $item['product']['price'] * $item['quantity'];
    }
    return $total;
}

// Add this function to your existing functions.php
function isAdmin() {
    // Start session if not started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Debug information
    error_log("Session data in isAdmin(): " . print_r($_SESSION, true));
    
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin'])) {
        return false;
    }
    return $_SESSION['is_admin'] == 1;
}

// Add this function for order status colors
function getStatusColor($status) {
    switch ($status) {
        case 'pending':
            return 'warning';
        case 'processing':
            return 'info';
        case 'completed':
            return 'success';
        case 'cancelled':
            return 'danger';
        default:
            return 'secondary';
    }
}

function getTotalProducts() {
    global $conn;
    $stmt = $conn->query("SELECT COUNT(*) FROM products");
    return $stmt->fetchColumn();
}

function getTotalOrders() {
    global $conn;
    $stmt = $conn->query("SELECT COUNT(*) FROM orders");
    return $stmt->fetchColumn();
}

function getTotalUsers() {
    global $conn;
    $stmt = $conn->query("SELECT COUNT(*) FROM users");
    return $stmt->fetchColumn();
}

function getRecentOrders($limit = 5) {
    global $conn;
    $stmt = $conn->prepare("
        SELECT o.*, u.name as customer_name 
        FROM orders o 
        JOIN users u ON o.user_id = u.id 
        ORDER BY o.created_at DESC 
        LIMIT ?
    ");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}
