@extends('layout.default')

@section('content')
<!-- Content -->
    
    @php
        $title =  __('Tags : ').(isset($blog_tag->title) ? $blog_tag->title : '');
    @endphp
    @include('elements.banner-inner', compact('title'))

    <div class="section-full bg-white content-inner">
        <div class="container">
            <div class="row">
                <div class="{{ (DzHelper::dzHasSidebar()) ? 'col-xl-9 col-lg-8 col-md-7 col-sm-12 col-12' : 'col-12' ; }}">
                    <div class="row loadmore-content">

                        @forelse($blogs as $blog)
                            <div class="{{ (DzHelper::dzHasSidebar()) ? 'col-lg-12' : 'col-lg-6' ; }} m-b30">
                                <div class="blog-card post-left">
                                    <div class="blog-card-media">
                                        <a href="{!! DzHelper::laraBlogLink($blog->id) !!}">
                                            @if(optional($blog->feature_img)->value && Storage::exists('public/blog-images/'.$blog->feature_img->value))
                                                <img src="{{ asset('storage/blog-images/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                                            @else
                                                <img src="{{ asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="blog-card-info">
                                        <ul class="cat-list">
                                            @forelse($blog->blog_categories as $blogcategory)
                                            <li class="title-sm post-tag"><a href="{!! DzHelper::laraBlogCategoryLink($blogcategory->id) !!}">{{ $blogcategory->title }}</a></li>
                                            @empty
                                            <li><a href="javascript:void(0);">{{ __('uncatagorized') }}</a></li>
                                            @endforelse
                                        </ul>
                                        @php
                                            if($blog->visibility != 'Pu'){
                                                $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ') ;
                                            }else {
                                                $blog_visibility = '';
                                            }
                                        @endphp
                                        <h4 class="title"><a href="{!! DzHelper::laraBlogLink($blog->id) !!}">{{ $blog_visibility }}{{ Str::limit($blog->title, 26, ' ...') }}</a></h4>
                                        <p>{{ Str::limit($blog->excerpt, 60, ' ...') }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <ul class="social-link-round">
                                                <li class="link-ic"><a href="javascript:void(0);" class="btn-link share"><i class="la la-share-alt"></i></a></li>
                                                <li><a target="_blank" href="{{ config('Social.twitter') }}" class="btn-link"><i class="fab fa-twitter"></i></a></li>
                                                <li><a target="_blank" href="{{ config('Social.whatsapp') }}" class="btn-link"><i class="fab fab fa-whatsapp"></i></a></li>
                                                <li><a target="_blank" href="{{ config('Social.facebook') }}" class="btn-link"><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a target="_blank" href="{{ config('Social.instagram') }}" class="btn-link"><i class="fab fa-instagram"></i></a></li>
                                            </ul>
                                            <div>
                                                <a href="{!! DzHelper::laraBlogLink($blog->id) !!}" class="btn-link readmore"><i class="la la-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <div class="col-md-12">{{ __('No record found.') }}</div>
                        @endforelse
                        <div class="col-lg-12 m-b40">
                            {!! $blogs->links('elements.pagination') !!}
                        </div>
                    </div>
                </div>
                @include('widgets.sidebar')
            </div>
        </div>
    </div>
<!-- Content End --> 

@endsection