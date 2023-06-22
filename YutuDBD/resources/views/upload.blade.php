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
                        <h5>Create a video</h5>
                        <form method="POST" action="{{ route('createVideo') }}" class="login-form">
                            <div class="input-item">
                                <input type="text" placeholder="Title of the video" class="input-line-simple" required name="titulo_video" id="titulo_video" style="color:aliceblue">
                            </div>

                            <div class="input-item">
                                <input type="text" placeholder="Description" class="input-line-simple" required name="descripcion" id="descripcion" style="color:aliceblue">
                            </div>

                            <div class="input-item">
                                <input type="text" placeholder="video link" class="input-line-simple" required name="link_video" id="link_video" style="color:aliceblue">
                            </div>

                            <div class="input-item">
                                <input type="text" placeholder="url image" class="input-line-simple" name="link_imagen" id="link_imagen" style="color:aliceblue">
                            </div>

                            <div class="input-item text-left">
                                <input type="text" placeholder="Age restriction? (number)" class="input-line-simple" name="restriccion_edad" id="restriccion_edad" style="color:aliceblue">
                            </div>

							<label>Selecciona una categoría</label>
                    		<select class="form-select form-select-sm" aria-label=".form-select-sm example" name="id_categoria" id="id_categoria">
								<option value=""> null </option>
								@foreach($category as $cate)
                            		<option value="{{ $cate->id }}"> {{ $cate->nombre }}</option>
                        		@endforeach
                    				</select>

                            <div class="text-center">
                                <br><button class="btn btn-sm">Upload video</button>
                            </div>
                        </form>
                    </div>
                    <div class="gaps size-2x"></div>
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
