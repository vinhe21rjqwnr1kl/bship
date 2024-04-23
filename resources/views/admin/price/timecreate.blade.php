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
	
		<form action="{{ route('price.admin.timestore') }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
						
						<div class="col-sm-12">
							<div class="row">
							<div class="form-group col-12">
									<strong>Theo tỷ lệ : Giá = Giá Km  * Tỷ lệ ( theo ưu tiên, thời gian ) * tỷ lệ thành phố</strong><br>
									<strong>Theo mặc định  = Giá mặc định (nếu chọn mặc định) * tỷ lệ thành phố</strong>
								</div>
								<div class="form-group col-md-6">
									<label>Từ ngày</label>
									<input type="text" name="date_from" id="date_from" class="form-control" autocomplete="first_name" value="{{ old('date_from') }}">
									@error('date_from')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-6">
									<label>Đến ngày</label>
									<input type="text" name="date_to" id="date_to"   class="form-control" value="{{ old('date_to') }}">
									@error('date_to')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-6">
									<label>Từ giờ</label>
									<input type="text" name="time_from" id="time_from" class="form-control" value="{{ old('last_name') }}">
									@error('time_from')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-6">
									<label>Đến giờ </label>
									<input type="text" name="time_to"  id="time_to" class="form-control" autocomplete="first_name" value="{{ old('duration_block_first01') }}">
									@error('time_to')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-6">
									<label>Loại thời gian</label>
									<select name="time_type" id="time_type" class="default-select form-control">
										<option value="1"> Giờ</option>
										<option value="2"> Ngày</option>
										<option value="3"> Thứ trong tuần</option>
									</select>
									@error('time_type')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-6">
									<label>Tỷ lệ</label>
									
											
									
									<select name="index_fee_id" id="index_fee_id" class="default-select form-control">
										@forelse($CfIndexTime as $servicesI)
										<option value="{{ $servicesI->id }}">{{ $servicesI->name }}--{{ $servicesI->index }}</option>
										@empty
										@endforelse
									</select>
							
									@error('index_fee_id')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-6">
									<label>Thứ </label>
									<select name="day_of_week" id="day_of_week" class="default-select form-control">
										<option value="0"> Tất cả</option>
										<option value="2"> T2</option>
										<option value="3"> T3 </option>
										<option value="4"> T4 </option>
										<option value="5"> T5 </option>
										<option value="6"> T6 </option>
										<option value="7"> T7 </option>
										<option value="8"> CN </option>
									</select>
									@error('day_of_week')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-6">
									<label>Ưu tiên</label>
									<input type="text" name="priority" id="priority" class="form-control" value="{{ old('last_name') }}">
									@error('priority')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-6">
									<label>Loại phí</label>
									
									<select name="fee_type" id="fee_type" class="default-select form-control">
										<option value="1"> Theo tỷ lệ (hệ số)</option>
										<option value="2"> Theo mặc định </option>
									</select>
									@error('fee_type')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-6">
									<label>Tiền </label>
									<input type="text" name="fee" id="fee" class="form-control" value="{{ old('fee_fixed') }}">
									@error('fee')
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
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">Tạo</button>
				<a href="{{ route('price.admin.km') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>

</div>

@endsection