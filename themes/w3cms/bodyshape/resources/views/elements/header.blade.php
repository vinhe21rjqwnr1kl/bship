<header class="site-header mo-left header header-transparent style-1">

	<!-- Top Header -->
	<div class="top-bar">
		<div class="container">
			<div class="dz-topbar-inner d-flex justify-content-between align-items-center">
				<div class="dz-topbar-left">
					<ul>
						<li><i class="fa-regular fa-envelope"></i> {{ config('Site.email') }}</li>
					</ul>
				</div>
				<div class="dz-topbar-right">
					<ul>
						<li><i class="fa-regular fa-clock"></i> {{ config('Site.office_time') }}</li>
						<li><i class="fa fa-phone"></i> {{ config('Site.contact') }}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<!-- Main Header -->
	<div class="sticky-header main-bar-wraper navbar-expand-lg">
		<div class="main-bar clearfix">
			<div class="container clearfix">
				<div class="box-header clearfix">

					<!-- website logo -->
					<div class="logo-header mostion logo-dark">
						<a href="{{ url('/') }}"><img src="{{ DzHelper::siteLogo() }}" alt="{{ __('Site Logo') }}"/></a>
					</div>

					<!-- Nav Toggle Button -->
					<button class="navbar-toggler navbar-toggler-skew navbar-toggler navbar-toggler-skew-skew collapsed navicon justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
					</button>

					<!-- Extra Nav -->
					<div class="extra-nav">
						<div class="extra-cell">
							<button id="quik-search-btn" type="button" class="header-search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
							<a href="{{ url('/contact') }}" class="btn btn-primary btn-skew appointment-btn"><span>{{ __('Contact Us') }}</span></a>
						</div>
					</div>
					<!-- Extra Nav -->
					
					<!-- Search Form -->
					<div class="dz-quik-search">
						<form method="get" action="{{ route('permalink.search') }}">
							<input name="s" value="" type="text" class="form-control" placeholder="{{ __('Enter Your Keyword ...') }}" required>
							<span type="submit" id="quik-search-remove"><i class="fa-solid fa-xmark"></i></span>
						</form>
					</div>

					<!-- Main Nav -->
					<div class="header-nav navbar-collapse collapse justify-content-end" id="navbarNavDropdown">
						<div class="logo-header">
							<a href="{{ url('/') }}"><img src="{{ DzHelper::siteLogo() }}" alt="{{ __('Site Logo') }}"/></a>
						</div>
						{{ DzHelper::nav_menu(
						  	array(
						 		'theme_location'  => 'primary',
						 		'menu_class'      => 'nav navbar-nav navbar navbar-left',
						  	)
						  ); }}
						<div class="dz-social-icon">
							<ul>
                                <li><a target="_blank" class="fab fa-facebook-f" href="{{ config('Social.facebook') }}"></a></li>
                                <li><a target="_blank" class="fab fa-instagram" href="{{ config('Social.instagram') }}"></a></li>
                                <li><a target="_blank" class="fab fa-whatsapp" href="{{ config('Social.whatsapp') }}"></a></li>
                                <li><a target="_blank" class="fab fa-twitter" href="{{ config('Social.twitter') }}"></a></li>
							</ul>
						</div>	
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<!-- Main Header END -->
</header>
