<?php
include 'connection.php';
include 'session.php';
?>
<!doctype html>
<html lang="en" class="semi-dark">


<!-- Mirrored from codervent.com/rukada/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Jan 2023 08:56:20 GMT -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="../assets/images/kcp.png" type="image/png" />
    <!--plugins-->
    <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="../assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="../assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
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
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <?php include 'sidebar.php' ?>
        <!--end sidebar wrapper -->
        <!--start header -->
        <?php include 'header.php' ?>
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Manage Products</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">View Products</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="ms-auto">
                        <div class="btn-group">
                            <form method="post"><button type="submit" name="add-btn" class="btn btn-primary">View Products</button></form>

                            <?php

                            if (isset($_POST["add-btn"])) {
                                echo "<script> window.location = 'products_view.php';</script>";
                            }
                            ?>

                        </div>
                    </div>
                </div>



                <!--end breadcrumb-->
                <h6 class="mb-0 text-uppercase">Car Parts</h6>
                <hr />
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table mb-0" style="width:100%">

                                <tbody>
                                    <?php
                                    $id = $_GET["dataid"];
                                    $sql = "SELECT * FROM products_tbl AS p LEFT JOIN models_tbl AS m ON p.model_id = m.model_id LEFT JOIN categories_tbl AS ct ON p.category_id = ct.category_id where p.product_id='$id'";
                                    $res = mysqli_query($conn, $sql);
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_assoc($res)) {

                                    ?>

                                        <tr>
                                            <th>Part Image</th>
                                            <td><img src="uploads/parts/<?php echo $row["part_image"]; ?>" height="100" width="100" alt=""></td>
                                        </tr>
                                        <tr>
                                            <th>Part Name</th>
                                            <td><?php echo $row["part_name"]; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Description</th>
                                            <td ><?php echo $row["part_description"]; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Car Name </th>
                                            <td><?php echo $row["model_name"]; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <td><?php echo $row["category_name"]; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Price</th>
                                            <td><?php echo $row["price"]; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Quantity</th>
                                            <td><?php echo $row["stock"]; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Reorder Level</th>
                                            <td><?php echo $row["reorder_level"]; ?></td>
                                        </tr>
                                    <?php

                                    }
                                    ?>


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
    <script src="../assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>


    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
    <!--app JS-->
    <script src="../assets/js/app.js"></script>
</body>




</html>