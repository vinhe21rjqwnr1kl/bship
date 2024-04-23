{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Thông tin</h4>
		</div>
		<form action="{{ route('custumer.admin.notifystore') }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
				
						<div class="col-sm-6">
							<div class="row">
								<div class="form-group col-12">
									<label>Tiêu đề</label>
									<input type="text" name="title" id="title" class="form-control"  value="{{ old('title') }}">
									@error('title')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>Nội dung</label>
									<input type="text" name="content" id="content" class="form-control" value="{{ old('content') }}">
									@error('content')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>Người nhận</label>
									<input type="text" name="receiver_id" id="receiver_id" class="form-control" value="{{ old('receiver_id') }}">
									@error('receiver_id')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>

								<div class="form-group col-12">
									<label>Loại</label>
									<select name="type" id="type" class="default-select form-control">
										<option value="1"> Khách hàng</option>
										<option value="2">Tài xế</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer pt-0 text-end">
				<button type="submit" class="btn btn-primary">Tạo</button>
				<a href="{{ route('custumer.admin.notify') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>
</div>

@endsection