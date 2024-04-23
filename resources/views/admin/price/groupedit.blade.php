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
		<form action="{{ route('price.admin.groupupdate', $Services->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
						
						<div class="col-sm-12">
							<div class="row">
								<div class="form-group col-md-6">
									<label>Tên </label>
									<input type="text" name="name" id="name"  class="form-control" autocomplete="name"  value="{{ $Services->name}}">
									@error('name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								
				
								<div class="form-group col-6">
									<label>Trạng thái</label>
									<select name="is_active" id="is_active" class="default-select form-control">
										<option value="1" {{  $Services->is_active == 1 ? 'selected="selected"':'' }}> Hoạt động</option>
										<option value="0"  {{  $Services->is_active == 0 ? 'selected="selected"':'' }}> Ngừng hoạt động</option>
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
				<a href="{{ route('price.admin.group') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>

</div>

@endsection