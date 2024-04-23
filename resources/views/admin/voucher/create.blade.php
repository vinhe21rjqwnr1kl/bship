{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')
<script type="text/javascript">
	function change_first(x)
	{
		//var value = document.getElementById("duration_block_first");
		document.getElementById("duration_block_first01").value= x;
	}
	function change_second(x)
	{
		//var value = document.getElementById("duration_block_first");
		document.getElementById("duration_block_second01").value= x;
	
	}
	</script>
<div class="container-fluid">

	<div class="card">
		<form action="{{ route('admin.voucher.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
						
						<div class="col-sm-12">
							<div class="row">
							<div class="form-group col-6">
									<label>Loại</label>
									<select name="services_detail_id" id="services_detail_id" class="default-select form-control">
									@forelse($ServicesDetailArr as $services)
											<option value="{{ $services->id }}">{{ $ServicesArr[$services->service_id] }}--{{ $ServicesTypeArr[$services->service_type] }}</option>
										@empty
										@endforelse
									</select>
									@error('services_detail_id')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-6">
									<label>Trạng thái </label>
									<select name="status" id="status" class="default-select form-control">
										<option value="1"> Hoạt động</option>
										<option value="0"> Ngưng hoạt động</option>
									</select>									
									@error('fee_min')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-4">
									<label>Mã Khuyến Mại </label>
									<input type="text" name="discount_code" id="discount_code" class="form-control" value="{{ old('discount_code') }}">
									@error('discount_code')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-4">
									<label>Loại </label>
									<select name="discount_type" id="discount_type" class="default-select form-control">
										<option value="1"> Theo %</option>
										<option value="2"> Theo VNĐ</option>
									</select>									
									@error('discount_type')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-4">
									<label>Giá trị </label>
									<input type="text" name="discount_value" id="discount_value" class="form-control" value="{{ old('discount_value') }}">
									@error('discount_value')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-4">
									<label>Ngày bắt đầu </label>
									<input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
									@error('start_date')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-4">
									<label>Ngày ngày kết thúc  </label>
									<input type="date" name="end_time" id="end_time" class="form-control" value="{{ old('end_time') }}">
									@error('end_time')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-4">
									<label>Số lần sử dụng  </label>
									<input type="text" name="times_of_uses" id="times_of_uses" class="form-control" value="{{ old('times_of_uses') }}">
									@error('times_of_uses')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									
									<label>Tiêu đề  </label>
									<input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
									@error('title')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>Nội dung  </label>
									<input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}">
									@error('description')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
						
								<div class="form-group col-6">
									<label>Loại - điều kiện tham gia </label>
									<select name="condition_id" id="condition_id" class="default-select form-control">
										<option value="1"> Theo thành phố</option>
										<option value="2"> Chỉ định 1 khách hàng</option>
										<option value="3"> Số lần sử dụng dịch vụ BUTL</option>
									</select>									
									@error('discount_type')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-6">
									<label>Giá trị tham gia KM </label>
									<input type="text" name="condition_content" id="condition_content" class="form-control" value="{{ old('discount_value') }}">
									
			                            <p class="text-danger">
										* Thành phố : nhập tên thành phố<br>
										* Chỉ định : nhập số điện thoại <br>
										* Số lần sử dụng dịch vụ : nhập số
			                            </p>
			               
								</div>
								<div class="form-group col-12">
									<label>Số lương cần tạo </label>
									<input type="text" name="quanlity" id="quanlity" value='1' class="form-control" value="{{ old('quantity') }}">
									@error('quantity')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
							</div>
						</div>
				
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">Tạo</button>
				<a href="{{ route('admin.voucher.index') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>

</div>

@endsection