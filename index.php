<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
include 'includes/header.php';

// Get featured products
$featured_products = getProducts(6);
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1>Welcome to <?php echo SITE_NAME; ?></h1>
            <p class="lead">Discover our collection of premium cosmetics and beauty products</p>
        </div>
    </div>

    <div class="row">
        <h2 class="mb-4">Featured Products</h2>
        <?php foreach ($featured_products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card product-card">
                    <img src="<?php echo SITE_URL; ?>/assets/images/products/<?php echo $product['image']; ?>" 
                         class="card-img-top product-image" 
                         alt="<?php echo $product['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text">$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="pages/product-details.php?id=<?php echo $product['id']; ?>" 
                           class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
