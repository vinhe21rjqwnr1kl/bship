@extends('layout.fullwidth')

@section('content')

    <div class="section-full">
        <div class="container">
            <div class="error-page text-center">
                <img src="{{ asset('storage/configuration-images/'.config('Site.logo')) }}" alt="{{ __('Site Logo') }}">
                <div class="dz_error coming_soon">{{ __('Coming Soon') }}</div>
                <h2 class="error-head text-lowercase">{!! config('Site.comingsoon_message') !!}</h2>
            </div>
        </div>
    </div>
    
@endsection