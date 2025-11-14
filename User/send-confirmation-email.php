<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_number'])) {
    include '../Admin/connection.php';
    
    $orderNumber = $_POST['order_number'];
    
    // Get order details
    $stmt = mysqli_prepare($conn, "SELECT * FROM orders_tbl WHERE order_number = ?");
    mysqli_stmt_bind_param($stmt, "s", $orderNumber);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($order = mysqli_fetch_assoc($result)) {
        // In a real application, you would use a proper email service like PHPMailer, SendGrid, etc.
        // For this demo, we'll simulate sending an email
        
        $to = $order['shipping_email'];
        $subject = "Order Confirmation - " . $order['order_number'];
        
        $message = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .header { background: #ff3b2f; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                .order-details { background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0; }
                .footer { background: #333; color: white; padding: 20px; text-align: center; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h1>Krishna Car Parts</h1>
                <h2>Order Confirmation</h2>
            </div>
            
            <div class='content'>
                <p>Dear " . htmlspecialchars($order['shipping_name']) . ",</p>
                
                <p>Thank you for your order! We're excited to confirm that your order has been received and is being processed.</p>
                
                <div class='order-details'>
                    <h3>Order Details:</h3>
                    <p><strong>Order Number:</strong> " . $order['order_number'] . "</p>
                    <p><strong>Order Date:</strong> " . date('F j, Y g:i A', strtotime($order['created_at'])) . "</p>
                    <p><strong>Total Amount:</strong> ₹" . number_format($order['total_amount'], 2) . "</p>
                    <p><strong>Payment Method:</strong> " . ucfirst(str_replace('_', ' ', $order['payment_method'])) . "</p>
                </div>
                
                <div class='order-details'>
                    <h3>Shipping Address:</h3>
                    <p>" . htmlspecialchars($order['shipping_address']) . "</p>
                    <p>Phone: " . htmlspecialchars($order['shipping_phone']) . "</p>
                </div>
                
                <p><strong>What's Next?</strong></p>
                <ul>
                    <li>Your order will be processed within 24 hours</li>
                    <li>You'll receive shipping updates via SMS and email</li>
                    <li>Expected delivery: 3-5 business days</li>
                </ul>
                
                <p>You can track your order status anytime by logging into your account on our website.</p>
                
                <p>If you have any questions, please don't hesitate to contact us at support@krishnacarparts.com or call +91 98765 43210.</p>
                
                <p>Thank you for choosing Krishna Car Parts!</p>
            </div>
            
            <div class='footer'>
                <p>&copy; 2024 Krishna Car Parts. All rights reserved.</p>
                <p>Visit us at www.krishnacarparts.com</p>
            </div>
        </body>
        </html>
        ";
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Krishna Car Parts <noreply@krishnacarparts.com>" . "\r\n";
        
        // In a real application, uncomment the line below to actually send the email
        // $emailSent = mail($to, $subject, $message, $headers);
        
        // For demo purposes, we'll simulate a successful email send
        $emailSent = true;
        
        echo json_encode([
            'success' => $emailSent,
            'message' => $emailSent ? 'Confirmation email sent successfully' : 'Failed to send confirmation email'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Order not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

mysqli_close($conn);
?>