<?php
session_start();
include '../Admin/connection.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to add items to cart']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $productId = intval($_POST['product_id'] ?? 0);
    
    if ($productId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
        exit;
    }
    
    // Initialize cart session if not exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    switch ($action) {
        case 'add':
            $quantity = intval($_POST['quantity'] ?? 1);
            
            // Check if product exists and has stock
            $stmt = mysqli_prepare($conn, "SELECT part_name, price, stock FROM products_tbl WHERE product_id = ?");
            mysqli_stmt_bind_param($stmt, "i", $productId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if ($product = mysqli_fetch_assoc($result)) {
                if ($product['stock'] >= $quantity) {
                    // Add to cart or increase quantity
                    if (isset($_SESSION['cart'][$productId])) {
                        $_SESSION['cart'][$productId]['quantity'] += $quantity;
                    } else {
                        $_SESSION['cart'][$productId] = [
                            'name' => $product['part_name'],
                            'price' => $product['price'],
                            'quantity' => $quantity
                        ];
                    }
                    
                    echo json_encode([
                        'success' => true, 
                        'message' => 'Product added to cart',
                        'cart_count' => array_sum(array_column($_SESSION['cart'], 'quantity'))
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Insufficient stock']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Product not found']);
            }
            break;
            
        case 'remove':
            if (isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);
                echo json_encode([
                    'success' => true, 
                    'message' => 'Product removed from cart',
                    'cart_count' => array_sum(array_column($_SESSION['cart'], 'quantity'))
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Product not in cart']);
            }
            break;
            
        case 'update':
            $quantity = intval($_POST['quantity'] ?? 1);
            if (isset($_SESSION['cart'][$productId]) && $quantity > 0) {
                $_SESSION['cart'][$productId]['quantity'] = $quantity;
                echo json_encode([
                    'success' => true, 
                    'message' => 'Cart updated',
                    'cart_count' => array_sum(array_column($_SESSION['cart'], 'quantity'))
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid quantity or product not in cart']);
            }
            break;
            
        case 'get_count':
            echo json_encode([
                'success' => true,
                'cart_count' => array_sum(array_column($_SESSION['cart'], 'quantity'))
            ]);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

mysqli_close($conn);
?>