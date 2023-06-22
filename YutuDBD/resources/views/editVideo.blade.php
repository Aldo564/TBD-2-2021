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
                        
                        <h5>Edit Video</h5>
                        <span class="small-heading">Change IS nature, dad, the part we can influence. And it all starts when we decide.</span>
						<div class="user-logo">
                            <a href="#">
                                <img src="{{$synopsis->link_imagen}}" style="width: 60%;"  alt="icon">

                            </a>
                        </div>





                        <form method="POST" action="{{url('/synopsis/update/'.$synopsis->id)}}">
							@method('PUT')
							<div class="input-item">
							<input style="color:#6c757d" type="text" placeholder="Title" class="input-line-simple" name="titulo_video" id="titulo_video" value=""  >
							</div>
							<div class="input-item">
								<input style="color:#6c757d" type="text" placeholder="Description" class="input-line-simple" name="descripcion" id="descripcion" value="" >
							</div>

							<div class="input-item">
								<input style="color:#6c757d" type="text" placeholder="Link Image" class="input-line-simple" name="link_imagen" id="link_imagen" value="" >
							</div>

							<div class="input-item">
								<input style="color:#6c757d" type="text" placeholder="Age restriction? (number)" class="input-line-simple" name="restriccion_edad" id="restriccion_edad" value="" >
							</div>

							
							<label>Category</label>
                                <select style="color:#6c757d" class="form-select" id="id_categoria" name="id_categoria" value="">
								<option value=""> Noup </option>
                                    @foreach($categorias as $cat)
                                        <option value="{{$cat->id}}"> {{ $cat->nombre}} </option>
                                    @endforeach
                                </select>
							
							<div class="input-item">
								<input style="color:#6c757d" type="text" placeholder="Link Video" class="input-line-simple" name="link_video" id="link_video" value="" >
							</div>
							
				

							<button class="btn btn-sm">Save Changes</button>
							
						</form>
						



						

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
