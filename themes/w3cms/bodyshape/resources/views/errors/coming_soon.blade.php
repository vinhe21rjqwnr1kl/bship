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
    <link rel="stylesheet" href="{{ theme_asset('vendor/magnific-popup/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('vendor/switcher/switcher.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/style.css') }}">
    <link class="skin" rel="stylesheet" type="text/css" href="{{ theme_asset('css/skin/skin-1.css') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body id="bg">
    <div class="page-wraper">

        <!-- coming-soon-page -->
        <div class="coming-soon" data-text="{{ __('HEALTH') }}" style="background-image: url({{ theme_asset('images/background/bg-appointment.jpg') }})">
            <div class="inner-content">
                <div class="logo-header logo-dark">
                    <a href="{{ url('/') }}"><img src="{{ asset('storage/configuration-images/'.config('Site.logo')) }}" alt="{{ __('Site Logo') }}"></a>
                </div>
                <h1 class="dz-head">{{ __('We Are Coming') }} <span class="text-primary">{{ __('Soon !') }}</span></h1>
                <p>{!! config('Site.comingsoon_message') !!}</p>
                <div class="countdown countdown-timer" data-date="{!! config('Site.comingsoon_date') !!}">
                    <div class="date clock-days">
                        <div class="items-days">
                            <div id="canvas-days" class="clock-canvas"></div>
                            <p class="val">0</p>
                        </div>                  
                        <span class="type-days type-time" data-border-color="#FF8139">{{ __('Days') }}</span>
                    </div>
                    <div class="date clock-hours">
                        <div class="items-days">
                            <div id="canvas-hours" class="clock-canvas"></div>
                            <p class="val">0</p>
                        </div>
                        <span class="type-hours type-time" data-border-color="#FF8139">{{ __('Hours') }}</span>
                    </div>
                    <div class="date clock-minutes">
                        <div class="items-days">
                            <div id="canvas-minutes" class="clock-canvas"></div>
                            <p class="val">0</p>
                        </div>
                        <span class="type-minutes type-time" data-border-color="var(--primary)">{{ __('Minutes') }}</span>
                    </div>
                    <div class="date clock-seconds">
                        <div class="items-days">
                            <div id="canvas-seconds" class="clock-canvas"></div>
                            <p class="val">0</p>
                        </div>
                        <span class="type-seconds type-time" data-border-color="#FF8139">{{ __('Second') }}</span>
                    </div>
                </div>
            </div>
            
            <img class="shape1 rotate-360" src="{{ theme_asset('images/pattern/pattern1.svg') }}" alt="{{ __('pattern 1') }}">
            <img class="shape2 rotate-360" src="{{ theme_asset('images/pattern/pattern1.svg') }}" alt="{{ __('pattern 1') }}">
            <img class="shape3 dzmove1" src="{{ theme_asset('images/pattern/pattern2.svg') }}" alt="{{ __('pattern 2') }}">
            <img class="shape4 dzmove2" src="{{ theme_asset('images/pattern/pattern2.svg') }}" alt="{{ __('pattern 1') }}">
            // <img class="girl-img" src="{{ theme_asset('images/footer-girl1.png') }}" alt="{{ __('footer girl image') }}">
            
        </div>

    </div>

    <script src="{{ theme_asset('js/jquery.min.js') }}"></script><!-- JQUERY.MIN JS -->
    <script src="{{ theme_asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->
    <script src="{{ theme_asset('vendor/countdown/kinetic.js') }}"></script><!-- COUNTDOWN JS -->
    <script src="{{ theme_asset('vendor/countdown/jquery.final-countdown.js') }}"></script><!-- COUNTDOWN JS -->
    <script src="{{ theme_asset('js/custom.js') }}"></script><!-- CUSTOM JS -->
</body>
</html>