@extends('layout.default')

@section('content')

    <div class="section-full">
        <div class="container">
            <div class="error-page text-center">
                <div class="dz_error">{{ __('404') }}</div>
                <h2 class="error-head">{{ __('We are sorry. But the page you are looking for cannot be found.') }}</h2>
                <a href="{{ url('/') }}" class="btn radius-no">
                    <span class="p-lr15">{{ __('Back to Home') }}</span>
                </a>
            </div>
        </div>
    </div>
    
@endsection