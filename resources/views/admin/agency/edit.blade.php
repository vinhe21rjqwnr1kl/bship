{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Thông tin</h4>
		</div>
		<form action="{{ route('admin.agencys.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
				
						<div class="col-sm-6">
							<div class="row">
								<div class="form-group col-12">
									<label>Tên</label>
									<input type="text" name="name" id="name" class="form-control" autocomplete="first_name" value="{{ old('name', $user->name) }}">
									@error('first_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>Điện thoại</label>
									<input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
									@error('last_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>{{ __('common.email') }}</label>
									<input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
									@error('email')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>Địa chỉ</label>
									<input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->address) }}">
									@error('address')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>Thông tin</label>
									<input type="text" name="info" id="info" class="form-control" value="{{ old('info', $user->info) }}">
									@error('info')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer pt-0 text-end">
				<button type="submit" class="btn btn-primary">Cập nhật</button>
				<a href="{{ route('admin.users.index') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>
</div>

@endsection