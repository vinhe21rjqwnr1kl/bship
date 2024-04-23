@extends('layout.default')

@section('content')
<!-- Content -->

    @php
        $searchRes = $title;
        $title =  __('Search : ').$title;
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
                    <div class="widget search-bx widget_search w-100">
                        <form method="get" action="{{ route('permalink.search') }}" >
                            @csrf
                            <div class="input-group d-block">
                                <div class="input-skew">
                                    <input type="text" name="s" class="form-control" placeholder="{{ __('Search..') }}" value="{{ $searchRes }}" required="">
                                </div>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary sharp radius-no"><i class="fa-solid fa-magnifying-glass scale3"></i></button>
                                </span> 
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
                            <div class="{{ (DzHelper::dzHasSidebar()) ? 'col-lg-12' : 'col-lg-8' ; }} m-b30">
                                <div class="dz-card style-1 blog-half">
                                    <div class="dz-media ">
                                        <a href="{{ $single_link }}">
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
                                        <ul class="dz-badge-list">
                                            <li><a href="javascript:void(0);" class="dz-badge">{{ Carbon\Carbon::parse($blog->publish_on)->format('F j, Y') }}</a></li>
                                        </ul>
                                        <a href="{{ DzHelper::laraBlogLink($blog->id) }}" class="btn btn-secondary">{{ __('Read More') }}</a>
                                    </div>
                                    <div class="dz-info">
                                        <div class="dz-meta">
                                            <ul>
                                                <li class="post-author">
                                                    <a href="{{ DzHelper::author($blog->user_id) }}">
                                                        <span>{{ __('By ') }}{{ $blog->user->name }}</span>
                                                    </a>
                                                </li>
                                                <li class="post-date"><a href="javascript:void(0);">{{ Carbon\Carbon::parse($blog->publish_on)->format('F j, Y') }}</a></li>
                                            </ul>
                                        </div>
                                        @php
                                            if($blog->visibility != 'Pu'){
                                                $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ') ;
                                            }else {
                                                $blog_visibility = '';
                                            }
                                        @endphp
                                        <h4 class="title"><a href="{{ $single_link }}">{{ $blog_visibility }}{{ Str::limit($blog->title, 30, ' ...') }}</a></h4>
                                        <p>{{ Str::limit($blog->excerpt, 60, ' ...') }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <div class="col-md-12 text-center"><strong>{{ __('Records Not Found.') }}</strong></div>
                        @endforelse
                    </div>
                </div>
                @include('widgets.sidebar')
            </div>
        </div>
    </div>
<!-- Content end -->
@endsection