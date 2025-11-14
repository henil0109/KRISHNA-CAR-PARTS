<?php
include 'header1.php';
$inquiryId = intval($_GET['id'] ?? 0);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Inquiry Submitted | Krishna Car Parts</title>
    <link rel="icon" href="../assets/images/kcp.png" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    
    <style>
        body {
            background: #0b0d10;
            color: #f6f7fb;
            min-height: 100vh;
        }
        
        .success-container {
            padding: 5rem 0;
            text-align: center;
        }
        
        .success-card {
            background: linear-gradient(180deg, #111317, #1b1f27);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .success-icon {
            font-size: 4rem;
            color: #00ff00;
            margin-bottom: 1.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #ff3b2f, #ff7b36);
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
    </style>
</head>

<body>
    <div class="success-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="success-card">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        
                        <h2 class="mb-3">Inquiry Submitted Successfully!</h2>
                        
                        <p class="text-muted mb-4">
                            Thank you for your inquiry. We have received your message and will get back to you within 24 hours.
                        </p>
                        
                        <?php if ($inquiryId > 0): ?>
                        <div class="alert alert-info">
                            <strong>Inquiry ID:</strong> #<?php echo str_pad($inquiryId, 6, '0', STR_PAD_LEFT); ?>
                            <br><small>Please keep this ID for future reference.</small>
                        </div>
                        <?php endif; ?>
                        
                        <div class="mt-4">
                            <a href="browse.php" class="btn btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                            </a>
                            <a href="contact.php" class="btn btn-outline-light">
                                <i class="fas fa-phone me-2"></i>Contact Us
                            </a>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top border-secondary">
                            <h6>What happens next?</h6>
                            <div class="row text-start mt-3">
                                <div class="col-md-4">
                                    <i class="fas fa-envelope text-info me-2"></i>
                                    <small>We'll review your inquiry</small>
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-phone text-warning me-2"></i>
                                    <small>Our team will contact you</small>
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-handshake text-success me-2"></i>
                                    <small>We'll provide the solution</small>
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
</body>
</html>