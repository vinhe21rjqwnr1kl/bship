@extends('layout.default')

@section('content')
<!-- Content -->

        <!-- Contact Us Page -->
        <div class="section-full bg-white content-inner-1 contact-form">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="text-center section-head">
                            <h1 class="contact-title">{{ __('Contact Me') }}</h1>
                        </div>
                        <div class="banner-contact">
                            <img src="{{ theme_asset('images/contact.jpg') }}" alt="{{ __('Contact Image') }}"/>
                        </div>
                        <div class="row">
                            <div class="col-xl-9 col-lg-8 m-b30">
                                <form method="POST" action="{{ route('front.contact') }}">
                                    @csrf
                                    <div class="row form-set">
                                        @if($errors->any())
                                            <div class="col-12 m-b30">
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    {{ implode(', ', $errors->all(':message')) }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            </div>
                                        @endif
                                        @if( Session::get('success') )
                                            <div class="col-12 m-b30">
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    {{ Session::get('success') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-xl-6 mb-3 mb-md-4">
                                            <input name="first_name" required type="text" class="form-control" placeholder="{{ __('First Name') }}">
                                        </div>
                                        <div class="col-xl-6 mb-3 mb-md-4">
                                            <input name="last_name" type="text" class="form-control" placeholder="{{ __('Last Name') }}">
                                        </div>
                                        <div class="col-xl-6 mb-3 mb-md-4">
                                            <input name="email" required type="text" class="form-control" placeholder="{{ __('Email Address') }}">
                                        </div>
                                        <div class="col-xl-6 mb-3 mb-md-4">
                                            <input name="phone_number" required type="text" class="form-control" placeholder="{{ __('Phone No.') }}">
                                        </div>
                                        <div class="col-xl-12 mb-3 mb-md-4">
                                            <textarea rows="4" name="message" required class="form-control" placeholder="{{ __('Message') }}"></textarea>
                                        </div>
                                        <div class="col-md-12 col-sm-12 text-center">
                                            <button name="submit" type="submit" value="Submit" class="btn radius-xl">{{ __('Send Message') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xl-3 col-lg-4 m-b30">
                                <div class="contact-info">
                                    <div class="extra-info">
                                        <div class="text-uppercase info-title text-center">{{ __('Additional info') }}</div>
                                        <ul>
                                            <li><i class="la la-location-arrow"></i> {{ config('Site.location') }}</li>
                                            <li><i class="la la-globe"></i> {{ config('Site.email') }}</li>
                                            <li><i class="la la-mobile-phone"></i> {{ config('Site.contact') }}</li>
                                        </ul>
                                    </div>
                                    <div class="text-center">
                                        <ul class="list-inline link-btn-style m-b0">
                                            <li><a target="_blank" href="{{ config('Social.facebook') }}"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a target="_blank" href="{{ config('Social.twitter') }}"><i class="fab fa-twitter"></i></a></li>
                                            <li><a target="_blank" href="{{ config('Social.whatsapp') }}"><i class="fab fa-whatsapp"></i></a></li>
                                            <li><a target="_blank" href="{{ config('Social.instagram') }}"><i class="fab fa-instagram"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact Us Page End -->


<!-- Content end -->
@endsection