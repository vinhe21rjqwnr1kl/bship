{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Thông tin</h4>
		</div>
		<form action="{{ route('custumer.admin.bannerstore') }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
				
						<div class="col-sm-6">
							<div class="row">
								<div class="form-group col-12">
									<label>Trạng thái</label>
									<select name="status" id="status" class="default-select form-control">
										<option value="1"> Hiển thị</option>
										<option value="0">Không hiển thị</option>
									</select>
								</div>
								<div class="form-group col-12">
									<label>Thứ tự</label>
									<input type="text" name="index" id="index" class="form-control"  value="{{ old('index') }}">
									@error('index')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="accordion__body p-4 collapse show" id="with-feature-image" data-bs-parent="#accordion-feature-image">
								<div class="featured-img-preview img-parent-box"> 

									<img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"  alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}"> 

									<input type="hidden" name="data[BlogMeta][4][title]" value="image" id="ContentMeta2Title">
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
			<div class="card-footer pt-0 text-end">
				<button type="submit" class="btn btn-primary">Tạo</button>
				<a href="{{ route('custumer.admin.banner') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>
</div>

@endsection