<div class="banner-top-info">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-8">
				<div class="location">
					<p><i class="fa fa-map-marker"></i>{{ __('Miami, Florida, USA') }}</p>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-4 align-self-center">
				<ul class="social-link list-inline m-b0">
					<li><a href="javascript:void(0);" class="fa fa-instagram"></a></li>
					<li><a href="javascript:void(0);" class="fa fa-twitter"></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- Slider Banner -->
<div class="banner-slide owl-carousel owl-dots">
	@if (!empty(config('Theme.home_slider')))
		@php
			$images = explode(",",config('Theme.home_slider'));
		@endphp
		@foreach ($images as $image)
			<div class="item">
				<div class="slider-bx">
					<div class="dlab-post-media overlay-black-light">
						<img src="{{ theme_asset('storage/configuration-images/'.$image) }}" alt="{{ $image }}">
					</div>
					<div class="slider-info text-white">
						<h6>{{ __('Welcome to') }}</h6>
						<h2>{{ __('My Blog') }}</h2>
					</div>
				</div>
			</div>	
		@endforeach
	@else
		<div class="item">
			<div class="slider-bx">
				<div class="dlab-post-media overlay-black-light">
					<img src="{{ theme_asset('images/main-slider/slide3.jpg') }}" alt="{{ __('Slider Image 1') }}">
				</div>
				<div class="slider-info text-white">
					<h6>{{ __('Welcome to') }}</h6>
					<h2>{{ __('My Blog') }}</h2>
				</div>
			</div>
		</div>			
		<div class="item">
			<div class="slider-bx">
				<div class="dlab-post-media overlay-black-light">
					<img src="{{ theme_asset('images/main-slider/slide4.jpg') }}" alt="{{ __('Slider Image 2') }}">
				</div>
				<div class="slider-info text-white">
					<h6>{{ __('Welcome to') }}</h6>
					<h2>{{ __('My Blog') }}</h2>
				</div>
			</div>
		</div>
	@endif
	
</div>
<!-- header -->
<header class="site-header mo-left header-full header header-transparent header-bottom">
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
					<div class="header-nav navbar-collapse collapse justify-content-center" id="navbarNavDropdown">
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
<!-- header END -->