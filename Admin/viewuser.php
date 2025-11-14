<?php
include 'session.php';
include 'connection.php';

// Handle user actions
if ($_POST['action'] ?? '' === 'toggle_status') {
    $userId = intval($_POST['user_id']);
    $status = $_POST['status'] === 'active' ? 'inactive' : 'active';
    
    $stmt = mysqli_prepare($conn, "UPDATE users_tbl SET status = ? WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "si", $status, $userId);
    mysqli_stmt_execute($stmt);
    
    header('Location: viewuser.php?updated=1');
    exit;
}

// Get users with order count
$sql = "SELECT u.*, COUNT(o.order_id) as order_count, COALESCE(SUM(o.total_amount), 0) as total_spent
        FROM users_tbl u 
        LEFT JOIN orders_tbl o ON u.user_id = o.user_id 
        GROUP BY u.user_id 
        ORDER BY u.user_id DESC";
$users = mysqli_query($conn, $sql);

// Get user statistics
$statsSql = "SELECT 
    COUNT(*) as total_users,
    COUNT(CASE WHEN status = 'active' THEN 1 END) as active_users,
    COUNT(CASE WHEN status = 'inactive' THEN 1 END) as inactive_users
    FROM users_tbl";
$stats = mysqli_fetch_assoc(mysqli_query($conn, $statsSql));
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
                    <div class="breadcrumb-title pe-3">Users</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="index.php"><i class="bx bx-home-alt"></i></a></li>
                                <li class="breadcrumb-item active">User Management</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                
                <?php if (isset($_GET['updated'])): ?>
                <div class="alert alert-success">User status updated successfully!</div>
                <?php endif; ?>
                
                <!-- User Statistics -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-gradient-primary text-white">
                            <div class="card-body">
                                <h6>Total Users</h6>
                                <h4><?php echo $stats['total_users']; ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-gradient-success text-white">
                            <div class="card-body">
                                <h6>Active Users</h6>
                                <h4><?php echo $stats['active_users']; ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-gradient-warning text-white">
                            <div class="card-body">
                                <h6>Inactive Users</h6>
                                <h4><?php echo $stats['inactive_users']; ?></h4>
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
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Orders</th>
                                        <th>Total Spent</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($user = mysqli_fetch_assoc($users)): ?>
                                    <tr>
                                        <td><?php echo $user['user_id']; ?></td>
                                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                        <td><?php echo $user['order_count']; ?></td>
                                        <td>₹<?php echo number_format($user['total_spent'], 2); ?></td>
                                        <td>
                                            <?php
                                            $statusClass = ($user['status'] ?? 'active') === 'active' ? 'success' : 'danger';
                                            ?>
                                            <span class="badge bg-<?php echo $statusClass; ?>"><?php echo ucfirst($user['status'] ?? 'active'); ?></span>
                                        </td>
                                        <td>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="action" value="toggle_status">
                                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                                <input type="hidden" name="status" value="<?php echo $user['status'] ?? 'active'; ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                    <?php echo ($user['status'] ?? 'active') === 'active' ? 'Deactivate' : 'Activate'; ?>
                                                </button>
                                            </form>
                                            <a href="user_details.php?id=<?php echo $user['user_id']; ?>" class="btn btn-sm btn-primary">View</a>
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