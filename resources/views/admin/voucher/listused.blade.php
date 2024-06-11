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
                    {{ Form::model(request()->all(), array('route' => array('admin.voucher.listused'), 'method' => 'get')) }}
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('discount_code', null, array('class' => 'form-control', 'placeholder' => __('Mã khuyến mại'))) }}
                            </div>


                            <div class=" col-sm-6 col-md-3 col-lg-4 col-xl-3 text-sm-end">
                                <input type="submit" name="search" value="Tìm" class="btn btn-primary me-2">
                                <input type="submit" name="excel" value="Excel" class="btn btn-primary me-2">
                                <a href="{{ route('admin.voucher.listused') }}" class="btn btn-danger">Nhập Lại</a>
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
                        <a href="{{ route('admin.voucher.create') }}" class="btn btn-primary">Tạo khuyến mại</a>
                    @endcan
                </div>
                <div class="pe-4 ps-4 pt-2 pb-2">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg mb-0">
                            <thead>
                                <tr>
                                    <th> <strong> STT</strong> </th>
                                    <th> <strong> Mã chuyến</strong> </th>
                                    <th> <strong> Loại </strong> </th>
									<th> <strong> Dịch vụ </strong> </th>
                                    <th> <strong> Mã KM</strong> </th>
                                    <th> <strong> Ngày dùng </strong> </th>
                                    <th> <strong> Khách hàng </strong> </th>
                                    <th> <strong> Tài xế </strong> </th>
                                    <th> <strong> Giá trị</strong> </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = $vouchers->firstItem();
                                @endphp
                                @forelse ($vouchers as $voucher)
                                <tr>
                                    <td> {{ $i++ }} </td>
                                    <td> BSHIP_{{ $voucher->go_info_id }} </td>
                               	    <td>{{ $ServicesArr[$voucher->service_id] }} </td>
									<td> {{ $ServicesTypeArr[$voucher->service_type] }} </td>
                                    <td> {{ $voucher->discount_code }} </td>
                                    <td> {{ $voucher->create_date }} </td>
                                    <td>
                                        <strong>Tên:</strong> {{$voucher->user_name09}}
										<br><strong>SĐT:</strong> {{$voucher->user_phone09}}</br>
                                    </td>
                                    <td>
										<strong>Tên:</strong> {{$voucher->driver_name}}
										<br><strong>SĐT:</strong> {{$voucher->driver_phone}}
								    </td>
                                    <td><strong>Tổng:</strong> {{ number_format($voucher->cost) }}
											<br><strong>Tài xế:</strong>{{ number_format($voucher->butl_cost) }}
											<br><strong>Đại lý:</strong>{{ number_format($voucher->driver_cost) }}
                                            <br><strong>Bảo hiểm:</strong>{{ number_format($voucher->service_cost) }}
                                            <br><strong>Khuyến mại:</strong>{{ number_format($voucher->discount_from_code) }}
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
                    {{ $vouchers->appends(Request::input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
