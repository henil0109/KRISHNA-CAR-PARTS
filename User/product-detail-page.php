<?php
include '../Admin/connection.php';
include 'header1.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: browse.php');
    exit;
}

$productId = intval($_GET['id']);

$sql = "SELECT p.*, c.category_name, m.model_name 
        FROM products_tbl p 
        LEFT JOIN categories_tbl c ON p.category_id = c.category_id 
        LEFT JOIN models_tbl m ON p.model_id = m.model_id 
        WHERE p.product_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $productId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$product = mysqli_fetch_assoc($result)) {
    header('Location: browse.php');
    exit;
}

// Determine stock status
if ($product['stock'] > $product['reorder_level']) {
    $stockStatus = 'In Stock';
    $stockClass = 'text-success';
    $stockBadge = 'bg-success';
} elseif ($product['stock'] > 0) {
    $stockStatus = 'Low Stock';
    $stockClass = 'text-warning';
    $stockBadge = 'bg-warning';
} else {
    $stockStatus = 'Out of Stock';
    $stockClass = 'text-danger';
    $stockBadge = 'bg-danger';
}

// Get related products
$relatedSql = "SELECT p.*, c.category_name FROM products_tbl p 
               LEFT JOIN categories_tbl c ON p.category_id = c.category_id 
               WHERE p.category_id = ? AND p.product_id != ? 
               ORDER BY RAND() LIMIT 4";
$relatedStmt = mysqli_prepare($conn, $relatedSql);
mysqli_stmt_bind_param($relatedStmt, "ii", $product['category_id'], $productId);
mysqli_stmt_execute($relatedStmt);
$relatedResult = mysqli_stmt_get_result($relatedStmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($product['part_name']); ?> | Krishna Car Parts</title>
    <link rel="icon" href="../assets/images/kcp.png" type="image/png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: #0b0d10;
            color: #f6f7fb;
            font-family: 'Inter', sans-serif;
        }
        
        .detail-container {
            padding: 2rem 0;
            min-height: 100vh;
        }
        
        .breadcrumb-nav {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 2rem;
        }
        
        .breadcrumb-nav a {
            color: #00ffe5;
            text-decoration: none;
        }
        
        .product-detail-card {
            background: linear-gradient(180deg, #111317, #1b1f27);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .product-image-container {
            background: #f8f9fa;
            padding: 2rem;
            text-align: center;
        }
        
        .product-image {
            max-width: 100%;
            max-height: 400px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .product-info {
            padding: 2rem;
        }
        
        .product-title {
            font-size: 2rem;
            font-weight: 700;
            color: #f6f7fb;
            margin-bottom: 1rem;
        }
        
        .price-display {
            background: linear-gradient(45deg, #ff3b2f, #ff7b36);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-size: 2rem;
            font-weight: bold;
            display: inline-block;
            margin: 1rem 0;
        }
        
        .stock-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            color: white;
            display: inline-block;
            margin-bottom: 1rem;
        }
        
        .info-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 1rem 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .quantity-input {
            width: 80px;
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #f6f7fb;
            border-radius: 8px;
            padding: 0.5rem;
        }
        
        .btn-quantity {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #f6f7fb;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .action-btn {
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            margin: 0.5rem;
            cursor: pointer;
        }
        
        .btn-add-cart {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
        }
        
        .btn-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3);
        }
        
        .btn-wishlist {
            background: linear-gradient(45deg, #dc3545, #e74c3c);
            color: white;
        }
        
        .btn-inquiry {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
        }
        
        .related-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 3rem;
        }
        
        .related-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1rem;
            text-align: center;
            transition: transform 0.3s ease;
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .related-card:hover {
            transform: translateY(-5px);
            border-color: #00ffe5;
        }
        
        .related-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="detail-container">
        <div class="container">
            <!-- Breadcrumb -->
            <nav class="breadcrumb-nav">
                <a href="index.php">Home</a> / 
                <a href="browse.php">Browse Parts</a> / 
                <a href="browse.php?category=<?php echo $product['category_id']; ?>"><?php echo htmlspecialchars($product['category_name']); ?></a> / 
                <span class="text-light"><?php echo htmlspecialchars($product['part_name']); ?></span>
            </nav>
            
            <div class="product-detail-card">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="product-image-container">
                            <img src="../Admin/uploads/parts/<?php echo !empty($product['part_image']) ? $product['part_image'] : 'air-filter.jpg'; ?>" 
                                 alt="<?php echo htmlspecialchars($product['part_name']); ?>" 
                                 class="product-image"
                                 onerror="this.onerror=null; this.src='../Admin/uploads/parts/air-filter.jpg';">
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="product-info">
                            <h1 class="product-title"><?php echo htmlspecialchars($product['part_name']); ?></h1>
                            
                            <div class="price-display">
                                ₹<?php echo number_format($product['price'], 2); ?>
                            </div>
                            
                            <div class="mb-3">
                                <span class="stock-badge <?php echo $stockBadge; ?>">
                                    <?php echo $stockStatus; ?>
                                </span>
                                <?php if ($product['stock'] > 0) { ?>
                                    <small class="text-muted d-block">
                                        <?php echo $product['stock']; ?> units available
                                    </small>
                                <?php } ?>
                            </div>
                            
                            <div class="info-card">
                                <div class="row">
                                    <div class="col-6">
                                        <strong><i class="fas fa-tags me-2"></i>Category:</strong><br>
                                        <span class="text-muted"><?php echo htmlspecialchars($product['category_name']); ?></span>
                                    </div>
                                    <div class="col-6">
                                        <strong><i class="fas fa-car me-2"></i>Model:</strong><br>
                                        <span class="text-muted"><?php echo htmlspecialchars($product['model_name']); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($product['part_description']) { ?>
                            <div class="info-card">
                                <strong><i class="fas fa-info-circle me-2"></i>Description:</strong>
                                <p class="mt-2 mb-0"><?php echo nl2br(htmlspecialchars($product['part_description'])); ?></p>
                            </div>
                            <?php } ?>
                            
                            <!-- Quantity Selector -->
                            <div class="quantity-selector">
                                <strong>Quantity:</strong>
                                <button class="btn-quantity" onclick="decreaseQuantity()">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="<?php echo $product['stock']; ?>">
                                <button class="btn-quantity" onclick="increaseQuantity()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            
                            <div class="action-buttons mt-4">
                                <button class="action-btn btn-add-cart" onclick="addToCartWithQuantity(<?php echo $product['product_id']; ?>)">
                                    <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                </button>
                                <button class="action-btn btn-wishlist" onclick="addToWishlist(<?php echo $product['product_id']; ?>)">
                                    <i class="fas fa-heart me-2"></i>Wishlist
                                </button>
                                <button class="action-btn btn-inquiry" onclick="inquireProduct(<?php echo $product['product_id']; ?>)">
                                    <i class="fas fa-question-circle me-2"></i>Inquire
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            <?php if (mysqli_num_rows($relatedResult) > 0) { ?>
            <div class="related-section">
                <h3 class="text-white mb-4"><i class="fas fa-layer-group me-2"></i>Related Products</h3>
                <div class="row">
                    <?php while ($related = mysqli_fetch_assoc($relatedResult)) { ?>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="related-card" onclick="window.location.href='product-detail-page.php?id=<?php echo $related['product_id']; ?>'">
                            <img src="../Admin/uploads/parts/<?php echo !empty($related['part_image']) ? $related['part_image'] : 'brake-pads.jpg'; ?>" 
                                 alt="<?php echo htmlspecialchars($related['part_name']); ?>" 
                                 class="related-img"
                                 onerror="this.onerror=null; this.src='../Admin/uploads/parts/brake-pads.jpg';">
                            <h6 class="text-white"><?php echo htmlspecialchars($related['part_name']); ?></h6>
                            <p class="text-muted small"><?php echo htmlspecialchars($related['category_name']); ?></p>
                            <strong class="text-danger">₹<?php echo number_format($related['price']); ?></strong>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    
    <!-- Toast Notifications -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="actionToast" class="toast" role="alert">
            <div class="toast-header">
                <i class="fas fa-check-circle text-success me-2"></i>
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body" id="toastMessage">
                Action completed successfully!
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="browse-script.js"></script>
    <script>
        function increaseQuantity() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.getAttribute('max'));
            if (parseInt(input.value) < max) {
                input.value = parseInt(input.value) + 1;
            }
        }
        
        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
        
        function addToCartWithQuantity(productId) {
            // Check if user is logged in first
            fetch('check-login.php')
            .then(response => response.json())
            .then(loginData => {
                if (!loginData.logged_in) {
                    if (confirm('You need to login to add items to cart. Go to login page?')) {
                        window.location.href = 'login.php';
                    }
                    return;
                }
                
                const quantity = document.getElementById('quantity').value;
                fetch('cart-actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=add&product_id=${productId}&quantity=${quantity}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Success', data.message, 'success');
                        // Update header cart count immediately
                        const cartBadge = document.getElementById('cartCount');
                        if (cartBadge) {
                            cartBadge.textContent = data.cart_count || 0;
                        }
                        if (typeof updateHeaderCounts === 'function') {
                            updateHeaderCounts();
                        }
                    } else {
                        showToast('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error', 'Failed to add product to cart', 'error');
                });
            });
        }
        
        function addToWishlist(productId) {
            // Check if user is logged in first
            fetch('check-login.php')
            .then(response => response.json())
            .then(loginData => {
                if (!loginData.logged_in) {
                    if (confirm('You need to login to add items to wishlist. Go to login page?')) {
                        window.location.href = 'login.php';
                    }
                    return;
                }
                
                fetch('wishlist-actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=add&product_id=' + productId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Success', data.message, 'success');
                        // Update header counts
                        if (typeof updateHeaderCounts === 'function') {
                            updateHeaderCounts();
                        }
                    } else {
                        showToast('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error', 'Failed to add product to wishlist', 'error');
                });
            });
        }
        
        function inquireProduct(productId) {
            window.location.href = 'inquiry.php?product_id=' + productId;
        }
        
        function showToast(title, message, type = 'success') {
            const toastElement = document.getElementById('actionToast');
            const toastHeader = toastElement.querySelector('.toast-header strong');
            const toastBody = document.getElementById('toastMessage');
            const toastIcon = toastElement.querySelector('.toast-header i');
            
            toastHeader.textContent = title;
            toastBody.textContent = message;
            
            toastIcon.className = type === 'success' ? 'fas fa-check-circle text-success me-2' : 'fas fa-exclamation-triangle text-danger me-2';
            
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
    </script>
</body>
</html>

<?php mysqli_close($conn); ?>