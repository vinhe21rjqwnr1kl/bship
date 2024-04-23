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
			<div class="card">
		
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg mb-0">
							<thead class="">
								<tr>
									<th> <strong> STT</strong> </th>
									<th> <strong> Tên nhóm</strong> </th>
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
										<td> {{$page->name}}</td>
										
										<td> 
											@if ($page->is_active == 1)
												<span class="badge badge-success"> Hoạt động</span>
											@else										
												<span class="badge badge-warning"> Ngừng hoạt động</span>
											@endif
										</td>
									

											<td class="text-center ">
                                        @can('Controllers > UsersController > edit')
                                            <a href="{{ route('price.admin.groupedit', $page->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
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
                    {{ $Services->onEachSide(2)->appends(Request::input())->links() }}
				</div>
			</div>
		</div>
	</div>

</div>
@endsection