<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Require login for checkout
requireLogin();

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

$message = '';
$cart_items = getCartItems();
$total = getCartTotal();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    
    if (empty($address) || empty($phone)) {
        $message = 'Please fill in all fields';
    } else {
        try {
            $conn->beginTransaction();
            
            // Create order
            $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, address, phone, status) 
                                  VALUES (?, ?, ?, ?, 'pending')");
            $stmt->execute([$_SESSION['user_id'], $total, $address, $phone]);
            $order_id = $conn->lastInsertId();
            
            // Add order items
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) 
                                  VALUES (?, ?, ?, ?)");
            foreach ($cart_items as $item) {
                $stmt->execute([
                    $order_id,
                    $item['product']['id'],
                    $item['quantity'],
                    $item['product']['price']
                ]);
                
                // Update product stock
                $new_stock = $item['product']['stock'] - $item['quantity'];
                $conn->prepare("UPDATE products SET stock = ? WHERE id = ?")
                     ->execute([$new_stock, $item['product']['id']]);
            }
            
            $conn->commit();
            
            // Clear cart
            $_SESSION['cart'] = [];
            
            // Redirect to order confirmation
            header("Location: order-details.php?id=$order_id&new=1");
            exit();
            
        } catch (Exception $e) {
            $conn->rollBack();
            $message = 'Checkout failed. Please try again.';
        }
    }
}

include '../includes/header.php';
?>

<div class="container py-5">
    <h1>Checkout</h1>
    
    <?php if ($message): ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h3>Shipping Information</h3>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="address" class="form-label">Delivery Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3>Order Summary</h3>
                    <?php foreach ($cart_items as $item): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?php echo htmlspecialchars($item['product']['name']); ?> × <?php echo $item['quantity']; ?></span>
                            <span>$<?php echo number_format($item['product']['price'] * $item['quantity'], 2); ?></span>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>$<?php echo number_format($total, 2); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
