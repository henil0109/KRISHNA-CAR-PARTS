<?php
session_start();
include '../Admin/connection.php';

// Create users table if it doesn't exist
$createTable = "CREATE TABLE IF NOT EXISTS users_tbl (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password VARCHAR(255),
    google_id VARCHAR(255),
    profile_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysqli_query($conn, $createTable);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    
    if ($action === 'signup') {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        
        // Validation
        if ($password !== $confirmPassword) {
            header("Location: signup.php?error=Passwords do not match");
            exit;
        }
        
        if (strlen($password) < 6) {
            header("Location: signup.php?error=Password must be at least 6 characters");
            exit;
        }
        
        // Check if email already exists
        $checkEmail = mysqli_prepare($conn, "SELECT user_id FROM users_tbl WHERE email = ?");
        mysqli_stmt_bind_param($checkEmail, "s", $email);
        mysqli_stmt_execute($checkEmail);
        $result = mysqli_stmt_get_result($checkEmail);
        
        if (mysqli_num_rows($result) > 0) {
            header("Location: signup.php?error=Email already exists");
            exit;
        }
        
        // Insert user
        $stmt = mysqli_prepare($conn, "INSERT INTO users_tbl (name, email, phone, password) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $password);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: login.php?success=1");
            exit;
        } else {
            header("Location: signup.php?error=Registration failed. Please try again.");
            exit;
        }
        
    } elseif ($action === 'change_password') {
        $userId = $_SESSION['user_id'];
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_new_password'];
        
        // Validation
        if ($newPassword !== $confirmPassword) {
            header("Location: change-password.php?error=New passwords do not match");
            exit;
        }
        
        if (strlen($newPassword) < 8 || !preg_match('/[A-Z]/', $newPassword) || !preg_match('/[a-z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword)) {
            header("Location: change-password.php?error=Password must meet all requirements");
            exit;
        }
        
        // Verify current password
        $stmt = mysqli_prepare($conn, "SELECT password FROM users_tbl WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($user = mysqli_fetch_assoc($result)) {
            if ($currentPassword === $user['password']) {
                // Update password
                $updateStmt = mysqli_prepare($conn, "UPDATE users_tbl SET password = ? WHERE user_id = ?");
                mysqli_stmt_bind_param($updateStmt, "si", $newPassword, $userId);
                
                if (mysqli_stmt_execute($updateStmt)) {
                    header("Location: change-password.php?success=1");
                    exit;
                } else {
                    header("Location: change-password.php?error=Failed to update password");
                    exit;
                }
            } else {
                header("Location: change-password.php?error=Current password is incorrect");
                exit;
            }
        } else {
            header("Location: change-password.php?error=User not found");
            exit;
        }
        
    } elseif ($action === 'login') {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];
        
        // Get user
        $stmt = mysqli_prepare($conn, "SELECT user_id, name, email, password FROM users_tbl WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($user = mysqli_fetch_assoc($result)) {
            if ($password === $user['password']) {
                // Set session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                
                header("Location: index.php");
                exit;
            } else {
                header("Location: login.php?error=1");
                exit;
            }
        } else {
            header("Location: login.php?error=1");
            exit;
        }
    }
}

mysqli_close($conn);
?>