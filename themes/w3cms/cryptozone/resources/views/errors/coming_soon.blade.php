<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="description" content="CryptoZone - Crypto Trading HTML Template">
    <meta property="og:title" content="CryptoZone - Crypto Trading HTML Template">
    <meta property="og:description" content="CryptoZone - Crypto Trading HTML Template">
    <meta property="og:image" content="">
    <meta name="format-detection" content="telephone=no">
    
    <!-- FAVICONS ICON -->
    @if(config('Site.favicon'))
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/configuration-images/'.config('Site.favicon')) }}">
    @else 
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}">
    @endif
    
    <!-- PAGE TITLE HERE -->
    <title>{{ config('Site.title') ? config('Site.title') : 'W3CMS Laravel' }}</title>
    
    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- STYLESHEETS -->
    <link rel="stylesheet" href="{{ asset('front/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/vendor/animate/animate.css') }}">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap">

</head>
<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-5">
                    <div class="form-input-content text-center error-page">
                        <h1 class="error-text fw-bold"><i class="fa fa-exclamation-triangle text-warning"></i></h1>
                        <h4>We Are Coming <span class="text-primary">Soon !</span></h4>
                        <p>{!! config('Site.comingsoon_message') !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{ asset('front/vendor/global/global.min.js') }}"></script>
<script src="{{ asset('front/js/custom.js') }}"></script>
<script src="{{ asset('front/js/deznav-init.js') }}"></script>
</body>
</html>