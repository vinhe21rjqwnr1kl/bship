<footer class="site-footer">
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-xl-3 col-lg-2 col-md-6 d-md-none d-lg-block">
						<div class="widget">
							<a href="{{ url('/') }}"><img width="180px" src="{{ DzHelper::siteLogo() }}" alt="{{ __('Site Logo') }}"></a> 
						</div>
					</div>
					<div class="col-xl-3 col-lg-4 col-md-6">
						<h6 class="m-b30 footer-title"><span>{{ __('Recent Post') }}</span></h6>
						{!! DzHelper::recentBlogs( array('limit'=>3, 'order'=>'asc', 'orderby'=>'created_at') ); !!}
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6">
						<h6 class="m-b30 footer-title"><span>{{ __('My Blogs') }}</span></h6>
						<a class="video widget relative popup-youtube overlay-black-middle" href="https://www.youtube.com/watch?v=VjlATH_rzYg">
							<img src="{{ theme_asset('images/footer-video.jpg') }}" alt="{{ __('Thumbnail Image') }}"/>
							<span class="play-video"><i class="la la-play"></i></span>
						</a>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-12">
						<h6 class="m-b30 footer-title"><span>{{ __('Subscribe') }}</span></h6>
						<ul class="d-flex widget-social-ic">
							<li><a target="_blank" href="{{ config('Social.facebook') }}" class="site-button-link"><i class="fab fa-facebook-f"></i></a></li>
							<li><a target="_blank" href="{{ config('Social.twitter') }}" class="site-button-link"><i class="fab fa-twitter"></i></a></li>
							<li><a target="_blank" href="{{ config('Social.whatsapp') }}" class="site-button-link"><i class="fab fa-whatsapp"></i></a></li>
							<li><a target="_blank" href="{{ config('Social.instagram') }}" class="site-button-link"><i class="fab fa-instagram"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-12 text-center">
						<span>{!! config('Site.copyright') !!}</span>
					</div>
				</div>
			</div>
		</div>
	</footer>

    