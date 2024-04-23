@extends('layout.fullwidth')

@section('content')

    <div class="section-full">
        <div class="container">
            <div class="error-page text-center">
                <img class="mb-3" src="{{ asset('storage/configuration-images/'.config('Site.logo')) }}" alt="{{ __('Site Logo') }}">
                <div class="dz_error ">{{ __('503') }}</div>
                <h2 class="error-head text-lowercase">{!! config('Site.maintenance_message') !!}</h2>
            </div>
        </div>
    </div>
    
@endsection