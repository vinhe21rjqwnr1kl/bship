{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Thông tin</h4>
		</div>
		<form action="{{ route('driver.admin.drservicestore') }}" method="post" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
				
						<div class="col-sm-6">
							<div class="row">
						
								<div class="form-group col-12">
									<label>Số Điện thoại tài xế</label>
									<input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
									@error('phone')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
							
								<div class="form-group col-12">
									<label>Dịch vụ</label>
									<select name="service_detail_id" id="service_detail_id" class="default-select form-control">
									@forelse($ServicesDetailArr as $services)
											<option value="{{ $services->id }}">{{ $ServicesArr[$services->service_id] }}--{{ $ServicesTypeArr[$services->service_type] }}</option>
										@empty
										@endforelse
									</select>
									@error('roles')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
						
							</div>
						</div>
					</div>
				</div>
			
			<div class="card-footer pt-0 text-end">
				<button type="submit" class="btn btn-primary">Tạo</button>
				<a href="{{ route('driver.admin.drservice') }}" class="btn btn-danger">Quay lại</a>
			</div></div
		</form>
	</div>
</div>

@endsection