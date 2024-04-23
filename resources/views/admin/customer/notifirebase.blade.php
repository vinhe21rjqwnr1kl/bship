{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Thông tin</h4>
		</div>
		<form action="{{ route('custumer.admin.notifirebasesend') }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
				
						<div class="col-sm-6">
							<div class="row">
							<div class="form-group col-12">
									<label>Danh sách cần gửi </label>
									<input type="text" name="phone" id="phone" class="form-control"  value="{{ old('phone') }}">
			                            <p class="text-danger">
			                               Gửi tất cả nhập: 1 <br>
										   Gửi theo sanh sách nhập : 0908313102;0908313131;
			                            </p>
			               
								</div>
								<div class="form-group col-12">
									<label>Tiêu đề</label>
									<input type="text" name="title" id="title" class="form-control"  value="{{ old('title') }}">
									@error('index')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-12">
									<label>Nội dung</label>
									<input type="text" name="body" id="body" class="form-control"  value="{{ old('body') }}">
									@error('index')
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
			</div>
			<div class="card-footer pt-0 text-end">
				<button type="submit" class="btn btn-primary">Gửi</button>
				<a href="{{ route('custumer.admin.notifirebase') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>
</div>

@endsection