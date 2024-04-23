{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">


	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Thông tin</h4>
		</div>
		<form action="{{ route('admin.usersbutl.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
						
					<div class="form-group col-md-12">
							<label for="BlogTitle">Trạng thái</label>
							
									<select name="is_active" id="is_active" class="form-control default-select">
										<option value="1" {{  $user->is_active == 1 ? 'selected="selected"':'' }}>Hoạt động</option>
										<option value="0" {{  $user->is_active != 1 ? 'selected="selected"':'' }}>Ngưng hoạt động</option>
									</select>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer pt-0 text-end">
				<button type="submit" class="btn btn-primary">Cập nhật </button>
				<a href="{{ route('admin.usersbutl.index') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>

	
</div>

@endsection