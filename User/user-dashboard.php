<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include '../Admin/connection.php';

// Get user data
$stmt = mysqli_prepare($conn, "SELECT * FROM users_tbl WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Krishna Car Parts</title>
    <link rel="icon" href="../assets/images/kcp.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #0b0d10 0%, #111317 50%, #1b1f27 100%);
            color: #f6f7fb;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        
        .dashboard-container {
            padding: 2rem 0;
        }
        
        .dashboard-card {
            background: linear-gradient(145deg, rgba(17, 19, 23, 0.95), rgba(27, 31, 39, 0.95));
            border: 1px solid rgba(0, 255, 229, 0.2);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            margin-bottom: 2rem;
        }
        
        .user-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .user-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #ff3b2f, #00ffe5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        
        .user-avatar i {
            font-size: 4rem;
            color: white;
        }
        
        .dashboard-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .option-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #f6f7fb;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .option-card:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #00ffe5;
            transform: translateY(-5px);
            color: #00ffe5;
        }
        
        .option-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #ff3b2f, #00ffe5);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .option-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .option-desc {
            font-size: 0.9rem;
            color: rgba(246, 247, 251, 0.7);
        }
        
        .logout-btn {
            background: linear-gradient(135deg, #ff3b2f, #e74c3c);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: linear-gradient(135deg, #e74c3c, #ff3b2f);
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'header1.php'; ?>
    
    <div class="dashboard-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="dashboard-card">
                        <div class="user-header">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
                            <p class="text-muted">Manage your account and preferences</p>
                        </div>
                        
                        <div class="dashboard-options">
                            <a href="profile.php" class="option-card">
                                <div class="option-icon">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <div class="option-title">Profile Settings</div>
                                <div class="option-desc">Update your personal information</div>
                            </a>
                            
                            <a href="change-password.php" class="option-card">
                                <div class="option-icon">
                                    <i class="fas fa-key"></i>
                                </div>
                                <div class="option-title">Change Password</div>
                                <div class="option-desc">Update your account password</div>
                            </a>
                            
                            <a href="cart.php" class="option-card">
                                <div class="option-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="option-title">My Cart</div>
                                <div class="option-desc">View items in your cart</div>
                            </a>
                            
                            <a href="wishlist.php" class="option-card">
                                <div class="option-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="option-title">Wishlist</div>
                                <div class="option-desc">View your saved items</div>
                            </a>
                            
                            <a href="order-history.php" class="option-card">
                                <div class="option-icon">
                                    <i class="fas fa-history"></i>
                                </div>
                                <div class="option-title">Order History</div>
                                <div class="option-desc">View your past orders</div>
                            </a>
                            
                            <a href="payment-methods.php" class="option-card">
                                <div class="option-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="option-title">Payment Methods</div>
                                <div class="option-desc">Manage saved cards & payments</div>
                            </a>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="logout.php" class="logout-btn">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>