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
$itemsStmt = mysqli_prepare($conn, "SELECT oi.*, p.part_name FROM order_items_tbl oi JOIN products_tbl p ON oi.product_id = p.product_id WHERE oi.order_id = ?");
mysqli_stmt_bind_param($itemsStmt, "i", $order['order_id']);
mysqli_stmt_execute($itemsStmt);
$itemsResult = mysqli_stmt_get_result($itemsStmt);
$orderItems = [];
$subtotal = 0;
while ($item = mysqli_fetch_assoc($itemsResult)) {
    $item['total'] = $item['price'] * $item['quantity'];
    $subtotal += $item['total'];
    $orderItems[] = $item;
}

$shipping = 50;
$tax = $subtotal * 0.18;
$total = $subtotal + $shipping + $tax;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - <?php echo $order['order_number']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: white;
            color: #333;
            font-family: 'Arial', sans-serif;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .invoice-header {
            border-bottom: 3px solid #ff3b2f;
            padding-bottom: 2rem;
            margin-bottom: 2rem;
        }
        
        .company-logo {
            font-size: 2rem;
            font-weight: bold;
            color: #ff3b2f;
        }
        
        .invoice-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
        }
        
        .invoice-details {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        
        .table th {
            background: #ff3b2f;
            color: white;
            border: none;
        }
        
        .table td {
            border-color: #dee2e6;
        }
        
        .total-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid #ff3b2f;
        }
        
        .footer-note {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #666;
        }
        
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .invoice-container { box-shadow: none; margin: 0; }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Print Button -->
        <div class="text-end mb-3 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Print Invoice
            </button>
        </div>
        
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="row">
                <div class="col-md-6">
                    <div class="company-logo">Krishna Car Parts</div>
                    <p class="mb-1">Premium Auto Parts & Accessories</p>
                    <p class="mb-1">123 Auto Street, Car City</p>
                    <p class="mb-1">Phone: +91 98765 43210</p>
                    <p class="mb-0">Email: info@krishnacarparts.com</p>
                </div>
                <div class="col-md-6 text-end">
                    <div class="invoice-title">INVOICE</div>
                    <p class="mb-1"><strong>Invoice #:</strong> <?php echo $order['order_number']; ?></p>
                    <p class="mb-1"><strong>Date:</strong> <?php echo date('F j, Y', strtotime($order['created_at'])); ?></p>
                    <p class="mb-0"><strong>Status:</strong> <span class="badge bg-success">Confirmed</span></p>
                </div>
            </div>
        </div>
        
        <!-- Customer Details -->
        <div class="invoice-details">
            <div class="row">
                <div class="col-md-6">
                    <h5>Bill To:</h5>
                    <p class="mb-1"><strong><?php echo htmlspecialchars($order['shipping_name']); ?></strong></p>
                    <p class="mb-1"><?php echo htmlspecialchars($order['shipping_email']); ?></p>
                    <p class="mb-1"><?php echo htmlspecialchars($order['shipping_phone']); ?></p>
                    <p class="mb-0"><?php echo htmlspecialchars($order['shipping_address']); ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Payment Details:</h5>
                    <p class="mb-1"><strong>Method:</strong> <?php echo ucfirst(str_replace('_', ' ', $order['payment_method'])); ?></p>
                    <p class="mb-1"><strong>Status:</strong> <?php echo ucfirst($order['payment_status']); ?></p>
                    <p class="mb-0"><strong>Order Status:</strong> <?php echo ucfirst($order['order_status']); ?></p>
                </div>
            </div>
        </div>
        
        <!-- Order Items -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-end">Unit Price</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderItems as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['part_name']); ?></td>
                        <td class="text-center"><?php echo $item['quantity']; ?></td>
                        <td class="text-end">₹<?php echo number_format($item['price'], 2); ?></td>
                        <td class="text-end">₹<?php echo number_format($item['total'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Totals -->
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="total-section">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>₹<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span>₹<?php echo number_format($shipping, 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax (18% GST):</span>
                        <span>₹<?php echo number_format($tax, 2); ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total Amount:</strong>
                        <strong>₹<?php echo number_format($total, 2); ?></strong>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer-note">
            <p><strong>Thank you for your business!</strong></p>
            <p>For any queries regarding this invoice, please contact us at support@krishnacarparts.com</p>
            <p class="small">This is a computer-generated invoice and does not require a signature.</p>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>