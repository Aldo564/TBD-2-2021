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
    <link rel="stylesheet" type="text/css" href="{{ asset('../assets/css/style.css?ver=142') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('../assets/css/theme.css?ver=142') }}">
</head>

<body class="theme-dark is-smooth-effect" data-spy="scroll" data-target="#mainnav" data-offset="80">

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
							<h2 class="page-heading">Shh... ya va a comenzar la película</h2>
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
						<div class="blog-photo">
							<img src="{{$synopsis->link_imagen}}" alt="blog-large">
						</div>
						<ul class="blog-meta">
							@if(!empty($usera->id))
								<li><span>Posted by: </span><a href="{{url('profile/'.$usera->id)}}">{{ $usera->nickname }}</a></li>
							@else
								<li><span>Posted by: </span><a href="#">Usuario no encontrado</a></li>
							@endif
							<li><span>Posted: </span><a href="#">{{ $synopsis->fecha_creacion }}</a></li>

							@if(session('user')->edad < $synopsis->restriccion_edad)
								<li><span>{{ $likes }}</span><a href="#">Likes</a></li>
								<li><span>{{ $dislikes }}</span><a href="#">Dislikes</a></li>
							@else
								<li><span>{{ $likes }}</span><a href="{{ url('/like/'.$synopsis->id) }}">Likes</a></li>
								<li><span>{{ $dislikes }}</span><a href="{{ url('/dislike/'.$synopsis->id) }}">Dislikes</a></li>
							@endif
							<li><span>{{ $views }}</span><a href="#">Views</a></li>
						</ul>
						<h3 class="blog-title"><a href="#">{{$video->titulo}}</a></h3>
						<p>{{$synopsis->descripcion}}</p>

						<!-- categorias -->
						<ul class="blog-tags">
							@if(!empty($category))
								@foreach($category as $cate)
									<li>{{$cate -> nombre}}</li>
								@endforeach
							@endif
						</ul>
						<!--video-->
						@if (session('user') != NULL)
							@if(session('user')->edad >= $synopsis->restriccion_edad)
							<iframe width="1280" height="720" src="{{$video->link_video}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							@endif
						<br><br>
						<form method="POST" action="{{url('/addToList')}}">
							<h4>Add to a List</h4>
                                <select style="color:#6c757d" class="form-select" id="id_list" name="id_list">
								@if (session('user') != NULL)
									@foreach($lists as $ls)
                                        <option value="{{$ls->id}}"> {{$ls->Nombre}} </option>
                                    @endforeach
								@endif
                                </select>
								<input style="color:#6c757d" type="text" name="id_sinopsis" id="id_sinopsis" value="{{$synopsis->id}}" hidden>
								<br><br>
								<button class="btn btn-sm" type= "submit">Add to the List</button>
							</form>
						
						@endif
						<!-- comentarios-->
						@if(session('user')->edad >= $synopsis->restriccion_edad)
							<div class="comment-section">
								<h5>Comments</h5>
								<ol class="comment-list">
								@if(!empty($comment))
									@foreach($comment as $com)
										@foreach($usuarios as $us)
											@if($com -> id_usuario == $us->id)
												<li class="comment-item">
													<div class="d-flex">
														<div class="comment-photo">
															<img src="../images/team-c-sq.jpg" alt="commenter">
														</div>
														<div class="comment-content">
															<div class="d-flex align-items-center">
																<div>
																	<h6>{{ $us->nickname }}</h6>
																	<div class="comment-time">{{ $com->fecha }}</div>
																</div>
																<div class="ml-auto">
																	<a href="#" class="comment-reply"><em class="fa fa-retweet"></em>Reply</a>
																</div>
															</div>
															<p>{{ $com -> texto}}</p>
														</div>
													</div>
												</li>
											@endif
										@endforeach
									@endforeach
								@endif




								</ol>
								<h5>Leave A Comment</h5>

								<form class="form-message text-left" action="{{url('/comment/create')}}" method="POST">
									<div class="form-results"></div>
										
										<input type="text" class="d-none" id="id_sinopsis" name="id_sinopsis" value="{{$synopsis->id}}">
										
										<div class="input-field">
											<textarea name="texto" id="texto" class="input-line required" placeholder="Your comment"></textarea>
										</div>
										
										<div class="input-field">

										<button type="submit" class="btn">Submit</button>
									</div>
								</form>













							</div>
						@endif
					</div>






				</div><!-- .col -->
				<div class="col-lg-4">
					<!-- Categorias -->
					<div class="sidebar-section">
						<div class="sidebar-widget category">
							<h5 class="sidebar-widget-title">Category</h5>
							<ul>
								@foreach($category as $cate)
								<li><a href="#">{{ $cate->nombre }}</a></li>
								@endforeach
							</ul>
						</div><!-- .sidebar-widget -->
					</div><!-- .sidebar-section -->

				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->
	</div>
	<!-- Start Section -->


	<!-- Start Section -->
	<div class="section footer-scetion no-pt section-pad-sm section-bg">
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

	<!-- JavaScript (include all script here) -->
	<script src="../assets/js/jquery.bundle.js?ver=142"></script>
	<script src="../assets/js/script.js?ver=142"></script>

</body>
</html>
