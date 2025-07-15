<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Get filters
$category_id = $_GET['category'] ?? null;
$search = $_GET['search'] ?? null;
$sort = $_GET['sort'] ?? 'name_asc';

// Build query
$query = "SELECT p.*, c.name as category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE 1=1";
$params = [];

if ($category_id) {
    $query .= " AND p.category_id = ?";
    $params[] = $category_id;
}

if ($search) {
    $query .= " AND (p.name LIKE ? OR p.description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// Add sorting
switch ($sort) {
    case 'price_asc':
        $query .= " ORDER BY p.price ASC";
        break;
    case 'price_desc':
        $query .= " ORDER BY p.price DESC";
        break;
    case 'name_desc':
        $query .= " ORDER BY p.name DESC";
        break;
    default:
        $query .= " ORDER BY p.name ASC";
}

$stmt = $conn->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Get categories for filter
$categories = $conn->query("SELECT * FROM categories ORDER BY name")->fetchAll();

include '../includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <!-- Filters -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body">
                    <h3>Filters</h3>
                    <form method="GET">
                        <div class="mb-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" 
                                   value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-control">
                                <option value="">All Categories</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>" 
                                            <?php echo $category_id == $category['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Sort By</label>
                            <select name="sort" class="form-control">
                                <option value="name_asc" <?php echo $sort == 'name_asc' ? 'selected' : ''; ?>>
                                    Name (A-Z)
                                </option>
                                <option value="name_desc" <?php echo $sort == 'name_desc' ? 'selected' : ''; ?>>
                                    Name (Z-A)
                                </option>
                                <option value="price_asc" <?php echo $sort == 'price_asc' ? 'selected' : ''; ?>>
                                    Price (Low to High)
                                </option>
                                <option value="price_desc" <?php echo $sort == 'price_desc' ? 'selected' : ''; ?>>
                                    Price (High to Low)
                                </option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="col-md-9">
            <div class="row">
                <?php if (empty($products)): ?>
                    <div class="col-12">
                        <div class="alert alert-info">No products found.</div>
                    </div>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="../assets/images/<?php echo $product['image']; ?>.jpg" 
                                     class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                    <p class="card-text text-muted">
                                        <?php echo htmlspecialchars($product['category_name']); ?>
                                    </p>
                                    <p class="card-text">$<?php echo number_format($product['price'], 2); ?></p>
                                    <a href="product-details.php?id=<?php echo $product['id']; ?>" 
                                       class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
