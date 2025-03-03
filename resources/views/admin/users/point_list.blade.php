{{-- Extends layout --}}
@extends('admin.layout.default')
{{-- Content --}}
@section('content')
    <div class="container-fluid">
        @php
            $collapsed = 'collapsed';
            $show = '';
        @endphp

        @if(!empty(request()->from_user_data) || !empty(request()->to_user_data))
            @php
                $collapsed = '';
                $show = 'show';
            @endphp
        @endif

        <div class="row">
            <!-- Column starts -->
            <div class="col-xl-12">
                <div class="card accordion accordion-rounded-stylish accordion-bordered" id="search-sec-outer">
                    <div class="accordion-header rounded-lg {{ $collapsed }}" data-bs-toggle="collapse"
                         data-bs-target="#rounded-search-sec">
                        <span class="accordion-header-icon"></span>
                        <h4 class="accordion-header-text m-0">Tìm Kiếm</h4>
                        <span class="accordion-header-indicator"></span>
                    </div>
                    <div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec"
                         data-bs-parent="#search-sec-outer">
                        {{ Form::model(request()->all(), array('route' => array('admin.point.list'), 'method' => 'get')) }}
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('from_user_data', null, array('class' => 'form-control', 'placeholder' => __('Thông tin người gửi'))) }}
                            </div>
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('to_user_data', null, array('class' => 'form-control', 'placeholder' => __('Thông tin người nhận'))) }}
                            </div>

                            <div class=" col-sm-6 col-md-3 col-lg-4 col-xl-3 text-sm-end">
                                <input type="submit" name="search" value="Tìm" class="btn btn-primary me-2">
                                <input type="submit" name="excel" value="Excel" class="btn btn-primary me-2">
                                <a href="{{ route('admin.point.list') }}" class="btn btn-danger">Nhập Lại</a>
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
                        {{--                        <a href="{{ route('driver.admin.payment_create') }}" class="btn btn-primary">Tạo yêu cầu nạp tiền</a>--}}
                    </div>
                    <div class="pe-4 ps-4 pt-2 pb-2">
                        <div class="table-responsive">
                            <table class="table table-responsive-lg mb-0">
                                <thead>
                                <tr>
                                    <th><strong> {{ __('common.s_no') }} </strong></th>
                                    {{--                                    <th> <strong> Tên người gửi </strong> </th>--}}
                                    {{--                                    <th> <strong> SĐT người gửi </strong> </th>--}}
                                    <th><strong> Tên người dùng </strong></th>
                                    <th><strong> SĐT người dùng </strong></th>
                                    <th><strong> Điểm </strong></th>
                                    <th><strong> Lý do </strong></th>
                                    <th><strong> Người tạo </strong></th>
                                    <th><strong> Thời gian </strong></th>
                                    <th><strong> Trạng thái </strong></th>

                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = $LogAddPointRequest->firstItem();
                                @endphp
                                @forelse ($LogAddPointRequest as $user)
                                    <tr>
                                        <td> {{ $i++ }} </td>
                                        {{--                                    <td> {{ $user->from_user ? $user->from_user->name : 'ADMIN' }} </td>--}}
                                        {{--                                    <td> {{ $user->from_user ? $user->from_user->phone : 'ADMIN' }} </td>--}}
                                        <td> {{ $user->to_user ? $user->to_user->name : 'Không tìm thấy' }} </td>
                                        <td> {{ $user->to_user ? $user->to_user->phone : 'Không tìm thấy' }} </td>
                                        <td> {{ number_format($user->point) }} </td>
                                        <td style="min-width: 150px; word-wrap: break-word;">
                                            {{ $type_points[$user->type] ?? '-' }}
                                        </td>
                                        <td> {{ $user->reason }} </td>
                                        <td> {{ $user->create_name }} </td>
                                        <td> Tạo: {{ $user->create_name }}<br>
                                            @if($user->approved_by)
                                                Duyệt: {{ $user->approved_by }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->status == 0)
                                                <span class="badge badge-warning">Chưa duyệt</span>
                                            @elseif ($user->status == 1)
                                                <span class="badge badge-success">Đã duyệt</span>
                                            @else
                                                <span class="badge badge-danger">Xoá</span>
                                            @endif

                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">{{ __('Chưa có dữ liệu') }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $LogAddPointRequest->appends(Request::input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
