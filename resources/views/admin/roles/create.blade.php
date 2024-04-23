{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">



	<div class="card">

		<form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Tên</label>
						<div class="col-sm-9">
							<input type="text" name="name" id="name" class="form-control" autocomplete="name" value="{{ old('name') }}">
							@error('name')
	                            <p class="text-danger">
	                                {{ $message }}
	                            </p>
	                        @enderror
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer text-end">
				<button type="submit" class="btn btn-primary">Tạo</button>
				<a href="{{ route('admin.roles.index') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>

</div>

@endsection