@php
    $date = !empty($year) ? $year : '';
    if (!empty($month)){
        $date = $year.' '.$month;
    }
    $title = __('Archives : ').$date;

    if(isset($user) && !empty($user)){
        $title = __('Author :').$user->name;
    }

@endphp

@extends('layout.default')

@section('content')
<!-- Content -->

    @include('elements.banner-inner', compact('title'))

    <div class="section-full bg-white content-inner">
        <div class="container">
            <div class="row">
                @if (DzHelper::dzHasSidebar())
                <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                @else
                <div class="col-12">
                @endif
                    <div class="row loadmore-content">
                        @forelse($blogs as $blog)
                            <div class="{{ (DzHelper::dzHasSidebar()) ? 'col-lg-6' : 'col-lg-4' ; }} m-b30">
                                <div class="dz-card style-1 overlay-shine">
                                    <div class="dz-media ">
                                        <a href="{!! DzHelper::laraBlogLink($blog->id) !!}">
                                            @if(optional($blog->feature_img)->value)
                                                <img src="{{ asset('storage/blog-images/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                                            @else
                                                <img src="{{ asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="dz-info">
                                        <div class="dz-meta">
                                            <ul>
                                                <li class="post-author">
                                                    <a href="{!! DzHelper::author($blog->user_id) !!}">
                                                        <span>{{ __('By') }} {{ $blog->user->name }}</span>
                                                    </a>
                                                </li>
                                                <li class="post-date"><a href="javascript:void(0);">{{ Carbon\Carbon::parse($blog->publish_on)->format('F j, Y') }}</a></li>
                                            </ul>
                                        </div>
                                        @php
                                            if($blog->visibility != 'Pu'){
                                                $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ');
                                            }else {
                                                $blog_visibility = '';
                                            }
                                        @endphp
                                        <h4 class="title"><a href="{!! DzHelper::laraBlogLink($blog->id) !!}">{{ $blog_visibility }}{{ Str::limit($blog->title, 25, ' ...') }}</a></h4>
                                        <p>{{ Str::limit($blog->excerpt, 60, ' ...') }}</p>
                                        <a href="{!! DzHelper::laraBlogLink($blog->id) !!}" class="btn btn-primary btn-skew"><span>{{ __('Read More') }}</span></a>
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
<!-- Content end -->
@endsection
