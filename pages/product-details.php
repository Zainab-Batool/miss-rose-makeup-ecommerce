<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

$product_id = $_GET['id'] ?? null;
if (!$product_id) {
    header('Location: products.php');
    exit();
}

// Get product details
$stmt = $conn->prepare("SELECT p.*, c.name as category_name 
                       FROM products p 
                       LEFT JOIN categories c ON p.category_id = c.id 
                       WHERE p.id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: products.php');
    exit();
}

// Get related products
$stmt = $conn->prepare("SELECT * FROM products 
                       WHERE category_id = ? AND id != ? 
                       LIMIT 4");
$stmt->execute([$product['category_id'], $product_id]);
$related_products = $stmt->fetchAll();

include '../includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <img src="../assets/images/<?php echo $product['image']; ?>.jpg" 
                 class="img-fluid" alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
        
        <div class="col-md-6">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="text-muted">Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
            
            <div class="mb-3">
                <h3>$<?php echo number_format($product['price'], 2); ?></h3>
            </div>
            
            <div class="mb-3">
                <?php if ($product['stock'] > 0): ?>
                    <span class="badge bg-success">In Stock (<?php echo $product['stock']; ?>)</span>
                <?php else: ?>
                    <span class="badge bg-danger">Out of Stock</span>
                <?php endif; ?>
            </div>
            
            <div class="mb-4">
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>
            
            <?php if ($product['stock'] > 0): ?>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" 
                               value="1" min="1" max="<?php echo $product['stock']; ?>" style="width: 100px;">
                    </div>
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if (!empty($related_products)): ?>
        <div class="row mt-5">
            <h3>Related Products</h3>
            <?php foreach ($related_products as $related): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="../assets/images/products/<?php echo $related['image']; ?>" 
                             class="card-img-top" alt="<?php echo htmlspecialchars($related['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($related['name']); ?></h5>
                            <p class="card-text">$<?php echo number_format($related['price'], 2); ?></p>
                            <a href="product-details.php?id=<?php echo $related['id']; ?>" 
                               class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
