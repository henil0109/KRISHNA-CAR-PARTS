<head>
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="../assets/css/dark-theme.css" />
	<link rel="stylesheet" href="../assets/css/semi-dark.css" />
	<link rel="stylesheet" href="../assets/css/header-colors.css" />
	<!-- Font Awesome and Boxicons for sidebar icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<style>
		html.semi-dark .sidebar-wrapper .sidebar-header .logo-text{
			color: red !important;
		}
		.logo-icon1{
			width: 80px;
            height: 60px;
			
		}
	</style>
</head>
<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="../assets/images/kcp.png" class="logo-icon1" alt="logo icon">
				</div>
				<!-- <div> -->
					<!-- <h4 class="logo-text">HIREHUNT</h4> -->
				<!-- </div> -->
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<li>
					<a href="index.php">
						<div class="parent-icon"><i class='fas fa-tachometer-alt fs-5'></i>
						</div>
						<div class="menu-title ">Dashboard</div>
					</a>
					
				</li>
				<li>
					
					
				
				<li class="menu-label">Admin Functions</li>
				
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='fas fa-cogs fs-5'></i>
						</div>
						<div class="menu-title">Products</div>
					</a>
					<ul>
						<li> <a href="products_add.php"><i class="bx bx-right-arrow-alt"></i>Add Product</a>
						</li>
						<li> <a href="products_view.php"><i class="bx bx-right-arrow-alt"></i>View Products</a>
						</li>
						
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='fas fa-tag fs-5'></i>
						</div>
						<div class="menu-title">Manage Brands</div>
					</a>
					<ul>
						<li> <a href="brands_add.php"><i class="bx bx-right-arrow-alt"></i>Add Brand</a>
						</li>
						<li> <a href="brands_view.php"><i class="bx bx-right-arrow-alt"></i>View Brands</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='fas fa-car fs-5'></i>
						</div>
						<div class="menu-title">Manage Cars</div>
					</a>
					<ul>
						<li> <a href="cars_add.php"><i class="bx bx-right-arrow-alt"></i>Add Car</a>
						</li>
						<li> <a href="cars_view.php"><i class="bx bx-right-arrow-alt"></i>View Cars</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='fas fa-road fs-5'></i>
						</div>
						<div class="menu-title">Manage Models</div>
					</a>
					<ul>
						<li> <a href="models_add.php"><i class="bx bx-right-arrow-alt"></i>Add Model</a>
						</li>
						<li> <a href="models_view.php"><i class="bx bx-right-arrow-alt"></i>View Models</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='fas fa-layer-group fs-5'></i>
						</div>
						<div class="menu-title">Manage Categories</div>
					</a>
					<ul>
						<li> <a href="category_add.php"><i class="bx bx-right-arrow-alt"></i>Add Category</a>
						</li>
						<li> <a href="category_view.php"><i class="bx bx-right-arrow-alt"></i>View Category</a>
						</li>
					</ul>
				</li>
				 <li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="fas fa-clipboard-check fs-5"></i>
						</div>
						<div class="menu-title">Manage Orders</div>
					</a>
					<ul>
						<li> <a href="orders.php"><i class="bx bx-right-arrow-alt"></i>Manage Orders</a>
						</li>
					</ul>
				</li> 
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"> <i class="bx bx-group fs-5 text-white"></i>
						</div>
						<div class="menu-title">User Management</div>
					</a>
					<ul>
						<li> <a href="viewuser.php"><i class="bx bx-right-arrow-alt"></i>View All Users</a>
						</li>
						<li> <a href="filteruser.php"><i class="bx bx-right-arrow-alt"></i>Filter User by Products</a>
						</li>
					</ul>
				</li>
                <li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"> <i class="fas fa-credit-card fs-5"></i>
						</div>
						<div class="menu-title">Payments</div>
					</a>
					<ul>
						<li> <a href="payments.php"><i class="bx bx-right-arrow-alt"></i>View All Payments</a>
						</li>
					</ul>
				</li>
			
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-support"></i>
						</div>
						<div class="menu-title">Inquiry</div></a>
                        <ul>
						<li> <a href="view_inquiries.php"><i class="bx bx-right-arrow-alt"></i> Manage Inquiries</a>
						</li>
					</ul>
					
				</li>
			</ul>
			<!--end navigation-->
		</div>
		
		<style>
		/* Fix MetisMenu behavior */
		.metismenu ul {
			display: none !important;
		}
		.metismenu .mm-active > ul {
			display: block !important;
		}
		/* Ensure icons display properly */
		.parent-icon i {
			font-family: 'Font Awesome 6 Free', 'boxicons' !important;
			font-weight: 900;
			font-style: normal;
		}
		.bx {
			font-family: 'boxicons' !important;
		}
		</style>
		
		<script>
		$(document).ready(function() {
			// Reinitialize MetisMenu with proper settings
			$('#menu').metisMenu({
				toggle: true,
				preventDefault: true
			});
		});
		</script>