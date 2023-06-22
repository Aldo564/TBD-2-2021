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

<header class="site-header is-sticky">

    <!-- Place Particle Js -->
    <div id="particles-js" class="particles-container particles-js"></div>

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

    <div class="user-page d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8 col-sm-8 text-center">
                    <div class="user-page-box">
                        <div class="user-logo">
                            <a href="#">
                                <img src="../images/logoYutu.png" style="width: 100%;" srcset="images/logoYutu.png 2x" alt="icon">
                            </a>
                        </div>
                        <h5>Create an account</h5>
                        <span class="small-heading">The first rule about fight club is you don't talk about fight club.</span>


                        <form method= "POST" action="{{action('UserController@store')}}">
                            <div class="input-item">
                                <input style="color:#6c757d" type="text" placeholder="Your Nickname" class="input-line-simple" name="nickname" id="nickname" value=""  required>
                            </div>
                            <div class="input-item">
                                <input style="color:#6c757d" type="date" placeholder="Your Birthday" class="input-line-simple" name="fecha_nacimiento" id="fecha_nacimiento" value="" >
                            </div>
                            <div class="input-item">
                                <input style="color:#6c757d" type="text" placeholder="Your Email" class="input-line-simple" name="email" id="email" value="" >
                            </div>
                            <label>Select a Location</label>
                                <select style="color:#6c757d" class="form-select" id="id_comuna" name="id_comuna">
                                    @foreach($commune as $com)
                                        <option value="{{$com->id}}"> {{ $com->nombre_comuna}} </option>
                                    @endforeach
                                </select>
                            <div class="input-item">
                                <input style="color:#6c757d" type="password" placeholder="Password" class="input-line-simple" name="contrasenia" id="contrasenia" value="" >
                            </div>
                            <button class="btn btn-sm" type= "submit">Sign Up</button>
                        </form>
                    </div>
                    <div class="gaps size-2x"></div>
                    <div class="form-note">
                        Already have an account? <a href="login">log in here!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
