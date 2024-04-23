@extends('layout.default')

@section('content')
<!-- Content -->

    @php
        $title = __('Search Results for : ').$title;
    @endphp
    @include('elements.banner-inner', compact('title'))
        
<div class="section-full bg-white content-inner">
    <div class="container">
        <div class="row">
            @if (DzHelper::dzHasSidebar())
            <div class="col-lg-8 col-md-7 col-sm-12 col-12">
            @else
            <div class="col-12">
            @endif
                <div class="widget widget_search w-100">
                    <form method="get" action="{{ route('permalink.search') }}" class="d-flex">
                        <div class="input-group d-flex">
                            <input type="search" id="input_search" class="wp-block-search__input form-control " name="s" value="{{ $title }}" placeholder="{{ __('Search...') }}" required="">
                            <div class="input-group-append">
                                <button name="submit" value="Submit" type="submit" class="btn">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row loadmore-content">
                    @forelse($blogs as $blog)
                            @php
                                $single_link = DzHelper::laraBlogLink($blog->id);
                                if(array_key_exists('page_type',$blog->toArray())) {
                                    $single_link = DzHelper::laraPageLink($blog->id);
                                }
                            @endphp
                        <div class="col-lg-6 m-b30">
                            <div class="blog-card blog-grid bg-dark">
                                <div class="blog-card-media">
                                    @if(optional($blog->feature_img)->value)
                                        @if (Storage::exists('public/page-images/'.$blog->feature_img->value))
                                            <img src="{{ theme_asset('storage/page-images/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                                        @elseif (Storage::exists('public/blog-images/'.$blog->feature_img->value))
                                            <img src="{{ theme_asset('storage/blog-images/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                                        @else
                                            <img src="{{ theme_asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                                        @endif
                                    @else
                                        <img src="{{ theme_asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                                    @endif
                                </div>
                                <div class="blog-card-info text-center">
                                    @php
                                        if($blog->visibility != 'Pu'){
                                            $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ');
                                        }else {
                                            $blog_visibility = '';
                                        }
                                    @endphp
                                    <h4 class="title"><a href="{!! $single_link !!}">{{ $blog_visibility }}{{ $blog->title }}</a></h4>
                                    <div class="post-date">
                                        {{ $blog->publish_on }}
                                    </div>
                                    <p>
                                        {!! $blog->excerpt !!}
                                    </p>
                                    <ul class="add-info">
                                        <li><a href="{!! $single_link !!}" class="btn outline radius-no white">{{ __('Read More') }}</a></li>
                                    </ul>
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