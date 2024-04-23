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
		<form action="{{ route('price.admin.gservicestore') }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
						
						<div class="col-sm-12">
						<div class="form-group col-12">
									<label>Nhóm</label>
									<select name="group_id" id="group_id" class="default-select form-control">
									@forelse($ServicesGrouplArr as $services)
											<option value="{{ $services->id }}">{{ $services->name }}</option>
										@empty
										@endforelse
									</select>
									@error('roles')
			                            <p class="text-danger">
			                                {{ $group_id }}
			                            </p>
			                        @enderror
								</div>
						
								<div class="form-group col-12">
									<label>Dịch vụ</label>
									<select name="service_id" id="service_id" class="default-select form-control">
									@forelse($ServicesArr as $services)
											<option value="{{ $services->id }}">{{ $services->name }}</option>
										@empty
										@endforelse
									</select>
									@error('service_id')
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
				<a href="{{ route('price.admin.gservice') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>

</div>

@endsection