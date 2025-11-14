<?php
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

include '../Admin/connection.php';

// Calculate totals
$subtotal = 0;
foreach ($_SESSION['cart'] as $productId => $item) {
    $stmt = mysqli_prepare($conn, "SELECT price FROM products_tbl WHERE product_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $productId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($product = mysqli_fetch_assoc($result)) {
        $subtotal += $product['price'] * $item['quantity'];
    }
}

$shipping = 50;
$tax = $subtotal * 0.18;
$total = $subtotal + $shipping + $tax;

// Get user data
$stmt = mysqli_prepare($conn, "SELECT * FROM users_tbl WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Krishna Car Parts</title>
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
        
        .checkout-container {
            padding: 2rem 0;
        }
        
        .checkout-card {
            background: linear-gradient(145deg, rgba(17, 19, 23, 0.95), rgba(27, 31, 39, 0.95));
            border: 1px solid rgba(0, 255, 229, 0.2);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            margin-bottom: 2rem;
        }
        
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f6f7fb;
            border-radius: 8px;
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #00ffe5;
            color: #f6f7fb;
            box-shadow: 0 0 0 0.2rem rgba(0, 255, 229, 0.25);
        }
        
        .payment-method {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .payment-method:hover, .payment-method.active {
            border-color: #00ffe5;
            background: rgba(0, 255, 229, 0.1);
        }
        
        .card-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f6f7fb;
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 1rem;
        }
        
        .qr-placeholder {
            background: rgba(255, 255, 255, 0.05);
            border: 2px dashed rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 3rem 2rem;
            color: #00ffe5;
        }
        
        .upi-app {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            text-align: center;
            font-size: 0.8rem;
        }
        
        .upi-app i {
            display: block;
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
            color: #00ffe5;
        }
        
        .alert-info {
            background: rgba(0, 255, 229, 0.1);
            border: 1px solid rgba(0, 255, 229, 0.3);
            color: #00ffe5;
        }
        
        .order-summary {
            background: rgba(0, 255, 229, 0.1);
            border: 1px solid rgba(0, 255, 229, 0.3);
            border-radius: 12px;
            padding: 2rem;
        }
        
        .btn-place-order {
            background: linear-gradient(135deg, #ff3b2f, #00ffe5);
            border: none;
            padding: 1rem 3rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
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
            background: #00ffe5;
            color: #0b0d10;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 0.5rem;
        }
        
        .step.inactive .step-number {
            background: rgba(255, 255, 255, 0.2);
            color: #f6f7fb;
        }
    </style>
</head>
<body>
    <?php include 'header1.php'; ?>
    
    <div class="checkout-container">
        <div class="container">
            <div class="step-indicator">
                <div class="step">
                    <div class="step-number">1</div>
                    <span>Cart</span>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <span>Checkout</span>
                </div>
                <div class="step inactive">
                    <div class="step-number">3</div>
                    <span>Payment</span>
                </div>
                <div class="step inactive">
                    <div class="step-number">4</div>
                    <span>Confirmation</span>
                </div>
            </div>
            
            <form method="POST" action="process-order.php" id="checkoutForm">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Shipping Information -->
                        <div class="checkout-card">
                            <h4><i class="fas fa-shipping-fast me-2"></i>Shipping Information</h4>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="shipping_name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="shipping_phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="shipping_email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Address Line 1</label>
                                <input type="text" name="shipping_address1" class="form-control" placeholder="Street address" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Address Line 2 (Optional)</label>
                                <input type="text" name="shipping_address2" class="form-control" placeholder="Apartment, suite, etc.">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" name="shipping_city" class="form-control" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">State</label>
                                    <input type="text" name="shipping_state" class="form-control" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">PIN Code</label>
                                    <input type="text" name="shipping_pincode" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Method -->
                        <div class="checkout-card">
                            <h4><i class="fas fa-credit-card me-2"></i>Payment Method</h4>
                            
                            <div class="payment-method active" onclick="selectPayment('card')">
                                <input type="radio" name="payment_method" value="card" checked hidden>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-credit-card me-3 fs-4"></i>
                                    <div>
                                        <strong>Credit/Debit Card</strong>
                                        <div class="text-muted small">Visa, MasterCard, RuPay</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="payment-method" onclick="selectPayment('upi')">
                                <input type="radio" name="payment_method" value="upi" hidden>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-mobile-alt me-3 fs-4"></i>
                                    <div>
                                        <strong>UPI Payment</strong>
                                        <div class="text-muted small">PhonePe, Google Pay, Paytm</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="payment-method" onclick="selectPayment('cod')">
                                <input type="radio" name="payment_method" value="cod" hidden>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-money-bill-wave me-3 fs-4"></i>
                                    <div>
                                        <strong>Cash on Delivery</strong>
                                        <div class="text-muted small">Pay when you receive</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Card Details -->
                            <div id="cardDetails" class="mt-3">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Demo Mode:</strong> Use dummy details for testing
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Card Number</label>
                                        <input type="text" name="card_number" class="card-input" value="4111 1111 1111 1111" maxlength="19">
                                        <small class="text-muted">Demo: 4111 1111 1111 1111</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Expiry Date</label>
                                        <input type="text" name="card_expiry" class="card-input" value="12/25" maxlength="5">
                                        <small class="text-muted">Demo: 12/25</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CVV</label>
                                        <input type="text" name="card_cvv" class="card-input" value="123" maxlength="3">
                                        <small class="text-muted">Demo: 123</small>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Cardholder Name</label>
                                    <input type="text" name="card_name" class="card-input" value="John Doe">
                                    <small class="text-muted">Demo: John Doe</small>
                                </div>
                            </div>
                            
                            <!-- UPI Details -->
                            <div id="upiDetails" class="mt-3" style="display: none;">
                                <div class="text-center">
                                    <div class="qr-code-container mb-3">
                                        <div class="qr-placeholder">
                                            <i class="fas fa-qrcode fa-5x mb-3"></i>
                                            <h5>Scan QR Code</h5>
                                            <p class="text-muted">Use any UPI app to scan and pay</p>
                                        </div>
                                    </div>
                                    <div class="upi-apps">
                                        <p class="mb-2">Or pay using:</p>
                                        <div class="d-flex justify-content-center gap-3">
                                            <div class="upi-app">
                                                <i class="fas fa-mobile-alt"></i>
                                                <span>PhonePe</span>
                                            </div>
                                            <div class="upi-app">
                                                <i class="fab fa-google-pay"></i>
                                                <span>GPay</span>
                                            </div>
                                            <div class="upi-app">
                                                <i class="fas fa-wallet"></i>
                                                <span>Paytm</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <input type="text" class="card-input text-center" placeholder="Enter UPI ID (optional)" name="upi_id">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="checkout-card">
                            <div class="order-summary">
                                <h4>Order Summary</h4>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>₹<?php echo number_format($subtotal, 2); ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span>₹<?php echo number_format($shipping, 2); ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax (18%):</span>
                                    <span>₹<?php echo number_format($tax, 2); ?></span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total:</strong>
                                    <strong>₹<?php echo number_format($total, 2); ?></strong>
                                </div>
                                
                                <button type="submit" class="btn btn-place-order">
                                    <i class="fas fa-lock me-2"></i>Place Order
                                </button>
                                
                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-shield-alt me-1"></i>
                                        Your payment information is secure
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectPayment(method) {
            document.querySelectorAll('.payment-method').forEach(el => el.classList.remove('active'));
            event.currentTarget.classList.add('active');
            document.querySelector(`input[value="${method}"]`).checked = true;
            
            const cardDetails = document.getElementById('cardDetails');
            const upiDetails = document.getElementById('upiDetails');
            
            cardDetails.style.display = method === 'card' ? 'block' : 'none';
            upiDetails.style.display = method === 'upi' ? 'block' : 'none';
            
            // Update required fields
            const cardInputs = cardDetails.querySelectorAll('input');
            cardInputs.forEach(input => {
                input.required = method === 'card';
            });
        }
        
        // Format card number
        document.querySelector('input[name="card_number"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });
        
        // Format expiry date
        document.querySelector('input[name="card_expiry"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0,2) + '/' + value.substring(2,4);
            }
            e.target.value = value;
        });
        
        // Initialize
        selectPayment('card');
    </script>
</body>
</html>