@extends('layout.default')

@section('content')

<!-- Content -->

    @php
        $search_res = $title;
        $title =  __('Search Results for : '). $title;
    @endphp
    @include('elements.banner-inner', compact('title'))

    <div class="section-full bg-white content-inner">
        <div class="container">
            <div class="row">

                <div class="{{ (DzHelper::dzHasSidebar()) ? 'col-xl-9 col-lg-8 col-md-7 col-sm-12 col-12' : 'col-12' ; }}">
                    <div class="widget w-100">
                        <div class="search-bx">
                            <form method="get" action="{{ route('permalink.search') }}">
                                @csrf
                                <div class="input-group">
                                    <input name="s" type="text" class="form-control" value="{{ $search_res }}" placeholder="{{ __('Search..') }}">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                                    </span> 
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row loadmore-content">
                        @forelse($blogs as $blog)
                            <div class="{{ (DzHelper::dzHasSidebar()) ? 'col-lg-12' : 'col-lg-6' ; }} m-b30">
                                @php
                                    $single_link = DzHelper::laraBlogLink($blog->id);
                                    if(array_key_exists('page_type',$blog->toArray())) {
                                        $single_link = DzHelper::laraPageLink($blog->id);
                                    }
                                @endphp
                                <div class="blog-card post-left">
                                    <div class="blog-card-media">
                                        <a href="{!! $single_link !!}">
                                            @if(optional($blog->feature_img)->value)
                                                @if (Storage::exists('public/page-images/'.$blog->feature_img->value))
                                                    <img src="{{ asset('storage/page-images/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                                                @elseif (Storage::exists('public/blog-images/'.$blog->feature_img->value))
                                                    <img src="{{ asset('storage/blog-images/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                                                @else
                                                    <img src="{{ asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                                                @endif
                                            @else
                                                <img src="{{ asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="blog-card-info">
                                        <ul class="cat-list">
                                            @if ($blog->blog_categories)
                                                @forelse($blog->blog_categories as $blogcategory)
                                                <li class="title-sm post-tag"><a href="{!! DzHelper::laraBlogCategoryLink($blogcategory->id) !!}">{{ $blogcategory->title }}</a></li>
                                                @empty
                                                <li class="title-sm post-tag"><a href="javascript:void(0);">{{ __('uncatagorized') }}</a></li>
                                                @endforelse
                                            @endif
                                        </ul>
                                        @php
                                            if($blog->visibility != 'Pu'){
                                                $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ') ;
                                            }else {
                                                $blog_visibility = '';
                                            }
                                        @endphp
                                        <h4 class="title"><a href="{!! $single_link !!}">{{ $blog_visibility }}{{ Str::limit($blog->title, 26, ' ...') }}</a></h4>
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
                                                <a href="{!! $single_link !!}" class="btn-link readmore"><i class="la la-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <div class="col-md-12">{{ __('No record found.') }}</div>
                        @endforelse
                    </div>
                </div>
                @include('widgets.sidebar')
            </div>
        </div>
    </div>
<!-- Content end -->
@endsection