<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?= APP_NAME ?> – <?= $title; ?></title>

	<!-- Custom fonts for this template-->
	<link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets/') ?>https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- sb-admin-2 styles for this template-->
	<link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">

	<!-- custom css -->
	<link href="<?= base_url('assets/') ?>css/custom.css" rel="stylesheet">
</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">
		<input type="hidden" name="base_url" value="<?= base_url() ?>">
		<!-- Sidebar -->
		<ul class="navbar-nav bg-success sidebar sidebar-dark accordion" id="accordionSidebar">

			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
				<div class="sidebar-brand-icon rotate-n-15">
					<i class="fas fa-coffee"></i>
				</div>
				<div class="sidebar-brand-text mx-3">Kopi Chuseyo</div>
			</a>


			<!-- Divider -->
			<hr class="sidebar-divider">

			<!-- Heading -->
			<div class="sidebar-heading">
				User
			</div>

			<!-- Nav Item - Charts -->
			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('user') ?>">
					<i class="fas fa-home"></i>
					<span>Home</span></a>

			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('user/reservasi') ?>">
					<i class="fas fa-calendar-week"></i>
					<span>Reservasi</span></a>

			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('user/menu') ?>">
					<i class="fas fa-utensils"></i>
					<span>Menu</span></a>

			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('user/member/daftar') ?>">
					<i class="fas fa-gift"></i>
					<span>Halaman Member</span></a>

			<li class="nav-item">
				<a class="nav-link" href="charts.html">
					<i class="fas fa-user"></i>
					<span>Profile</span></a>

				<!-- Divider -->
				<hr class="sidebar-divider d-none d-md-block">

				<!-- Sidebar Toggler (Sidebar) -->
				<div class="text-center d-none d-md-inline">
					<button class="rounded-circle border-0" id="sidebarToggle"></button>
				</div>

		</ul>
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Topbar -->
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

					<!-- Sidebar Toggle (Topbar) -->
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
						<i class="fa fa-bars"></i>
					</button>

					<!-- Topbar Search -->
					<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-md-0 mw-100 navbar-search">
						<div class="input-group">
							<input type="text" class="form-control bg-light border-0 small" placeholder="Search" aria-label="Search">
							<div class="input-group-append">
								<button class="btn btn-warning" type="button">
									<i class="fas fa-search fa-sm"></i>
								</button>
							</div>
						</div>
					</form>


					<!-- Topbar Navbar -->
					<ul class="navbar-nav ml-auto">

						<!-- Nav Item - Alerts -->
						<li class="nav-item dropdown no-arrow mx-1">
							<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-bell fa-fw"></i>
								<!-- Counter - Alerts -->
								<span class="badge badge-danger badge-counter">3+</span>
							</a>
							<!-- Dropdown - Alerts -->
							<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
								<h6 class="dropdown-header">
									Alerts Center
								</h6>
								<a class="dropdown-item d-flex align-items-center" href="#">
									<div class="mr-3">
										<div class="icon-circle bg-primary">
											<i class="fas fa-money-bill-wave text-white"></i>
										</div>
									</div>
									<div>
										<div class="small text-gray-500">15 Juni 2021</div>
										<span class="font-weight-bold">Special Price untuk K-Food khusus di bulan Juni!</span>
									</div>
								</a>
								<a class="dropdown-item d-flex align-items-center" href="#">
									<div class="mr-3">
										<div class="icon-circle bg-success">
											<i class="fas fa-exclamation text-white"></i>
										</div>
									</div>
									<div>
										<div class="small text-gray-500">17 Juni 2021</div>
										Event NCT RESONANCE by NCTZENINA sedang berlangsung!
									</div>
								</a>
								<a class="dropdown-item d-flex align-items-center" href="#">
									<div class="mr-3">
										<div class="icon-circle bg-warning">
											<i class="fas fa-coffee text-white"></i>
										</div>
									</div>
									<div>
										<div class="small text-gray-500">18 Juni 2021</div>
										Jangan lewatkan promo minuman spring day up to 10%!
									</div>
								</a>
								<a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
							</div>
						</li>

						<?php if (count($this->session->userdata())): ?>
							<li class="nav-item dropdown no-arrow mx-1">
								<a class="nav-link dropdown-toggle" href="<?= base_url()."user/keranjang" ?>">
									<i class="fa fa-shopping-cart"></i>
									<!-- Counter - Alerts -->
									<span class="cart-counter badge badge-danger badge-counter">0</span>
								</a>
							</li>
						<?php endif ?>

						<div class="topbar-divider d-none d-sm-block"></div>

						<!-- Nav Item - User Information -->
						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user['nama']; ?></span>
								<img class="img-profile rounded-circle" src="<?= base_url('assets/img/profile/') . $user['image']; ?>">
							</a>
							<!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="<?= base_url()."user/riwayat-transaksi" ?>">
									Riwayat Transaksi
								</a>
								<a class="dropdown-item" href="#">
									My Profile
								</a>
								<a class="dropdown-item" href="#">
									Settings
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?= base_url('auth/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
									Logout
								</a>
							</div>
						</li>

					</ul>
					
				</nav>
				<!-- End of Topbar -->