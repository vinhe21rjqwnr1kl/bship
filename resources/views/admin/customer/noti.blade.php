{{-- Extends layout --}}
@extends('admin.layout.default')
{{-- Content --}}
@section('content')
<div class="container-fluid">
    @php
        $collapsed = 'collapsed';
        $show = '';
    @endphp

    @if(!empty(request()->name) || !empty(request()->email) || !empty(request()->role))
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
                    <h4 class="accordion-header-text m-0">Tìm Kiếm</h4>
                    <span class="accordion-header-indicator"></span>
                </div>
                <div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec" data-bs-parent="#search-sec-outer">
                    {{ Form::model(request()->all(), array('route' => array('custumer.admin.notify'), 'method' => 'get')) }}
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => __('Tiêu đề'))) }}
                            </div>
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('phone', null, array('class' => 'form-control', 'placeholder' => __('Số điện thoại'))) }}
                            </div>
              
                            <div class=" col-sm-6 col-md-3 col-lg-4 col-xl-3 text-sm-end">
                                <input type="submit" name="search" value="Tìm" class="btn btn-primary me-2"> <a href="{{ route('custumer.admin.notify') }}" class="btn btn-danger">Nhập Lại</a>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <!-- row -->
    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"></h4>
                    @can('Controllers > UsersController > create')
                        <a href="{{ route('custumer.admin.notifycreate') }}" class="btn btn-primary">Tạo thông báo</a>
                    @endcan
                </div>
                <div class="pe-4 ps-4 pt-2 pb-2">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg mb-0">
                            <thead>
                                <tr>
                                    <th> <strong> {{ __('common.s_no') }} </strong> </th>
                                    <th> <strong> Tiêu đề </strong> </th>
                                    <th> <strong> Nội dung </strong> </th>
                                    <th> <strong> Người  nhận</strong> </th>
                                    <th> <strong> Trạng thái </strong> </th>
                                    <th> <strong> Loại </strong> </th>
                                    <th class="text-center"> <strong> Thao tác </strong> </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = $noti->firstItem();
                                @endphp
                                @forelse ($noti as $notis)
                                <tr>
                                    <td> {{ $i++ }} </td>
                                    <td> {{ $notis->title }} </td>
                                    <td> {{ $notis->content }} </td>
                                    <td> {{ $notis->phone }} </td>
                                    <td> 
                                        @if ($notis->is_read == 1)
                                            <span class="badge badge-success"> Đã đọc </span>
                                        @else											
                                            <span class="badge badge-warning"> Chưa  đọc</span>
                                        @endif
                                    </td>
                                    <td> 
                                        @if ($notis->type == 1)
                                            <span class="badge badge-success"> Khách hàng </span>
                                        @else											
                                            <span class="badge badge-warning"> Tài xế</span>
                                        @endif
                                    </td>
                                    
                                    <td class="text-center">
												<a href="{{ route('custumer.admin.notifydelete', $notis->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                   	 </td>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('common.no_users') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $noti->appends(Request::input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection