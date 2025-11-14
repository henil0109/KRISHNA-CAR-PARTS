<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Krishna Car Parts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css" rel="stylesheet">
    <link href="../assets/css/admin.css" rel="stylesheet">
</head>
<body class="admin-body">
    <!-- Sidebar -->
    <?php include 'sidebar.php' ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <?php include 'header.php' ?>

        <!-- Dashboard Content -->
        <div class="container-fluid p-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Dashboard</h2>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" onclick="refreshData()">
                        <i class="fas fa-sync-alt me-2"></i>Refresh
                    </button>
                    <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#quickAddModal">
                        <i class="fas fa-plus me-2"></i>Quick Add
                    </button> -->
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card stats-card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50">Total Products</h6>
                                    <h3 class="fw-bold mb-0" id="totalProducts">1,245</h3>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-cogs fa-2x"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-white-50">
                                    <i class="fas fa-arrow-up me-1"></i>12% from last month
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card stats-card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50">Active Customers</h6>
                                    <h3 class="fw-bold mb-0" id="activeCustomers">856</h3>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-white-50">
                                    <i class="fas fa-arrow-up me-1"></i>8% from last month
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card stats-card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50">Pending Inquiries</h6>
                                    <h3 class="fw-bold mb-0" id="pendingInquiries">23</h3>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-envelope fa-2x"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-white-50">
                                    <i class="fas fa-arrow-down me-1"></i>5% from last week
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card stats-card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50">Monthly Revenue</h6>
                                    <h3 class="fw-bold mb-0" id="monthlyRevenue">₹2.4L</h3>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-rupee-sign fa-2x"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-white-50">
                                    <i class="fas fa-arrow-up me-1"></i>15% from last month
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-4 mb-4">
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

            <!-- Recent Activities -->
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">Recent Inquiries</h5>
                            <a href="inquiries.html" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Customer</th>
                                            <th>Product</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recentInquiriesTable">
                                        <!-- Data will be loaded via JavaScript -->
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
                                <a href="cars_add.php" class="btn btn-outline-success">
                                    <i class="fas fa-car me-2"></i>Add New Car Model
                                </a>
                                <a href="viewuser.php" class="btn btn-outline-info">
                                    <i class="fas fa-users me-2"></i>Manage Customers
                                </a>
                                <!-- <a href="reports.html" class="btn btn-outline-warning">
                                    <i class="fas fa-chart-bar me-2"></i>Generate Report
                                </a> -->
                            </div>
                        </div>
                    </div>

                    <!-- System Status -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="fw-bold mb-0">System Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="status-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Database</span>
                                    <span class="badge bg-success">Online</span>
                                </div>
                            </div>
                            <div class="status-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Email Service</span>
                                    <span class="badge bg-success">Pending</span>
                                </div>
                            </div>
                            <div class="status-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Backup</span>
                                    <span class="badge bg-warning">Pending</span>
                                </div>
                            </div>
                            <div class="status-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Storage</span>
                                    <span class="text-muted">78% Used</span>
                                </div>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar" style="width: 78%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Add Modal -->
    <!-- <div class="modal fade" id="quickAddModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quick Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-grid gap-2">
                        <a href="products.html?action=add" class="btn btn-outline-primary">
                            <i class="fas fa-cogs me-2"></i>Add Product
                        </a>
                        <a href="cars.html?action=add" class="btn btn-outline-success">
                            <i class="fas fa-car me-2"></i>Add Car Model
                        </a>
                        <a href="customers.html?action=add" class="btn btn-outline-info">
                            <i class="fas fa-user-plus me-2"></i>Add Customer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <?php include 'footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/admin-dashboard.js"></script>
</body>
</html>
