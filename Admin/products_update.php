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
    <link href="../assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />\
    <link href="../assets/plugins/datetimepicker/css/classic.css" rel="stylesheet" />
    <link href="../assets/plugins/datetimepicker/css/classic.date.css" rel="stylesheet" />
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
                                <li class="breadcrumb-item active" aria-current="page">Add Product</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="ms-auto">
                        <div class="btn-group">
                            <form method="post"><button type="submit" name="view-btn" class="btn btn-primary">View Products</button></form>

                            <?php

                            if (isset($_POST["view-btn"])) {
                                echo "<script> window.location = 'products_view.php';</script>";
                            }
                            ?>

                        </div>
                    </div>
                </div>
                <!--end breadcrumb-->
                <div class="row">


                    <hr />
                    <?php

                    if (isset($_GET["updateid"])) {
                        $id = $_GET["updateid"];
                        $result = mysqli_query($conn, "select * from products_tbl where product_id='$id'");
                        $row = mysqli_fetch_assoc($result);
                    }

                    ?>
                    <div class="card border-top border-0 border-4 border-danger">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-user me-1 font-22 text-danger"></i>
                                </div>
                                <h5 class="mb-0 text-danger"><b>Products Registration</b></h5>
                            </div>
                            <hr>
                            <form class="row g-3" method="post" id="registerForm" enctype="multipart/form-data">
                                <div class="col-6">
                                    <label for="inputmodel" class="form-label"><b>Model Name</b></label>
                                    <select name="modelname" id="modelname" class="form-select mb-3," aria-label="Default select example">
                                        <option value="">Select Model Name</option>

                                        <?php

                                        $result = mysqli_query($conn, "SELECT * FROM models_tbl") or die(mysqli_error($conn));


                                        while ($row1 = mysqli_fetch_assoc($result)) {

                                        ?>

                                            <option <?php if ($row["model_id"] == $row1["model_id"]) {  ?> selected <?php  } ?> value="<?php echo $row1["model_id"]; ?>"><?php echo $row1["model_name"]; ?></option>
                                        <?php


                                        }



                                        ?>

                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="inputcategory" class="form-label"><b>Category</b></label>
                                    <select name="categoryname" id="categoryname" class="form-select mb-3" aria-label="Default select example">
                                        <option value="">Select Category</option>

                                        <?php

                                        $result = mysqli_query($conn, "SELECT * FROM categories_tbl") or die(mysqli_error($conn));


                                        while ($row1 = mysqli_fetch_assoc($result)) {

                                        ?>

                                            <option <?php if ($row["category_id"] == $row1["category_id"]) {  ?> selected <?php  } ?> value="<?php echo $row1["category_id"]; ?>"><?php echo $row1["category_name"]; ?></option>
                                        <?php
                                        }
                                        ?>

                                    </select>

                                </div>

                                <div class="col	-12">
                                    <label for="inputname" class="form-label"><b>Car Part Name</b></label>
                                    <div>
                                        <input type="text" value="<?php echo $row["part_name"] ?>" class="form-control border-start-1" name="inputname" id="inputname" placeholder="Enter Car-Part Name" />
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <label for="inputimage" class="form-label"><b>Part Image</b></label>
                                    <div>
                                        <img src="uploads/parts/<?php echo $row['part_image']; ?>" height="50" width="50" alt="" />
                                        <input type="file" class="form-control border-start-1" name="inputimage" id="inputimage" placeholder="Insert an image" />
                                        <input type="hidden" class="form-control border-start-1" value="<?php echo $row['part_image']; ?>" name="oldimg" id="oldimg" placeholder="Insert an image" />
                                    </div>
                                </div>


                                <div class="col-12">
                                    <label for="inputdescp" class="form-label"><b>Part Description</b></label>
                                    <textarea  class="form-control" name="inputdescp" id="inputdescp" placeholder="Enter part details" rows="3"><?php echo $row["part_description"] ?></textarea>
                                </div>


                                <div class="col-12">
                                    <label for="inputprice" class="form-label"><b>Price</b></label>
                                    <div>
                                        <input type="text" value="<?php echo $row["price"] ?>" class="form-control border-start-1" id="inputprice" name="inputprice" placeholder="Enter Price of the Part" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="inputquantity" class="form-label"><b>Quantity</b></label>
                                    <div>
                                        <input type="text" value="<?php echo $row["stock"] ?>" class="form-control border-start-1" id="inputquantity" name="inputquantity" placeholder="Enter Part Quantity
                                        " />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="inputlevel" class="form-label"><b>Reorder Level</b></label>
                                    <div>
                                        <input type="text" value="<?php echo $row["reorder_level"] ?>" class="form-control border-start-1" id="inputlevel" name="inputlevel" placeholder="Enter Reorder Level for the Part" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger px-5" name="btn">Save</button>
                                    <button type="button" class="btn btn-success px-5" onclick="clearForm()">Clear</button>
                                </div>
                            </form>

                            <?php
                            if (isset($_POST["btn"])) {
                                $id = $_GET["updateid"];
                                $name = mysqli_real_escape_string($conn, $_POST["inputname"]);
                                $descp = mysqli_real_escape_string($conn, $_POST["inputdescp"]);
                                $price = mysqli_real_escape_string($conn, $_POST["inputprice"]);
                                $quantity = mysqli_real_escape_string($conn, $_POST["inputquantity"]);
                                $level = mysqli_real_escape_string($conn, $_POST["inputlevel"]);
                                $category = mysqli_real_escape_string($conn, $_POST["categoryname"]);
                                $model = mysqli_real_escape_string($conn, $_POST["modelname"]);

                                $oldimage = $_POST["oldimg"];
                                $newimage = "";

                                if (empty($_FILES["inputimage"]["name"])) {
                                    $newimage = $oldimage;
                                } else {
                                    unlink("uploads/parts/$oldimage");
                                    $ext = pathinfo($_FILES["inputimage"]["name"], PATHINFO_EXTENSION);
                                    $filename = time() . random_int(1111, 9999) . "." . $ext;  //142578522.png
                                    move_uploaded_file($_FILES["inputimage"]["tmp_name"], "uploads/parts/" . $filename);
                                    $newimage = $filename;
                                }




                                $sql = "UPDATE products_tbl 
            					SET part_name='$name',
            					    model_id='$model',
            					    part_description='$descp',
            					    category_id='$category',
            					    price='$price',
									stock='$quantity',
            					    reorder_level='$level',
									part_image='$newimage'
            					WHERE product_id='$id'";

                                $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                                if ($res) {
                                    echo "Successfully Updated";
                                    echo "<script> window.location = 'products_view.php';</script>";
                                } else {
                                    echo "Failed to update.";
                                }
                            }
                            ?>

                        </div>
                    </div>

                    <!--end row-->
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
        <script src="../assets/plugins/datetimepicker/js/picker.date.js"></script>
        <script src="../assets/plugins/datetimepicker/js/picker.js"></script>

        <!--app JS-->
        <script src="../assets/js/app.js"></script>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        <script>
            function clearForm() {
                document.getElementById("registerForm").reset();
            }
        </script>
        <script>
            // Custom validator for "spaces only"
            $.validator.addMethod("noSpaceOnly", function(value, element) {
                return $.trim(value).length > 0;
            }, "Spaces only are not allowed.");

            // Custom validator: Deadline must be after Posted Date
            $.validator.addMethod("greaterThan", function(value, element, param) {
                let startDate = $(param).val();
                return Date.parse(value) > Date.parse(startDate);
            }, "Deadline must be after Posted Date.");

            $(document).ready(function() {
                $("#registerForm").validate({
                    rules: {
                        modelname: {
                            required: true
                        },
                        categoryname: {
                            required: true
                        },
                        inputname: {
                            required: true,
                            minlength: 3,
                            noSpaceOnly: true
                        },
                        inputimage: {
                            extension: "jpg|jpeg|png|gif|webp"
                        },
                        inputdescp: {
                            required: true,
                            minlength: 10
                        },
                        inputprice: {
                            required: true,
                            number: true,
                            min: 1
                        },
                        inputquantity: {
                            required: true,
                            digits: true,
                            min: 1
                        },
                        inputlevel: {
                            required: true,
                            digits: true,
                            min: 1
                        }
                    },
                    messages: {
                        modelname: "Please select a model name",
                        categoryname: "Please select a category",
                        inputname: {
                            required: "Please enter car part name",
                            minlength: "Car part name must be at least 3 characters",
                            noSpaceOnly: "Spaces only are not allowed"
                        },
                        inputimage: {
                            extension: "Only jpg, jpeg, png, gif, or webp formats allowed"
                        },
                        inputdescp: {
                            required: "Please enter part description",
                            minlength: "Description must be at least 10 characters"
                        },
                        inputprice: {
                            required: "Please enter price",
                            number: "Price must be a number",
                            min: "Price must be greater than 0"
                        },
                        inputquantity: {
                            required: "Please enter quantity",
                            digits: "Quantity must be a whole number",
                            min: "Quantity must be at least 1"
                        },
                        inputlevel: {
                            required: "Please enter reorder level",
                            digits: "Reorder level must be a whole number",
                            min: "Reorder level must be at least 1"
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