<?php
//Mulai Sesion
session_start();
if (isset($_SESSION["ses_username"]) == "") {
	header("location: login.php");
} else {
	$data_id = $_SESSION["ses_id"];
	$data_nama = $_SESSION["ses_nama"];
	$data_user = $_SESSION["ses_username"];
	$data_level = $_SESSION["ses_level"];
}

//KONEKSI DB
include "inc/koneksi.php";
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sistem Informasi Perpustakaan</title>
	<link rel="icon" href="dist/img/logo-doang.png">
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
	<!-- Select2 -->
	<link rel="stylesheet" href="plugins/select2/select2.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
	
	<!-- Custom CSS for modifications -->
	<style>
		/* Logo spacing fix */
		.logo-lg img {
			margin-right: 10px;
		}
		
		/* Settings dropdown button */
		.settings-dropdown .dropdown-toggle {
			background-color: transparent;
			border: none;
			color: white;
			padding: 10px 15px;
			border-radius: 4px;
			transition: background-color 0.3s;
		}
		
		.settings-dropdown .dropdown-toggle:hover,
		.settings-dropdown .dropdown-toggle:focus {
			background-color: rgba(255,255,255,0.15);
		}
		
		.settings-dropdown .dropdown-toggle i {
			font-size: 18px;
		}
		
		/* Clean dropdown menu */
		.settings-dropdown .dropdown-menu {
			right: 0;
			left: auto;
			min-width: 280px;
			border-radius: 8px;
			box-shadow: 0 4px 12px rgba(0,0,0,0.15);
			border: none;
			padding: 0;
			margin-top: 8px;
		}
		
		/* User header in dropdown */
		.settings-dropdown .user-dropdown-header {
			background: linear-gradient(135deg, #00a65a 0%, #00c86f 100%);
			padding: 30px 20px;
			text-align: center;
			border-radius: 8px 8px 0 0;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			min-height: 100px;
		}
		
		.settings-dropdown .user-dropdown-header img {
			width: 60px;
			height: 60px;
			border: 3px solid white;
			margin-bottom: 12px;
		}
		
		.settings-dropdown .user-dropdown-header .user-name {
			color: white;
			font-size: 16px;
			font-weight: 600;
			margin: 0;
			padding: 0;
		}
		
		.settings-dropdown .user-dropdown-header .user-role {
			color: rgba(255,255,255,0.9);
			font-size: 13px;
			margin-top: 5px;
		}
		
		/* Menu items */
		.settings-dropdown .dropdown-menu-items {
			padding: 8px 0;
		}
		
		.settings-dropdown .dropdown-menu-item {
			display: block;
			padding: 12px 20px;
			color: #333;
			text-decoration: none;
			transition: background-color 0.2s;
			border-left: 3px solid transparent;
		}
		
		.settings-dropdown .dropdown-menu-item:hover {
			background-color: #f5f5f5;
			border-left-color: #00a65a;
		}
		
		.settings-dropdown .dropdown-menu-item i {
			width: 20px;
			margin-right: 10px;
			color: #00a65a;
		}
		
		/* Icon for user image in menu */
		.settings-dropdown .menu-user-icon {
			width: 20px;
			height: auto;
			margin-right: 10px;
			color: #00a65a;
		}
		
		/* Divider */
		.settings-dropdown .dropdown-divider {
			height: 1px;
			background-color: #e5e5e5;
			margin: 8px 0;
		}
		
		/* Logout button */
		.settings-dropdown .logout-item {
			color: #d9534f;
			font-weight: 500;
		}
		
		.settings-dropdown .logout-item:hover {
			background-color: #fef5f5;
			border-left-color: #d9534f;
		}
		
		.settings-dropdown .logout-item i {
			color: #d9534f;
		}
	</style>
</head>

<body class="hold-transition skin-green sidebar-mini">
	<!-- Site wrapper -->
	<div class="wrapper">

		<header class="main-header">
			<!-- Logo -->
			<a href="index.php" class="logo">
				<span class="logo-mini">
					<img src="dist/img/logo-doang.png" width="30px">
				</span>
				<span class="logo-lg">
					<img src="dist/img/logo-doang.png" width="37px">
					<b>SIPERPUS</b>
				</span>
			</a>
			
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top" style="display: flex; justify-content: space-between; align-items: center; margin: 0;">
				<div style="display: flex; align-items: center; margin-left: -750px; ">
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" style="float: none; padding: 15px;">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>

					<div style="color: white; font-size: 16px; white-space: nowrap;">
						<b>Sistem Informasi Perpustakaan</b>
					</div>
				</div>

				<div class="navbar-custom-menu" style="float: none; margin: 0; margin-right: -750px;">
					<ul class="nav navbar-nav" style="margin: 0;">
						<!-- Settings Dropdown -->
						<li class="dropdown settings-dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-cog"></i>
								<i class="fa fa-angle-down" style="margin-left: 5px; font-size: 14px;"></i>
							</a>
							<ul class="dropdown-menu">
								<!-- User Header -->
								<li class="user-dropdown-header">
									<img src="dist/img/avatar.png" class="img-circle" alt="User Image">
									<p class="user-name"><?php echo $data_nama; ?></p>
									<small class="user-role"><?php echo $data_level; ?></small>
								</li>
								
								<!-- Menu Items -->
								<li class="dropdown-menu-items">
									<?php if ($data_level == "Administrator") { ?>
									<a href="?page=MyApp/data_pengguna" class="dropdown-menu-item">
										<i class="fa fa-users menu-user-icon"></i>
										<span>Pengguna Sistem</span>
									</a>
									<?php } ?>
								</li>
								
								<!-- Divider -->
								<li class="dropdown-divider"></li>
								
								<!-- Logout -->
								<li class="dropdown-menu-items">
									<a href="logout.php" onclick="return confirm('Anda yakin keluar dari aplikasi ?')" class="dropdown-menu-item logout-item">
										<i class="fa fa-sign-out"></i>
										<span>Logout</span>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<!-- =============================================== -->

		<!-- Left side column. contains the sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- Sidebar user panel -->
				<div class="user-panel">
					<div class="pull-left image">
						<img src="dist/img/avatar.png" class="img-circle" alt="User Image">
					</div>
					<div class="pull-left info">
						<p>
							<?php echo $data_nama; ?>
						</p>
						<span class="label label-warning">
							<?php echo $data_level; ?>
						</span>
					</div>
				</div>
				</br>
				<!-- /.search form -->
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<ul class="sidebar-menu">
					<li class="header">MAIN NAVIGATION</li>

					<!-- Level  -->
					<?php
					if ($data_level == "Administrator") {
					?>

						<li class="treeview">
							<a href="?page=admin">
								<i class="fa fa-dashboard"></i>
								<span>Dashboard</span>
								<span class="pull-right-container">
								</span>
							</a>
						</li>

						<li class="treeview">
							<a href="#">
								<i class="fa fa-folder"></i>
								<span>Kelola Data</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">

								<li>
									<a href="?page=MyApp/data_buku">
										<i class="fa fa-book"></i>Data Buku</a>
								</li>
								<li>
									<a href="?page=MyApp/data_agt">
										<i class="fa fa-users"></i>Data Anggota</a>
								</li>
							</ul>
						</li>

						<li class="treeview">
							<a href="?page=data_sirkul">
								<i class="fa fa-refresh"></i>
								<span>Pengelolaan</span>
								<span class="pull-right-container">
								</span>
							</a>
						</li>

						<li class="treeview">
							<a href="#">
								<i class="fa fa-book"></i>
								<span>Log Data</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">

								<li>
									<a href="?page=log_pinjam">
										<i class="fa fa-arrow-circle-o-down"></i>Peminjaman</a>
								</li>
								<li>
									<a href="?page=log_kembali">
										<i class="fa fa-arrow-circle-o-up"></i>Pengembalian</a>
								</li>
							</ul>
						</li>


						<li class="treeview">
							<a href="#">
								<i class="fa fa-print"></i>
								<span>Laporan</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li>
									<a href="?page=laporan_sirkulasi">
										<i class="fa fa-file"></i>Laporan Sirkulasi</a>
								</li>
							</ul>
						</li>

					<?php
					} elseif ($data_level == "Petugas") {
					?>

						<li class="treeview">
							<a href="?page=petugas">
								<i class="fa fa-dashboard"></i>
								<span>Dashboard</span>
								<span class="pull-right-container">
								</span>
							</a>
						</li>

						<li class="treeview">
							<a href="#">
								<i class="fa fa-folder"></i>
								<span>Kelola Data</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">

								<li>
									<a href="?page=MyApp/data_buku">
										<i class="fa fa-book"></i>Data Buku</a>
								</li>
								<li>
									<a href="?page=MyApp/data_agt">
										<i class="fa fa-users"></i>Data Anggota</a>
								</li>
							</ul>
						</li>

						<li class="treeview">
							<a href="?page=data_sirkul">
								<i class="fa fa-refresh"></i>
								<span>Sirkulasi</span>
								<span class="pull-right-container">
								</span>
							</a>
						</li>

						<li class="treeview">
							<a href="#">
								<i class="fa fa-book"></i>
								<span>Log Data</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">

								<li>
									<a href="?page=log_pinjam">
										<i class="fa fa-arrow-circle-o-down"></i>Peminjaman</a>
								</li>
								<li>
									<a href="?page=log_kembali">
										<i class="fa fa-arrow-circle-o-up"></i>Pengembalian</a>
								</li>
							</ul>
						</li>

						<li class="treeview">
							<a href="#">
								<i class="fa fa-print"></i>
								<span>Laporan</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">


								<li>
									<a href="?page=laporan_sirkulasi">
										<i class="fa fa-file"></i>Laporan Sirkulasi</a>
								</li>
							</ul>
						</li>

					<?php
					}
					?>

			</section>
			<!-- /.sidebar -->
		</aside>

		<!-- =============================================== -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<!-- Main content -->
			<section class="content">
				<?php
				if (isset($_GET['page'])) {
					$hal = $_GET['page'];

					switch ($hal) {
							//Klik Halaman Home Pengguna
						case 'admin':
							include "home/admin.php";
							break;
						case 'petugas':
							include "home/petugas.php";
							break;

							//Pengguna
						case 'MyApp/data_pengguna':
							include "admin/pengguna/data_pengguna.php";
							break;
						case 'MyApp/add_pengguna':
							include "admin/pengguna/add_pengguna.php";
							break;
						case 'MyApp/edit_pengguna':
							include "admin/pengguna/edit_pengguna.php";
							break;
						case 'MyApp/del_pengguna':
							include "admin/pengguna/del_pengguna.php";
							break;


							//agt
						case 'MyApp/data_agt':
							include "admin/agt/data_agt.php";
							break;
						case 'MyApp/add_agt':
							include "admin/agt/add_agt.php";
							break;
						case 'MyApp/edit_agt':
							include "admin/agt/edit_agt.php";
							break;
						case 'MyApp/del_agt':
							include "admin/agt/del_agt.php";
							break;
						case 'MyApp/print_agt':
							include "admin/agt/print_agt.php";
							break;
						case 'MyApp/print_allagt':
							include "admin/agt/print_allagt.php";
							break;


							//buku
						case 'MyApp/data_buku':
							include "admin/buku/data_buku.php";
							break;
						case 'MyApp/add_buku':
							include "admin/buku/add_buku.php";
							break;
						case 'MyApp/edit_buku':
							include "admin/buku/edit_buku.php";
							break;
						case 'MyApp/del_buku':
							include "admin/buku/del_buku.php";
							break;

							//sirkul
						case 'data_sirkul':
							include "admin/sirkul/data_sirkul.php";
							break;
						case 'add_sirkul':
							include "admin/sirkul/add_sirkul.php";
							break;
						case 'panjang':
							include "admin/sirkul/panjang.php";
							break;
						case 'kembali':
							include "admin/sirkul/kembali.php";
							break;

							//log
						case 'log_pinjam':
							include "admin/log/log_pinjam.php";
							break;
						case 'log_kembali':
							include "admin/log/log_kembali.php";
							break;

							//laporan
						case 'laporan_sirkulasi':
							include "admin/laporan/laporan_sirkulasi.php";
							break;
						case 'MyApp/print_laporan':
							include "admin/laporan/print_laporan.php";
							break;



							//default
						default:
							echo "<center><br><br><br><br><br><br><br><br><br>
				  <h1> Halaman tidak ditemukan !</h1></center>";
							break;
					}
				} else {
					// Auto Halaman Home Pengguna
					if ($data_level == "Administrator") {
						include "home/admin.php";
					} elseif ($data_level == "Petugas") {
						include "home/petugas.php";
					}
				}
				?>



			</section>
			<!-- /.content -->
		</div>

	

		<footer class="main-footer">
			<div class="pull-right hidden-xs">
			</div>
			<strong>Copyright &copy;
				<a href="https://www.facebook.com/">Ryan Pradnyana</a>.</strong> All rights reserved.
		</footer>
		<div class="control-sidebar-bg"></div>
		-->

	

		<!-- jQuery 2.2.3 -->
		<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
			 
		<!--Bootstrap 3.3.6 -->
			
		<script src = "bootstrap/js/bootstrap.min.js"></script>
		

		<script src="plugins/select2/select2.full.min.js"></script>
		<!-- DataTables -->
		<script src="plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

		<!-- AdminLTE App -->
		<script src="dist/js/app.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>
		<!-- page script -->


		<script>
			$(function() {
				$("#example1").DataTable({
					columnDefs: [{
						"defaultContent": "-",
						"targets": "_all"
					}]
				});
				$('#example2').DataTable({
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering": true,
					"info": true,
					"autoWidth": false
				});
			});
		</script>

		<script>
			$(function() {
				//Initialize Select2 Elements
				$(".select2").select2();
			});
		</script>
</body>

</html>