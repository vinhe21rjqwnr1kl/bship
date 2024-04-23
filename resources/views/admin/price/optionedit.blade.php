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
		<form action="{{ route('price.admin.optionupdate',$CfServicesOptionDetail->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
						<div class="col-sm-12">
								<div class="form-group col-6">
									<label>Tỷ lệ (nhân)  </label>
									<input type="text" name="cost" id="cost" class="form-control"  value="{{ $CFServicesSub->cost }}">
									<p class="text-danger">
			                             *** Để giá trị * giá , mặc định là 1
			                            </p>
									@error('cost')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-6">
									<label>Tên </label>
									<input type="text" name="name" id="name" class="form-control"  value="{{ $CFServicesSub->name }}">
									@error('name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-6">
									<label>Trạng thái</label>
									<select name="status" id="status" class="default-select form-control">
										<option value="1" {{  $CfServicesOptionDetail->status == 1 ? 'selected="selected"':'' }}> Hoạt động</option>
										<option value="0"  {{  $CfServicesOptionDetail->status == 0 ? 'selected="selected"':'' }}> Ngừng hoạt động</option>
									</select>
									@error('status')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
						
								<div class="form-group col-6">
									<label>Dịch vụ</label>
									<select name="service_detail_id" id="service_detail_id" class="default-select form-control">
									@forelse($ServicesDetailArr as $services)
											@if($CfServicesOptionDetail->service_type == $services->id )
												<option value="{{ $services->id }}" selected>{{ $ServicesArr[$services->service_id] }}--{{ $ServicesTypeArr[$services->service_type] }}</option>
											@else
												<option value="{{ $services->id }}">{{ $ServicesArr[$services->service_id] }}--{{ $ServicesTypeArr[$services->service_type] }}</option>
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
				<button type="submit" class="btn btn-primary">Tạo</button>
				<a href="{{ route('price.admin.option') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>

</div>

@endsection