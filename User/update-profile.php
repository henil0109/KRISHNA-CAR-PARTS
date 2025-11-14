<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include '../Admin/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
    // Check if email already exists for another user
    $checkStmt = mysqli_prepare($conn, "SELECT user_id FROM users_tbl WHERE email = ? AND user_id != ?");
    mysqli_stmt_bind_param($checkStmt, "si", $email, $userId);
    mysqli_stmt_execute($checkStmt);
    $result = mysqli_stmt_get_result($checkStmt);
    
    if (mysqli_num_rows($result) > 0) {
        header("Location: profile.php?error=Email already exists");
        exit;
    }
    
    // Update user profile
    $stmt = mysqli_prepare($conn, "UPDATE users_tbl SET name = ?, email = ?, phone = ? WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $phone, $userId);
    
    if (mysqli_stmt_execute($stmt)) {
        // Update session data
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        
        header("Location: profile.php?success=1");
        exit;
    } else {
        header("Location: profile.php?error=Failed to update profile");
        exit;
    }
} else {
    header("Location: profile.php");
    exit;
}

mysqli_close($conn);
?>