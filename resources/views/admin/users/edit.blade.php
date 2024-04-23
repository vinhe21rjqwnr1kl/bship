{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">


	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Thông tin</h4>
		</div>
		<form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
						<div class="form-group col-sm-4 ">
							<div class=" text-center">
								<div class="custom-img-upload img-parent-box mt-4">
									
	                                <img src="{{ HelpDesk::user_img($user->profile) }}" class="img-for-onchange" id="RemoveProfile_{{ $user->id }}" alt="{{ __('common.user_profile') }}">
		                            
		                            <div class="upload-btn">

										@if ($user->profile)
			                                <a href="javascript:void(0);" rdx-link="{{ route('admin.user.remove_user_image', $user->id) }}" class="rdxUpdateAjax btn btn-primary btn-xs me-1" rdx-delete-box="RemoveProfile_{{ $user->id }}">{{ __('common.remove') }}</a>
			                            @endif

		                            	<input type="file" class="form-file-input form-control ps-2 img-input-onchange" name="user_img" id="user_img" accept=".png, .jpg, .jpeg" hidden>
		                            	<label class="upload-label btn btn-xs btn-primary m-0" for="user_img">{{ __('common.upload') }}</label>
		                            </div>
	                                @error('user_img')
	                                    <p class="text-danger">
	                                        {{ $message }}
	                                    </p>
	                                @enderror
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="row">
								<div class="form-group col-12">
									<label>Họ</label>
									<input type="text" name="first_name" id="first_name" class="form-control" autocomplete="first_name" value="{{ old('first_name', $user->first_name) }}">
									@error('first_name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>Tên</label>
									<input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
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
									<label>Đại lý</label>
									<select name="agency_id" id="agency_id" class="default-select form-control">
									<option value="0" >Công ty BUTL</option>
										@forelse($agencys as $agency)
											<option value="{{ $agency->id }}"  {{ ($agency->id == $user->agency_id ) ? 'selected="selected"' : '' }}>{{ $agency->name }}</option>
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
			</div>
			<div class="card-footer pt-0 text-end">
				<button type="submit" class="btn btn-primary">Cập nhật </button>
				<a href="{{ route('admin.users.index') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Mật Khẩu</h4>
		</div>
		<form action="{{ route('admin.users.update-password', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row">
						<div class="form-group col-md-6">
							<label for="dz-password">Password</label>
							<div class="input-group">
								<input type="password" name="password" id="dz-password" class="form-control" autocomplete="new-password">
								<span class="input-group-text show-pass"> 
                                    <i class="fa fa-eye-slash"></i>
                                    <i class="fa fa-eye"></i>
                                </span>
							</div>
							@error('password')
	                            <p class="text-danger">
	                                {{ $message }}
	                            </p>
	                        @enderror
						</div>
						<div class="form-group col-md-6">
							<label for="dz-con-password">{{ __('common.confirm_password') }}</label>
							<div class="input-group">
								<input type="password" name="confirm_password" id="dz-con-password" class="form-control" autocomplete="new-password">
								<span class="input-group-text show-con-pass"> 
	                                <i class="fa fa-eye-slash"></i>
	                                <i class="fa fa-eye"></i>
	                            </span>
							</div>
							@error('confirm_password')
	                            <p class="text-danger">
	                                {{ $message }}
	                            </p>
	                        @enderror
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer text-end">
				<button type="submit" class="btn btn-primary">Cập nhật</button>
				<a href="{{ route('admin.users.index') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Nhóm</h4>
		</div>
		<form action="{{ route('admin.users.update_user_roles', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row">
						<label class="p-0 mb-2" for="roles">Thông tin</label>
						<select name="roles[]" id="roles" class="default-select form-control" multiple="true">
							@forelse($roles as $role)
								<option value="{{ $role->id }}" {{ (in_array($role->id, $userRoles)) ? 'selected="selected"' : '' }}>{{ $role->name }}</option>
							@empty
							@endforelse
						</select>
						@error('roles')
	                        <p class="text-red-500 text-xm">
	                            {{ $message }}
	                        </p>
	                    @enderror
					</div>
				</div>
			</div>
			<div class="card-footer text-end">
				<button type="submit" class="btn btn-primary">Cập nhật</button>
				<a href="{{ route('admin.users.index') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>
</div>

@endsection