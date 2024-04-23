<header class="site-header mo-left header-full header header-transparent {{ $bg_dark }}">
	<!-- Main Header -->
	<div class="sticky-header main-bar-wraper navbar-expand-lg">
		<div class="main-bar clearfix ">
			<div class="container-fluid">
				<div class="header-content-bx">
					<!-- website logo -->
					<div class="logo-header">
						<a href="{{ url('/') }}"><img src="{{ DzHelper::siteLogo() }}" alt="{{ __('Site Logo') }}"/></a>
					</div>
					<!-- Extra Nav -->
					<div class="extra-nav">
						<div class="extra-cell">
							<ul>
								<li class="search-btn">
									<a href="javascript:;" class="btn-link menu-icon">
										<div class="menu-icon-in">
											<span></span>
											<span></span>
											<span></span>
											<span></span>
										</div>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<!-- Main Nav -->
					<div class="header-nav navbar-collapse collapse justify-content-center nav-dark" id="navbarNavDropdown">
						{{ DzHelper::nav_menu(
						  	array(
						 		'theme_location'  => 'primary',
						 		'menu_class'      => 'nav navbar-nav',
						  	)
						  ); }}
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Main Header END -->
	<!-- Header Left -->
	<div class="header-nav navbar-collapse collapse full-sidenav content-scroll">
		<div class="location">
			<p><i class="fa fa-map-marker"></i>{{ __('Miami, Florida, USA') }}</p>
		</div>
		{{ DzHelper::nav_menu(
		  	array(
		 		'theme_location'  => 'expanded',
		 		'menu_class'      => 'nav navbar-nav',
		  	)
		  ); }}
		<div class="logo-header">
			<a href="{{ url('/') }}"><img src="{{ DzHelper::siteLogo() }}" alt="{{ __('Site Logo') }}"/></a>
		</div>
	</div>
	<div class="menu-close">
		<i class="la la-close"></i>
	</div>
	<!-- Header Left End -->
</header>