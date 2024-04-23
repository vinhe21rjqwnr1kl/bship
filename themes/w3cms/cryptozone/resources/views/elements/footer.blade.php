<footer class="site-footer style-1" id="footer">
	<img class="bg-shape1" src="{{ theme_asset('images/home-banner/shape1.png') }}" alt="{{ __('Footer banner') }}">

	<div class="footer-top background-luminosity" style="background-image: url({{ theme_asset('images/background/bg1.jpg') }})">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-12 wow fadeInUp" data-wow-delay="0.2s">
					<div class="widget widget_about">
						<div class="footer-logo logo-white">
							<a href="{{ url('/') }}"><img src="{{ asset('images/logo-full-white.png') }}" alt="{{ __('Footer Logo') }}"></a>
						</div>
						<p>{!! config('Site.biography') !!}</p>
						<div class="dz-social-icon transparent space-10">
							<ul>
								<li><a target="_blank" class="fab fa-facebook-f" href="{{ config('Social.facebook') }}"></a></li>
								<li><a target="_blank" class="fab fa-twitter" href="{{ config('Social.twitter') }}"></a></li>
								<li><a target="_blank" class="fab fa-linkedin-in" href="{{ config('Social.linkedin') }}"></a></li>
								<li><a target="_blank" class="fab fa-instagram" href="{{ config('Social.instagram') }}"></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0.6s">
					{{ DzHelper::recentBlogs( array('limit'=>2, 'order'=>'asc', 'orderby'=>'created_at') ) }}
				</div>
				<div class="col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0.8s">
					<div class="widget widget_locations">
						<h4 class="widget-title">{{ __('Locations') }}</h4>
						<div class="clearfix">
							<h6 class="title">{{ __('Washington') }}</h6>
							<p>{{ config('Site.location') }}</p>
							<img src="{{ theme_asset('images/footer/world-map-with-flags1.png') }}" alt="{{ __('World map image') }}">
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<!-- Footer Bottom Part -->
	<div class="footer-bottom text-center">
		<div class="container">
			<span class="copyright-text">{!! config('Site.copyright') !!}</span>
		</div>
	</div>
</footer>