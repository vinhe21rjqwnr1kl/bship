@extends('layout.default')

@section('content')

    <!-- Content -->
    <div class="page-content bg-white">
        <!-- Error Page -->
        <div class="section-full content-inner-2">
            <div class="container">
                <div class="error-page text-center">
                    <div class="dz_error "><small>{{ __('under maintenance') }}</small></div>
                    <h2 class="error-head">{!! config('Site.maintenance_message') !!}</h2>
                </div>
            </div>
        </div>
        <!-- Error Page End -->
    </div>
    <!-- Content END-->
@endsection
