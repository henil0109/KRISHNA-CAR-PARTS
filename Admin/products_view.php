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
							<form method="post"><button type="submit" name="add-btn" class="btn btn-primary">Add Product</button></form>
							    
								<?php 
				
								if(isset($_POST["add-btn"]))
								{
									 echo "<script> window.location = 'products_add.php';</script>";
								}		
                    			?>

						</div>
					</div>
				</div>

			<!-- Modal -->
				<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">WARNING!!</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">Are you sure You want to delete?</div>
							<div class="modal-footer">
								<form method="post">
									<input type="hidden" name="deleteid" id="deleteid">
									<input type="text" name="deleteimg" id="deleteimg">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
									<button type="submit" name="delete-btn" class="btn btn-primary">Yes</button>
								</form>
							</div>
						</div>
					</div>
				</div>

				<?php 
				
					if(isset($_POST["delete-btn"]))
					{
						$did = $_POST["deleteid"];
						$dimg = $_POST["deleteimg"];

						unlink("uploads/parts/$dimg");

						$result = mysqli_query($conn,"delete from products_tbl where product_id='$did'") or die(mysqli_error($conn));

						if($result)
						{
							// echo "record delete!";
							?>
								<div class="alert alert-primary border-0 bg-primary alert-dismissible fade show py-2">
									<div class="d-flex align-items-center">
										<div class="font-35 text-white"><i class="bx bx-bookmark-heart"></i>
										</div>
										<div class="ms-3">
											<h6 class="mb-0 text-white">record deleted!</h6>
											<!-- <div class="text-white">A simple primary alert—check it out!</div> -->
										</div>
									</div>
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
							<?php
						}
						else
						{
							echo "recored not delete";
						}



					}
				
				?>

				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Car Parts</h6>
				<hr />
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table mb-0" style="width:100%">
								<thead class="table-light">
									<tr>
										<th>#</th>
										<th>Part Image</th>
										<th>Part Name</th>
										<!-- <th>Description</th> -->
										<!-- <th>Desgnation </th> -->
										<th>Car Name</th>
										<!-- <th>Location</th> -->
										<th>Category Name</th>
                                        <th>Price</th>
										<!-- <th>Qualifications</th> -->
										<!-- <th>Posted Date</th> -->
										<!-- <th>Expiry Date</th> -->
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = "SELECT * FROM products_tbl AS p LEFT JOIN models_tbl AS m ON p.model_id = m.model_id LEFT JOIN categories_tbl AS ct ON p.category_id = ct.category_id;";
									$res = mysqli_query($conn, $sql);
									$cnt = 1;
									while ($row = mysqli_fetch_assoc($res)) {

									?>
										<tr>
											<td><?php echo $cnt; ?></td>
											
											 <td><img src="../assets/images/<?php echo $row["part_image"]; ?>" height="50" width="50" alt=""></td>
											<td><?php echo $row["part_name"]; ?></td>
											<td><?php echo $row["model_name"]; ?></td>
											<td><?php echo $row["category_name"]; ?></td>
                                            <td><?php echo $row["price"]; ?></td>
								

											<td>
												<a href="product_details.php?dataid=<?php echo $row["product_id"] ?>" class="btn btn-outline-primary px-2">View</a>&nbsp;
												<a href="products_update.php?updateid=<?php echo $row["product_id"] ?>" class="btn btn-outline-primary px-1">Update</a>&nbsp;
												<button type="button" data-id="<?php echo $row["product_id"] ?>" data-img="<?php echo $row["part_image"] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-outline-primary px-1 btndelete">Delete</button>
											</td>

										</tr>

									<?php
										$cnt++;
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

			$(document).on("click", ".btndelete", function() {

				var id = $(this).attr("data-id");
				var img = $(this).attr("data-img");
				//alert(id);
				$("#deleteid").val(id);
				$("#deleteimg").val(img);

			})

			$('#example').DataTable();
		});
	</script>

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


<!-- Mirrored from codervent.com/rukada/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Jan 2023 08:56:20 GMT -->

</html>