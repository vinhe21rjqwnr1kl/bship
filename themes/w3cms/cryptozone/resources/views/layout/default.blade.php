<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="">
	<meta name="description" content="{{ __('CryptoZone - Crypto Trading HTML Template') }}">
	<meta property="og:title" content="{{ __('CryptoZone - Crypto Trading HTML Template') }}">
	<meta property="og:description" content="{{ __('CryptoZone - Crypto Trading HTML Template') }}">
	<meta property="og:image" content="">
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON -->
	@if(config('Site.favicon'))
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/configuration-images/'.config('Site.favicon')) }}">
    @else 
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}">
    @endif
	
	<!-- PAGE TITLE HERE -->
	<title>{{ config('Site.title') ? config('Site.title') : __('W3CMS Laravel') }}</title>
	
	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="{{ theme_asset('css/style.css') }}">

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap">

</head>
<body>

	<!--*******************
        Preloader start
    ********************-->
    <!--*******************
        Preloader end
    ********************-->
	
	<div class="page-wraper">

		<!-- header -->
		@include('elements.header')
		<!-- header END -->
		
		<div class="page-content">

			@yield('content')

		</div>

		<!-- Footer -->
		@include('elements.footer')
		<!-- Footer END-->

		<!-- Bottom to top -->
		<button class="scroltop icon-up" type="button"><i class="fas fa-arrow-up"></i></button>

	</div>

	<!-- JAVASCRIPT FILES ========================================= -->
	<script src="{{ theme_asset('js/jquery.min.js') }}"></script>
	<script src="{{ theme_asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ theme_asset('vendor/wow/wow.js') }}"></script>
	<script src="{{ theme_asset('js/custom-min.js') }}"></script>
</body>
</html>