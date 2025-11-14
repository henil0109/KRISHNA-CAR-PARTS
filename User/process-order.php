<?php
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

include '../Admin/connection.php';

// Check if orders table exists, if not create it
$checkTable = mysqli_query($conn, "SHOW TABLES LIKE 'orders_tbl'");
if (mysqli_num_rows($checkTable) == 0) {
    $createOrdersTable = "CREATE TABLE orders_tbl (
        order_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        order_number VARCHAR(20) UNIQUE NOT NULL,
        total_amount DECIMAL(10,2) NOT NULL,
        shipping_name VARCHAR(255) NOT NULL,
        shipping_phone VARCHAR(20) NOT NULL,
        shipping_email VARCHAR(255) NOT NULL,
        shipping_address TEXT NOT NULL,
        payment_method VARCHAR(50) NOT NULL,
        payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
        order_status ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    mysqli_query($conn, $createOrdersTable);
} else {
    // Add missing columns
    $columns = ['order_number', 'shipping_name', 'shipping_phone', 'shipping_email', 'shipping_address', 'payment_method', 'payment_status', 'order_status'];
    foreach ($columns as $column) {
        $checkColumn = mysqli_query($conn, "SHOW COLUMNS FROM orders_tbl LIKE '$column'");
        if (mysqli_num_rows($checkColumn) == 0) {
            switch ($column) {
                case 'order_number':
                    mysqli_query($conn, "ALTER TABLE orders_tbl ADD COLUMN order_number VARCHAR(20) UNIQUE");
                    break;
                case 'shipping_name':
                case 'shipping_phone':
                case 'shipping_email':
                    mysqli_query($conn, "ALTER TABLE orders_tbl ADD COLUMN $column VARCHAR(255)");
                    break;
                case 'shipping_address':
                    mysqli_query($conn, "ALTER TABLE orders_tbl ADD COLUMN shipping_address TEXT");
                    break;
                case 'payment_method':
                    mysqli_query($conn, "ALTER TABLE orders_tbl ADD COLUMN payment_method VARCHAR(50)");
                    break;
                case 'payment_status':
                    mysqli_query($conn, "ALTER TABLE orders_tbl ADD COLUMN payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending'");
                    break;
                case 'order_status':
                    mysqli_query($conn, "ALTER TABLE orders_tbl ADD COLUMN order_status ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending'");
                    break;
            }
        }
    }
    // Add created_at column if missing
    $checkCreatedAt = mysqli_query($conn, "SHOW COLUMNS FROM orders_tbl LIKE 'created_at'");
    if (mysqli_num_rows($checkCreatedAt) == 0) {
        mysqli_query($conn, "ALTER TABLE orders_tbl ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
    }
}

// Check if order items table exists, if not create it
$checkItemsTable = mysqli_query($conn, "SHOW TABLES LIKE 'order_items_tbl'");
if (mysqli_num_rows($checkItemsTable) == 0) {
    $createOrderItemsTable = "CREATE TABLE order_items_tbl (
        item_id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        price DECIMAL(10,2) NOT NULL
    )";
    mysqli_query($conn, $createOrderItemsTable);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Generate order number
    $orderNumber = 'KCP' . date('Y') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    
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
    
    // Prepare shipping address
    $shippingAddress = $_POST['shipping_address1'];
    if (!empty($_POST['shipping_address2'])) {
        $shippingAddress .= ', ' . $_POST['shipping_address2'];
    }
    $shippingAddress .= ', ' . $_POST['shipping_city'] . ', ' . $_POST['shipping_state'] . ' - ' . $_POST['shipping_pincode'];
    
    // Insert order
    $stmt = mysqli_prepare($conn, "INSERT INTO orders_tbl (user_id, order_number, total_amount, shipping_name, shipping_phone, shipping_email, shipping_address, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isdsssss", 
        $_SESSION['user_id'], 
        $orderNumber, 
        $total, 
        $_POST['shipping_name'], 
        $_POST['shipping_phone'], 
        $_POST['shipping_email'], 
        $shippingAddress, 
        $_POST['payment_method']
    );
    
    if (mysqli_stmt_execute($stmt)) {
        $orderId = mysqli_insert_id($conn);
        
        // Insert order items
        foreach ($_SESSION['cart'] as $productId => $item) {
            $stmt = mysqli_prepare($conn, "SELECT price FROM products_tbl WHERE product_id = ?");
            mysqli_stmt_bind_param($stmt, "i", $productId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if ($product = mysqli_fetch_assoc($result)) {
                $itemStmt = mysqli_prepare($conn, "INSERT INTO order_items_tbl (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                mysqli_stmt_bind_param($itemStmt, "iiid", $orderId, $productId, $item['quantity'], $product['price']);
                mysqli_stmt_execute($itemStmt);
                
                // Update stock
                $updateStock = mysqli_prepare($conn, "UPDATE products_tbl SET stock = stock - ? WHERE product_id = ?");
                mysqli_stmt_bind_param($updateStock, "ii", $item['quantity'], $productId);
                mysqli_stmt_execute($updateStock);
            }
        }
        
        // Clear cart
        unset($_SESSION['cart']);
        
        // Redirect to confirmation
        header("Location: order-confirmation.php?order=" . $orderNumber);
        exit;
    } else {
        header("Location: checkout.php?error=Order processing failed");
        exit;
    }
} else {
    header("Location: checkout.php");
    exit;
}

mysqli_close($conn);
?>