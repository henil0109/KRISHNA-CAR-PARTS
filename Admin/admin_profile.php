<?php
include 'session.php';
include 'connection.php';

// Handle profile update
if ($_POST['action'] ?? '' === 'update_profile') {
    $name = mysqli_real_escape_string($conn, $_POST['admin_name']);
    $email = mysqli_real_escape_string($conn, $_POST['admin_email']);
    
    $stmt = mysqli_prepare($conn, "UPDATE admin_tbl SET admin_name = ?, admin_email = ? WHERE admin_id = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $_SESSION['adminid']);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['adminname'] = $name;
        $success = "Profile updated successfully!";
    } else {
        $error = "Failed to update profile.";
    }
}

// Get admin data
$stmt = mysqli_prepare($conn, "SELECT * FROM admin_tbl WHERE admin_id = ?");
mysqli_stmt_bind_param($stmt, "i", $_SESSION['adminid']);
mysqli_stmt_execute($stmt);
$admin = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
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
                    <div class="breadcrumb-title pe-3">Admin Profile</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="index.php"><i class="bx bx-home-alt"></i></a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                
                <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5>Profile Information</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <input type="hidden" name="action" value="update_profile">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="admin_name" class="form-control" value="<?php echo htmlspecialchars($admin['admin_name']); ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="admin_email" class="form-control" value="<?php echo htmlspecialchars($admin['admin_email']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <input type="text" class="form-control" value="Administrator" readonly>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Account Stats</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Total Products:</span>
                                    <strong><?php echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products_tbl"))['count']; ?></strong>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Total Orders:</span>
                                    <strong><?php echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders_tbl"))['count']; ?></strong>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Total Users:</span>
                                    <strong><?php echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users_tbl"))['count']; ?></strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Last Login:</span>
                                    <strong>Today</strong>
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