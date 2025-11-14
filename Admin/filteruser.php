<?php
include 'session.php';
include 'connection.php';

$selectedProduct = $_GET['product_id'] ?? '';
$users = [];

if ($selectedProduct) {
    // Get users who ordered this product
    $stmt = mysqli_prepare($conn, "
        SELECT DISTINCT u.*, COUNT(o.order_id) as order_count, SUM(o.total_amount) as total_spent
        FROM users_tbl u 
        JOIN orders_tbl o ON u.user_id = o.user_id 
        JOIN order_items_tbl oi ON o.order_id = oi.order_id 
        WHERE oi.product_id = ? 
        GROUP BY u.user_id 
        ORDER BY u.name
    ");
    mysqli_stmt_bind_param($stmt, "i", $selectedProduct);
    mysqli_stmt_execute($stmt);
    $users = mysqli_stmt_get_result($stmt);
}

// Get all products for dropdown (distinct names)
$products = mysqli_query($conn, "SELECT DISTINCT part_name, MIN(product_id) as product_id FROM products_tbl GROUP BY part_name ORDER BY part_name");
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
                    <div class="breadcrumb-title pe-3">Filter Users</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="index.php"><i class="bx bx-home-alt"></i></a></li>
                                <li class="breadcrumb-item active">Filter Users by Product</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h5>Filter Users by Product Purchase</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <select name="product_id" class="form-select" required>
                                        <option value="">Select a product...</option>
                                        <?php while ($product = mysqli_fetch_assoc($products)): ?>
                                        <option value="<?php echo $product['product_id']; ?>" <?php echo $selectedProduct == $product['product_id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($product['part_name']); ?>
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Filter Users</button>
                                </div>
                            </div>
                        </form>
                        
                        <?php if ($selectedProduct && mysqli_num_rows($users) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Total Orders</th>
                                        <th>Total Spent</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($user = mysqli_fetch_assoc($users)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                        <td><?php echo $user['order_count']; ?></td>
                                        <td>₹<?php echo number_format($user['total_spent'], 2); ?></td>
                                        <td>
                                            <a href="user_details.php?id=<?php echo $user['user_id']; ?>" class="btn btn-sm btn-primary">View Details</a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php elseif ($selectedProduct): ?>
                        <div class="alert alert-info">No users found who purchased this product.</div>
                        <?php endif; ?>
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