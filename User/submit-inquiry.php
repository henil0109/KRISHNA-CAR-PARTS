<?php
include '../Admin/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id'] ?? 0);
    $customerName = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $customerEmail = mysqli_real_escape_string($conn, $_POST['customer_email']);
    $customerPhone = mysqli_real_escape_string($conn, $_POST['customer_phone']);
    $inquiryType = mysqli_real_escape_string($conn, $_POST['inquiry_type']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $inquiryDate = date('Y-m-d H:i:s');
    
    // Create inquiries table if it doesn't exist
    $createTable = "CREATE TABLE IF NOT EXISTS inquiries_tbl (
        inquiry_id INT AUTO_INCREMENT PRIMARY KEY,
        product_id INT,
        customer_name VARCHAR(255) NOT NULL,
        customer_email VARCHAR(255) NOT NULL,
        customer_phone VARCHAR(20) NOT NULL,
        inquiry_type VARCHAR(50) NOT NULL,
        message TEXT NOT NULL,
        inquiry_date DATETIME NOT NULL,
        status ENUM('pending', 'replied', 'closed') DEFAULT 'pending',
        FOREIGN KEY (product_id) REFERENCES products_tbl(product_id)
    )";
    
    mysqli_query($conn, $createTable);
    
    // Insert inquiry
    $sql = "INSERT INTO inquiries_tbl (product_id, customer_name, customer_email, customer_phone, inquiry_type, message, inquiry_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issssss", $productId, $customerName, $customerEmail, $customerPhone, $inquiryType, $message, $inquiryDate);
    
    if (mysqli_stmt_execute($stmt)) {
        $inquiryId = mysqli_insert_id($conn);
        
        // Redirect with success message
        header("Location: inquiry-success.php?id=" . $inquiryId);
        exit;
    } else {
        // Redirect with error
        header("Location: inquiry.php?error=1" . ($productId ? "&product_id=" . $productId : ""));
        exit;
    }
} else {
    header("Location: browse.php");
    exit;
}

mysqli_close($conn);
?>