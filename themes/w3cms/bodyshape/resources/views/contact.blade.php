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
        <section class="content-inner-2 z-index-none">  
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-xl-5"> 
                        <div class="contact-box">
                            <h3 class="contact-title">{{ __('Contact Information') }}</h3>
                            <p class="contact-text">{{ __('Fill up the form and our Team will get back to you within 24 hours.') }}</p>
                            <div class="widget widget_getintuch ">
                                <ul>
                                    <li>
                                        <i class="fa-solid fa-location-dot"></i>
                                        <p>{{ config('Site.location') }}</p>
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-phone"></i>
                                        <p>{{ config('Site.contact') }}</p>
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-envelope"></i>
                                        <p>{{ config('Site.email') }}</p>
                                    </li>
                                </ul>
                            </div>
                            <h6 class="m-b15 text-white">{{ __('Our Socials') }}</h6>
                            <div class="dz-social-icon style-1 dark">
                                <ul>
                                    <li><a target="_blank" class="fab fa-facebook-f" href="{{ config('Social.facebook') }}"></a></li>
                                    <li><a target="_blank" class="fab fa-instagram" href="{{ config('Social.instagram') }}"></a></li>
                                    <li><a target="_blank" class="fab fa-whatsapp" href="{{ config('Social.whatsapp') }}"></a></li>
                                    <li><a target="_blank" class="fab fa-twitter" href="{{ config('Social.twitter') }}"></a></li>
                                </ul>
                            </div>
                            <svg width="250" height="70" viewBox="0 0 250 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 38L250 0L210 70L0 38Z" fill="url(#paint0_linear_306_1296)"></path>
                                <defs>
                                    <linearGradient id="paint0_linear_306_1296" x1="118.877" y1="35.552" x2="250.365" y2="35.552" gradientUnits="userSpaceOnUse">
                                    <stop offset="1" stop-color="var(--primary)"></stop>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-7  m-sm-0 m-b40">
                        <form class="dz-form  style-1" method="POST" action="{{ route('front.contact') }}">
                            @csrf
                            <div class="dzFormMsg">{{ Session::get('success') }}</div>
                            <div class="row">
                                @if($errors->any())
                                    <div class="col-12 m-b30">
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                          <strong>{{ __('Something') }} </strong>{{ __(' Went wrong.') }}
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
                                <div class="col-lg-6">
                                    <div class="input-area">
                                        <label>{{ __('First Name') }} <span class="text-danger">*</span></label>
                                        <div class="input-group input-line">
                                            <input name="first_name" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-area">
                                        <label>{{ __('Last Name') }}</label>
                                        <div class="input-group input-line">
                                            <input name="last_name" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="input-area">
                                        <label>{{ __('Your Email Address') }} <span class="text-danger">*</span></label>
                                        <div class="input-group input-line">
                                            <input name="email" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="input-area">
                                        <label>{{ __('Phone') }} <span class="text-danger">*</span></label>
                                        <div class="input-group input-line">
                                            <input name="phone_number" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input-area">
                                        <label>{{ __('Message... ') }}<span class="text-danger">*</span></label>
                                        <div class="input-group input-line m-b30">
                                            <textarea name="message" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button name="submit" type="submit" value="Submit" class="btn btn-primary btn-lg btn-skew"><span>{{ __('Send Message') }}</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>


        <div class="container content-inner-1">
            <div class="map-iframe">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d28896.531392443423!2d75.81462525569334!3d25.133445080066668!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x537f208422eb8f28!2sW3ITEXPERTS%20-%20Software%20Development%20Company%20in%20kota!5e0!3m2!1sen!2sin!4v1669897446044!5m2!1sen!2sin" style="border:0; margin-bottom: -7px; width: 100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <!-- Contact Us Page End -->
        
<!-- Content end -->
@endsection