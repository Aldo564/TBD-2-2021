<!DOCTYPE html>
<html lang="zxx" class="js">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Softnio">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="ICO Crypto is a modern and elegant landing page, created for ICO Agencies and digital crypto currency investment website.">
	<!-- Fav Icon  -->
	<link rel="shortcut icon" href="../images/favicon.png">
	<!-- Site Title  -->
	<title>YutuDBD</title>
	<!-- Vendor Bundle CSS -->
	<link rel="stylesheet" href="{{ asset('../assets/css/vendor.bundle.css?ver=142') }}">
	<!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/style.css?ver=142') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/theme.css?ver=142') }}">

</head>

<body class="theme-dark" data-spy="scroll" data-target="#mainnav" data-offset="80">

	<!-- Header -->
	<header class="site-header is-sticky">
		<!-- Navbar -->
		<div class="navbar navbar-expand-lg is-transparent" id="mainnav">
			<nav class="container">
				<a class="navbar-brand animated" data-animate="fadeInDown" data-delay=".65" href="{{ url('/') }}">
					<img class="logo logo-dark" alt="logo" src="../images/logoYutu.png" srcset="../images/logoYutu.png 2x">
					<img class="logo logo-light" alt="logo" src="../images/logoYutu.png" srcset="../images/logoYutu.png 2x">
				</a>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle">
					<span class="navbar-toggler-icon">
						<span class="ti ti-align-justify"></span>
					</span>
				</button>

				<div class="collapse navbar-collapse justify-content-end" id="navbarToggle">
					<ul class="navbar-nav animated" data-animate="fadeInDown" data-delay=".9">
						<li class="nav-item"><a class="nav-link menu-link" href="{{ url('/') }}#blogs">Catalogue</a></li>
						@if (session('user') != NULL)
							<li class="nav-item"><a class="nav-link menu-link">Welcome!</a></li>
						@endif
						<!--<li class="nav-item"><a class="nav-link menu-link" href="#partners">Categories</a></li>
						<li class="nav-item"><a class="nav-link menu-link" href="#partners">Lists</a></li>-->
					</ul>
                    @if (session('user') == NULL)
					<ul class="navbar-nav navbar-btns animated" data-animate="fadeInDown" data-delay="1.15">
						<li class="nav-item"><a class="nav-link btn btn-sm btn-outline menu-link" href="{{url('/s')}}">Sign Up</a></li>
						<li class="nav-item"><a class="nav-link btn btn-sm btn-outline menu-link" href="{{url('/login')}}">Log in</a></li>
					</ul>
                    @else
                    <ul class="navbar-nav navbar-btns animated" data-animate="fadeInDown" data-delay="1.15">
						<li class="nav-item"><a class="nav-link btn btn-sm btn-outline menu-link" href="{{ url('/profile') }}">My Profile</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-sm btn-outline menu-link" href="{{ url('/logout') }}">Log out</a></li>
					</ul>
                    @endif
				</div>
			</nav>
		</div>
		<!-- End Navbar -->

		<!-- Banner -->
		<div id="header" class="page-banner d-flex align-items-center">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="page-head">
							<h2 class="page-heading">Here's <del>Johnny</del> {{ session('user')->nickname }} !!</h2>
						</div>
					</div>
					<div class="page-head-image">
						<img src="../images/3d-glasses1.png" alt="page-head" style="width:80%; padding-left: 20%;">
					</div>
				</div>
			</div><!-- .container  -->
		</div>
		<!-- End Banner -->
	</header>
	<!-- End Header -->


	<!-- Start Section -->
	<div class="section section-pad-md section-bg-alt blog-section" id="news">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="blog-content">
						<div class="blog-photo" style="width: 50%; margin-top: -110px;">
							<img src="../images/Gigachad.jpg" alt="blog-large">
						</div>
						<form action="/profile" method="POST" class="login-form">
							@method('PUT')
							@csrf
							<div class="input-item">
            		<input type="text" name="nickname" placeholder="{{ session('user')->nickname }}" class="input-line-simple" style="color:aliceblue">
	            </div>

							<div class="input-item">
	            	<input type="text" placeholder="{{ session('user')->edad }}" class="input-line-simple" disabled style="color:aliceblue">
	            </div>

							<div class="input-item">
	            	<input type="text" placeholder="{{ session('user')->fecha_nacimiento }}" class="input-line-simple" disabled style="color:aliceblue">
	            </div>

	            <div class="input-item">
	                <input type="text" name="email" placeholder="{{ session('user')->email }}" class="input-line-simple" style="color:aliceblue">
	            </div>

	            <div class="input-item">
	                <input type="password" name="confirmacion_contrasenia" placeholder="Enter old password" class="input-line-simple" style="color:aliceblue">
							</div>

							<div class="input-item">
	                <input type="password" name="contrasenia_nueva" placeholder="Enter new password" class="input-line-simple" style="color:aliceblue">
							</div>

	            <div class="text-center">
	                <button class="btn btn-sm" type="submit">Update Info</button>
	            </div>
	      		</form>
				</div><!-- .col -->



			</div><!-- .row -->
			<div class="col-lg-4">
					<!-- Categorias -->
					<div class="sidebar-section">
						<div class="sidebar-widget category">
							<h5 class="sidebar-widget-title">Actions</h5>
							<ul>
								<li><a href="{{ url('/uploadVideo') }}">Upload a video</a></li>
								<li><a href="{{ url('/myLists') }}">My lists</a></li>
								<li><a href="{{url('/mv')}}">My videos</a></li>
								<li><a href="#">Change My Location</a></li>
								<li><a href="{{ url('/getHistory/'.session('user')->id) }}">Video History</a></li>
								<li><a href="{{ url('/getChannels/'.session('user')->id) }}">Channels following</a></li>
							</ul>
						</div><!-- .sidebar-widget -->
					</div><!-- .sidebar-section -->

				</div><!-- .col -->
		</div><!-- .container -->
	</div>
	<!-- Start Section -->

	<div style="height: 70px;">

	</div>

	<!-- Start Section -->
	<div class="section footer-scetion no-pt section-pad-sm section-bg" style="margin-bottom: -120px;">
		<div class="container">
			<div class="row text-center">
				<div class="col-md-12">
					<span class="copyright-text">
						Copyright &copy; 2018, ICO Crypto. Template Made By <a href="http://softnio.com" target="_blank">Softnio</a> &amp; Handcrafted by iO.
						<span>All trademarks and copyrights belong to their respective owners.</span>
					</span>
				</div>
			</div>
		</div>
	</div>
	<!-- End Section -->

	<!-- Preloader !remove please if you do not want -->
	<div id="preloader">
		<div id="loader"></div>
		<div class="loader-section loader-top"></div>
   		<div class="loader-section loader-bottom"></div>
	</div>
	<!-- Preloader End -->

	<!-- JavaScript (include all script here) -->
	<script src="../assets/js/jquery.bundle.js?ver=142"></script>
	<script src="../assets/js/script.js?ver=142"></script>

</body>
</html>
