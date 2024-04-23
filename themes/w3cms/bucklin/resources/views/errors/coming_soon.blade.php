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
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/configuration-images/'.config('Site.favicon')) }}">
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
<div id="loading-area1"></div>
    <!-- header -->
    <header class="site-header mo-left header-full header bg-dark">
        <!-- Main Header -->
        <div class="sticky-header main-bar-wraper navbar-expand-lg">
            <div class="main-bar clearfix ">
                <div class="container-fluid">
                    <div class="header-content-bx">
                        <!-- website logo -->
                        <div class="logo-header">
                            <a href="{{ url('/') }}"><img src="{{ DzHelper::siteLogo() }}" alt="{{ __('Site Logo') }}"/></a>
                        </div>
                        <!-- Extra Nav -->
                        <div class="extra-nav">
                            <div class="extra-cell">
                                <ul>
                                    <li class="search-btn">
                                        <a href="javascript:;" class="btn-link menu-icon">
                                            <div class="menu-icon-in">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Main Nav -->
                        <div class="header-nav navbar-collapse collapse justify-content-center nav-dark" id="navbarNavDropdown">
                            {{ DzHelper::nav_menu(
                                array(
                                    'theme_location'  => 'primary',
                                    'menu_class'      => 'nav navbar-nav',
                                )
                              ); }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Header END -->
        <!-- Header Left -->
        <div class="header-nav navbar-collapse collapse full-sidenav content-scroll">
            <div class="location">
                <p><i class="fa fa-map-marker"></i>{{ __('Miami, Florida, USA') }}</p>
            </div>
            {{ DzHelper::nav_menu(
                array(
                    'theme_location'  => 'expanded',
                    'menu_class'      => 'nav navbar-nav',
                )
              ); }}
            <div class="logo-header">
                <a href="{{ url('/') }}"><img src="{{ DzHelper::siteLogo() }}" alt="{{ __('Site Logo') }}"/></a>
            </div>
        </div>
        <div class="menu-close">
            <i class="la la-close"></i>
        </div>
        <!-- Header Left End -->
    </header>

<!-- Content -->
    <div class="page-content bg-white">
        <!-- Error Page -->
        <div class="section-full content-inner-2">
            <div class="container">
                <div class="error-page text-center">
                    <div class="dz_error">{{ __('Coming soon') }}</div>
                    <h2 class="error-head">{!! config(' Site.comingsoon_message') !!}</h2>
                </div>
            </div>
        </div>
        <!-- Error Page End -->
    </div>
    <!-- Content END-->

@include('elements.footer')
