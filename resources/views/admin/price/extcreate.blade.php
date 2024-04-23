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
		<form action="{{ route('price.admin.extstore') }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
						
						<div class="col-sm-12">
								<div class="form-group col-12">
									<label>Số tiền ( cộng) </label>
									<input type="text" name="fee_fixed" id="fee_fixed" class="form-control" value="{{ old('fee_fixed') }}">
									<p class="text-danger">
			                             *** Để giá trị này sẽ được cộng vào giá tổng và không ảnh hưởng % của tài xế và công ty.
			                            </p>
									@error('fee_fixed')
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