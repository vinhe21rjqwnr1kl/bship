<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="description" content="{{ __('Bucklin : Blog HTML Template') }}" />
	<meta property="og:title" content="{{ __('Bucklin : Blog HTML Template') }}" />
	<meta property="og:description" content="{{ __('Bucklin : Blog HTML Template') }}" />
	<meta property="og:image" content="http://bucklin.dexignzone.com/xhtml/social-image.png" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON -->
	@if(config('Site.favicon'))
        <link rel="icon" type="image/png" sizes="16x16" href="{{ theme_asset('storage/configuration-images/'.config('Site.favicon')) }}">
    @endif
	
	<!-- PAGE TITLE HERE -->
	<title>{{ config('Site.title') ? config('Site.title') : __('Admin Panel') }}</title>
	
	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- STYLESHEETS -->
	<link rel="stylesheet" type="text/css" href="{{ theme_asset('css/plugins.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ theme_asset('css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ theme_asset('css/templete.css') }}">
	<link class="skin" rel="stylesheet" type="text/css" href="{{ theme_asset('css/skin/skin-1.css') }}">

</head>
<body id="bg">
	<div class="page-wraper">

			@php
				$bg_dark = (isset($exception) && $exception->getStatusCode() == 404) ? 'bg-dark': '' ;
			@endphp
			
			@if (isset($page->slug) && Str::contains($page->slug, 'home'))
			@else
			<!-- header -->
				@include('elements.header')
			<!-- header END -->
			@endif
			
			<div class="page-content bg-white">


				@yield('content')

			</div>

			<!-- Footer -->
			@include('elements.footer')
			<!-- Footer END-->

			<!-- Footer END-->
    	<button class="scroltop fa fa-chevron-up" ></button>
	</div>
	<!-- JAVASCRIPT FILES ========================================= -->
	<script src="{{ theme_asset('js/jquery.min.js') }}"></script><!-- JQUERY.MIN JS -->
	<script src="{{ theme_asset('plugins/bootstrap/js/popper.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->
	<script src="{{ theme_asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->
	<script src="{{ theme_asset('plugins/bootstrap-select/bootstrap-select.min.js') }}"></script><!-- FORM JS -->
	<script src="{{ theme_asset('plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js') }}"></script><!-- FORM JS -->
	<script src="{{ theme_asset('plugins/magnific-popup/magnific-popup.js') }}"></script><!-- MAGNIFIC POPUP JS -->
	<script src="{{ theme_asset('plugins/imagesloaded/imagesloaded.js') }}"></script><!-- IMAGESLOADED -->
	<script src="{{ theme_asset('plugins/masonry/masonry-3.1.4.js') }}"></script><!-- MASONRY -->
	<script src="{{ theme_asset('plugins/masonry/masonry.filter.js') }}"></script><!-- MASONRY -->
	<script src="{{ theme_asset('plugins/owl-carousel/owl.carousel.js') }}"></script><!-- OWL SLIDER -->
	<script src="{{ theme_asset('plugins/scroll/scrollbar.min.js') }}"></script><!-- Scroll Bar -->
	<script src="{{ theme_asset('js/custom-min.js') }}"></script><!-- CUSTOM FUCTIONS  -->
	<script src="{{ theme_asset('js/dz-carousel-min.js') }}"></script><!-- SORTCODE FUCTIONS -->
</body>
</html>