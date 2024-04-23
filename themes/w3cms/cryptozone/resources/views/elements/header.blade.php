<header class="site-header mo-left header header-transparent style-1">

	<!-- Main Header -->
	<div class="sticky-header main-bar-wraper navbar-expand-lg">
		<div class="main-bar clearfix">
			<div class="container clearfix">

				<!-- Website Logo -->
				<div class="logo-header">
					<a href="{{ url('/') }}" class="logo-dark"><img src="{{ DzHelper::siteLogo() }}" alt="{{ __('Dark theme site logo') }}"></a>
					<a href="{{ url('/') }}" class="logo-light"><img src="{{ theme_asset('images/logo-full-white.png') }}" alt="{{ __('light theme site logo') }}"></a>
				</div>
				
				<!-- Nav Toggle Button Strat -->
				<button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span></span>
					<span></span>
					<span></span>
				</button>
				<!-- Nav Toggle Button End -->
				
				<!-- Extra Nav Start -->
				<div class="extra-nav">
					<div class="extra-cell">
						<a class="btn btn-primary btn-gradient btn-shadow" target="_blank" href="{{ url('/contact') }}">{{ __('Contact Us') }}</a>
					</div>
				</div>
				<!-- Extra Nav End -->
					
				<div class="header-nav navbar-collapse collapse justify-content-end" id="navbarNavDropdown">
					
					<!-- Mobile Sidebar Logo -->
					<div class="logo-header mostion">
						<a href="{{ url('/') }}" class="logo-dark"><img src="{{ DzHelper::siteLogo() }}" alt="{{ __('Logo') }}" class="mw-100"></a>
					</div>
					
					<!-- Navbar nav -->
					{{ DzHelper::nav_menu(
					  	array(
					 		'theme_location'  => 'primary',
					 		'menu_class'      => 'nav navbar-nav navbar',
					  	)
					  ); }}
					
					<!-- Mobile Sidebar bottom -->
					<div class="header-bottom">
						<div class="dz-social-icon">
							<ul>
								<li><a target="_blank" class="fab fa-facebook-f" href="{{ config('Social.facebook') }}"></a></li>
								<li><a target="_blank" class="fab fa-twitter" href="{{ config('Social.twitter') }}"></a></li>
								<li><a target="_blank" class="fab fa-linkedin-in" href="{{ config('Social.linkedin') }}"></a></li>
								<li><a target="_blank" class="fab fa-instagram" href="{{ config('Social.instagram') }}"></a></li>
							</ul>
						</div>	
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
	<!-- Main Header End -->

</header>
