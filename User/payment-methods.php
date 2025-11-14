<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods | Krishna Car Parts</title>
    <link rel="icon" href="../assets/images/kcp.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #0b0d10 0%, #111317 50%, #1b1f27 100%);
            color: #f6f7fb;
            min-height: 100vh;
        }
        
        .payment-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1rem;
        }
        
        .payment-method {
            background: rgba(0, 255, 229, 0.1);
            border: 1px solid rgba(0, 255, 229, 0.3);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <?php include 'header1.php'; ?>
    
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4"><i class="fas fa-credit-card me-2"></i>Payment Methods</h2>
                
                <div class="payment-card">
                    <div class="payment-method">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-credit-card fa-2x me-3 text-info"></i>
                            <div>
                                <h5>Credit/Debit Cards</h5>
                                <p class="text-muted mb-0">Visa, MasterCard, RuPay accepted</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="payment-method">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-mobile-alt fa-2x me-3 text-success"></i>
                            <div>
                                <h5>UPI Payments</h5>
                                <p class="text-muted mb-0">PhonePe, Google Pay, Paytm, BHIM</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="payment-method">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-money-bill-wave fa-2x me-3 text-warning"></i>
                            <div>
                                <h5>Cash on Delivery</h5>
                                <p class="text-muted mb-0">Pay when you receive your order</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted">
                            <i class="fas fa-shield-alt me-2"></i>
                            All payments are secure and encrypted
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>