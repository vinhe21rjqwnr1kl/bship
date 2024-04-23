@extends('layout.default')

@section('content')
<!-- Content -->
        <!-- Page Detail -->

        @if (Str::contains($page->slug, 'home'))
            @include('elements.main-banner');
        @else
            @php
                $title = Str::limit($page->title, 10, ' ...');
            @endphp
            @include('elements.banner-inner', compact('title'))
        @endif

        @if ($page)
            @if ($page->visibility == 'PP' && $status == 'locked')
            <div class="container">
                <form method="POST" action="" class="dz-form style-1 my-5 ">
                    @csrf
                    <p>{{ __('This content is password protected. To view it please enter your password below:') }}</p>

                    <div class=" row">
                        <div class="col-md-8 d-flex">
                            <div class="input-area col-sm-8">
                                <label for="password" class="form-control-label">{{ __('Password') }}</label>
                                <div class=" input-line">
                                    <input id="password" type="password" class="form-control" required name="password">
                                </div>
                                @error('password')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="col-sm-4 text-end">
                                <button type="submit" class="btn btn-primary btn-skew">
                                    <span>{{ __('Login') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endif
            @if ($status == 'unlock_'.$page->id)
                {!! $page->content !!}

                <!-- Child Pages Detail End -->
                @if (optional($page->child_pages)->isNotEmpty())
                <div class="container">
                    <h4>{{ __('Related Pages') }}</h4>
                    <ul class="related-pages p-l m-b30">
                        @forelse($page->child_pages as $child_page)
                        <li>
                            -<a href="{!! DzHelper::laraPageLink($child_page->id) !!}" class="pl-2 ">{{ $child_page->title }}</a>
                            @if ($child_page->child_pages->isNotEmpty())
                                {!! DzHelper::getChildPage($child_page->child_pages) !!}
                            @endif
                        </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
                @endif
                <!-- Child Pages Detail End -->
            @endif
        @else
            <div class="col-12">{{ __('No record found.') }}</div>
        @endif
        <!-- Page Detail End -->
        
<!-- Content end -->
@endsection