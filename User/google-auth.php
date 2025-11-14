<?php
session_start();
include '../Admin/connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $credential = $input['credential'];
    
    // Decode JWT token (simplified - in production use a proper JWT library)
    $parts = explode('.', $credential);
    $payload = json_decode(base64_decode($parts[1]), true);
    
    $googleId = $payload['sub'];
    $email = $payload['email'];
    $name = $payload['name'];
    $picture = $payload['picture'] ?? '';
    
    // Check if user exists
    $stmt = mysqli_prepare($conn, "SELECT user_id, name, email FROM users_tbl WHERE email = ? OR google_id = ?");
    mysqli_stmt_bind_param($stmt, "ss", $email, $googleId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($user = mysqli_fetch_assoc($result)) {
        // User exists, update Google ID if not set
        if (empty($user['google_id'])) {
            $updateStmt = mysqli_prepare($conn, "UPDATE users_tbl SET google_id = ?, profile_image = ? WHERE user_id = ?");
            mysqli_stmt_bind_param($updateStmt, "ssi", $googleId, $picture, $user['user_id']);
            mysqli_stmt_execute($updateStmt);
        }
        
        // Set session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        
        echo json_encode(['success' => true]);
    } else {
        // Create new user
        $stmt = mysqli_prepare($conn, "INSERT INTO users_tbl (name, email, google_id, profile_image) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $googleId, $picture);
        
        if (mysqli_stmt_execute($stmt)) {
            $userId = mysqli_insert_id($conn);
            
            // Set session
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to create user']);
        }
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

mysqli_close($conn);
?>