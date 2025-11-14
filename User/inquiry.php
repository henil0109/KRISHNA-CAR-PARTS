<?php
include '../Admin/connection.php';
include 'header1.php';

$productId = intval($_GET['product_id'] ?? 0);
$product = null;

if ($productId > 0) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM products_tbl WHERE product_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $productId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Product Inquiry | Krishna Car Parts</title>
    <link rel="icon" href="../assets/images/kcp.png" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    
    <style>
        body {
            background: #0b0d10;
            color: #f6f7fb;
            min-height: 100vh;
        }
        
        .inquiry-container {
            padding: 3rem 0;
        }
        
        .inquiry-card {
            background: linear-gradient(180deg, #111317, #1b1f27);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f6f7fb;
            border-radius: 8px;
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #ff3b2f;
            color: #f6f7fb;
            box-shadow: 0 0 0 0.2rem rgba(255, 59, 47, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #ff3b2f, #ff7b36);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 59, 47, 0.4);
        }
        
        .product-info {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="inquiry-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="inquiry-card">
                        <h3 class="mb-4"><i class="fas fa-question-circle me-2"></i>Product Inquiry</h3>
                        
                        <?php if ($product): ?>
                        <div class="product-info">
                            <h5>Inquiring about: <?php echo htmlspecialchars($product['part_name']); ?></h5>
                            <p class="text-muted mb-0">Price: ₹<?php echo number_format($product['price'], 2); ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="submit-inquiry.php">
                            <?php if ($product): ?>
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Your Name *</label>
                                    <input type="text" name="customer_name" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="customer_email" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="tel" name="customer_phone" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Inquiry Type</label>
                                    <select name="inquiry_type" class="form-select">
                                        <option value="price">Price Inquiry</option>
                                        <option value="availability">Availability</option>
                                        <option value="compatibility">Compatibility</option>
                                        <option value="bulk">Bulk Order</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Your Message *</label>
                                <textarea name="message" class="form-control" rows="5" required placeholder="Please describe your inquiry in detail..."></textarea>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Inquiry
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>