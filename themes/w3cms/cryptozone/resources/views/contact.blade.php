@extends('layout.default')

@section('content')
<!-- Content -->

        <!-- Banner  -->
        @php
            $title = __('Contact Us');
        @endphp
        @include('elements.banner-inner', compact('title'))
        <!-- Banner End -->

        <!-- Contact form sectio starts from here -->
        <section class="content-inner contact-form-wraper style-1">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-5 col-lg-5 m-b30">
                        <div class="info-box">
                            <div class="info">
                                <h2>{{ __('Contact Information') }}</h2>
                                <p class="font-18">{{ __('Fill up the form and our team will get back to you within 24 hours.') }}</p>
                            </div>
                            
                            <div class="widget widget_about">
                                <div class="widget widget_getintuch">
                                    <ul>
                                        <li>
                                            <i class="fa fa-phone"></i>
                                            <span>{{ config('Site.contact') }}</span> 
                                        </li>
                                        <li>
                                            <i class="fa fa-envelope"></i> 
                                            <span>{{ config('Site.email') }}</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ config('Site.location') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="social-box dz-social-icon style-3">
                                <h6>{{ __('Our Socials') }}</h6>
                                <ul class="social-icon">
                                    <li><a class="social-btn" target="_blank" href="{{ config('Social.facebook') }}"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    <li><a class="social-btn" target="_blank" href="{{ config('Social.twitter') }}"><i class="fa-brands fa-twitter"></i></a></li>
                                    <li><a class="social-btn" target="_blank" href="{{ config('Social.linkedin') }}"><i class="fab fa-linkedin"></i></a></li>
                                    <li><a class="social-btn" target="_blank" href="{{ config('Social.instagram') }}"><i class="fa-brands fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                        
                    <div class="col-xl-7 col-lg-7">
                        <div class="contact-box">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <h2 class="mb-0">{{ __('Get In touch') }}</h2>
                                        <p class="mb-0 font-18 text-primary">{{ __('We are here for you. How we can help?') }}</p>
                                    </div>
                                    <form method="POST" action="{{ route('front.contact') }}">
                                        @csrf
                                        <div class="row">
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
                                                <textarea name="message" required class="form-control" placeholder="{{ __('Message') }}"></textarea>
                                            </div>
                                            <div class="col-xl-12">
                                                <button name="submit" type="submit" value="{{ __('Submit') }}" class="btn btn-primary">{{ __('Submit Now') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact form section ends from here -->
        
<!-- Content end -->
@endsection