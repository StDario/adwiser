<!DOCTYPE html>
<html>
	<head>
		<title>Adwiser</title>
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
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin' rel='stylesheet' type='text/css'>
		{{ HTML::style('css/font-awesome.css') }}
		{{ HTML::style('packages/bootstrap/css/bootstrap.min.css') }}
		{{ HTML::style('css/components.css') }}
		{{ HTML::style('css/style.css') }}
		{{ HTML::style('css/reset-min.css') }}
		{{ HTML::style('css/unsemantic-grid-responsive.css') }}
		{{ HTML::style('css/docs.css') }}
		{{ HTML::style('packages/bootstrap/css/bootstrap-social.css') }}


		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<!-- End jQuery -->
		
		{{HTML::script('packages/bootstrap/js/bootstrap.min.js') }}
		{{HTML::script('js/bootstrap-datepicker.js')}}
		{{HTML::script('js/jquery.placeholder.min.js')}}
		{{HTML::script('js/angular.min.js')}}
		{{HTML::script('js/angular-route.min.js')}}
		{{HTML::script('js/angular-ui-router.min.js')}}
		{{HTML::script('js/angular-animate.min.js')}}
		{{HTML::script('js/docs.js')}}
		{{HTML::script('js/search.js')}}
		 {{HTML::script('js/index.js')}}
		
	{{ HTML::script('js/ui-bootstrap-0.9.0.min.js') }}
	{{ HTML::script('js/ui-bootstrap-tpls-0.9.0.min.js') }}


		@yield('scripts')

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
<div id="fb-root"></div>
	<script type="text/javascript">
			$(document).ready(function() {
			  $.ajaxSetup({ cache: true });
			  $.getScript('//connect.facebook.net/en_US/all.js', function(){
			    FB.init({
			      appId: '157980984393269',
			    });     
			    $('#loginbutton,#feedbutton').removeAttr('disabled');
			    FB.getLoginStatus(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
			  });
			});
		</script>
    

		<div id="top-wrapper" class="cyan" >
			<div class="grid-container">
				<header class="grid-20 mobile-grid-100 logo">
					<p id="logo">Adwiser</p>
					<p id="menu-button" class="hide-on-desktop"><i class="icon-reorder"></i></p>
				</header>
					    
				<nav class="grid-75 mobile-grid-100 navigation">
					<ul id="menu">
						@if(Auth::check())
						<li><a href="{{ URL::to('home')}}">Home</a></li>
						<li><a href="{{ URL::to('profile') }}">You</a></li>
						@endif
						<li class="li-search" ng-controller="SearchController" id="search-li">
							<form method="GET" action="/search-result">
							<input type="text" auto-complete id="search-input" 
									name="search-input" placeholder="Search Adwiser" class="form-control search" />
							</form>	
						</li>
						<script type="text/javascript">
							angular.bootstrap(document.getElementById('search-li'), ['search']);
						</script>
						@if(Auth::check())
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown">Extra</a>
							<ul class="dropdown-menu" role="menu">
								<li class="dropdown-li"><a class="dropdown-anchor" href="/profile">{{ Auth::user()->username }}</a></li>
								<li class="dropdown-li"><a class="dropdown-anchor" href="/reviews/create">Add review</a></li>
								<li class="dropdown-li"><a class="dropdown-anchor" href="/questions/create">Ask question</a></li>
								<li class="dropdown-li"><a class="dropdown-anchor" href="/logout">Logout</a></li>
							</ul>
						</li>
						@endif
					</ul>

				</nav>

			</div>
		</div>

		<section>
			<div class="colored-stripe whitesmoke">
				<div class="grid-container">
					@yield('content')
				</div>
			</div>
		</section>

		<footer class="darkgrey">
		<nav>
			<ul id="footer-ul">
				<li><a href="/terms">Terms</a></li>
				<li><a href="/privacy">Privacy</a></li>
				<li><a href="/about">About</a></li>
				<li><a href="contact">Contact</a></li>
			</ul><br/>
			</nav>
			Copyright &copy 2013 Adwiser. All rights reserved.
		</footer>


	</body>
</html>