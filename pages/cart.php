<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Require login for cart
requireLogin();

$message = '';

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $product_id = $_POST['product_id'];
                $quantity = $_POST['quantity'] ?? 1;
                addToCart($product_id, $quantity);
                $message = 'Product added to cart';
                break;
                
            case 'update':
                $product_id = $_POST['product_id'];
                $quantity = $_POST['quantity'];
                updateCartQuantity($product_id, $quantity);
                $message = 'Cart updated';
                break;
                
            case 'remove':
                $product_id = $_POST['product_id'];
                removeFromCart($product_id);
                $message = 'Product removed from cart';
                break;
        }
    }
}

// Get cart items
$cart_items = getCartItems();
$total = getCartTotal();

include '../includes/header.php';
?>

<div class="container py-5">
    <h1>Shopping Cart</h1>
    
    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <?php if (empty($cart_items)): ?>
        <div class="alert alert-info">Your cart is empty. <a href="products.php">Continue shopping</a></div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td>
                                <img src="../assets/images/<?php echo $item['product']['image']; ?>.jpg" 
                                     alt="" style="width: 50px; height: 50px; object-fit: cover;">
                                <?php echo htmlspecialchars($item['product']['name']); ?>
                            </td>
                            <td>$<?php echo number_format($item['product']['price'], 2); ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="product_id" value="<?php echo $item['product']['id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" 
                                           min="1" max="<?php echo $item['product']['stock']; ?>" 
                                           class="form-control" style="width: 80px;" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td>$<?php echo number_format($item['product']['price'] * $item['quantity'], 2); ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="product_id" value="<?php echo $item['product']['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="d-flex justify-content-between">
            <a href="products.php" class="btn btn-secondary">Continue Shopping</a>
            <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
