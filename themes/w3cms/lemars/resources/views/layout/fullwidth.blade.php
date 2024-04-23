<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="">
	<meta name="description" content="{{ __('LeMars : Blog HTML Template') }}">
	<meta property="og:title" content="{{ __('LeMars : Blog HTML Template') }}">
	<meta property="og:description" content="{{ __('LeMars : Blog HTML Template') }}">
	<meta property="og:image" content="https://w3cms.dexignzone.com/laravel/social-image.png">
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
	
	<!-- STYLESHEETS -->
	<link rel="stylesheet" type="text/css" href="{{ theme_asset('css/plugins.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ theme_asset('css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ theme_asset('css/templete.css') }}">
	<link class="skin" rel="stylesheet" type="text/css" href="{{ theme_asset('css/skin/skin-1.css') }}">


	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body id="bg">
	<div class="page-wraper">
		
		<div class="page-content bg-white">

			@yield('content')

		</div>

		<button class="scroltop fas fa-chevron-up" ></button>

	</div>

	<!-- JAVASCRIPT FILES ========================================= -->
	<script src="{{ theme_asset('js/jquery.min.js') }}"></script><!-- JQUERY.MIN JS -->
	<script src="{{ theme_asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->
	<script src="{{ theme_asset('plugins/bootstrap-select/bootstrap-select.min.js') }}"></script><!-- FORM JS -->
	<script src="{{ theme_asset('js/custom.js') }}"></script><!-- CUSTOM FUCTIONS  -->
</body>
</html>