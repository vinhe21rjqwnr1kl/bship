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
                        <h1 class="error-text  font-weight-bold">{{ __('403') }}</h1>
                        <h4><i class="fa fa-times-circle text-danger"></i> {{ __('Forbidden Error!') }}</h4>
                        <p>{{ __('You do not have permission to view this resource.') }}</p>
            			<div>
                            <a class="btn btn-primary" href="{{ url('/admin') }}">{{ __('Back to Home') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>