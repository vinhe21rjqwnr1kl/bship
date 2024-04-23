@extends('layout.default')

@section('content')
<!-- Content -->

    @php
        $title = Str::limit($blog->title, 15, ' ...');
    @endphp
    @include('elements.banner-inner', compact('title'))
 
    <!-- Blog Details -->
    <div class="section-full content-inner bg-white">
        <div class="container">
            @if($blog)
            <div class="row">
                @if (DzHelper::dzHasSidebar())
                <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                @else
                <div class="col-12">
                @endif
                    <div class="blog-post blog-single blog-post-style-2 sidebar">
                        <div class="dlab-post-info">
                            <div class="dlab-post-meta text-center">
                                <ul>
                                    @forelse($blog_categories as $blogcategory)
                                    <li class="post-tag">
                                        <a href="{!! DzHelper::laraBlogCategoryLink($blogcategory->id) !!}">{{ $blogcategory->title }}</a>
                                    </li>
                                    @empty
                                    <li class="post-tag">uncatagorized</li>
                                    @endforelse
                                    <li class="post-date">{{ $blog->publish_on }}</li>
                                </ul>
                            </div>
                            <div class="dlab-post-title text-center">
                                @php
                                    if($blog->visibility != 'Pu'){
                                        $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ');
                                    }else {
                                        $blog_visibility = '';
                                    }
                                @endphp
                                <h2 class="post-title">{{ $blog_visibility }}{{ $blog->title }}</h2>
                            </div>
                            @if ($blog->visibility == 'PP' && $status == 'locked')
                                <form method="POST" action="" class="my-5 text-center">
                                    @csrf

                                    <p>{{ __('This content is password protected. To view it please enter your password below:') }}</p>

                                    <div class="form-group row">
                                        <label for="password" class="form-control-label">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control" name="password">

                                            @error('password')
                                                <p class="text-danger">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                            @if ($status == 'unlock_'.$blog->id)
                                <p class="blog-excerpt text-center">{{ optional($blog)->excerpt }}</p>
                                <div class="dlab-post-text text hjkhjkg">
                                    <div class="wp-block-image alignwide">
                                        <figure class="aligncenter">
                                            @php
                                                $imagepath = isset($blog->page_metas) ? 'page-images' : 'blog-images'; 
                                            @endphp
                                            @if(optional($blog->feature_img)->value)
                                                <img src="{{ theme_asset('storage/'.$imagepath.'/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                                            @else
                                                <img src="{{ theme_asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                                            @endif
                                        </figure>
                                    </div>

                                    {!! $blog->content !!}

                                    @if(optional($blog->video)->value)
                                    <div>
                                        <iframe width="420" height="345" src="{{ $blog->video->value }}"></iframe>
                                    </div>
                                    @endif

                                </div>

                                @if (optional($blog->child_pages)->isNotEmpty())
                                <h4>{{ __('Related Pages') }}</h4>
                                <ul class="related-pages p-l m-b30">
                                    @forelse($blog->child_pages as $child_page)
                                    <li>
                                        -<a href="{!! DzHelper::laraPageLink($child_page->id) !!}" class="pl-2 ">{{ $child_page->title }}</a>
                                        @if ($child_page->child_pages->isNotEmpty())
                                            {!! DzHelper::getChildPage($child_page->child_pages) !!}
                                        @endif
                                    </li>
                                    @empty
                                    @endforelse
                                </ul>
                                @endif
                            @endif   
                            <div class="post-footer">
                                <div class="row ">
                                    <div class="col-lg-4 m-b30">                                               
                                        <span class="m-r5">{{ __('by') }}</span> <a href="{!! DzHelper::author($blog->user_id) !!}" class="text-uppercase">{{ optional($blog->user)->full_name ? optional($blog->user)->full_name : __('No Author') }}</a> 
                                    </div>
                                    @if ($blog->comment != 0)
                                    <div class="col-lg-4 m-b30">
                                        <div class="text-right">
                                            <a href="javascript:void(0);" class="text-uppercase">{{ __('Write A Comment') }}</a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($blogs))
                    <div class="min-container">
                        <div class="row m-b30">
                            <div class="col-lg-3">
                                <div class="sticky-top">
                                    <h6 class="title-style1 text-uppercase">{{ __('Recent Posts') }}</h6>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="row">
                                    @forelse($blogs as $blog)
                                        <div class="col-lg-6">
                                            <div class="category-box overlay m-b30">
                                                <div class="category-media">
                                                    @if(optional($blog->feature_img)->value)
                                                        <img src="{{ theme_asset('storage/blog-images/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}" width="200" height="143">
                                                    @else
                                                        <img src="{{ theme_asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}" width="200" height="143">
                                                    @endif
                                                </div>
                                                <div class="category-info bg-dark p-a20 text-center">
                                                    <h6 class="title m-b0"><a href="{!! DzHelper::laraBlogLink($blog->id) !!}">{{ $blog->title }}</a></h6>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-md-12">{{ __('No record found.') }}</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @include('widgets.sidebar')
            </div>
            @elseif ($page)
                @if ($page->visibility == 'PP' && $status == 'locked')
                    <form method="POST" action="" class="dz-form style-1 my-5 ">
                        @csrf
                        <p>{{ __('This content is password protected. To view it please enter your password below:') }}</p>

                        <div class=" row">
                            <div class="col-md-8">
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

                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-skew">
                                        <span>{{ __('Login') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
                @if ($status == 'unlock_'.$page->id)
                    {!! $page->content !!}
                @endif
            @else
            <div class="col-12">{{ __('No record found.') }}</div>
            @endif
        </div>
    </div>
    <!-- Blog Details End -->

<!-- Content end -->
@endsection
