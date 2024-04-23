<div class="dz-bnr-inr style-1 text-center">

    <div class="container">
        <div class="dz-bnr-inr-entry">
            <h1 class="text-center">{{ $title }}</h1>
            <!-- Breadcrumb Row -->
            <nav aria-label="breadcrumb" class="breadcrumb-row">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ul>
            </nav>
            <!-- Breadcrumb Row End -->
        </div>
    </div>
    <img class="bg-shape1" src="{{ theme_asset('images/home-banner/shape1.png') }}" alt="{{ __('Banner shape 1') }}">
    <img class="bg-shape2" src="{{ theme_asset('images/home-banner/shape1.png') }}" alt="{{ __('Banner shape 2') }}">
    <img class="bg-shape3" src="{{ theme_asset('images/home-banner/shape3.png') }}" alt="{{ __('Banner shape 3') }}">
    <img class="bg-shape4" src="{{ theme_asset('images/home-banner/shape3.png') }}" alt="{{ __('Banner shape 4') }}">

</div>