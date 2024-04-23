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
<form action="{{ route('booking.admin.commentupdate', $driver->id ) }}" method="post" enctype="multipart/form-data">
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
										<label for="BlogTitle">Tiêu đề:</label>
										<input  name="title" class="form-control" id="title" placeholder="" value="{{ $driver->title }}">
										@error('title')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Nội dung:</label>
										<input  name="content" class="form-control" id="content" placeholder="" value="{{ $driver->content }}">
										@error('content')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Trạng thái bình luận </label>
										
									            <select name="comment_tag" id="comment_tag" class="form-control default-select">
                                                    <option value="AWESOME" {{  $driver->comment_tag == 'AWESOME' ? 'selected="selected"':'' }}> {{ $comment_tag["AWESOME"] }}</option>
													<option value="GOOD" {{  $driver->comment_tag == 'GOOD' ? 'selected="selected"':'' }}>  {{ $comment_tag["GOOD"] }}</option>
													<option value="PASSABLE" {{  $driver->comment_tag == 'PASSABLE' ? 'selected="selected"':'' }}> {{$comment_tag["PASSABLE"] }}</option>
													<option value="MIDDLE" {{  $driver->comment_tag == 'MIDDLE' ? 'selected="selected"':'' }}> {{$comment_tag["MIDDLE"] }}</option>

                                                </select>
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

