{{-- Extends layout --}}
@extends('admin.layout.default')
{{-- Content --}}
@section('content')
    <div class="container-fluid">
        @php
            $collapsed = 'collapsed';
            $show = '';
        @endphp

        @if(!empty(request()->name) || !empty(request()->phone) || !empty(request()->dateto) || !empty(request()->datefrom))
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
                        {{ Form::model(request()->all(), array('route' => array('driver.admin.payment'), 'method' => 'get')) }}
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => __('Tên'))) }}
                            </div>
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('phone', null, array('class' => 'form-control', 'placeholder' => __('Số điện thoại'))) }}
                            </div>


                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                <input type="date" name="datefrom" class="form-control" placeholder="Ngày bắt đầu"
                                       value="{{ old('datefrom', request()->input('datefrom')) }}">
                            </div>
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                <input type="date" name="dateto" class="form-control" placeholder="Ngày kết thúc"
                                       value="{{ old('dateto', request()->input('dateto')) }}">
                            </div>

                            <div class=" col-sm-6 col-md-3 col-lg-4 col-xl-3 text-sm-end">
                                <input type="submit" name="search" value="Tìm" class="btn btn-primary me-1">
                                @can('Controllers > DriverController > handleExportPaymentRequest')
                                    <input type="submit" name="excel" value="Excel" class="btn btn-primary me-1"
                                           formaction="{{ route('driver.admin.export_payment_request') }}">
                                @endcan
                                <a href="{{ route('driver.admin.payment') }}" class="btn btn-danger">Nhập Lại</a>
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
                        <a href="{{ route('driver.admin.payment_create') }}" class="btn btn-primary">Tạo yêu cầu nạp
                            tiền</a>
                    </div>
                    <div class="pe-4 ps-4 pt-2 pb-2">
                        <div class="table-responsive">
                            <table class="table table-responsive-lg mb-0">
                                <thead>
                                <tr>
                                    <th><strong> {{ __('common.s_no') }} </strong></th>
                                    <th><strong> Tên TX</strong></th>
                                    <th><strong> SĐT </strong></th>
                                    <th><strong> Tiền</strong></th>
                                    <th><strong> Loại </strong></th>
                                    <th><strong> Thông tin </strong></th>
                                    <th><strong> Người tạo </strong></th>
                                    <th><strong> Thời gian </strong></th>
                                    <th><strong> Trạng thái </strong></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = $LogAddMoneyRequest->firstItem();
                                @endphp
                                @forelse ($LogAddMoneyRequest as $user)
                                    <tr>
                                        <td> {{ $i++ }} </td>
                                        <td> {{ $user->user_name }} </td>
                                        <td> {{ $user->user_phone }} </td>
                                        <td> {{ number_format($user->money) }} </td>
                                        <td style="min-width: 150px; word-wrap: break-word;">
                                            {{ $type_payments[$user->type] ?? $user->type }}
                                        </td>
                                        <td> {{ $user->reason }} </td>
                                        <td> {{ $user->create_name }} </td>
                                        <td style="min-width: 135px; word-wrap: break-word;"> {{ $user->create_date }} </td>
                                        @php
                                            $currentUser = auth()->user()->email;
                                        @endphp
                                        <td style="min-width: 150px; word-wrap: break-word;">
                                            @if ($user->status == 0)
                                                <span class="badge badge-warning">Chưa duyệt</span>
                                            @elseif ($user->status == 1)
                                                <span class="badge badge-success">Đã duyệt</span>
                                            @elseif($user->status == 2)
                                                <span class="badge badge-danger">Xoá</span>
                                            @endif

                                                @if($user->status == 0 && $currentUser == $user->create_name)
                                                    <form
                                                        action="{{ route('driver.admin.payment_remove_user', $user->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-danger shadow btn-xs sharp me-1">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">{{ __('common.no_users') }}</td>
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
{{--    --}}
@endsection
