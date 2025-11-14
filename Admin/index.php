<?php
include 'connection.php';
include 'session.php';
?>
<!doctype html>
<html lang="en" class="semi-dark">


<!-- Mirrored from codervent.com/HIREHUNT/demo/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Jan 2023 08:52:10 GMT -->

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="../assets/images/kcp.png" type="image/png" />
    <!--plugins-->
    <link href="../assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <title>Krishna Car Parts</title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <?php include 'sidebar.php'; ?>

        <!--end sidebar wrapper -->
        <!--start header -->
        <?php include 'header.php'; ?>
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <?php
                // Get real data from database
                $totalProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products_tbl"))['count'];
                $totalRevenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(total_amount), 0) as total FROM orders_tbl"))['total'];
                $totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users_tbl"))['count'];
                $totalOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders_tbl"))['count'];
                ?>
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                    <div class="col">
                        <div class="card radius-10 bg-gradient-deepblue">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 text-white"><?php echo $totalProducts; ?></h5>
                                    <div class="ms-auto">
                                        <i class='fas fa-cogs fs-3 text-white'></i>
                                    </div>
                                </div>
                                <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                    <div class="progress-bar bg-white" role="progressbar" style="width: 75%"></div>
                                </div>
                                <div class="d-flex align-items-center text-white">
                                    <p class="mb-0">Total Products</p>
                                    <p class="mb-0 ms-auto">Active</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card radius-10 bg-gradient-ohhappiness">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 text-white">₹<?php echo number_format($totalRevenue); ?></h5>
                                    <div class="ms-auto">
                                        <i class='fas fa-rupee-sign fs-3 text-white'></i>
                                    </div>
                                </div>
                                <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                    <div class="progress-bar bg-white" role="progressbar" style="width: 85%"></div>
                                </div>
                                <div class="d-flex align-items-center text-white">
                                    <p class="mb-0">Total Revenue</p>
                                    <p class="mb-0 ms-auto">Growing</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card radius-10 bg-gradient-ibiza">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 text-white"><?php echo $totalUsers; ?></h5>
                                    <div class="ms-auto">
                                        <i class='fas fa-users fs-3 text-white'></i>
                                    </div>
                                </div>
                                <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                    <div class="progress-bar bg-white" role="progressbar" style="width: 65%"></div>
                                </div>
                                <div class="d-flex align-items-center text-white">
                                    <p class="mb-0">Total Users</p>
                                    <p class="mb-0 ms-auto">Registered</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card radius-10 bg-gradient-moonlit">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 text-white"><?php echo $totalOrders; ?></h5>
                                    <div class="ms-auto">
                                        <i class='fas fa-shopping-cart fs-3 text-white'></i>
                                    </div>
                                </div>
                                <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                    <div class="progress-bar bg-white" role="progressbar" style="width: 70%"></div>
                                </div>
                                <div class="d-flex align-items-center text-white">
                                    <p class="mb-0">Total Orders</p>
                                    <p class="mb-0 ms-auto">Processed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
                <!-- Charts Row -->
                <div class="row g-4 mb-4">
                    <!-- Sales Analytics -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="fw-bold mb-0">Sales Analytics</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="salesChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Popular Categories -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="fw-bold mb-0">Popular Categories</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="categoryChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0">Recent Orders</h5>
                                <a href="orders.php" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Order #</th>
                                                <th>Customer</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $recentOrders = mysqli_query($conn, "SELECT o.order_number, o.total_amount, o.order_status, o.created_at, u.name FROM orders_tbl o LEFT JOIN users_tbl u ON o.user_id = u.user_id ORDER BY o.order_id DESC LIMIT 5");
                                            while ($order = mysqli_fetch_assoc($recentOrders)):
                                            ?>
                                            <tr>
                                                <td><?php echo $order['order_number']; ?></td>
                                                <td><?php echo htmlspecialchars($order['name'] ?? 'Guest'); ?></td>
                                                <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
                                                <td><span class="badge bg-primary"><?php echo ucfirst($order['order_status']); ?></span></td>
                                                <td><?php echo isset($order['created_at']) ? date('M d', strtotime($order['created_at'])) : 'N/A'; ?></td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="fw-bold mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="products_add.php" class="btn btn-outline-primary">
                                        <i class="fas fa-plus me-2"></i>Add New Product
                                    </a>
                                    <a href="orders.php" class="btn btn-outline-success">
                                        <i class="fas fa-clipboard-list me-2"></i>Manage Orders
                                    </a>
                                    <a href="viewuser.php" class="btn btn-outline-info">
                                        <i class="fas fa-users me-2"></i>Manage Users
                                    </a>
                                    <a href="payments.php" class="btn btn-outline-warning">
                                        <i class="fas fa-credit-card me-2"></i>View Payments
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- System Status -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="fw-bold mb-0">System Status</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                // Check database connection
                                $dbStatus = mysqli_ping($conn) ? 'Online' : 'Offline';
                                $dbClass = mysqli_ping($conn) ? 'success' : 'danger';
                                
                                // Get server info
                                $memoryUsage = memory_get_usage(true) / 1024 / 1024; // MB
                                ?>
                                <div class="status-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Database</span>
                                        <span class="badge bg-<?php echo $dbClass; ?>"><?php echo $dbStatus; ?></span>
                                    </div>
                                </div>
                                <div class="status-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Website</span>
                                        <span class="badge bg-success">Active</span>
                                    </div>
                                </div>
                                <div class="status-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Orders System</span>
                                        <span class="badge bg-success">Running</span>
                                    </div>
                                </div>
                                <div class="status-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Memory Usage</span>
                                        <span class="text-muted"><?php echo round($memoryUsage, 1); ?> MB</span>
                                    </div>
                                    <div class="progress mt-1" style="height: 4px;">
                                        <div class="progress-bar bg-info" style="width: <?php echo min(($memoryUsage/128)*100, 100); ?>%"></div>
                                    </div>
                                </div>
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
        <?php include 'footer.php'; ?>
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

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Get real sales data
        <?php
        $salesData = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        for ($i = 1; $i <= 12; $i++) {
            $monthSales = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(total_amount), 0) as total FROM orders_tbl WHERE MONTH(created_at) = $i AND YEAR(created_at) = YEAR(CURDATE())"))['total'];
            $salesData[] = $monthSales;
        }
        ?>
        
        // ===== Sales Analytics Chart (Line Chart) =====
        const ctxSales = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctxSales, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: "Monthly Sales (₹)",
                    data: <?php echo json_encode($salesData); ?>,
                    backgroundColor: "rgba(54, 162, 235, 0.2)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 2,
                    pointBackgroundColor: "#fff",
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "top",
                        labels: {
                            color: "#333"
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: "#555"
                        },
                        grid: {
                            color: "rgba(200,200,200,0.2)"
                        }
                    },
                    y: {
                        ticks: {
                            color: "#555"
                        },
                        grid: {
                            color: "rgba(200,200,200,0.2)"
                        }
                    }
                }
            }
        });

        // ===== Popular Categories Chart (Doughnut) =====
        const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(ctxCategory, {
            type: 'doughnut',
            data: {
                labels: ["Engine Parts", "Suspension", "Electrical", "Body Parts", "Accessories"],
                datasets: [{
                    label: "Category Share",
                    data: [35, 20, 15, 18, 12],
                    backgroundColor: [
                        "rgba(255, 99, 132, 0.7)",
                        "rgba(54, 162, 235, 0.7)",
                        "rgba(255, 206, 86, 0.7)",
                        "rgba(75, 192, 192, 0.7)",
                        "rgba(153, 102, 255, 0.7)"
                    ],
                    borderColor: [
                        "rgba(255, 99, 132, 1)",
                        "rgba(54, 162, 235, 1)",
                        "rgba(255, 206, 86, 1)",
                        "rgba(75, 192, 192, 1)",
                        "rgba(153, 102, 255, 1)"
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: {
                            color: "#333"
                        }
                    }
                }
            }
        });
    </script>
</body>


<!-- Mirrored from codervent.com/HIREHUNT/demo/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Jan 2023 08:52:40 GMT -->

</html>