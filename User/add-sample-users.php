<?php
include '../Admin/connection.php';

// Sample users data
$users = [
    ['John Smith', 'john.smith@email.com', '+1234567890', 'Password123'],
    ['Sarah Johnson', 'sarah.johnson@email.com', '+1234567891', 'SecurePass1'],
    ['Mike Wilson', 'mike.wilson@email.com', '+1234567892', 'MyPassword2'],
    ['Emma Davis', 'emma.davis@email.com', '+1234567893', 'StrongPass3'],
    ['David Brown', 'david.brown@email.com', '+1234567894', 'UserPass456']
];

echo "<h3>Adding Sample Users...</h3>";

foreach ($users as $user) {
    $name = $user[0];
    $email = $user[1];
    $phone = $user[2];
    $password = $user[3];
    
    // Check if user already exists
    $checkStmt = mysqli_prepare($conn, "SELECT user_id FROM users_tbl WHERE email = ?");
    mysqli_stmt_bind_param($checkStmt, "s", $email);
    mysqli_stmt_execute($checkStmt);
    $result = mysqli_stmt_get_result($checkStmt);
    
    if (mysqli_num_rows($result) == 0) {
        // Insert user
        $stmt = mysqli_prepare($conn, "INSERT INTO users_tbl (name, email, phone, password) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $password);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<p>✅ Added: $name ($email)</p>";
        } else {
            echo "<p>❌ Failed to add: $name</p>";
        }
    } else {
        echo "<p>⚠️ Already exists: $name ($email)</p>";
    }
}

echo "<h4>Sample Users Added Successfully!</h4>";
echo "<p><strong>Login Credentials:</strong></p>";
echo "<ul>";
echo "<li>john.smith@email.com / Password123</li>";
echo "<li>sarah.johnson@email.com / SecurePass1</li>";
echo "<li>mike.wilson@email.com / MyPassword2</li>";
echo "<li>emma.davis@email.com / StrongPass3</li>";
echo "<li>david.brown@email.com / UserPass456</li>";
echo "</ul>";

mysqli_close($conn);
?>