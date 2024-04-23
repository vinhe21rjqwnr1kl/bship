{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	<form action="{{ route('driver.admin.store') }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Thông tin</h4>
							</div>
							<div class="card-body p-4">
								<div class="row">
									<div class="form-group col-md-12">
										<label for="BlogTitle">Tên</label>
										<input type="text" name="name" class="form-control" id="name" placeholder="" value="{{ old('name') }}">
										@error('name')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Số điện thoại</label>
										<input type="text" name="phone" class="form-control" id="phone" placeholder="" value="{{ old('phone') }}">
										@error('phone')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Ngày sinh:</label>
										<input type="text" name="birthday" class="form-control" id="BlogTitle" placeholder="" value="{{ old('birthday') }}">
										@error('birthday')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Địa chỉ email</label>
										<input type="text" name="email" class="form-control" id="BlogTitle" placeholder="" value="{{ old('email') }}">
										@error('email')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">CMND</label>
										<input type="text" name="cmnd" class="form-control" id="BlogTitle" placeholder="" value="{{ old('cmnd') }}">
										@error('cmnd')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Bằng lái (Hạng)</label>
										<input type="text" name="gplx_level" class="form-control" id="BlogTitle" placeholder="" value="{{ old('gplx_level') }}">
										@error('gplx_level')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Bằng lái (Số)</label>
										<input type="text" name="gplx_number" class="form-control" id="BlogTitle" placeholder="" value="{{ old('gplx_number') }}">
										@error('gplx_number')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Số năm kinh nghiệm</label>
										<input type="text" name="exp" class="form-control" id="BlogTitle" placeholder="" value="{{ old('exp') }}">
										@error('exp')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Biển số xe</label>
										<input type="text" name="car_num" class="form-control" id="BlogTitle" placeholder="" value="{{ old('car_num') }}">
										@error('car_num')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Thông tin xe</label>
										<input type="text" name="car_info" class="form-control" id="BlogTitle" placeholder="" value="{{ old('car_info') }}">
										@error('car_info')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="col-md-12">
										<button type="submit" class="btn btn-primary">Thêm</button>
									</div>
								</div>
							</div>
						</div>
					</div>
		
				</div>
			</div>	
			<div class="col-md-4">
				<div class="row">
				<div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XFeaturedImage {{ $screenOption['FeaturedImage']['visibility'] ? '' : 'd-none' }}" id="accordion-feature-image">
							<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-feature-image" aria-expanded="true">
								<h4 class="card-title">Hình Tài Xế</h4>
								<span class="accordion-header-indicator"></span>
							</div>
							<div class="accordion__body p-4 collapse show" id="with-feature-image" data-bs-parent="#accordion-feature-image">
								<div class="featured-img-preview img-parent-box"> 

									<img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"  alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}"> 

									<input type="hidden" name="data[BlogMeta][0][title]" value="avatar" id="ContentMeta0Title">
									<div class="form-file">
										<input type="file" class="ps-2 form-control img-input-onchange" name="data[BlogMeta][0][value]" accept=".png, .jpg, .jpeg"  id="BlogMeta0Value">
									</div>
							   </div>
                                @error('data.BlogMeta.0.value')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
							</div>
						</div>
					</div>
				<div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XFeaturedImage {{ $screenOption['FeaturedImage']['visibility'] ? '' : 'd-none' }}" id="accordion-feature-image">
							<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-feature-image" aria-expanded="true">
								<h4 class="card-title">Hình CMND</h4>
								<span class="accordion-header-indicator"></span>
							</div>
							<div class="accordion__body p-4 collapse show" id="with-feature-image" data-bs-parent="#accordion-feature-image">
								<div class="featured-img-preview img-parent-box"><font color="red"> Mặt trước</font>
									<img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"  alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}"> 

									<input type="hidden" name="data[BlogMeta][1][title]" value="cmnd" id="ContentMeta1Title">
									<div class="form-file">
										<input type="file" class="ps-2 form-control img-input-onchange" name="data[BlogMeta][1][value]" accept=".png, .jpg, .jpeg"  id="BlogMeta1Value">
									</div>
							   </div>
                                @error('data.BlogMeta.0.value')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
							</div>
							<div class="accordion__body p-4 collapse show" id="with-feature-image" data-bs-parent="#accordion-feature-image">
								<div class="featured-img-preview img-parent-box"> <font color="red"> Mặt sau</font>

									<img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"  alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}"> 

									<input type="hidden" name="data[BlogMeta][3][title]" value="cmnd_s" id="ContentMeta3Title">
									<div class="form-file">
										<input type="file" class="ps-2 form-control img-input-onchange" name="data[BlogMeta][3][value]" accept=".png, .jpg, .jpeg"  id="BlogMeta3Value">
									</div>
							   </div>
                                @error('data.BlogMeta.0.value')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
							</div>
						</div>
						
					</div>
					<div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XFeaturedImage {{ $screenOption['FeaturedImage']['visibility'] ? '' : 'd-none' }}" id="accordion-feature-image">
							<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-feature-image" aria-expanded="true">
								<h4 class="card-title">Hình bằng lái</h4>
								<span class="accordion-header-indicator"></span>
							</div>
							<div class="accordion__body p-4 collapse show" id="with-feature-image" data-bs-parent="#accordion-feature-image">
								<div class="featured-img-preview img-parent-box"> <font color="red"> Mặt trước</font>

									<img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"  alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}"> 

									<input type="hidden" name="data[BlogMeta][2][title]" value="gplx" id="ContentMeta4Title">
									<div class="form-file">
										<input type="file" class="ps-2 form-control img-input-onchange" name="data[BlogMeta][2][value]" accept=".png, .jpg, .jpeg"  id="BlogMeta2Value">
									</div>
							   </div>
                                @error('data.BlogMeta.1.value')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
							</div>
							<div class="accordion__body p-4 collapse show" id="with-feature-image" data-bs-parent="#accordion-feature-image">
								<div class="featured-img-preview img-parent-box"> <font color="red"> Mặt sau</font>

									<img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"  alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}"> 

									<input type="hidden" name="data[BlogMeta][4][title]" value="gplx_s" id="ContentMeta2Title">
									<div class="form-file">
										<input type="file" class="ps-2 form-control img-input-onchange" name="data[BlogMeta][4][value]" accept=".png, .jpg, .jpeg"  id="BlogMeta4Value">
									</div>
							   </div>
                                @error('data.BlogMeta.1.value')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</form>
</div>

@push('inline-scripts')
	<script>
		'use strict';
		var screenOptionArray = '<?php echo json_encode($screenOption) ?>';
	</script>
@endpush

@endsection

