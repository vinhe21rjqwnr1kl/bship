@extends('layout.default')

@section('content')

    @php
        $title =  __('Blog Details');
    @endphp
    @include('elements.banner-inner', compact('title'))

    <!-- Blog Detail -->
    <div class="section-full content-inner bg-white">
        <div class="container">
            <div class="row">
                @if($blog)
                    @php
                        if($blog->visibility != 'Pu'){
                            $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ');
                        }else {
                            $blog_visibility = '';
                        }
                    @endphp
                <div class="{{ (DzHelper::dzHasSidebar()) ? 'col-xl-9 col-lg-8 col-md-7 col-sm-12 col-12' : 'col-12' ; }}">
                    <div class="section-head text-center">
                        <ul class="cat-list">
                            @forelse($blog->blog_categories as $blogcategory)
                            <li class="title-sm post-tag"><a href="{!! DzHelper::laraBlogCategoryLink($blogcategory->id) !!}">{{ $blogcategory->title }}</a></li>
                            @empty
                            <li><a href="javascript:void(0);">{{ __('uncatagorized') }}</a></li>
                            @endforelse
                        </ul>
                        <h2 class="title-head">{{ $blog_visibility }}{{ $blog->title }}</h2>
                    </div>
                    <div class="blog-post blog-single blog-post-style-2 sidebar">
                        <div class="dlab-post-info">
                            <div class="dlab-post-text text">
                                <div class="alignwide">
                                    <figure class="aligncenter">
                                        @if(optional($blog->feature_img)->value && Storage::exists('public/blog-images/'.$blog->feature_img->value))
                                            <img src="{{ asset('storage/blog-images/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                                        @else
                                            <img src="{{ asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                                        @endif
                                    </figure>
                                </div>
                                <p class="blog-excerpt fs-5">{{ optional($blog)->excerpt }}</p>

                                {!! $blog->content !!}
                            </div>
                            <div class="blog-card-info style-1 no-bdr">
                                <div class="date">{{ $blog->publish_on }}</div>
                                <ul class="social-link-round">
                                    <li class="link-ic"><a href="javascript:void(0);" class="btn-link share"><i class="la la-share-alt"></i></a></li>
                                    <li><a target="_blank" href="{{ config('Social.twitter') }}" class="btn-link"><i class="fab fa-twitter"></i></a></li>
                                    <li><a target="_blank" href="{{ config('Social.whatsapp') }}" class="btn-link"><i class="fab fab fa-whatsapp"></i></a></li>
                                    <li><a target="_blank" href="{{ config('Social.facebook') }}" class="btn-link"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a target="_blank" href="{{ config('Social.instagram') }}" class="btn-link"><i class="fab fa-instagram"></i></a></li>
                                </ul>
                                <div>
                                    <a href="javascript:void(0);" class="btn-link comment">{{ __('WRITE A COMMENT') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="author-box blog-user m-b60">
                            <div class="author-profile-info">
                                <div class="author-profile-pic">
                                    <img src="{{ HelpDesk::user_img($blog->user->profile); }}" alt="{{ __("user'.htaccess profile") }}">
                                </div>
                                <div class="author-profile-content">
                                    <h6>{{ __('By') }} {{ $blog->user->name }}</h6>
                                    <p>{{ __('Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quisma bibendum auctor nisi elit consequat ipsum, nec sagittis sem amet nibh vulputate cursus itaet mauris.') }} </p>
                                    <ul class="list-inline m-b0">
                                        <li><a target="_blank" href="https://twitter.com/" class="btn-link"><i class="fab fa-twitter"></i></a></li>
                                        <li><a target="_blank" href="https://in.pinterest.com/" class="btn-link"><i class="fab fa-pinterest-p"></i></a></li>
                                        <li><a target="_blank" href="https://www.facebook.com/" class="btn-link"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a target="_blank" href="https://www.instagram.com/" class="btn-link"><i class="fab fa-instagram"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="post-btn">
                            <div class="prev-post">
                                @if(optional($blogs[0]->feature_img)->value && Storage::exists('public/blog-images/'.$blog->feature_img->value))
                                    <img src="{{ asset('storage/blog-images/'.$blogs[0]->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                                @else
                                    <img src="{{ asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                                @endif
                                <h6 class="title">
                                    <a href="{{ DzHelper::laraBlogLink($blogs[0]->id) }}">{{ Str::limit($blogs[0]->title, 24, '..') }}</a>
                                    <span class="post-date">{{ $blogs[0]->publish_on }}</span>
                                </h6>
                            </div>
                            <div class="next-post">
                                <h6 class="title">
                                    <a href="{{ DzHelper::laraBlogLink($blogs[1]->id) }}">{{ Str::limit($blogs[1]->title, 24, '..') }}</a>
                                    <span class="post-date">{{ $blogs[1]->publish_on }}</span></h6>
                                @if(optional($blogs[1]->feature_img)->value && Storage::exists('public/blog-images/'.$blog->feature_img->value))
                                    <img src="{{ asset('storage/blog-images/'.$blogs[1]->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                                @else
                                    <img src="{{ asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="col">{{ __('Record Not found.') }}</div>
                @endif
                @include('widgets.sidebar')
            </div>
        </div>
    </div>
    <!-- Blog Detail End -->

@endsection
