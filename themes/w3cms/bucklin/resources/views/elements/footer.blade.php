	<!-- Footer -->
    <footer class="site-footer">
        <div class="footer-top">
            <div class="container">
				<div class="row">
					<div class="col-lg-4">
						{{ DzHelper::nav_menu(
							  	array(
							 		'theme_location'  => 'footer',
			 						'menu_class'      => 'footer-link m-b0',
							  	)
							  ); }}					
					</div>
					<div class="col-lg-4">
						<div class="footer-logo">
							<a href="{{ url('/') }}"><img src="{{ DzHelper::siteLogo() }}" alt="{{ __('Site Logo') }}" style="max-width: 190px;"></a>
						</div>
					</div>
					<div class="col-lg-4">
						<p class="copyright">{!! config('Site.copyright') !!}</p>
					</div>
				</div>
			</div>
        </div>
    </footer>
	   