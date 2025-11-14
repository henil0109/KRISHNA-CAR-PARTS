<?php
include 'session.php';
include 'connection.php';

$userId = intval($_GET['id'] ?? 0);

// Get user details
$stmt = mysqli_prepare($conn, "SELECT * FROM users_tbl WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$user) {
    header('Location: viewuser.php');
    exit;
}

// Get user orders
$stmt = mysqli_prepare($conn, "SELECT * FROM orders_tbl WHERE user_id = ? ORDER BY order_id DESC");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$orders = mysqli_stmt_get_result($stmt);

// Get user statistics
$stmt = mysqli_prepare($conn, "SELECT COUNT(*) as order_count, COALESCE(SUM(total_amount), 0) as total_spent FROM orders_tbl WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$userStats = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
?>
<!doctype html>
<html lang="en" class="semi-dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../assets/images/kcp.png" type="image/png" />
    <!--plugins-->
    <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="../assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="../assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="../assets/css/pace.min.css" rel="stylesheet" />
    <script src="../assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="../assets/css/app.css" rel="stylesheet">
    <link href="../assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="../assets/css/dark-theme.css" />
    <link rel="stylesheet" href="../assets/css/semi-dark.css" />
    <link rel="stylesheet" href="../assets/css/header-colors.css" />
    <title>KRISHNA CAR PARTS</title>
</head>
<body>
    <div class="wrapper">
        <!--sidebar wrapper -->
        <?php include 'sidebar.php' ?>
        <!--end sidebar wrapper -->
        <!--start header -->
        <?php include 'header.php' ?>
        <!--end header -->
        
        <div class="page-wrapper">
            <div class="page-content">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">User Details</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="index.php"><i class="bx bx-home-alt"></i></a></li>
                                <li class="breadcrumb-item"><a href="viewuser.php">Users</a></li>
                                <li class="breadcrumb-item active"><?php echo htmlspecialchars($user['name']); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>User Information</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                                <p><strong>Status:</strong> 
                                    <span class="badge bg-<?php echo ($user['status'] ?? 'active') === 'active' ? 'success' : 'danger'; ?>">
                                        <?php echo ucfirst($user['status'] ?? 'active'); ?>
                                    </span>
                                </p>
                                <p><strong>Joined:</strong> <?php echo isset($user['created_at']) ? date('M d, Y', strtotime($user['created_at'])) : 'N/A'; ?></p>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-header">
                                <h5>Statistics</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Total Orders:</strong> <?php echo $userStats['order_count']; ?></p>
                                <p><strong>Total Spent:</strong> ₹<?php echo number_format($userStats['total_spent'], 2); ?></p>
                                <p><strong>Average Order:</strong> ₹<?php echo $userStats['order_count'] > 0 ? number_format($userStats['total_spent'] / $userStats['order_count'], 2) : '0.00'; ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5>Order History</h5>
                            </div>
                            <div class="card-body">
                                <?php if (mysqli_num_rows($orders) > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Amount</th>
                                                <th>Payment</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                                            <tr>
                                                <td><?php echo $order['order_number']; ?></td>
                                                <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
                                                <td><?php echo ucfirst($order['payment_method']); ?></td>
                                                <td><span class="badge bg-primary"><?php echo ucfirst($order['order_status']); ?></span></td>
                                                <td><?php echo isset($order['created_at']) ? date('M d, Y', strtotime($order['created_at'])) : 'N/A'; ?></td>
                                                <td><a href="order_details.php?id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-primary">View</a></td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php else: ?>
                                <p class="text-muted">No orders found for this user.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <?php include 'footer.php' ?>
    </div>
    <!--end wrapper-->
    
    <!-- Bootstrap JS -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="../assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <!--app JS-->
    <script src="../assets/js/app.js"></script>
</body>
</html>