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
                    {{ Form::model(request()->all(), array('route' => array('admin.voucher.index'), 'method' => 'get')) }}
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('discount_code', null, array('class' => 'form-control', 'placeholder' => __('Mã khuyến mại'))) }}
                            </div>
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('title', null, array('class' => 'form-control', 'placeholder' => __('Tiêu đề'))) }}
                            </div>
              
                            <div class=" col-sm-6 col-md-3 col-lg-4 col-xl-6 text-sm-end">
                                 <input type="submit" name="excel" value="Excel" class="btn btn-primary me-2"> 
                                <input type="submit" name="search" value="Tìm" class="btn btn-primary me-2">
                                 <a href="{{ route('admin.voucher.index') }}" class="btn btn-danger">Nhập Lại</a>
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
                                    <th> <strong> Loại </strong> </th>
									<th> <strong> Dịch Vụ </strong> </th>
                                    <th> <strong> Mã </strong> </th>
                                    <th> <strong> Loại KM </strong> </th>
                                    <th> <strong> Giá trị</strong> </th>
                                    <th> <strong> Ngày bắt đầu </strong> </th>
                                    <th> <strong> Ngày kết thúc </strong> </th>
                                    <th> <strong> Số lần dùng </strong> </th>
                                    <th> <strong> Số lần đã dùng </strong> </th>
                                    <th> <strong> Tiêu đề  </strong> </th>
                                    <th> <strong> Ghi chú  </strong> </th>
                                    <th> <strong> Trạng thái  </strong> </th>
                                    <th> <strong> Cập nhật <br> ngưng hoạt động  </strong> </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = $vouchers->firstItem();
                                @endphp
                                @forelse ($vouchers as $voucher)
                                <tr>
                                    <td> {{ $i++ }} </td>
                                    <td> {{$ServicesArr[$voucher->service_id]}}</td>
									<td> {{ $ServicesTypeArr[$voucher->service_type]}}</td>
                                    <td> {{ $voucher->discount_code }} </td>
                                    <td>
                                        @if ($voucher->discount_type == 1)
                                            <span class="badge badge-success"> Theo %</span>
                                        @elseif($voucher->discount_type == 2)
                                            <span class="badge badge-danger">Theo VNĐ</span>
                                        @endif 
                                    </td>
                                    <td> {{ $voucher->discount_value }} </td>
                                    <td> {{ $voucher->start_date }} </td>
                                    <td> {{ $voucher->end_time }} </td>
                                    <td> {{ $voucher->times_of_uses }} </td>
                                    <td> {{ $voucher->times_of_used -1 }}  </td>
                                    <td> {{ $voucher->title }} </td>
                                    <td> {{ $voucher->description }} </td>
                                    <td>      @if ($voucher->status == 1)
                                            <span class="badge badge-success"> Đang hoạt động</span>
                                        @elseif($voucher->status == 0)
                                            <span class="badge badge-danger">Ngưng hoạt động</span>
                                        @endif </td>
                                	
										<td class="text-center ">
                                            <a href="{{ route('admin.voucher.edit', $voucher->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                       
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