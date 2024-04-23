{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

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
			<div class="card accordion accordion-rounded-stylish accordion-bordered" id="search-sec-outer">
				<div class="accordion-header rounded-lg {{ $collapsed }}" data-bs-toggle="collapse" data-bs-target="#rounded-search-sec">
					<span class="accordion-header-icon"></span>
                    <h4 class="accordion-header-text m-0">Tìm kiếm</h4>
                    <span class="accordion-header-indicator"></span>
				</div>
				<div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec" data-bs-parent="#search-sec-outer">
					<form action="{{ route('booking.admin.order') }}" method="get">
					@csrf
						<input type="hidden" name="todo" value="Filter">
						<div class="row">
							<div class="mb-3 col-md-4">
								<input type="search" name="phone" class="form-control" placeholder="Số điện thoại" value="{{ old('phone', request()->input('phone')) }}">
							</div>
							<div class="mb-3 col-md-4">
							<input type="search" name="name" class="form-control" placeholder="Họ và tên" value="{{ old('name', request()->input('name')) }}">
							</div>
					
							<div class="mb-3 col-md-4">
							<input type="date" name="datefrom" class="form-control" placeholder="Ngày bắt đầu" value="{{ old('datefrom', request()->input('datefrom')) }}">
							</div>
							<div class="mb-3 col-md-4">
							<input type="date" name="dateto" class="form-control" placeholder="Ngày kết thúc" value="{{ old('dateto', request()->input('dateto')) }}">
							</div>
							<div class="mb-3 col-md-4">
							<input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary me-2"> 
								<a href="{{ route('booking.admin.order') }}" class="btn btn-danger">Nhập Lại</a>
							
							</div>
					
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<!-- Column starts -->
		<div class="col-xl-12">
			<div class="card">

				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg mb-0">
							<thead class="">
								<tr>
									<th> <strong> STT</strong> </th>
									<th> <strong> Khách hàng </strong> </th>
									<th> <strong> Đại lý </strong> </th>
									<th> <strong> DV </strong> </th>
									<th> <strong> Thời gian sử dụng </strong> </th>
									<th> <strong> Trạng thái </strong> </th>
									<th> <strong> Thời gian </strong> </th>
									<th> <strong> Thao tác </strong> </th>
								</tr>
							</thead>
							<tbody>
								@php
									$i = $drivers->firstItem();
								@endphp
								@forelse ($drivers as $page)
									<tr>
										<td> {{ $i++ }} </td>
										<td> 
											<strong>Tên:</strong> {{$page->user_name09}}
											<br><strong>SĐT:</strong> {{$page->user_phone09}}
										 </td>
										<td> 
											<strong>Tên:</strong> {{$page->s_name}}
										 </td>
										 <td>{{ $ServicesArr[$page->service_id] }} 
										<td> <strong>{{ $page->request_time }}</strong> </td>
										<td> 		
											

											@if ($page->status_order == 2)
												<span class="badge badge-success"> Hoàn thành</span>
											@elseif($page->status_order == 1)
												<span class="badge badge-info"> Mới</span>
											@elseif($page->status_order == 3)
												<span class="badge badge-warning"> Đang xử lý</span>
											@else
												<span class="badge badge-danger"> Huỷ</span>
											@endif</td>

								
										<td> {{$page->create_date}} </td>
										<td class="text-center">
												<a href="{{ route('booking.admin.edit', $page->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
									
										</td>
										
									</tr>
								@empty
									<tr><td class="text-center" colspan="9"><p>Không có dữ liệu.</p></td></tr>
								@endforelse

							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
                    {{ $drivers->onEachSide(2)->appends(Request::input())->links() }}
				</div>
			</div>
		</div>
	</div>

</div>
@endsection