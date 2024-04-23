{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')
<script type="text/javascript">
	function change_first(x)
	{
		//var value = document.getElementById("duration_block_first");
		document.getElementById("duration_block_first01").value= x;
	}
	function change_second(x)
	{
		//var value = document.getElementById("duration_block_first");
		document.getElementById("duration_block_second01").value= x;
	
	}
	</script>
<div class="container-fluid">

	<div class="card">
		<form action="{{ route('price.admin.serviceupdate', $Services->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">
						
						<div class="col-sm-12">
							<div class="row">
								<div class="form-group col-md-6">
									<label>Tên </label>
									<input type="text" name="name" id="name"  class="form-control" autocomplete="name"  value="{{ $Services->name}}">
									@error('name')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
								<div class="form-group col-6">
									<label>Thứ tự</label>
									<input type="text" name="is_show_home" id="is_show_home"  class="form-control" autocomplete="name"  value="{{ $Services->is_show_home}}">

									@error('roles')
			                            <p class="text-danger">
			                               * Nếu lớn >0 sẽ hiện thị và thứ từ lớn sẽ hiển thị lên trên.
			                            </p>
			                        @enderror
								</div>
				
								<div class="form-group col-6">
									<label>Trạng thái</label>
									<select name="is_active" id="is_active" class="default-select form-control">
										<option value="1" {{  $Services->is_active == 1 ? 'selected="selected"':'' }}> Hoạt động</option>
										<option value="0"  {{  $Services->is_active == 0 ? 'selected="selected"':'' }}> Ngừng hoạt động</option>
									</select>
									@error('roles')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
						
								<div class="form-group col-6">
									<label>Kinh doanh</label>
									<select name="is_ready" id="is_ready" class="default-select form-control">
										<option value="1" {{  $Services->is_ready == 1 ? 'selected="selected"':'' }}> Kinh doanh</option>
										<option value="0"  {{  $Services->is_ready == 0 ? 'selected="selected"':'' }}> Ngừng kinh doanh</option>
									</select>
									@error('roles')
			                            <p class="text-danger">
			                                {{ $message }}
			                            </p>
			                        @enderror
								</div>
							<div class="form-group col-4">
							<div class="accordion__body p-4 collapse show" id="with-feature-image" data-bs-parent="#accordion-feature-image">
								<div class="featured-img-preview img-parent-box">
									@if(!empty($Services->image))
										<img src="{{ $Services->image }}" class="avatar img-for-onchange"  width="100px" height="100px"> 
									@else
										<img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"  alt="{{ __('common.image') }}" width="100px" height="100px" title="{{ __('common.image') }}"> 
									@endif
									<input type="hidden" name="data[BlogMeta][2][title]" value="image" id="ContentMeta2Title">
									<div class="form-file">
										<input type="file" class="ps-2 form-control img-input-onchange" name="data[BlogMeta][2][value]" accept=".png, .jpg, .jpeg"  id="BlogMeta2Value">
									</div>
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
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">Cập nhật</button>
				<a href="{{ route('price.admin.service') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>

</div>

@endsection