<div class="dz-bnr-inr style-1 text-center" data-text="{{ __('HEALTH') }}" style="background-image: url({{ theme_asset('themes/w3cms/bodyshape/images/banner/bg2.png') }});">
    <div class="container">
        <div class="dz-bnr-inr-entry">
            <h1>{{ $title }}</h1>
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
</div>