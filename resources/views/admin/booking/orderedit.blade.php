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
<form action="{{ route('booking.admin.update', $driver->id ) }}" method="post" enctype="multipart/form-data">
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
										<label for="BlogTitle">Ngày sử dụng:</label>
										<input  name="request_time" class="form-control" id="request_time" placeholder="" value="{{ $driver->request_time }}">
										@error('request_time')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Trạng thái </label>
										
									            <select name="status_order" id="find_index" class="form-control default-select">
                                                    <option value="1" {{  $driver->status_order == 1 ? 'selected="selected"':'' }}>Mới </option>
													<option value="3" {{  $driver->status_order == 3 ? 'selected="selected"':'' }}>Đang xử lý</option>
													<option value="2" {{  $driver->status_order == 2 ? 'selected="selected"':'' }}>Hoàn thành</option>
													<option value="0" {{  $driver->status_order == 0 ? 'selected="selected"':'' }}>Huỷ </option>

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

