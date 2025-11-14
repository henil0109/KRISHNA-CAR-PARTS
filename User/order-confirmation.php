<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_GET['order'])) {
    header('Location: index.php');
    exit;
}

include '../Admin/connection.php';

$orderNumber = $_GET['order'];

// Get order details
$stmt = mysqli_prepare($conn, "SELECT * FROM orders_tbl WHERE order_number = ? AND user_id = ?");
mysqli_stmt_bind_param($stmt, "si", $orderNumber, $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$order = mysqli_fetch_assoc($result)) {
    header('Location: index.php');
    exit;
}

// Get order items
$itemsStmt = mysqli_prepare($conn, "SELECT oi.*, p.part_name, p.part_image FROM order_items_tbl oi JOIN products_tbl p ON oi.product_id = p.product_id WHERE oi.order_id = ?");
mysqli_stmt_bind_param($itemsStmt, "i", $order['order_id']);
mysqli_stmt_execute($itemsStmt);
$itemsResult = mysqli_stmt_get_result($itemsStmt);
$orderItems = [];
while ($item = mysqli_fetch_assoc($itemsResult)) {
    $orderItems[] = $item;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation | Krishna Car Parts</title>
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
        
        .confirmation-container {
            padding: 2rem 0;
        }
        
        .confirmation-card {
            background: linear-gradient(145deg, rgba(17, 19, 23, 0.95), rgba(27, 31, 39, 0.95));
            border: 1px solid rgba(0, 255, 229, 0.2);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .success-icon {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 1rem;
            animation: bounce 1s ease-in-out;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }
        
        .order-details {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 2rem;
            margin: 2rem 0;
            text-align: left;
        }
        
        .order-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        
        .item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 1rem;
        }
        
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }
        
        .step {
            display: flex;
            align-items: center;
            margin: 0 1rem;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #28a745;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 0.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #ff3b2f, #00ffe5);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            margin: 0.5rem;
        }
        
        .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.3);
            color: #f6f7fb;
        }
        
        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #00ffe5;
            color: #00ffe5;
        }
        
        .invoice-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 2rem;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <?php include 'header1.php'; ?>
    
    <div class="confirmation-container">
        <div class="container">
            <div class="step-indicator">
                <div class="step">
                    <div class="step-number"><i class="fas fa-check"></i></div>
                    <span>Cart</span>
                </div>
                <div class="step">
                    <div class="step-number"><i class="fas fa-check"></i></div>
                    <span>Checkout</span>
                </div>
                <div class="step">
                    <div class="step-number"><i class="fas fa-check"></i></div>
                    <span>Payment</span>
                </div>
                <div class="step">
                    <div class="step-number"><i class="fas fa-check"></i></div>
                    <span>Confirmation</span>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="confirmation-card">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        
                        <h2 class="mb-3">Order Confirmed!</h2>
                        <p class="lead">Thank you for your purchase. Your order has been successfully placed.</p>
                        
                        <div class="order-details">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5><i class="fas fa-receipt me-2"></i>Order Details</h5>
                                    <p><strong>Order Number:</strong> <?php echo $order['order_number']; ?></p>
                                    <p><strong>Order Date:</strong> <?php echo date('F j, Y g:i A', strtotime($order['created_at'])); ?></p>
                                    <p><strong>Total Amount:</strong> ₹<?php echo number_format($order['total_amount'], 2); ?></p>
                                    <p><strong>Payment Method:</strong> <?php echo ucfirst(str_replace('_', ' ', $order['payment_method'])); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h5><i class="fas fa-shipping-fast me-2"></i>Shipping Details</h5>
                                    <p><strong>Name:</strong> <?php echo htmlspecialchars($order['shipping_name']); ?></p>
                                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['shipping_phone']); ?></p>
                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($order['shipping_email']); ?></p>
                                    <p><strong>Address:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="order-details">
                            <h5><i class="fas fa-box me-2"></i>Order Items</h5>
                            <?php foreach ($orderItems as $item): ?>
                            <div class="order-item">
                                <img src="../Admin/uploads/parts/<?php echo $item['part_image']; ?>" 
                                     alt="<?php echo htmlspecialchars($item['part_name']); ?>" 
                                     class="item-image"
                                     onerror="this.src='../Admin/uploads/parts/placeholder.jpg'">
                                <div class="flex-grow-1">
                                    <h6><?php echo htmlspecialchars($item['part_name']); ?></h6>
                                    <small class="text-muted">Quantity: <?php echo $item['quantity']; ?> × ₹<?php echo number_format($item['price'], 2); ?></small>
                                </div>
                                <div>
                                    <strong>₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></strong>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="mt-4">
                            <a href="invoice.php?order=<?php echo $order['order_number']; ?>" class="btn btn-primary" target="_blank">
                                <i class="fas fa-file-invoice me-2"></i>Download Invoice
                            </a>
                            <a href="browse.php" class="btn btn-outline-light">
                                <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                            </a>
                            <a href="order-history.php" class="btn btn-outline-light">
                                <i class="fas fa-history me-2"></i>View Orders
                            </a>
                        </div>
                        
                        <div class="invoice-section mt-4">
                            <h6><i class="fas fa-info-circle me-2"></i>What's Next?</h6>
                            <div class="row text-start">
                                <div class="col-md-4">
                                    <i class="fas fa-envelope text-info me-2"></i>
                                    <small>Order confirmation email sent</small>
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-box text-warning me-2"></i>
                                    <small>Order processing within 24 hours</small>
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-truck text-success me-2"></i>
                                    <small>Shipping updates via SMS/Email</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Send confirmation email (simulate)
        fetch('send-confirmation-email.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'order_number=<?php echo $order['order_number']; ?>'
        });
    </script>
</body>
</html>