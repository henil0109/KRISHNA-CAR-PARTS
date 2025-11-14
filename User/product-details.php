<?php
include '../Admin/connection.php';

if (isset($_GET['id'])) {
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
    
    if ($product = mysqli_fetch_assoc($result)) {
        // Determine stock status
        if ($product['stock'] > $product['reorder_level']) {
            $stockStatus = 'In Stock';
            $stockClass = 'text-success';
        } elseif ($product['stock'] > 0) {
            $stockStatus = 'Low Stock';
            $stockClass = 'text-warning';
        } else {
            $stockStatus = 'Out of Stock';
            $stockClass = 'text-danger';
        }
?>

<div class="row">
    <div class="col-md-6">
        <div class="product-image-large">
            <img src="../Admin/uploads/parts/<?php echo $product['part_image']; ?>" 
                 alt="<?php echo htmlspecialchars($product['part_name']); ?>" 
                 class="img-fluid rounded"
                 onerror="this.style.display='none'; this.parentNode.innerHTML='<div style=\"height:400px; background:#333; display:flex; align-items:center; justify-content:center; color:#fff; font-size:16px;\">No Image Available</div>'">
        </div>
    </div>
    <div class="col-md-6">
        <div class="product-details">
            <h4 class="mb-3"><?php echo htmlspecialchars($product['part_name']); ?></h4>
            
            <div class="product-meta mb-3">
                <div class="row">
                    <div class="col-6">
                        <strong>Category:</strong><br>
                        <span class="text-muted"><?php echo htmlspecialchars($product['category_name']); ?></span>
                    </div>
                    <div class="col-6">
                        <strong>Model:</strong><br>
                        <span class="text-muted"><?php echo htmlspecialchars($product['model_name']); ?></span>
                    </div>
                </div>
            </div>
            
            <div class="price-section mb-3">
                <h3 class="text-danger mb-0">₹<?php echo number_format($product['price'], 2); ?></h3>
            </div>
            
            <div class="stock-info mb-3">
                <strong>Availability: </strong>
                <span class="<?php echo $stockClass; ?>"><?php echo $stockStatus; ?></span>
                <?php if ($product['stock'] > 0) { ?>
                    <small class="text-muted d-block"><?php echo $product['stock']; ?> units available</small>
                <?php } ?>
            </div>
            
            <div class="description mb-4">
                <strong>Description:</strong>
                <p class="mt-2"><?php echo nl2br(htmlspecialchars($product['part_description'])); ?></p>
            </div>
            
            <div class="action-buttons">
                <div class="row g-2">
                    <div class="col-12">
                        <button class="btn btn-danger w-100" onclick="addToCart(<?php echo $product['product_id']; ?>)">
                            <i class="fas fa-cart-plus me-2"></i>Add to Cart
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-outline-light w-100" onclick="addToWishlist(<?php echo $product['product_id']; ?>)">
                            <i class="fas fa-heart me-2"></i>Wishlist
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-outline-info w-100" onclick="inquireProduct(<?php echo $product['product_id']; ?>)">
                            <i class="fas fa-question-circle me-2"></i>Inquire
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-image-large img {
    max-height: 400px;
    width: 100%;
    object-fit: cover;
    border-radius: 12px;
}

.product-details {
    padding: 1rem 0;
}

.product-meta {
    background: rgba(255, 255, 255, 0.05);
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.price-section {
    background: linear-gradient(135deg, rgba(255, 59, 47, 0.15), rgba(255, 123, 54, 0.15));
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid rgba(255, 59, 47, 0.3);
    text-align: center;
}

.stock-info {
    padding: 1rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.description {
    background: rgba(255, 255, 255, 0.05);
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.action-buttons .btn {
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.action-buttons .btn:hover {
    transform: translateY(-2px);
}

.btn-danger {
    background: linear-gradient(135deg, #ff3b2f, #ff7b36);
    border: none;
}

.btn-danger:hover {
    box-shadow: 0 8px 20px rgba(255, 59, 47, 0.4);
}

.btn-outline-light:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #00ffe5;
    border-color: #00ffe5;
}

.btn-outline-info:hover {
    background: rgba(0, 123, 255, 0.1);
    color: #007bff;
    border-color: #007bff;
}
</style>

<?php
    } else {
        echo '<div class="text-center p-4"><h5>Product not found</h5></div>';
    }
} else {
    echo '<div class="text-center p-4"><h5>Invalid product ID</h5></div>';
}

mysqli_close($conn);
?>