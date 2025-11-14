<?php
session_start();
include '../Admin/connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to manage wishlist']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $productId = intval($_POST['product_id'] ?? 0);
    
    if ($productId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
        exit;
    }
    
    // Create wishlist table if not exists
    $createTable = "CREATE TABLE IF NOT EXISTS wishlist_tbl (
        wishlist_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_wishlist (user_id, product_id)
    )";
    mysqli_query($conn, $createTable);
    
    switch ($action) {
        case 'add':
            $stmt = mysqli_prepare($conn, "INSERT IGNORE INTO wishlist_tbl (user_id, product_id) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "ii", $_SESSION['user_id'], $productId);
            
            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_affected_rows($conn) > 0) {
                    $message = 'Added to wishlist';
                } else {
                    $message = 'Already in wishlist';
                }
                
                // Get wishlist count
                $countStmt = mysqli_prepare($conn, "SELECT COUNT(*) as count FROM wishlist_tbl WHERE user_id = ?");
                mysqli_stmt_bind_param($countStmt, "i", $_SESSION['user_id']);
                mysqli_stmt_execute($countStmt);
                $countResult = mysqli_stmt_get_result($countStmt);
                $wishlistCount = mysqli_fetch_assoc($countResult)['count'];
                
                echo json_encode(['success' => true, 'message' => $message, 'wishlist_count' => $wishlistCount]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add to wishlist']);
            }
            break;
            
        case 'remove':
            $stmt = mysqli_prepare($conn, "DELETE FROM wishlist_tbl WHERE user_id = ? AND product_id = ?");
            mysqli_stmt_bind_param($stmt, "ii", $_SESSION['user_id'], $productId);
            
            if (mysqli_stmt_execute($stmt)) {
                // Get wishlist count
                $countStmt = mysqli_prepare($conn, "SELECT COUNT(*) as count FROM wishlist_tbl WHERE user_id = ?");
                mysqli_stmt_bind_param($countStmt, "i", $_SESSION['user_id']);
                mysqli_stmt_execute($countStmt);
                $countResult = mysqli_stmt_get_result($countStmt);
                $wishlistCount = mysqli_fetch_assoc($countResult)['count'];
                
                echo json_encode(['success' => true, 'message' => 'Removed from wishlist', 'wishlist_count' => $wishlistCount]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove from wishlist']);
            }
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

mysqli_close($conn);
?>