@extends('layout.default')

@section('content')

    <!-- Banner  -->
    @php
        $title = __('Blog Details');
    @endphp
    @include('elements.banner-inner', compact('title'))
    <!-- Banner End -->


    <!-- Blog Detail -->
    <div class="section-full content-inner bg-white">
        <div class="container">
            <div class="row">
            @if($blog)
                @if (DzHelper::dzHasSidebar())
                <div class="col-lg-8 col-md-7">
                @else
                <div class="col-12">
                @endif
                    @if ($blog->visibility == 'PP' && $status == 'locked')
                        <form method="POST" class="dz-form style-1 my-5 ">
                            @csrf
                            <p>{{ __('This content is password protected. To view it please enter your password below:') }}</p>

                            <div class=" row">
                                <div class="col-lg-8">
                                    <div class="input-area">
                                        <label for="password" class="form-control-label">{{ __('Password') }}</label>
                                        <div class="input-group input-line">
                                            <input id="password" type="password" class="form-control" required name="password">
                                        </div>
                                    </div>
                                    @error('password')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror

                                    <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                </div>
                                <div class="col text-lg-end">
                                    <button type="submit" class="btn btn-primary btn-skew">
                                        <span>{{ __('Login') }}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                    @if ($status == 'unlock_'.$blog->id)
                    <div class="blog-single dz-card sidebar">
                        <div class="dz-media dz-media-rounded">
                            @if(optional($blog->feature_img)->value)
                                <img src="{{ asset('storage/blog-images/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                            @else
                                <img src="{{ asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                            @endif
                        </div>
                        <div class="dz-info m-b30">
                            <div class="dz-meta">
                                <ul>
                                    <li class="post-author">
                                        <a href="{{ DzHelper::author($blog->user_id) }}">
                                            <span>{{ __('By ') }}{{ $blog->user->name }}</span>
                                        </a>
                                    </li>
                                    <li class="post-date">{{ $blog->publish_on }}</li>
                                </ul>
                            </div>
                            @php
                                if($blog->visibility != 'Pu'){
                                    $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ') ;
                                }else {
                                    $blog_visibility = '';
                                }
                            @endphp
                            <h3 class="dz-title">{{ $blog_visibility }}{{ $blog->title }}</h3>
                            <p class="blog-excerpt fs-5">{{ optional($blog)->excerpt }}</p>

                            {!! $blog->content !!}

                            @if(optional($blog->video)->value)
                                <div>
                                    <iframe width="420" height="345" src="{{ $blog->video->value }}"></iframe>
                                </div>
                            @endif

                            @if (optional($blog->child_pages)->isNotEmpty())
                                <h4>{{ __('Related Pages') }}</h4>
                                <ul class="related-pages p-l m-b30">
                                    @forelse($blog->child_pages as $child_page)
                                    <li>
                                        -<a href="{{ DzHelper::laraPageLink($child_page->id) }}" class="pl-2 ">{{ $child_page->title }}</a>
                                        @if ($child_page->child_pages->isNotEmpty())
                                            {{ DzHelper::getChildPage($child_page->child_pages) }}
                                        @endif
                                    </li>
                                    @empty
                                    @endforelse
                                </ul>
                            @endif
                            <div class="dz-share-post">
                                <div class="post-tags">
                                <h6 class="m-b0 m-r10 d-inline">{{ __('Tags:') }}</h6>
                                    @forelse($blog->blog_tags as $blog_tag)
                                    <a href="{{ DzHelper::laraBlogTagLink($blog_tag->id) }}"><span>{{ $blog_tag->title }}</span></a>
                                    @empty
                                    @endforelse
                                </div>
                                <div class="dz-social-icon dark">
                                    <ul>
                                        <li><a target="_blank" class="fab fa-facebook-f" href="{{ config('Social.facebook') }}"></a></li>
                                        <li><a target="_blank" class="fab fa-twitter" href="{{ config('Social.twitter') }}"></a></li>
                                        <li><a target="_blank" class="fab fa-linkedin" href="{{ config('Social.linkedin') }}"></a></li>
                                        <li><a target="_blank" class="fab fa-instagram" href="{{ config('Social.instagram') }}"></a></li>
                                    </ul>
                                </div>                                  
                            </div>
                        </div>
                    </div>
                    @endif   
                    @if(isset($blogs) && !empty($blogs))
                    <div class="widget-title">
                        <h4 class="title">{{ __('Related Blog') }}</h4>
                    </div>
                    <div class="row m-b30 m-sm-b10">
                        @forelse($blogs as $blog)
                            <div class="col-lg-6 m-b30">
                                <div class="dz-card style-1 blog-lg overlay-shine">
                                    <div class="dz-media ">
                                        <a href="{{ DzHelper::laraBlogLink($blog->id) }}">
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
                                        <h4 class="dz-title"><a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ $blog_visibility }}{{ Str::limit($blog->title, 25, ' ...') }}</a></h4>
                                        <p>{{ Str::limit($blog->excerpt, 60, ' ...') }}</p>
                                        <a href="{{ DzHelper::laraBlogLink($blog->id) }}" class="btn btn-primary">{{ __('Read More') }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12">{{ __('No record found.') }}</div>
                        @endforelse
                    </div>
                    @endif
                </div>
                @include('widgets.sidebar')
            @else
                <div class="col-12">{{ __('No record found.') }}</div>
            @endif
        </div>
    </div>
    <!-- Blog Detail End -->

@endsection