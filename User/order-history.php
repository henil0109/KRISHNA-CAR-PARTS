<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include '../Admin/connection.php';

// Check if created_at column exists
$checkColumn = mysqli_query($conn, "SHOW COLUMNS FROM orders_tbl LIKE 'created_at'");
if (mysqli_num_rows($checkColumn) == 0) {
    mysqli_query($conn, "ALTER TABLE orders_tbl ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
}

// Get user orders
$stmt = mysqli_prepare($conn, "SELECT * FROM orders_tbl WHERE user_id = ? ORDER BY order_id DESC");
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$orders = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History | Krishna Car Parts</title>
    <link rel="icon" href="../assets/images/kcp.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #0b0d10 0%, #111317 50%, #1b1f27 100%);
            color: #f6f7fb;
            min-height: 100vh;
        }
        
        .order-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .order-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: #00ffe5;
        }
        
        .order-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-pending { background: #ffc107; color: #000; }
        .status-confirmed { background: #17a2b8; color: #fff; }
        .status-processing { background: #fd7e14; color: #fff; }
        .status-shipped { background: #6f42c1; color: #fff; }
        .status-delivered { background: #28a745; color: #fff; }
        .status-cancelled { background: #dc3545; color: #fff; }
        
        .btn-view {
            background: linear-gradient(135deg, #ff3b2f, #00ffe5);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .btn-view:hover {
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <?php include 'header1.php'; ?>
    
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4"><i class="fas fa-history me-2"></i>Order History</h2>
                
                <?php if (mysqli_num_rows($orders) > 0): ?>
                    <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                        <div class="order-card">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <h5 class="mb-1"><?php echo $order['order_number']; ?></h5>
                                    <small class="text-muted"><?php echo isset($order['created_at']) ? date('M d, Y', strtotime($order['created_at'])) : 'Recent'; ?></small>
                                </div>
                                <div class="col-md-2">
                                    <span class="order-status status-<?php echo $order['order_status']; ?>">
                                        <?php echo ucfirst($order['order_status']); ?>
                                    </span>
                                </div>
                                <div class="col-md-2">
                                    <strong>₹<?php echo number_format($order['total_amount'], 2); ?></strong>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted"><?php echo $order['payment_method']; ?></small>
                                </div>
                                <div class="col-md-2 text-end">
                                    <a href="invoice.php?order=<?php echo $order['order_number']; ?>" class="btn-view">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                        <h4>No Orders Yet</h4>
                        <p class="text-muted">Start shopping to see your orders here!</p>
                        <a href="browse.php" class="btn-view">Browse Parts</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>