<header class="site-header mo-left header style-1">
	<!-- main header -->
    <div class="sticky-header main-bar-wraper navbar-expand-lg">
        <div class="main-bar clearfix ">
            <div class="container">
				<div class="header-content-bx no-bdr">
					<!-- website logo -->
					<div class="logo-header d-inline-flex align-items-center">
						<a href="{{ url('/') }}"><img src="{{ DzHelper::siteLogo() }}" alt="{{ __('Site Logo') }}"/></a>
					</div>
					<!-- nav toggle button -->
					<button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
					</button>
					<!-- main nav -->
					<div class="header-nav navbar-collapse collapse justify-content-center" id="navbarNavDropdown">
						<div class="logo-header">
							<a href="{{ url('/') }}"><img src="{{ asset('images/logo-full-white.png') }}" alt="{{ __('Site Logo Full Image') }}"/></a>
						</div>
						{{ DzHelper::nav_menu(
						  	array(
						 		'theme_location'  => 'primary',
						 		'menu_class'      => 'nav navbar-nav',
						  	)
						  ); }}
						<div class="social-menu">
							<ul>
								<li><a target="_blank" class="fab fa-facebook-f" href="{{ config('Social.facebook') }}"></a></li>
                                <li><a target="_blank" class="fab fa-instagram" href="{{ config('Social.instagram') }}"></a></li>
                                <li><a target="_blank" class="fab fa-whatsapp" href="{{ config('Social.whatsapp') }}"></a></li>
                                <li><a target="_blank" class="fab fa-twitter" href="{{ config('Social.twitter') }}"></a></li>
							</ul>
						</div>
					</div>
					<div class="extra-nav">
						<div class="extra-cell">
							<ul>
								<li><a target="_blank" class="fab fa-facebook-f" href="{{ config('Social.facebook') }}" class="site-button-link"></a></li>
                                <li><a target="_blank" class="fab fa-instagram" href="{{ config('Social.instagram') }}" class="site-button-link"></a></li>
                                <li><a target="_blank" class="fab fa-whatsapp" href="{{ config('Social.whatsapp') }}" class="site-button-link" ></a></li>
                                <li><a target="_blank" class="fab fa-twitter" href="{{ config('Social.twitter') }}" class="site-button-link"></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
    <!-- main header END -->
</header>