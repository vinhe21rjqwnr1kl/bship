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
		<form action="{{ route('price.admin.cityupdate', $CfFee->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
						
						<div class="col-sm-6">
								<div class="form-group col-12">
									<label>Tỷ lệ (nhân)  </label>
									<input type="text" name="ratio" id="ratio" class="form-control" value="{{ $CfFee->ratio }}">
									<p class="text-danger">
			                             *** Để giá trị 0 là thành phố đó không được mở dịch vụ này.
			                            </p>
									@error('fee_fixed')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>Tỉnh/Thành Phố </label>
									<input type="text" name="city" id="city" class="form-control" value="{{ $CfFee->city }}">
									@error('fee_min')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>Tỉnh/Thành Phố ( tìm ở Google Map) </label>
									<input type="text" name="city_search_name" id="city_search_name" class="form-control" value="{{ $CfFee->city_search_name }}">
									@error('fee_min')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>Dịch vụ</label>
									<select name="service_detail_id" id="service_detail_id" class="default-select form-control">
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