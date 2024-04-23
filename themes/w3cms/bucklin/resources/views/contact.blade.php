@extends('layout.default')

@section('content')
<!-- Content -->

    <!-- Banner -->
    @php
        $title = __('Contact Us');
    @endphp
    @include('elements.banner-inner', compact('title'))
    <!-- Banner end -->

    <!-- Contact Us Page -->
    <div class="section-full bg-white content-inner-1 contact-form">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1 class="contact-title text-center">{{ __('Get in touch with Me…') }}</h1>
                    <div class="max-w700 m-auto">
                        <p class="first-content">{{ __('Aliquam eleifend consequat est laoreet bibendum. Proin et nibh augue. Fusce condimentum vehicula condi entum. Nulla rutrum justo pellentesque nunc porta aliquam. Mauris sodales mauris sed mi elementum faucibus. Aliquam tinci dunt sem nec augue porta euismod. Nulla facilisi. Nulla ultricies ipsum massa, quis molestie magna acibus sed.') }}</p>
                        <p>{{ __('Mauris sed risus facilisis, ullamcorper massa eu, elementum ligula. Vivamus sit amet risus i ornare finibus vitae ac nulla. Aenean eget ex ut libero congue rutrum a et diam. Mauris eu metus et nibh pulvinar tempus idefficitur dolor.') }}</p>
                        <div class="dzFormMsg"></div>
                        <form method="post" action="{{ route('front.contact') }}">
                            @csrf
                            <div class="row m-lr0">
                                @if($errors->any())
                                    <div class="col-12 m-b30">
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>{{ __('Something  wrong!') }}</strong> {{ __('You should check in fields below.') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                @if( Session::get('success') )
                                    <div class="col-12 m-b30">
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ Session::get('success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6 col-sm-6 p-lr0">
                                    <div class="form-group">
                                        <input name="first_name" type="text" required class="form-control" placeholder="{{ __('First Name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 p-lr0">
                                    <div class="form-group">
                                        <input name="last_name" type="text" required class="form-control" placeholder="{{ __('Last Name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 p-lr0">
                                    <div class="form-group">
                                        <input name="phone_number" type="text" required class="form-control" placeholder="{{ __('Phone Number') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 p-lr0">
                                    <div class="form-group">
                                        <input name="email" type="email" class="form-control" required placeholder="{{ __('Email') }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 p-lr0 m-b30">
                                    <div class="form-group">
                                        <textarea name="message" rows="4" class="form-control" required placeholder="{{ __('Add Your Message') }}" spellcheck="false"></textarea>
                                        <button name="submit" type="submit" value="Submit" class="btn radius-no primary">{{ __('Send') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="section-full social-link-bx">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                    <a href="{{ config('Social.twitter') }}" class="social-link">
                        <i class="fa fa-twitter"></i>
                        <span>{{ __('Twitter') }}</span>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                    <a href="{{ config('Social.facebook') }}" class="social-link">
                        <i class="fa fa-facebook"></i>
                        <span>{{ __('Facebook') }}</span>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                    <a href="{{ config('Social.linkedin') }}" class="social-link">
                        <i class="fa fa-linkedin"></i>
                        <span>{{ __('Linkedin') }}</span>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                    <a href="j{{ config('Social.instagram') }}" class="social-link">
                        <i class="fa fa-instagram"></i>
                        <span>{{ __('Instagram') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Us Page End -->
        
    </div>

    <!-- Content end -->
@endsection
