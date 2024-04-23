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
    <div id="loading-area" class="loading-page-1">
        <div class="loading-inner">
            <div class="inner">
                <img class="item-logo" src="{{ theme_asset('images/favicon.png') }}" alt="">
                <div class="load-text">
                    <span data-text="{{ __('B') }}" class="text-load">{{ __('B') }}</span>
                    <span data-text="{{ __('o') }}" class="text-load">{{ __('o') }}</span>
                    <span data-text="{{ __('d') }}" class="text-load">{{ __('d') }}</span>
                    <span data-text="{{ __('y') }}" class="text-load">{{ __('y') }}</span>
                    <span data-text="{{ __('S') }}" class="text-load">{{ __('S') }}</span>
                    <span data-text="{{ __('h') }}" class="text-load">{{ __('h') }}</span>
                    <span data-text="{{ __('a') }}" class="text-load">{{ __('a') }}</span>
                    <span data-text="{{ __('p') }}" class="text-load">{{ __('p') }}</span>
                    <span data-text="{{ __('e') }}" class="text-load">{{ __('e') }}</span>
                </div>
                <div class="item-circle">
                    <img class="rotate-360" src="{{ theme_asset('images/pattern/circle-footer-1.svg') }}" alt="{{ __('Footer Image') }}">
                </div>
            </div>
        </div>
    </div>
    <div class="page-wraper">
        
        <section class="under-construction cc" style="background-image:url({{ theme_asset('images/background/bg-appointment.jpg') }});background-repeat:no-repeat;background-size: cover;">
            <div class="inner-construction">
                <img class="warning-img" src="{{ theme_asset('images/warning.png') }}" alt="{{ __('Warning Image') }}">
                <h1 class="dz-head">{{ __('UNDER MAINTENANCE') }}</h1>
                <p>{!! config('Site.maintenance_message') !!}</p>
            </div>
            <img class="shape1 rotate-360" src="{{ theme_asset('images/pattern/pattern1.svg') }}" alt="{{ __('503 Shape 1 Image') }}">
            <img class="shape2 rotate-360" src="{{ theme_asset('images/pattern/pattern1.svg') }}" alt="{{ __('503 Shape 2 Image') }}">
            <img class="shape3 dzmove1" src="{{ theme_asset('images/pattern/pattern2.svg') }}" alt="{{ __('503 Shape 3 Image') }}">
            <img class="shape4 dzmove2" src="{{ theme_asset('images/pattern/pattern2.svg') }}" alt="{{ __('503 Shape 4 Image') }}">
            <img class="shape5 dzmove2" src="{{ theme_asset('images/pattern/pattern2.svg') }}" alt="{{ __('503 Shape 5 Image') }}">
            <img class="girl-img" src="{{ theme_asset('images/footer-girl1.png') }}" alt="{{ __('503 Shape 6 Image') }}">
        </section>

    </div>

    <script src="{{ theme_asset('js/jquery.min.js') }}"></script>
    <script src="{{ theme_asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->
    <script src="{{ theme_asset('js/custom.js') }}"></script><!-- CUSTOM JS -->
</body>
</html>