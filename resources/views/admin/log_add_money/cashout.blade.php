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
                    <div class="accordion-header rounded-lg {{ $collapsed }}" data-bs-toggle="collapse"
                         data-bs-target="#rounded-search-sec">
                        <span class="accordion-header-icon"></span>
                        <h4 class="accordion-header-text m-0">Tìm Kiếm</h4>
                        <span class="accordion-header-indicator"></span>
                    </div>
                    <div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec"
                         data-bs-parent="#search-sec-outer">
                        {{ Form::model(request()->all(), array('route' => array('log_add_money.admin.cashout'), 'method' => 'get')) }}
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => __('Tên hoặc email'))) }}
                            </div>
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('phone', null, array('class' => 'form-control', 'placeholder' => __('Số điện thoại'))) }}
                            </div>

                            <div class=" col-sm-6 col-md-3 col-lg-4 col-xl-3 text-sm-end">
                                <input type="submit" name="search" value="Tìm" class="btn btn-primary me-2"> <a
                                    href="{{ route('log_add_money.admin.cashout') }}" class="btn btn-danger">Nhập
                                    Lại</a>
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
                        {{--                        @can('Controllers > UsersController > create')--}}
                        {{--                            <a href="{{ route('driver.admin.payment_create',0) }}" class="btn btn-primary">Tạo yêu cầu nạp tiền</a>--}}
                        {{--                        @endcan--}}
                    </div>
                    <div class="pe-4 ps-4 pt-2 pb-2">
                        <div class="table-responsive">
                            <table class="table table-responsive-lg mb-0">
                                <thead>
                                <tr>
                                    <th><strong> {{ __('common.s_no') }} </strong></th>
                                    <th><strong> Tên </strong></th>
                                    <th><strong> Email </strong></th>
                                    <th><strong> Số điện thoại </strong></th>
                                    <th><strong> Loại </strong></th>
                                    <th><strong> Ngân hàng </strong></th>
                                    <th><strong> Tên tài khoản </strong></th>
                                    <th><strong> Số tài khoản </strong></th>
                                    <th><strong> Số tiền </strong></th>
                                    <th><strong> Trạng thái </strong></th>
                                    <th><strong> Ngày tạo </strong></th>
                                    <th><strong> Duyệt </strong></th>

                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = $LogAddMoneyRequest->firstItem();
                                @endphp
                                @forelse ($LogAddMoneyRequest as $log)
                                    <tr>

                                        <td> {{ $i++ }} </td>

                                        @if($log->user_type == 1 && $log->user_data)
                                            <td> {{ $log->user_data->name }} </td>
                                            <td> {{ $log->user_data->email }} </td>
                                            <td> {{ $log->user_data->phone }} </td>

                                        @elseif($log->user_type == 2 && $log->user_driver_data)
                                            <td> {{ $log->user_driver_data->name }} </td>
                                            <td> {{ $log->user_driver_data->email }} </td>
                                            <td> {{ $log->user_driver_data->phone }} </td>

                                        @endif

                                        <td>
                                            @if ($log->user_type == 1)
                                                <span class="badge badge-warning">Khách hàng</span>
                                            @elseif ($log->user_type == 2)
                                                <span class="badge badge-success">Tài xế</span>
                                            @endif
                                        </td>
                                        <td> {{ $log->bank_name }} </td>
                                        <td> {{ $log->account_name }} </td>
                                        <td> {{ $log->number_account_id }} </td>
                                        <td> {{ number_format($log->amount) }} </td>
                                        <td>
                                            @if ($log->status == 1)
                                                <span class="badge badge-warning">Chưa duyệt</span>
                                            @elseif ($log->status == 2)
                                                <span class="badge badge-success">Đã duyệt</span>
                                            @elseif($log->status == 0)
                                                <span class="badge badge-danger">Từ chối</span>
                                            @endif
                                        </td>
                                        <td> {{ $log->created_at }} </td>

                                        <td class="text-center">
                                            @if($log->status == 1)
                                                <a href="{{ route('log_add_money.admin.cashout.accept', $log->id) }}"
                                                   class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                        class="fas fa-tasks"></i></a>
{{--                                                <a href="{{ route('log_add_money.admin.cashout.reject', $log->id) }}"--}}
{{--                                                   class="btn btn-danger shadow btn-xs sharp"><i--}}
{{--                                                        class="fa fa-trash"></i></a>--}}

{{--                                                @can('Controllers > UsersController > edit')--}}
{{--                                                    <a href="{{ route('delivery_size.admin.edit', $size->id) }}"--}}
{{--                                                       class="btn btn-primary shadow btn-xs sharp me-1"><i--}}
{{--                                                            class="fas fa-pencil-alt"></i></a>--}}
{{--                                                @endcan--}}
                                                @can('Controllers > UsersController > destroy')
                                                    <button type="button" class="btn btn-danger shadow btn-xs sharp me-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal" data-bs-id="{{$log->id}}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endcan
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Chưa có dữ liệu</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $LogAddMoneyRequest->appends(Request::input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h4 style="margin: 10px 0 0 0;">Xác nhận xóa dữ liệu?</h4>
                </div>
                <div class="modal-footer">
                    <a href="#" id="deleteLink" class="btn btn-danger shadow btn-s sharp me-1"><i
                            class="fa fa-trash"></i></a>
                    <button type="button" class="btn btn-secondary shadow btn-s sharp me-1" data-bs-dismiss="modal"><i
                            class="fa fa-times-circle"></i></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var exampleModal = document.getElementById('exampleModal')
        exampleModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var id = button.getAttribute('data-bs-id')
            var deleteLink = document.getElementById('deleteLink');
            var deleteLinkHref = "{{ route('log_add_money.admin.cashout.reject', ':id') }}";
            deleteLinkHref = deleteLinkHref.replace(':id', id);
            deleteLink.setAttribute('href', deleteLinkHref);
        })
    </script>
@endsection
