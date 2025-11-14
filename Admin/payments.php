<?php
include 'session.php';
include 'connection.php';

// Get payment data from orders
$sql = "SELECT o.order_id, o.order_number, o.total_amount, o.payment_method, o.payment_status, o.created_at, u.name as user_name, u.email as user_email 
        FROM orders_tbl o 
        LEFT JOIN users_tbl u ON o.user_id = u.user_id 
        ORDER BY o.order_id DESC";
$payments = mysqli_query($conn, $sql);

// Calculate totals
$totalSql = "SELECT 
    COUNT(*) as total_orders,
    SUM(total_amount) as total_revenue,
    SUM(CASE WHEN payment_status = 'paid' THEN total_amount ELSE 0 END) as paid_amount,
    SUM(CASE WHEN payment_status = 'pending' THEN total_amount ELSE 0 END) as pending_amount
    FROM orders_tbl";
$totals = mysqli_fetch_assoc(mysqli_query($conn, $totalSql));
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
                    <div class="breadcrumb-title pe-3">Payments</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="index.php"><i class="bx bx-home-alt"></i></a></li>
                                <li class="breadcrumb-item active">Payments</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                
                <!-- Payment Summary Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-gradient-primary text-white">
                            <div class="card-body">
                                <h6>Total Orders</h6>
                                <h4><?php echo $totals['total_orders']; ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-gradient-success text-white">
                            <div class="card-body">
                                <h6>Total Revenue</h6>
                                <h4>₹<?php echo number_format($totals['total_revenue'], 2); ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-gradient-info text-white">
                            <div class="card-body">
                                <h6>Paid Amount</h6>
                                <h4>₹<?php echo number_format($totals['paid_amount'], 2); ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-gradient-warning text-white">
                            <div class="card-body">
                                <h6>Pending Amount</h6>
                                <h4>₹<?php echo number_format($totals['pending_amount'], 2); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($payment = mysqli_fetch_assoc($payments)): ?>
                                    <tr>
                                        <td><?php echo $payment['order_number']; ?></td>
                                        <td>
                                            <?php echo htmlspecialchars($payment['user_name'] ?? 'N/A'); ?><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($payment['user_email'] ?? ''); ?></small>
                                        </td>
                                        <td>₹<?php echo number_format($payment['total_amount'], 2); ?></td>
                                        <td><?php echo ucfirst($payment['payment_method']); ?></td>
                                        <td>
                                            <?php
                                            $statusClass = $payment['payment_status'] === 'paid' ? 'success' : ($payment['payment_status'] === 'failed' ? 'danger' : 'warning');
                                            ?>
                                            <span class="badge bg-<?php echo $statusClass; ?>"><?php echo ucfirst($payment['payment_status']); ?></span>
                                        </td>
                                        <td><?php echo isset($payment['created_at']) ? date('M d, Y', strtotime($payment['created_at'])) : 'N/A'; ?></td>
                                        <td>
                                            <a href="order_details.php?id=<?php echo $payment['order_id']; ?>" class="btn btn-sm btn-primary">View Order</a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
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