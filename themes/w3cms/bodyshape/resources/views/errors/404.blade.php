<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="description" content="{{ __('BodyShape - Coach, Speaker & Motivation HTML Template') }}">
    <meta property="og:title" content="{{ __('BodyShape - Coach, Speaker & Motivation HTML Template') }}">
    <meta property="og:description" content="{{ __('BodyShape - Coach, Speaker & Motivation HTML Template') }}">
    <meta property="og:image" content="https://w3cms.dexignzone.com/laravel/social-image.png">
    <meta name="format-detection" content="telephone=no">
    
    <!-- FAVICONS ICON -->
    @if(config('Site.favicon'))
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/configuration-images/'.config('Site.favicon')) }}">
    @endif
    
    <!-- PAGE TITLE HERE -->
    <title>{{ config('Site.title') ? config('Site.title') : __('Admin Panel') }}</title>
    
    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- STYLESHEETS -->
    <link rel="stylesheet" href="{{ theme_asset('vendor/animate/animate.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('vendor/magnific-popup/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('vendor/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('vendor/rangeslider/rangeslider.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('vendor/switcher/switcher.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/style.css') }}">
    <link class="skin" rel="stylesheet" type="text/css" href="{{ theme_asset('css/skin/skin-1.css') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body id="bg" data-anm=".anm">
    
    <div class="page-wraper">

        <!-- header -->
        @include('elements.header')
        <!-- header END -->

        <div class="page-content bg-white">
            <section class="error-page" data-text="{{ __('ERROR') }}" style="background-image: url({{ theme_asset('images/background/bg-appointment.jpg') }});">
                <div class="container">
                    <div class="inner-content text-center">
                        <div class="dz_error">{{ __('404') }}</div>
                        <h2 class="error-head">{{ __('We are sorry. But the page you are looking for cannot be found.') }}</h2>
                        <a href="{{ url('/') }}" class="btn btn-primary btn-skew"><span>{{ __('BACK TO HOMEPAGE') }}</span></a>
                    </div>
                </div>
            </section>
        </div>

        <footer class="site-footer style-1 bg-img-fix footer-action" id="footer">
            <!-- Footer Bottom Part -->
            <div class="footer-bottom">
                <div class="text-center"> 
                    <span class="copyright-text">{!!  DzHelper::siteFooterText() !!}</span> 
                </div>
            </div>
        </footer>

    </div>

    <!-- JAVASCRIPT FILES ========================================= -->

    <script src="{{ theme_asset('js/jquery.min.js') }}"></script>
    <script src="{{ theme_asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ theme_asset('js/custom.js') }}"></script>
</body>
</html>