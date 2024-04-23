@extends('layout.default')

@section('content')

    <!-- Error Page -->
    <div class="section-full content-inner-2">
        <div class="container">
            <div class="error-page text-center">
                <div class="dz_error">{{ __('404') }}</div>
                <h2 class="error-head">{{ __('Oops! That page can’t be found.') }}</h2>
                <a href="{{ url('/') }}" class="btn radius-no primary">{{ __('Back to Homepage') }}</a>
            </div>
        </div>
    </div>
    <!-- Error Page End -->

@endsection
