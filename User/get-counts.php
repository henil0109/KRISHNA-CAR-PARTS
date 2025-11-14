<?php
session_start();
header('Content-Type: application/json');

$response = ['success' => false, 'cart_count' => 0, 'wishlist_count' => 0];

if (isset($_SESSION['user_id'])) {
    // Cart count from session
    $cart_count = 0;
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $cart_count += $item['quantity'];
        }
    }
    
    // Wishlist count from database
    include '../Admin/connection.php';
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) as count FROM wishlist_tbl WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $wishlist_count = mysqli_fetch_assoc($result)['count'];
    
    $response = [
        'success' => true,
        'cart_count' => $cart_count,
        'wishlist_count' => $wishlist_count
    ];
}

echo json_encode($response);
?>