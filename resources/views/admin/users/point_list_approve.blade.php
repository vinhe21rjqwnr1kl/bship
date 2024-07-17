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
                        {{ Form::model(request()->all(), array('route' => array('admin.point.list-request'), 'method' => 'get')) }}
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('from_user_data', null, array('class' => 'form-control', 'placeholder' => __('Thông tin người gửi'))) }}
                            </div>
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('to_user_data', null, array('class' => 'form-control', 'placeholder' => __('Thông tin người nhận'))) }}
                            </div>

                            <div class=" col-sm-6 col-md-3 col-lg-4 col-xl-3 text-sm-end">
                                <input type="submit" name="search" value="Tìm" class="btn btn-primary me-2"> <a
                                    href="{{ route('admin.point.list-request') }}" class="btn btn-danger">Nhập Lại</a>
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
                    <div class="card-header justify-content-start">
                        <h4 class="card-title"></h4>
                        @can('Controllers > UsersController > create')
                            <div id="action-bar" style="display: none;">
                                <button id="handle-selected" class="btn btn-primary shadow btn-xs">Duyệt (<span
                                        id="selected-count">0</span>)
                                </button>
                            </div>
                        @endcan
                    </div>
                    <div class="pe-4 ps-4 pt-2 pb-2">
                        <div class="table-responsive">
                            <form id="multiple-accept-form"
                                  action="{{ route('admin.point.point_handle_accept_multiple') }}"
                                  method="POST">
                                @csrf
                                <table class="table table-responsive-lg mb-0">
                                    <thead>
                                    <tr>
                                        <th>
                                            <strong>
                                                <input class="form-check-input" type="checkbox" name="choose_all"
                                                       id="choose_all">
                                            </strong>
                                        </th>
                                        <th><strong> Mã </strong></th>
{{--                                        <th><strong> Tên người gửi </strong></th>--}}
{{--                                        <th><strong> SĐT người gửi </strong></th>--}}
                                        <th><strong> Tên người dùng </strong></th>
                                        <th><strong> SĐT người dùng </strong></th>
                                        <th><strong> Điểm </strong></th>
                                        <th><strong> Loại </strong></th>
                                        <th><strong> Lý do </strong></th>
                                        <th><strong> Người tạo </strong></th>
                                        <th><strong> Thời gian </strong></th>
                                        <th><strong> Duyệt </strong></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i = $LogAddPointRequest->firstItem();
                                    @endphp
                                    @forelse ($LogAddPointRequest as $user)
                                        <tr>
                                            <td>
                                                <input class="form-check-input choose_item" type="checkbox"
                                                       name="choose_item[]" value="{{$user->id}}">
                                            </td>
                                            <td> {{ $user->id }} </td>
{{--                                            <td> {{ $user->from_user ? $user->from_user->name : 'ADMIN' }} </td>--}}
{{--                                            <td> {{ $user->from_user ? $user->from_user->phone : 'ADMIN' }} </td>--}}
                                            <td> {{ $user->to_user ? $user->to_user->name : 'Không tìm thấy' }} </td>
                                            <td> {{ $user->to_user ? $user->to_user->phone : 'Không tìm thấy' }} </td>
                                            <td> {{ number_format($user->point) }} </td>
                                            <td style="min-width: 150px; word-wrap: break-word;">
                                                {{ $type_points[$user->type] ?? '-' }}
                                            </td>
                                            <td> {{ $user->reason }} </td>
                                            <td> {{ $user->create_name }}<br>
                                                @if($user->approved_by)
                                                    {{ $user->approved_by }}
                                                @endif
                                            </td>
                                            <td> {{ $user->create_date }} </td>
                                            <td class="text-center">
                                                <button type="submit"
                                                        formaction="{{ route('admin.point.handle-accept', $user->id) }}"
                                                        class="btn btn-primary shadow btn-xs me-1 mt-1">
                                                    Duyệt
                                                </button>
                                                <button type="submit"
                                                        formaction="{{ route('admin.point.handle-remove', $user->id) }}"
                                                        class="btn btn-danger shadow btn-xs me-1 mt-1">
                                                    Xóa
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Chưa có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $LogAddPointRequest->appends(Request::input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/handle-accept-point.js') }}"></script>
@endsection
