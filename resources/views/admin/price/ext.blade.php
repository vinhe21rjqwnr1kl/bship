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
					<form action="{{ route('price.admin.ext') }}" method="get">
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
								<a href="{{ route('price.admin.ext') }}" class="btn btn-danger">Nhập Lại</a>
							
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
                        <a href="{{ route('price.admin.extcreate') }}" class="btn btn-primary">Tạo giá theo Bảo hiểm/Dịch vụ</a>
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
									<th> <strong> Tiền phí ( bảo hiểm / dịch vụ) </strong> </th>
								
								
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
										<td> {{number_format($page->fee_fixed)}}</td>
										
									
										<td class="text-center ">
                                        @can('Controllers > UsersController > edit')
                                            <a href="{{ route('price.admin.extedit', $page->fee_id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                        @endcan
                                        @can('Controllers > UsersController > destroy')
                                            <a href="{{ route('price.admin.extdelete', $page->fee_id) }}" class="btn btn-danger shadow btn-xs sharp me-1"><i class="fa fa-trash"></i></a>
                                        @endcan
                                   	 </td>
									
									</tr>
								@empty
									<tr><td class="text-center" colspan="7"><p>Không có dữ liệu.</p></td></tr>
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