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

<body class="theme-dark is-smooth-effect" data-spy="scroll" data-target="#mainnav" data-offset="80">

	<!-- Header -->
	<header class="site-header is-sticky">

		<!-- Place Particle Js -->
		<div id="particles-js" class="particles-container particles-js"></div>

		<!-- Navbar -->
		<div class="navbar navbar-expand-lg is-transparent" id="mainnav">
			<nav class="container">
				<a class="navbar-brand animated" data-animate="fadeInDown" data-delay=".65" href="/">
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
						<li class="nav-item"><a class="nav-link menu-link" href="#blogs">Catalogue</a></li>
						@if (session('user') != NULL)
						<li class="nav-item"><a class="nav-link menu-link">Welcome!</a></li>
						@endif
						<!--<li class="nav-item"><a class="nav-link menu-link" href="#partners">Categories</a></li>
						<li class="nav-item"><a class="nav-link menu-link" href="#partners">Lists</a></li>-->
					</ul>
          @if (session('user') == NULL)
						<ul class="navbar-nav navbar-btns animated" data-animate="fadeInDown" data-delay="1.15">
							<li class="nav-item"><a class="nav-link btn btn-sm btn-outline menu-link" href="{{url('/s')}}">Sign Up</a></li>
							<li class="nav-item"><a class="nav-link btn btn-sm btn-outline menu-link" href="login">Log in</a></li>
						</ul>
          @else
          	<ul class="navbar-nav navbar-btns animated" data-animate="fadeInDown" data-delay="1.15">
							<li class="nav-item"><a class="nav-link btn btn-sm btn-outline menu-link" href="profile">My Profile</a></li>
              <li class="nav-item"><a class="nav-link btn btn-sm btn-outline menu-link" href="logout">Log out</a></li>
						</ul>
          @endif
				</div>
			</nav>
		</div>
		<!-- End Navbar -->

		<!-- Banner/Slider -->
		<div id="header" class="banner banner-curb banner-particle d-flex align-items-center">
			<div class="container">
				<div class="banner-content">
					<div class="row align-items-center mobile-center">
						<div class="col-lg-6 col-md-12 order-lg-first">
							<div class="header-txt">
								<h1 class="animated" data-animate="fadeInUp" data-delay="1.55">{{$mensaje ?? ''}}</h1>
								<p class="lead color-secondary animated" data-animate="fadeInUp" data-delay="1.65">Powered by DEBEDE</p>
								@if (session('user') == NULL)
								<ul class="btns animated" data-animate="fadeInUp" data-delay="1.75">
									<li><a href="{{url('/s')}}" class="btn">Sign up to Join</a></li>
									<li><a href="login" class="btn">Log in</a></li>
								</ul>
								@endif
							</div>
						</div><!-- .col  -->
						<div class="col-lg-6 col-md-12 order-first">
							<div class="header-image animated left-icon" data-animate="fadeInRight" data-delay="1.25">
								<img src="../images/header-image-dark.png" alt="header">
								<img class="header-image-icon left-icon" src="../images/movie1.png" alt="header-icon">
								<img class="header-image-icon right-icon" src="../images/asd1.png" alt="header-icon">
							</div>
						</div><!-- .col  -->
					</div><!-- .row  -->
				</div><!-- .banner-content  -->
			</div><!-- .container  -->
		</div>
		<!-- End Banner/Slider -->
	</header>
	<!-- End Header -->

	<!-- Start Section -->
	<div class="section section-pad section-bg-dark blog-section" id="blogs">
		<div class="container">
			<div class="row text-center">
				<div class="col">
					<div class="section-head">
						<h2 class="section-title animated" data-animate="fadeInUp" data-delay="0">Movies & Series<span>Videos</span></h2>
					</div>
				</div>
			</div><!-- .row -->

			<div class="row">
				
                <form method="GET" action="{{ action('HomeController@sortByCategory') }}">
                    <label>Filter by Categories</label>
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="id_categoria" id="id_categoria">
                        @foreach($category as $cate)
                            <option value="{{ $cate->id }}"> {{ $cate->nombre }}</option>
                        @endforeach
                    </select>

                    <br><br><button type="submit" class="btn btn-primary">Apply Filter</button>
                </form>

                <div class="col-lg-5"></div>
                <form method="GET" action="{{ action('HomeController@sortByUser') }}">
                    <label>Filter by Users</label>
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="nickname">
                        @foreach($user as $us)
                            <option value="{{ $us->nickname }}"> {{ $us->nickname }}</option>
                        @endforeach
                    </select>

                    <br><br><button type="submit" class="btn btn-primary">Apply Filter</button><br><br>
                </form>

				<form method="GET" action="{{ action('HomeController@sortByViews') }}">
                    <label>Order by Views</label>
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="order" id="order">
                        <option value="desc">Overrated First</option>
						<option value="asc">Underrated First</option>
                    </select>

                    <br><br><button type="submit" class="btn btn-primary">Apply Order</button><br><br>
                </form>


				<div class="col-lg-8"></div>
				<form method="GET" action="{{ url('/') }}">
					<br><button type="submit" class="btn btn-primary">Delete Filter</button><br><br>
				</form>
            </div>

			@if (session('user') != NULL)
				<div class="blog-list"> <!-- rellenar con sinopsises de la bd-->
				@if(!empty($filtro_cate))
					<label>Categoría: {{ $filtro_cate->nombre }}</label><br><br>
				@elseif(!empty($filtro_user))
					<label>Usuario: {{ $filtro_user->nickname }}</label><br><br>
				@endif
					
					<div class="row">
					@foreach($synopse as $syn)
						@if(count($synopse) == 1)
							<div class="col-lg-6 offset-lg-0 col-sm-8 offset-sm-2 "><!-- .col -->
								<div class="blog-item animated" data-animate="fadeInUp" data-delay="0">
									<div class="blog-photo"><a href="{{ url('showMovie/'.$syn->id) }}"><img src="{{ $syn->link_imagen }}" alt="blog-photo"></a></div>
										<div class="blog-texts">
											<ul class="blog-meta">
												<li><a href="{{ url('showMovie/'.$syn->id) }}">{{ $syn->fecha_creacion }}</a></li><!-- quien lo subió-->
											</ul>
											<h5 class="blog-title" ><a href="{{ url('showMovie/'.$syn->id) }}">{{ $syn->titulo_video }}</a></h5> <!-- titulo-->
										</div>
								</div>
							</div><!-- .col -->
						@else
							<div class="col-lg-4 offset-lg-0 col-sm-8 offset-sm-2 "><!-- .col -->
								<div class="blog-item animated" data-animate="fadeInUp" data-delay="0">
									<div class="blog-photo"><a href="{{ url('showMovie/'.$syn->id) }}"><img src="{{ $syn->link_imagen }}" alt="blog-photo"></a></div>
										<div class="blog-texts">
											<ul class="blog-meta">
												<li><a href="{{ url('showMovie/'.$syn->id) }}">{{ $syn->fecha_creacion }}</a></li><!-- quien lo subió-->
											</ul>
											<h5 class="blog-title" ><a href="{{ url('showMovie/'.$syn->id) }}">{{ $syn->titulo_video }}</a></h5> <!-- titulo-->
										</div>
								</div>
							</div><!-- .col -->
						@endif
					@endforeach
					</div><!-- .row -->
				</div><!-- .blog-list -->
			@else 
			
				<div class="blog-list"> <!-- rellenar con sinopsises de la bd-->
				@if(!empty($filtro_cate))
					<label>Categoría: {{ $filtro_cate->nombre }}</label><br><br>
				@elseif(!empty($filtro_user))
					<label>Usuario: {{ $filtro_user->nickname }}</label><br><br>
				@endif
					
					<div class="row">
					@foreach($synopse as $syn)
							@if(count($synopse) == 1)
								
									<div class="col-lg-6 offset-lg-0 col-sm-8 offset-sm-2 "><!-- .col -->
										<div class="blog-item animated" data-animate="fadeInUp" data-delay="0">
											<div class="blog-photo"><a href="{{ url('mGuest/'.$syn->id) }}"><img src="{{ $syn->link_imagen }}" alt="blog-photo"></a></div>
												<div class="blog-texts">
													<ul class="blog-meta">
														<li><a href="{{ url('/mGuest/'.$syn->id) }}">{{ $syn->fecha_creacion }}</a></li><!-- quien lo subió-->
													</ul>
													<h5 class="blog-title" ><a href="{{ url('/mGuest/'.$syn->id) }}">{{ $syn->titulo_video }}</a></h5> <!-- titulo-->
												</div>
										</div>
									</div><!-- .col -->
									
							@else
								<div class="col-lg-4 offset-lg-0 col-sm-8 offset-sm-2 "><!-- .col -->
									<div class="blog-item animated" data-animate="fadeInUp" data-delay="0">
										<div class="blog-photo"><a href="{{ url('mGuest/'.$syn->id) }}"><img src="{{ $syn->link_imagen }}" alt="blog-photo"></a></div>
											<div class="blog-texts">
												<ul class="blog-meta">
													<li><a href="{{ url('mGuest/'.$syn->id) }}">{{ $syn->fecha_creacion }}</a></li><!-- quien lo subió-->
												</ul>
												<h5 class="blog-title" ><a href="{{ url('mGuest/'.$syn->id) }}">{{ $syn->titulo_video }}</a></h5> <!-- titulo-->
											</div>
									</div>
								</div><!-- .col -->
							@endif
						
					@endforeach
					</div><!-- .row -->
				</div><!-- .blog-list -->
			@endif

		</div><!-- .container -->
	</div>
	<!-- Start Section -->

	<!-- Start Section -->
	<div class="section footer-scetion no-pt section-pad-sm section-bg">
		<div class="container">
			<div class="row text-center">
				<div class="col-md-12">
					<span class="copyright-text animated" data-animate="fadeInUp" data-delay=".3">
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
    <script>
        document.onmouseover = function() {
            //User's mouse is inside the page.
            window.innerDocClick = true;
        }

        document.onmouseleave = function() {
            //User's mouse has left the page.
            window.innerDocClick = false;
        }

        window.onhashchange = function() {
            if (not(window.innerDocClick) && (window.location === 'http://127.0.0.1:8000/verificatorLogin' || window.location === 'http://127.0.0.1:8000/Rlogout')) {
                //Your own in-page mechanism triggered the hash change
                function redireccionar(){
                    window.locationf="/Rlogout";
                    }
                setTimeout ("redireccionar()", 100);

            } else {
                //Browser back button was clicked

            }
        }
    </script>
</body>
</html>
