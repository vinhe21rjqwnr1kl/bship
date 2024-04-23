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
	function change_end(x)
	{
		//var value = document.getElementById("duration_block_first");
		document.getElementById("duration_block_end01").value= x;
	}
	function change_end1(x)
	{
		//var value = document.getElementById("duration_block_first");
		document.getElementById("duration_block_end02").value= x;
	}
	function change_end2(x)
	{
		//var value = document.getElementById("duration_block_first");
		document.getElementById("duration_block_end03").value= x;
	}
	
	</script>
<div class="container-fluid">

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Chỉnh sửa giá tiền theo Km</h4>
		</div>
		<form action="{{ route('price.admin.kmupdate', $CfFee->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
						
						<div class="col-sm-12">
							<div class="row">
							<div class="form-group col-12">
								<strong>* Nếu quãng đường đi nhỏ hơn móc đầu tiên (ô nhập đến 1): Giá = giá min </strong><br>
									<strong>* Nếu quãng đường lớn hơn móc đầu tiên (ô nhập đến 1): Giá = Giá min + ( giá1 * km1)+ ( giá2 * km2)+ ( giá3 * km3)</strong><br>
								</div>
								<div class="form-group col-md-4">
									<label>Từ Km</label>
									<input type="text" name="first_name" id="first_name" disabled class="form-control" autocomplete="first_name" value="1">
									@error('first_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-4">
									<label>Đến Km </label>
									<input type="text" name="duration_block_first" id="duration_block_first"  onchange="change_first(this.value);"  class="form-control" value="{{ $CfFee->duration_block_first }}">
									@error('duration_block_first')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-4">
									<label>Giá</label>
									<input type="text" name="" id="" disabled class="form-control" value="lấy giá min">
									@error('fee_block_first')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-4">
									<label>Từ Km</label>
									<input type="text" name="duration_block_first01" disabled id="duration_block_first01" class="form-control" autocomplete="first_name" value="{{ $CfFee->duration_block_first }}">
									@error('first_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-4">
									<label>Đến Km</label>
									<input type="text" name="duration_block_second" id="duration_block_second" onchange="change_second(this.value);"  class="form-control" value="{{ $CfFee->duration_block_second }}">
									@error('last_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-4">
									<label>Giá</label>
									<input type="text" name="fee_block_first" id="fee_block_first" class="form-control" value="{{ $CfFee->fee_block_first }}">
									@error('last_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-4">
									<label>Từ Km</label>
									<input type="text" name="duration_block_second01"  disabled id="duration_block_second01" class="form-control" autocomplete="first_name" value="{{ $CfFee->duration_block_second }}">
									@error('first_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-4">
									<label>Đến Km</label>
									<input type="text" name="duration_block_end" id="duration_block_end" class="form-control"  onchange="change_end(this.value);" value="{{ $CfFee->duration_block_end }}">
									@error('last_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-4">
									<label>Giá</label>
									<input type="text" name="fee_block_second" id="fee_block_second" class="form-control" value="{{ $CfFee->fee_block_second }}">
									@error('last_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>


								<div class="form-group col-md-4">
									<label>Từ Km </label>
									<input type="text" name="duration_block_end01"  disabled id="duration_block_end01" class="form-control" autocomplete="first_name" value="{{ $CfFee->duration_block_end }}">
									@error('first_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-4">
									<label>Đến Km</label>
									<input type="text" name="duration_block_end_one" id="duration_block_end_one"  class="form-control"  onchange="change_end1(this.value);" value="{{ $CfFee->duration_block_end_one }}">
									@error('last_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-4">
									<label>Giá</label>
									<input type="text" name="fee_block_end" id="fee_block_end" class="form-control" value="{{ $CfFee->fee_block_end }}">
									@error('last_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>


								<div class="form-group col-md-4">
									<label>Từ Km </label>
									<input type="text" name="duration_block_end02"  disabled id="duration_block_end02" class="form-control" autocomplete="first_name" value="{{ $CfFee->duration_block_end_one }}">
									@error('duration_block_end02')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-4">
									<label>Đến Km</label>
									<input type="text" name="duration_block_end_two" id="duration_block_end_two"  class="form-control"  onchange="change_end2(this.value);" value="{{ $CfFee->duration_block_end_two }}">
									@error('duration_block_end_two')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-4">
									<label>Giá</label>
									<input type="text" name="fee_block_end_one" id="fee_block_end_one" class="form-control" value="{{ $CfFee->fee_block_end_one }}">
									@error('last_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>



								
								<div class="form-group col-md-4">
									<label>Từ Km </label>
									<input type="text" name="duration_block_end03"  disabled id="duration_block_end03" class="form-control" autocomplete="first_name" value="{{ $CfFee->duration_block_end_two }}">
									@error('duration_block_end03')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-4">
									<label>Đến Km</label>
									<input type="text" name="" id=""  class="form-control" disable value="15000">
									@error('last_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-md-4">
									<label>Giá</label>
									<input type="text" name="fee_block_end_two" id="fee_block_end_two" class="form-control" value="{{ $CfFee->fee_block_end_two }}">
									@error('fee_block_end_two')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>



						



								<div class="form-group col-12">
									<label>Giá cố định </label>
									<input type="text" name="fee_fixed" id="fee_fixed" class="form-control" value="{{ $CfFee->fee_fixed }}">
									@error('fee_fixed')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>Giá min </label>
									<input type="text" name="fee_min" id="fee_min" class="form-control" value="{{ $CfFee->fee_min }}">
									@error('fee_min')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>Cách tính tiền </label>
									<select name="fee_type" id="fee_type" class="default-select form-control">
										<option value="1" {{  $CfFee->fee_type == 1 ? 'selected="selected"':'' }}> Tính theo km</option>
										<option value="2"  {{  $CfFee->fee_type == 2 ? 'selected="selected"':'' }}> Cố định</option>
										<option value="3"  {{  $CfFee->fee_type == 3 ? 'selected="selected"':'' }} > Theo ngày</option>
									</select>
									@error('roles')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>Loại</label>
									<select name="service_detail_id" id="service_detail_id" disabled class="default-select form-control">
										@forelse($ServicesDetailArr as $services)
											@if($CfFee->service_detail_id == $services->id )
												<option> {{ $ServicesArr[$services->service_id] }}--{{ $ServicesTypeArr[$services->service_type] }}</option>
											@endif
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
				<button type="submit" class="btn btn-primary">Cập nhật</button>
				<a href="{{ route('price.admin.km') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>

</div>

@endsection