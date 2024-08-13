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
<form action="{{ route('driver.admin.update', $driver->id ) }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Thông tin</h4>
							</div>
							<div class="card-body p-4">
								<div class="row">
									<div class="form-group col-md-12">
										<label for="BlogTitle">Tên</label>
										<input type="text" name="name" class="form-control" id="name" placeholder="" value="{{ $driver->name }}">
										@error('name')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Số điện thoại</label>
										<input type="hidden" name="phone" value="{{ $driver->phone }}" id="phone">
										<input type="text" name="phone1" disabled class="form-control" id="phone1" placeholder="" value="{{ $driver->phone }}">
										@error('phone')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Ngày sinh:</label>
										<input type="date" name="birthday" class="form-control" id="BlogTitle" placeholder="" value="{{ $driver->birthday }}">
										@error('birthday')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Địa chỉ email</label>
										<input type="text" name="email" class="form-control" id="BlogTitle" placeholder="" value="{{ $driver->email }}">
										@error('email')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">CMND</label>
										<input type="text" name="cmnd" class="form-control" id="BlogTitle" placeholder="" value="{{ $driver->cmnd }}">
										@error('cmnd')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Bằng lái (Hạng)</label>
										<input type="text" name="gplx_level" class="form-control" id="BlogTitle" placeholder="" value="{{ $driver->gplx_level }}">
										@error('gplx_level')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Bằng lái (Số)</label>
										<input type="text" name="gplx_number" class="form-control" id="BlogTitle" placeholder="" value="{{ $driver->gplx_number }}">
										@error('gplx_number')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Số năm kinh nghiệm</label>
										<input type="text" name="exp" class="form-control" id="BlogTitle" placeholder="" value="{{ $driver->exp }}">
										@error('exp')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Biển số xe <span class="text-primary">*(VD: 29K1-288.32)</span></label>
										<input type="text" name="car_num" class="form-control" id="BlogTitle" placeholder="" value="{{ $driver->car_num }}">
										@error('car_num')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Loại xe <span class="text-primary">*(VD: Vinfast Feliz S)</span></label>
										<input type="text" name="car_info" class="form-control" id="BlogTitle" placeholder="" value="{{ $driver->car_info }}">
										@error('car_info')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
                                    <div class="form-group col-md-12">
                                        <label for="car_color">Màu xe <span class="text-primary">*(VD: Cam)</span></label>
                                        <input type="text" name="car_color" class="form-control" id="car_color" placeholder="" value="{{ $driver->car_color }}">
                                        @error('car_color')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="car_identification">Số khung</label>
                                        <input type="text" name="car_identification" class="form-control" id="car_identification" placeholder="" value="{{ $driver->car_identification }}">
                                        @error('car_identification')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

									<div class="form-group col-md-12">
										<label for="BlogTitle">Trạng thái</label>

									            <select name="is_active" id="is_active" class="form-control default-select">
                                                    <option value="1" {{  $driver->is_active == 1 ? 'selected="selected"':'' }}>Hoạt động</option>
                                                    <option value="2" {{  $driver->is_active != 1 ? 'selected="selected"':'' }}>Ngưng hoạt động</option>
                                                </select>
									</div>

									<div class="form-group col-md-12">
										<label for="BlogTitle">Ngày Khoá: <font color="red">{{ $driver->day_lock }}</font></label>
										<input type="date" name="day_lock" class="form-control" id="day_lock" value="{{ $driver->day_lock }}">
										@error('day_lock')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									@if($userId ==1)
									<div class="form-group col-md-12">
										<label for="BlogTitle">Nhận cuốc ( ưu tiên ) </label>

									            <select name="find_index" id="find_index" class="form-control default-select">
													<option value="0" {{  $driver->find_index == 0 ? 'selected="selected"':'' }}>Không nhận chuyến </option>
                                                    <option value="1" {{  $driver->find_index == 1 ? 'selected="selected"':'' }}>Ưu tiên </option>
													<option value="2" {{  $driver->find_index == 2 ? 'selected="selected"':'' }}>Ưu tiên trung bình</option>
                                                    <option value="3" {{  $driver->find_index == 3 ? 'selected="selected"':'' }}>Ưu tiên thấp</option>
                                                </select>
									</div>
									@else
									<input type="hidden" name="find_index" value="{{ $driver->find_index }}" id="find_index">

									@endif

                                    <div class="form-group col-md-12">
                                        <label for="reason_for_block">Lý do khóa tài khoản</label>
                                        <input type="text" name="reason_for_block" class="form-control" id="reason_for_block" placeholder="" value="{{ $driver->reason_for_block ?? null }}" {{ ($driver->is_active != 1 || !empty($driver->day_lock)) ? 'required' : '' }}>
                                        @error('reason_for_block')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
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
			<div class="col-md-4">
				<div class="row">
				<div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XFeaturedImage" id="accordion-feature-image">
							<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-feature-image-1" aria-expanded="true">
								<h4 class="card-title">Hình Tài Xế</h4>
								<span class="accordion-header-indicator"></span>
							</div>
							<div class="accordion__body p-4 collapse show" id="with-feature-image-1" data-bs-parent="#accordion-feature-image">
								<div class="featured-img-preview img-parent-box">
									@if(!empty($driver->avatar_img))
										<img src="{{ $driver->avatar_img }}" class="avatar img-for-onchange"  width="100px" height="100px">
									@else
										<img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"  alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}">
									@endif
									<input type="hidden" name="data[BlogMeta][0][title]" value="avatar" id="ContentMeta0Title">
									<div class="form-file mb-1">
										<input type="file" class="ps-2 form-control img-input-onchange" name="data[BlogMeta][0][value]" accept=".png, .jpg, .jpeg"  id="BlogMeta0Value">
									</div>
                                        <font color="red">*(Ảnh không quá 2MB)</font>


                                </div>
                                @error('data.BlogMeta.0.value')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
							</div>
						</div>
					</div>
				<div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XFeaturedImage {{ $screenOption['FeaturedImage']['visibility'] ? '' : 'd-none' }}" id="accordion-feature-image">
							<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-feature-image-2" aria-expanded="true">
								<h4 class="card-title">Hình CMND</h4>
								<span class="accordion-header-indicator"></span>
							</div>
							<div class="accordion__body p-4 collapse show" id="with-feature-image-2" data-bs-parent="#accordion-feature-image">
								<div class="featured-img-preview img-parent-box">  <font color="red"> Mặt trước</font>
									@if(!empty($driver->cmnd_image))
										<img src="{{ $driver->cmnd_image }}" class="avatar img-for-onchange"  width="100px" height="100px">
									@else
										<img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"  alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}">
									@endif
									<input type="hidden" name="data[BlogMeta][1][title]" value="cmnd" id="ContentMeta1Title">
									<div class="form-file mb-1">
										<input type="file" class="ps-2 form-control img-input-onchange" name="data[BlogMeta][1][value]" accept=".png, .jpg, .jpeg"  id="BlogMeta1Value">
									</div>
                                    <font color="red">*(Ảnh không quá 2MB)</font>

                                </div>
                                @error('data.BlogMeta.0.value')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
							</div>
							<div class="accordion__body p-4 collapse show" id="with-feature-image-2" data-bs-parent="#accordion-feature-image">
								<div class="featured-img-preview img-parent-box"> <font color="red"> Mặt sau</font>

								@if(!empty($driver->cmnd_image_s))
										<img src="{{ $driver->cmnd_image_s }}" class="avatar img-for-onchange"  width="100px" height="100px">
									@else
										<img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"  alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}">
									@endif
									<input type="hidden" name="data[BlogMeta][3][title]" value="cmnd_s" id="ContentMeta3Title">
									<div class="form-file mb-1">
										<input type="file" class="ps-2 form-control img-input-onchange" name="data[BlogMeta][3][value]" accept=".png, .jpg, .jpeg"  id="BlogMeta3Value">
									</div>
                                    <font color="red">*(Ảnh không quá 2MB)</font>

                                </div>
                                @error('data.BlogMeta.0.value')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="card accordion accordion-rounded-stylish accordion-bordered XFeaturedImage {{ $screenOption['FeaturedImage']['visibility'] ? '' : 'd-none' }}" id="accordion-feature-image">
							<div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#with-feature-image-3" aria-expanded="true">
								<h4 class="card-title">Hình bằng lái</h4>
								<span class="accordion-header-indicator"></span>
							</div>
							<div class="accordion__body p-4 collapse show" id="with-feature-image-3" data-bs-parent="#accordion-feature-image">
								<div class="featured-img-preview img-parent-box">  <font color="red"> Mặt trước</font>
									@if(!empty($driver->gplx_image))
										<img src="{{ $driver->gplx_image }}" class="avatar img-for-onchange"  width="100px" height="100px">
									@else
										<img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"  alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}">
									@endif
									<input type="hidden" name="data[BlogMeta][2][title]" value="gplx" id="ContentMeta2Title">
									<div class="form-file mb-1">
										<input type="file" class="ps-2 form-control img-input-onchange" name="data[BlogMeta][2][value]" accept=".png, .jpg, .jpeg"  id="BlogMeta2Value">
									</div>
                                    <font color="red">*(Ảnh không quá 2MB)</font>
                                </div>
                                @error('data.BlogMeta.1.value')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
							</div>
							<div class="accordion__body p-4 collapse show" id="with-feature-image-3" data-bs-parent="#accordion-feature-image">
								<div class="featured-img-preview img-parent-box"> <font color="red"> Mặt sau</font>

								@if(!empty($driver->gplx_image_s))
										<img src="{{ $driver->gplx_image_s }}" class="avatar img-for-onchange"  width="100px" height="100px">
									@else
										<img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"  alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}">
									@endif
									<input type="hidden" name="data[BlogMeta][4][title]" value="gplx_s" id="ContentMeta2Title">
									<div class="form-file mb-1">
										<input type="file" class="ps-2 form-control img-input-onchange" name="data[BlogMeta][4][value]" accept=".png, .jpg, .jpeg"  id="BlogMeta4Value">
									</div>
                                    <font color="red">*(Ảnh không quá 2MB)</font>
                                </div>
                                @error('data.BlogMeta.1.value')
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
	</form>
</div>

@push('inline-scripts')
    <script>
        'use strict';
        var screenOptionArray = '<?php echo json_encode($screenOption) ?>';

        // Thêm logic mới ở đây
        document.addEventListener('DOMContentLoaded', function() {
            const isActiveSelect = document.getElementById('is_active');
            const dayLockInput = document.getElementById('day_lock');
            const reasonForBlockInput = document.getElementById('reason_for_block');
            const reasonForBlockGroup = reasonForBlockInput.closest('.form-group');

            function updateReasonForBlock() {
                const isInactive = isActiveSelect.value != '1';
                const hasDayLock = dayLockInput.value !== '';

                if (isInactive) {
                    reasonForBlockGroup.style.display = 'block';
                    reasonForBlockInput.required = true;
                } else {
                    reasonForBlockGroup.style.display = 'none';
                    reasonForBlockInput.required = false;
                }
            }

            isActiveSelect.addEventListener('change', updateReasonForBlock);
            dayLockInput.addEventListener('change', updateReasonForBlock);

            // Gọi hàm lần đầu để thiết lập trạng thái ban đầu
            updateReasonForBlock();
        });
    </script>
@endpush

@endsection

