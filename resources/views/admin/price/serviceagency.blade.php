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
					<form action="{{ route('price.admin.agencyservice') }}" method="get">
					@csrf
						<input type="hidden" name="todo" value="Filter">
						<div class="row">
		
							<div class="mb-3 col-md-3">
							<select name="agency_id" id="agency_id" class="default-select form-control">
									@forelse($AgencyArr as $agency)
											<option value="{{ $agency->id }}">{{ $agency->name }}</option>
										@empty
										@endforelse
									</select>
							</div>
							<div class="mb-3 col-md-3">
							<input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary me-2"> 
								<a href="{{ route('price.admin.cityservice') }}" class="btn btn-danger">Nhập Lại</a>
							
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
                        <a href="{{ route('price.admin.agencyservicecreate') }}" class="btn btn-primary">Tạo dv cho đại lý</a>
                    @endcan
                </div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg mb-0">
							<thead class="">
								<tr>
									<th> <strong> STT</strong> </th>
									<th> <strong> Dịch vụ</strong> </th>
									<th> <strong> Loại</strong> </th>
									<th> <strong> Trạng thái </strong> </th>
									<th> <strong> Thao tác</strong> </th>
								</tr>
							</thead>
							<tbody>
								@php
									$i = $Services->firstItem();
								@endphp
								@forelse ($Services as $page)
									<tr>
										<td> {{ $i++ }} </td>
										<td> {{$ServicesArr[$page->service_id]}}</td>
										<td> {{$ServicesTypeArr[$page->service_type]}}</td>
										<td> {{$page->name}}</td>
										
        
										<td class="text-center">
												<a href="{{ route('price.admin.agencyservicedel', $page->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
										
                               
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
                    {{ $Services->onEachSide(2)->appends(Request::input())->links() }}
				</div>
			</div>
		</div>
	</div>

</div>
@endsection