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


	@php
        $collapsed = 'collapsed';
        $show = '';
    @endphp

    @if(!empty(request()->title) || !empty(request()->category) || !empty(request()->user) || !empty(request()->status) || !empty(request()->from) || !empty(request()->to) || !empty(request()->tag) || !empty(request()->visibility) || !empty(request()->publish_on))
        @php
            $collapsed = '';
            $show = 'show';
        @endphp
    @endif

	<!-- row -->
	<!-- Row starts -->

	<div class="row">
		<!-- Column starts -->
		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg mb-0">
							<thead class="">
								<tr>
									<th> <strong> Tên dịch vụ</strong> </th>
									<th> <strong> Loại dịch vụ </strong> </th>
									<th> <strong> Trạng thái từ tài xế </strong> </th>
									<th> <strong> Trạng thái từ quản trị </strong> </th>
									<th> <strong> Đăng ký từ CN</strong> </th>
									<th colspan="2"> <strong>Phần trăm BUTL nhận</strong> </th>
								</tr>
							</thead>
							<tbody>
								@forelse ($CfServiceDetail as $page01)
									<tr>
										<td> {{$ServicesArr[$page01->service_id]}}</td>
										<td> {{$ServicesTypeArr[$page01->service_type]}}</td>
										@if(isset($drivers[$page01->id]) )											
												@if( $drivers[$page01->id]["active"]==1 ) 
													<td> Đang chạy</td>
												@else
													<td> Không chạy</td>
												@endif
												@if( $drivers[$page01->id]["allow_service"]==1 ) 
													<td> <a href="javascript:allow_drs({{ $drivers[$page01->id]['id'] }});" class="btn btn-primary">Khoá</a></td>
												@else
													<td> <a href="javascript:allow_drs({{ $drivers[$page01->id]['id'] }});" class="btn btn-success">Mở</a></td>
												@endif
												<td> <a href="javascript:delete_drs({{ $drivers[$page01->id]['id'] }});" class="btn btn-success">Đã đăng ký</a></td>
												@if($userId ==1 || $role_id ==2)
													<td class="text-center">
														@if(isset($drivers_percent[$page01->id])) 
															<input type="text" name="percent_{{ $page01->id}}" class="form-control" id="percent_{{ $page01->id}}" placeholder="" value="{{ $drivers_percent[$page01->id] }}">
														@else
															<input type="text" name="percent_{{ $page01->id}}" class="form-control" id="percent_{{ $page01->id}}" placeholder="" value="0">
														@endif
													</td>
													<td class="text-center">
														<a href="javascript:percent({{$driver_id}},{{ $page01->id}});" class="btn btn-success">Cập nhật</a>
													</td>
												@else
													<td>Liên hệ BUTL</td>
													<td></td>
												@endif

											

										@else
											<td> </td>
											<td> </td>
											<td> <a href="javascript:create({{$driver_id}},{{ $page01->id}});" class="btn btn-primary">Chưa đăng ký</a></td>
											<td> </td>
											<td> </td>
										@endif

									

									</tr>
								@empty
									<tr><td class="text-center" colspan="9"><p>Không có dữ liệu.</p></td></tr>
								@endforelse

							</tbody>
						</table>
					</div>
				</div>
			
			</div>
		</div>
	</div>

</div>
<script type="text/javascript">

function percent(driver_id, service_detail_id)
{
	var  percent_str	= "percent_"+service_detail_id;
	var percent = document.getElementById(percent_str).value;  
	var url = "{{ route('driver.admin.percent', [':driver_id', ':service_detail_id', ':percent']) }}";
	url = url.replace(':driver_id', driver_id);
	url = url.replace(':service_detail_id', service_detail_id);
	url = url.replace(':percent', percent);
	location.href = url;
}
function create(driver_id, service_detail_id)
{
	var url = "{{ route('driver.admin.drservicestore', [':driver_id', ':service_detail_id']) }}";
	url = url.replace(':driver_id', driver_id);
	url = url.replace(':service_detail_id', service_detail_id);
	location.href = url;
}
function delete_drs(id)
{
	var url = "{{ route('driver.admin.drservicedelete',  ':id') }}";
	url = url.replace(':id', id);
	location.href = url;
}

function allow_drs(id)
{
	var url = "{{ route('driver.admin.drserviceallow',  ':id') }}";
	url = url.replace(':id', id);
	location.href = url;
}
</script>
@endsection