<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta
		  name="viewport"
		  content="
		    width=device-width,
		    initial-scale=1,
		    minimum-scale=1,
		    maximum-scale=1
		  "
		/>
		
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<!-- Link to GoogleFonts -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin' rel='stylesheet' type='text/css'>
		<!-- End Link to GoogleFonts -->
		
		<!-- Glyphs Font : FontAwesome -->
		<!--<link rel="stylesheet" href="resources/css/font-awesome.min.css"> -->
		{{ HTML::style('css/font-awesome.css') }}
		{{ HTML::style('packages/bootstrap/css/bootstrap.min.css') }}
		<!--[if IE 7]>
		<link rel="stylesheet" href="resources/css/font-awesome-ie7.min.css">
		<![endif]-->
		<!-- End Glyphs Font : FontAwesome -->
		
		<!-- General CSS -->
		{{ HTML::style('css/reset-min.css') }}
		{{ HTML::style('css/unsemantic-grid-responsive.css') }}
		<!--<link href="resources/css/reset-min.css" type="text/css" rel="stylesheet">
		<link href="resources/css/unsemantic-grid-responsive.css" type="text/css" rel="stylesheet"> -->
		<!-- End General CSS -->
		
		<!-- Components.css -->

		{{ HTML::style('css/components.css') }}
		{{ HTML::style('css/font-awesome.min.css') }}
		{{ HTML::style('css/style.css') }}
		{{ HTML::style('css/docs.css') }}
		{{ HTML::style('packages/bootstrap/css/bootstrap-social.css') }}
		<!--<link href="resources/css/components.css" type="text/css" rel="stylesheet">-->
		<!-- End Components.css -->
		<!-- Style -->
		<!--<link href="resources/css/style.css" type="text/css" rel="stylesheet">-->
		<!-- End Style -->
		

		
		<!-- jQuery -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<!-- End jQuery -->
		
		{{HTML::script('js/jquery.scrollTo-1.4.3.1-min.js')}}
		{{HTML::script('js/jquery.placeholder.min.js')}}
		{{HTML::script('js/swipe.js')}}
		{{HTML::script('js/docs.js')}}

		<!-- Scroll to JS -->
		<!--<script type="text/javascript" src="resources/js/jquery.scrollTo-1.4.3.1-min.js"></script>-->
		<!-- End Scroll to JS -->
		
		<!-- Placeholders JS for IE -->
		<!--<script src="resources/js/jquery.placeholder.min.js"></script>-->
		<!-- End Placeholders JS for IE -->
		
		<!-- Swipe -->
		<!--<script src='resources/js/swipe.js'></script> -->
		<!-- End Swipe -->
		
		<script type="text/javascript">
		$(document).ready(function() {
			
			$('#menu-button').toggle(function() {
				$('#menu').animate({
					marginTop: '+=10',
					height: '100%',
					opacity: 1
				}, 300, function() {
					// Animation complete.
				});
			}, function() {
				$('#menu').animate({
					marginTop: '-=10',
					opacity: 0,
					height: '0px'
				}, 300, function() {
					// Animation complete.
				});
			});
			
		});
		</script>
	</head>

	<body>

	<!-- Top menu/logo wrapper -->
	<div id="top-wrapper" class="cyan">
		<div class="grid-container">
			<header class="grid-20 mobile-grid-100">
				<p id="logo">Adwiser</p>
				<p id="menu-button" class="hide-on-desktop"><i class="icon-reorder"></i></p>
			</header>
				    
			<nav class="grid-80 mobile-grid-100">
				<ul id="menu">
					<li><a href="/home">Go to Adwiser</a></li>
				</ul>
			</nav>
		</div>
	</div>
	<!-- End Top menu/logo wrapper -->

	<section>

	<div class="colored-stripe whitesmoke">
		<div class="grid-container">
			<div class="grid-100 grid-parent paragraphs-container">
				<div class="grid-50" id="introduction">
					<div class="white" style="padding: 10px;">
						<h1>Welcome to Adwiser</h1>
						<h3>Seek advice for just about everything</h3>
						<p>
							Adwiser helps you get the best answers for your questions
						</p><br/><br/>
						<a class="btn btn-block btn-social btn-twitter" href="/users/logintwitter">
						    <i class="fa fa-twitter"></i> Sign in with Twitter
						</a>
						<a class="btn btn-block btn-social btn-facebook" href="/users/loginfacebook">
						    <i class="fa fa-facebook"></i> Sign in with Facebook
						</a>
						<a class="btn btn-block btn-social btn-google-plus" href="/users/logingoogle">
						    <i class="fa fa-google-plus"></i> Sign in with Google+
						</a>

					</div>
					
				</div>
				<div class="grid-50">
					{{ Form::open(array('url' => 'users/login', 'method' => 'post', 'class' => 'white', 'id' => 'login'  )) }}
					<!--<form id="login" class="white" action="http://localhost:8000"> -->
						<input type="text" name="username" class="form-control" placeholder="Username" required/>
						<input type="password" name="password" class="form-control" placeholder="Password" required/>
						<input type="checkbox" id="remember" name="remember"/>Remember me?
						<input type="submit" value="Sign in" class="btn-primary" />
					{{Form::close()}}
					{{ Form::open(array('url' => 'signup', 'method' => 'post', 'class' => 'white', 'id' => 'signup')) }}
					<!--<form id="signup" class="white"> -->
						<h3>First time here? Sign up</h3>
						<input type="text" name="fullname" class="form-control" placeholder="Full name" />
						<input type="text" name="username-signup" class="form-control" placeholder="Username" />
						<input type="password" name="password-signup" class="form-control" placeholder="Password" />
						<input type="submit" value="Sign up" class="btn-primary" />
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>

	<!-- Four Paragraphs -->
	
	<!-- End Four Paragraphs -->
	</section>
	<footer class="darkgrey">
		<nav>
			<ul id="footer-ul">
				<li><a href="terms">Terms</a></li>
				<li><a href="privacy">Privacy</a></li>
				<li><a href="about">About</a></li>
				<li><a href="contact">Contact</a></li>
			</ul><br/>
			</nav>
			Copyright &copy 2013 Adwiser. All rights reserved.
		</footer>
	</body>
</html>