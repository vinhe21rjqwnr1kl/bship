<div class="main-bnr-one">
	<div class="swiper-container main-slider">
		<div class="swiper-wrapper">
			@if (!empty(config('Theme.home_slider')))
				@php
					$images = explode(",",config('Theme.home_slider'));
				@endphp
				@foreach ($images as $image)
					<div class="swiper-slide">
						<div class="banner-inner" style="background-position: top center;background-image: url({{ asset('storage/configuration-images/'.$image) }})">
						</div>
					</div>
				@endforeach
			@else
				<div class="swiper-slide">
					<div class="banner-inner" style="background-position: top center;background-image: url({{ theme_asset('images/banner/pic2.jpg') }})">
					</div>
				</div>
				<div class="swiper-slide">
					<div class="banner-inner" style="background-position: top center;background-image: url({{ theme_asset('images/banner/pic3.jpg') }})">
					</div>
				</div>
			@endif
		</div>
		<div class="main-btn main-btn-prev"><i class="fa fa-angle-left"></i></div>
		<div class="main-btn main-btn-next"><i class="fa fa-angle-right"></i></div>
	</div>
</div>
<!-- Banner -->