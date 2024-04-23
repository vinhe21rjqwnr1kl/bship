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
					<form action="{{ route('price.admin.km') }}" method="get">
					@csrf
						<input type="hidden" name="todo" value="Filter">
						<div class="row">
		
							<div class="mb-3 col-md-3">
							<select name="service_detail_id" id="service_detail_id" class="default-select form-control">
									@forelse($ServicesDetailArr as $services)
											<option value="{{ $services->id }}">{{ $ServicesArr[$services->service_id] }}--{{ $ServicesTypeArr[$services->service_type] }}</option>
										@empty
										@endforelse
									</select>
							</div>
							<div class="mb-3 col-md-3">
							<input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary me-2"> 
								<a href="{{ route('price.admin.km') }}" class="btn btn-danger">Nhập Lại</a>
							
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
                    @can('Controllers > UsersController > create')
                        <a href="{{ route('price.admin.kmcreate') }}" class="btn btn-primary">Tạo giá theo Km</a>
                    @endcan
                </div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg mb-0">
							<thead class="">
								<tr>
									<th> <strong> STT</strong> </th>
									<th> <strong> Loại </strong> </th>
									<th> <strong> Dịch Vụ </strong> </th>
									<th> <strong> Cách tính tiền </strong> </th>
									<th> <strong> Phí cố định </strong> </th>
									<th> <strong> Phí nhỏ nhất </strong> </th>
									<th> <strong> Giá 1 </strong> </th>
									<th> <strong> Giá 2</strong> </th>
									<th> <strong> Giá 3 </strong> </th>
									<th> <strong> Thao tác </strong> </th>
								</tr>
							</thead>
							<tbody>
								@php
									$i = $Prices->firstItem();
								@endphp
								@forelse ($Prices as $page)
									<tr>
										<td> {{ $i++ }} </td>
										<td> {{$ServicesArr[$page->service_id]}}</td>
										<td> {{ $ServicesTypeArr[$page->service_type]}}</td>
										<td> 
										@if ($page->fee_type == 1)
												<span class="badge badge-success"> Theo Km </span>
											@elseif($page->fee_type == 2)
												<span class="badge badge-danger"> Cố định</span>
											@elseif($page->fee_type == 3)												
												<span class="badge badge-warning"> Theo ngày</span>
											@endif
										</td>
										<td> {{$page->fee_fixed}}</td>
										<td> {{$page->fee_min}}</td>
										<td> <strong>Km:</strong> 1->{{$page->duration_block_first}}<br><strong>Giá:</strong> {{$page->fee_block_first}}</td>
										<td> <strong>Km:</strong> {{$page->duration_block_first}}->{{$page->duration_block_second}}<br><strong>Giá:</strong> {{$page->fee_block_second}}</td>
										<td> <strong>Km:</strong> {{$page->duration_block_second}}->{{$page->duration_block_end}}<br><strong>Giá:</strong> {{$page->fee_block_end}}</td>							
									
										<td class="text-center ">
                                        @can('Controllers > UsersController > edit')
                                            <a href="{{ route('price.admin.kmedit', $page->fee_id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                        @endcan
                                        @can('Controllers > UsersController > destroy')
                                            <a href="{{ route('price.admin.kmdelete', $page->fee_id) }}" class="btn btn-danger shadow btn-xs sharp me-1"><i class="fa fa-trash"></i></a>
                                        @endcan
                                   	 </td>
									
									</tr>
								@empty
									<tr><td class="text-center" colspan="10"><p>Không có dữ liệu.</p></td></tr>
								@endforelse

							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
                    {{ $Prices->onEachSide(2)->appends(Request::input())->links() }}
				</div>
			</div>
		</div>
	</div>

</div>
@endsection