<?php
include 'connection.php';
include 'session.php';
?>
<!doctype html>
<html lang="en" class="semi-dark">


<!-- Mirrored from codervent.com/rukada/demo/vertical/form-layouts.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Jan 2023 08:56:09 GMT -->

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
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Manage Cars</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Add Car</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="ms-auto">
                        <div class="btn-group">
                            <form method="post"><button type="submit" name="viewbtn" class="btn btn-primary">View Cars</button></form>
                            <?php

                            if (isset($_POST["viewbtn"])) {
                                echo "<script> window.location = 'cars_view.php';</script>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <hr />
                <?php
                if (isset($_POST["btn"])) {
                    $car = $_POST["txtcar"];
                    $brand = $_POST["brandname"];
                    $result = mysqli_query($conn, "select * from cars_tbl where car_name='$car'");
                    if (mysqli_num_rows($result) <= 0) {
                        $sql = "INSERT INTO `cars_tbl`(brand_id,car_name) VALUES ('$brand','$car')";
                        $res = mysqli_query($conn, $sql);
                        if ($res) {
                            echo "Successfully inserted";
                            echo "<script> window.location = 'cars_view.php';</script>";
                        } else {
                            echo "Fail to insert.";
                        }
                    } else {

                        echo "data already exists!";
                    }
                }
                ?>
                <div class="card border-top border-0 border-4 border-danger">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-user me-1 font-22 text-danger"></i>
                            </div>
                            <h5 class="mb-0 text-danger">Car Registration</h5>
                        </div>
                        <hr>
                        <form class="row g-3" method="post" id="registercar">

                            <div class="col-md-6">
                                <label for="inputbrand" class="form-label"><b>Brand Name</b></label>
                                <select name="brandname" id="brandname" class="form-select mb-3" aria-label="Default select example">
                                    <option value="">Select Brand</option>

                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM brands_tbl") or die(mysqli_error($conn));
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <option value="<?php echo $row["brand_id"]; ?>"><?php echo $row["brand_name"]; ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>
                            </div>

                            <div class="col-12">
                                <label for="inputcar" class="form-label">Car Name</label>
                                <div class="input-group"> <span class="input-group-text bg-transparent">🚗</span>
                                    <input type="text" class="form-control border-start-0" placeholder="Enter Car Name" name="txtcar" />
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-danger px-5" name="btn">Insert</button>
                                <button type="button" class="btn btn-success px-5" onclick="clearForm()">Clear</button>
                            </div>
                    </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
    </div>

    <!--end row-->

    <!--end row-->

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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
        function clearForm() {
            document.getElementById("registercar").reset();
        }
    </script>
    <script>
        $.validator.addMethod("noSpaceOnly", function(value, element) {
            return $.trim(value).length > 0;
        }, "*Spaces only are not allowed.");

        $(document).ready(function() {
            $("#registercar").validate({
                rules: {
                    txtcar: {
                        required: true,
                        noSpaceOnly: true
                    }
                },
                messages: {
                    txtcar: {
                        required: "*Please enter a Car Name.",

                    }

                },
                errorElement: "div",
                errorClass: "invalid-feedback",
                highlight: function(element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid");
                },
                errorPlacement: function(error, element) {
                    if (element.is("select")) {
                        error.insertAfter(element);
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    </script>
</body>



</html>