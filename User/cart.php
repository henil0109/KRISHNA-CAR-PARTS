<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include '../Admin/connection.php';

$cartItems = [];
$total = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $item) {
        $stmt = mysqli_prepare($conn, "SELECT * FROM products_tbl WHERE product_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $productId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($product = mysqli_fetch_assoc($result)) {
            $product['quantity'] = $item['quantity'];
            $product['subtotal'] = $product['price'] * $item['quantity'];
            $total += $product['subtotal'];
            $cartItems[] = $product;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | Krishna Car Parts</title>
    <link rel="icon" href="../assets/images/kcp.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #0b0d10 0%, #111317 50%, #1b1f27 100%);
            color: #f6f7fb;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        
        .cart-container {
            padding: 2rem 0;
        }
        
        .cart-card {
            background: linear-gradient(145deg, rgba(17, 19, 23, 0.95), rgba(27, 31, 39, 0.95));
            border: 1px solid rgba(0, 255, 229, 0.2);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            margin-bottom: 2rem;
        }
        
        .cart-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .qty-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #f6f7fb;
            width: 35px;
            height: 35px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        
        .qty-input {
            width: 60px;
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #f6f7fb;
            border-radius: 6px;
            padding: 0.5rem;
        }
        
        .total-section {
            background: rgba(0, 255, 229, 0.1);
            border: 1px solid rgba(0, 255, 229, 0.3);
            border-radius: 12px;
            padding: 2rem;
        }
        
        .btn-checkout {
            background: linear-gradient(135deg, #ff3b2f, #00ffe5);
            border: none;
            padding: 1rem 3rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
        }
        
        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 59, 47, 0.4);
        }
        
        .empty-cart {
            text-align: center;
            padding: 3rem;
        }
        
        .empty-icon {
            font-size: 4rem;
            color: #00ffe5;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <?php include 'header1.php'; ?>
    
    <div class="cart-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-card">
                        <h3><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h3>
                        
                        <?php if (empty($cartItems)): ?>
                        <div class="empty-cart">
                            <div class="empty-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <h4>Your cart is empty</h4>
                            <p class="text-muted">Add some products to get started</p>
                            <a href="browse.php" class="btn btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                            </a>
                        </div>
                        <?php else: ?>
                        
                        <?php foreach ($cartItems as $item): ?>
                        <div class="cart-item">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="../Admin/uploads/parts/<?php echo $item['part_image']; ?>" 
                                         alt="<?php echo htmlspecialchars($item['part_name']); ?>" 
                                         class="item-image"
                                         onerror="this.src='../Admin/uploads/parts/placeholder.jpg'">
                                </div>
                                <div class="col-md-4">
                                    <h6><?php echo htmlspecialchars($item['part_name']); ?></h6>
                                    <small class="text-muted">₹<?php echo number_format($item['price'], 2); ?> each</small>
                                </div>
                                <div class="col-md-3">
                                    <div class="quantity-controls">
                                        <button class="qty-btn" onclick="updateQuantity(<?php echo $item['product_id']; ?>, -1)">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" class="qty-input" value="<?php echo $item['quantity']; ?>" 
                                               onchange="setQuantity(<?php echo $item['product_id']; ?>, this.value)" min="1">
                                        <button class="qty-btn" onclick="updateQuantity(<?php echo $item['product_id']; ?>, 1)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong>₹<?php echo number_format($item['subtotal'], 2); ?></strong>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-sm btn-outline-danger" onclick="removeItem(<?php echo $item['product_id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if (!empty($cartItems)): ?>
                <div class="col-lg-4">
                    <div class="cart-card">
                        <div class="total-section">
                            <h4>Order Summary</h4>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>₹<?php echo number_format($total, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>₹50.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax (18%):</span>
                                <span>₹<?php echo number_format($total * 0.18, 2); ?></span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total:</strong>
                                <strong>₹<?php echo number_format($total + 50 + ($total * 0.18), 2); ?></strong>
                            </div>
                            
                            <a href="checkout.php" class="btn btn-checkout">
                                <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateQuantity(productId, change) {
            const input = document.querySelector(`input[onchange*="${productId}"]`);
            const newQty = Math.max(1, parseInt(input.value) + change);
            setQuantity(productId, newQty);
        }
        
        function setQuantity(productId, quantity) {
            if (quantity < 1) return;
            
            fetch('cart-actions.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `action=update&product_id=${productId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartDisplay();
                    if (typeof updateHeaderCounts === 'function') {
                        updateHeaderCounts();
                    }
                }
            });
        }
        
        function removeItem(productId) {
            if (confirm('Remove this item from cart?')) {
                fetch('cart-actions.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `action=remove&product_id=${productId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartDisplay();
                        if (typeof updateHeaderCounts === 'function') {
                            updateHeaderCounts();
                        }
                    }
                });
            }
        }
        
        function updateCartDisplay() {
            // Reload only the cart content without full page refresh
            fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.cart-container');
                if (newContent) {
                    document.querySelector('.cart-container').innerHTML = newContent.innerHTML;
                }
            });
        }
    </script>
</body>
</html>