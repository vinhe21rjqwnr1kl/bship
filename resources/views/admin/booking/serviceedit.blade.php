{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')
@php
    $current_user   = auth()->user();
    $roles            =    $current_user->roles->toArray();
    $role_id            =   ($roles[0]['pivot']['role_id']);
    $user_name      = isset($current_user->full_name) ? $current_user->full_name : '';
    $user_email         = isset($current_user->email) ? $current_user->email : '';
    $userId         = isset($current_user->id) ? $current_user->id : '';
    $userImg        = HelpDesk::user_img($current_user->profile);
    
@endphp
<div class="container-fluid">
<form action="{{ route('booking.admin.serviceupdate', $driver->id ) }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Thông tin</h4>
							</div>
							<div class="card-body p-4">
								<div class="row">
							
									<div class="form-group col-md-12">
										<label for="BlogTitle">Tên:</label>
										<input  name="name" class="form-control" id="name" placeholder="" value="{{ $driver->name }}">
										@error('name')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Nội dung:</label>
										<input  name="description" class="form-control" id="description" placeholder="" value="{{ $driver->description }}">
										@error('content')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Giá:</label>
										<input  name="cost" class="form-control" id="cost" placeholder="" value="{{ $driver->cost }}">
										@error('cost')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>

									<div class="form-group col-md-12">
										<label for="BlogTitle">Giá giảm:</label>
										<input  name="org_cost" class="form-control" id="org_cost" placeholder="" value="{{ $driver->org_cost }}">
										@error('org_cost')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>

									<div class="form-group col-md-12">
										<label for="BlogTitle">Trạng thái </label>
										
									            <select name="status" id="status" class="form-control default-select">
                                                    <option value="0" {{  $driver->status == 0 ? 'selected="selected"':'' }}>Ẩn </option>
													<option value="1" {{  $driver->status == 1 ? 'selected="selected"':'' }}>Hiện</option>
                                                </select>
									</div>

									<div class="col-md-12">
										<button type="submit" class="btn btn-primary">Cập nhật</button>
									</div>
								</div>
							</div>
						</div>
					</div>
			
	

				</div>
			</div>	
			
		</div>
	</form>
</div>


@endsection

