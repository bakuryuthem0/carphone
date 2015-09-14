<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ $title }}</title>
	{{ HTML::style('css/bootstrap.min.css') }}
	{{ HTML::style('css/prettyPhoto.css') }}
	{{ HTML::style('css/price-range.css') }}
	{{ HTML::style('css/animate.css') }}
	{{ HTML::style('css/main.css') }}
	{{ HTML::style('css/responsive.css') }}
	{{ HTML::style('css/custom.css') }}
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="{{ asset('images/ico/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/ico/apple-touch-icon-57-precomposed.png') }}">
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top bg-info"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> Telefono</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> email@domain.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-md-4">
						<div class="logo pull-left">
							<a href="index.html"><img src="images/home/logo.png" alt="" /></a>
						</div>
						<div class="btn-group pull-right">
						</div>
					</div>
					<div class="col-md-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								@if(Auth::check())
									<li><a href="#"><i class="fa fa-star"></i> Lista de Deseos</a></li>
									<li><a href="cart. html"><i class="fa fa-shopping-cart"></i> Carrito</a></li>
									<li><a href="checkout.html"><i class="fa fa-crosshairs"></i> Pagar</a></li>
									<li><a href="{{ URL::to('cerrar-sesion') }}"><i class="fa fa-sign-out"></i> Cerrar Sesión</a></li>
								@else
									<li><a href="{{ URL::to('registrarse') }}"><i class="fa fa-user"></i> Registrarse</a></li>
									<li><a href="#!" data-toggle="modal" data-target="#myModal"><i class="fa fa-sign-in"></i> Login</a></li>
								@endif

							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-md-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.html" class="active">Inicio</a></li>
								<li class="dropdown">
									<a href="#">Tiendas<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="shop.html">Carrors</a></li>
										<li><a href="{{ URL::to('telefonos') }}">Telefonos</a></li> 
										@if(Auth::check())
											<li><a href="checkout.html">Checkout</a></li> 
											<li><a href="cart.html">Cart</a></li> 
										@else
											<li><a href="#!" data-toggle="modal" data-target="#myModal">Login</a></li> 
										@endif
                                    </ul>
                                </li> 
								
								<li><a href="contact-us.html">Contact</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-3">
						<div class="search_box pull-right">
							<div class="input-group">
							  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
							  <input type="text" class="input form-control" placeholder="Buscar" aria-describedby="basic-addon1">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	@yield('content');
	
	<footer id="footer" class="bg-info"><!--Footer-->
				
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-md-2">
						<div class="single-widget">
							<h2>Service</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Online Help</a></li>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">Order Status</a></li>
								<li><a href="#">Change Location</a></li>
								<li><a href="#">FAQ’s</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-2">
						<div class="single-widget">
							<h2>Quock Shop</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">T-Shirt</a></li>
								<li><a href="#">Mens</a></li>
								<li><a href="#">Womens</a></li>
								<li><a href="#">Gift Cards</a></li>
								<li><a href="#">Shoes</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-2">
						<div class="single-widget">
							<h2>Policies</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Terms of Use</a></li>
								<li><a href="#">Privecy Policy</a></li>
								<li><a href="#">Refund Policy</a></li>
								<li><a href="#">Billing System</a></li>
								<li><a href="#">Ticket System</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-2">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Company Information</a></li>
								<li><a href="#">Careers</a></li>
								<li><a href="#">Store Location</a></li>
								<li><a href="#">Affillate Program</a></li>
								<li><a href="#">Copyright</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-3 col-md-offset-1">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<form action="#" class="searchform form-inline">
								<div>
									<div class="form-group">
										<input type="text" placeholder="Your email address" / class="input form-control">
									</div>
									<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								</div>
								<p>Get the most recent updates from <br />our site and be updated your self...</p>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
					<p class="pull-right">Creado por <span><a target="_blank" href="http://tecnographic.com.ve">Tecnographic Venezuela</a></span></p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
@if(!Auth::check() && $title != "Iniciar Sesión | Nombre")
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content contDeColor">
				<div class="login-form"><!--login form-->
				<legend><h2>Inicie Sesion en su cuenta</h2></legend>
				@if(Session::has('success'))
				<div class="alert alert-success">
					<p>{{ Session::get('success') }}</p>
				</div>
				@endif
				<div class="alert responseAjax">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				</div>
				<fieldset>
					<label for="">Usuario</label>
					<input type="text" placeholder="Usuario" class="login-input form-control username">
				</fieldset>
				<br>
				<fieldset>
					<input type="password" placeholder="Contraseña" class="login-input form-control password">
				</fieldset>
				<span class="checkbox">
					<input type="checkbox" class="checkbox checkbox-login">
					Recordar
				</span>
				<button type="submit" class="btn btn-default login">Login</button>
				<br>
				<br>
				<a href="{{ URL::to('registrarse') }}">¿No Tienes cuenta? Registrate</a>
				<br>
				<a href="">¿Olvidaste tu contraseña?</a>
				</div><!--/login form-->
			</div>
		</div>
	</div>
@endif
	</div>
  
	{{ HTML::script('js/jquery.js') }}
	{{ HTML::script('js/bootstrap.min.js') }}
	{{ HTML::script('js/jquery.scrollUp.min.js') }}
	{{ HTML::script('js/price-range.js') }}
	{{ HTML::script('js/jquery.prettyPhoto.js') }}
	{{ HTML::script('js/main.js') }}
	{{ HTML::script('js/custom.js') }}

</body>
</html>