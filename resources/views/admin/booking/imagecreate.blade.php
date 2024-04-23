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
<form action="{{ route('booking.admin.imagestore') }}" method="post" enctype="multipart/form-data">
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
						
									<div class="form-group col-md-6">
										<div class="row">
											<div class="col-md-6">
												<div class="card accordion accordion-rounded-stylish accordion-bordered XFeaturedImage" id="accordion-feature-image">
													<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-feature-image" aria-expanded="true">
														<h4 class="card-title">Hình dịch vụ</h4>
														<span class="accordion-header-indicator"></span>
													</div>
													<div class="accordion__body p-4 collapse show" id="with-feature-image" data-bs-parent="#accordion-feature-image">
														<div class="featured-img-preview img-parent-box"> 
																<img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"  alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}"> 
													
															<input type="hidden" name="data[BlogMeta][0][title]" value="avatar" id="ContentMeta0Title">
															<div class="form-file">
																<input type="file" class="ps-2 form-control img-input-onchange" name="data[BlogMeta][0][value]" accept=".png, .jpg, .jpeg"  id="BlogMeta0Value">
															</div>
													</div>
														@error('data.BlogMeta.0.value')
															<p class="text-danger">
																{{ $message }}
															</p>
														@enderror
													</div>
												</div>
											</div>
									</div>
					
							
						
									<div class="form-group col-md-12">
										<label for="BlogTitle">Trạng thái </label>
										
									            <select name="status" id="status" class="form-control default-select">
                                                    <option value="0" >Ẩn </option>
													<option value="1" selected>Hiện</option>
                                                </select>
									</div>

									<div class="col-md-12">
										<button type="submit" class="btn btn-primary">Tạo mới</button>
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

