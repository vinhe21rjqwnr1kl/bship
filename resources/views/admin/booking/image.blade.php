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
					<form action="{{ route('booking.admin.image') }}" method="get">
					@csrf
						<input type="hidden" name="todo" value="Filter">
						<div class="row">
			
							<div class="mb-3 col-md-3">
							<input type="search" name="name" class="form-control" placeholder="Tên" value="{{ old('name', request()->input('name')) }}">
							</div>
							<div class="mb-3 col-md-3">
							<input type="date" name="datefrom" class="form-control" placeholder="Ngày bắt đầu" value="{{ old('datefrom', request()->input('datefrom')) }}">
							</div>
							<div class="mb-3 col-md-3">
							<input type="date" name="dateto" class="form-control" placeholder="Ngày kết thúc" value="{{ old('dateto', request()->input('dateto')) }}">
							</div>
							<div class="mb-3 col-md-3">
							<input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary me-2"> 
								<a href="{{ route('booking.admin.image') }}" class="btn btn-danger">Nhập Lại</a>
							
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
			<div class="card-header">
                    <h4 class="card-title"></h4>
                        <a href="{{ route('booking.admin.imagecreate') }}" class="btn btn-primary">Thêm hình ảnh</a>
                </div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg mb-0">
							<thead class="">
								<tr>
									<th> <strong> STT</strong> </th>
									<th> <strong> Đại lý </strong> </th>
									<th> <strong> Hình </strong> </th>
							
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
									
										<td> {{$page->s_name}} </td>
										<td> <img src="{{ $page->image }}" width="70" height="50"></td>
										<td> 		
											@if ($page->status== 1)
												<span class="badge badge-success"> Hiện</span>
											@else
												<span class="badge badge-danger">Ẩn</span>
											@endif</td>

								
										<td> {{$page->create_date}} </td>
										<td class="text-center">
												<a href="{{ route('booking.admin.imageedit', $page->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
									
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