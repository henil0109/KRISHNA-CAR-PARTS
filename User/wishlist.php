<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include '../Admin/connection.php';

// Create wishlist table if not exists
$createTable = "CREATE TABLE IF NOT EXISTS wishlist_tbl (
    wishlist_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_wishlist (user_id, product_id)
)";
mysqli_query($conn, $createTable);

// Get wishlist items
$stmt = mysqli_prepare($conn, "SELECT w.*, p.* FROM wishlist_tbl w JOIN products_tbl p ON w.product_id = p.product_id WHERE w.user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$wishlistItems = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist | Krishna Car Parts</title>
    <link rel="icon" href="../assets/images/kcp.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #0b0d10 0%, #111317 50%, #1b1f27 100%);
            color: #f6f7fb;
            min-height: 100vh;
        }
        
        .wishlist-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .wishlist-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: #00ffe5;
        }
        
        .item-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 12px;
        }
        
        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            margin: 0.25rem;
        }
        
        .btn-cart {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .btn-remove {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'header1.php'; ?>
    
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4"><i class="fas fa-heart me-2"></i>My Wishlist</h2>
                
                <?php if (mysqli_num_rows($wishlistItems) > 0): ?>
                    <?php while ($item = mysqli_fetch_assoc($wishlistItems)): ?>
                        <div class="wishlist-card">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="../Admin/uploads/parts/<?php echo $item['part_image']; ?>" 
                                         alt="<?php echo htmlspecialchars($item['part_name']); ?>" 
                                         class="item-image"
                                         onerror="this.src='../Admin/uploads/parts/placeholder.jpg'">
                                </div>
                                <div class="col-md-6">
                                    <h5><?php echo htmlspecialchars($item['part_name']); ?></h5>
                                    <p class="text-muted mb-1"><?php echo htmlspecialchars($item['part_description']); ?></p>
                                    <strong class="text-success">₹<?php echo number_format($item['price'], 2); ?></strong>
                                </div>
                                <div class="col-md-4 text-end">
                                    <button class="btn-action btn-cart" onclick="addToCart(<?php echo $item['product_id']; ?>)">
                                        <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                    </button>
                                    <button class="btn-action btn-remove" onclick="removeFromWishlist(<?php echo $item['product_id']; ?>)">
                                        <i class="fas fa-trash me-1"></i>Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                        <h4>Your wishlist is empty</h4>
                        <p class="text-muted">Save items you love for later!</p>
                        <a href="browse.php" class="btn btn-primary">Browse Parts</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addToCart(productId) {
            fetch('cart-actions.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `action=add&product_id=${productId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Added to cart!');
                    const cartBadge = document.getElementById('cartCount');
                    if (cartBadge) cartBadge.textContent = data.cart_count || 0;
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }
        
        function removeFromWishlist(productId) {
            if (confirm('Remove from wishlist?')) {
                fetch('wishlist-actions.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `action=remove&product_id=${productId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        }
    </script>
</body>
</html>