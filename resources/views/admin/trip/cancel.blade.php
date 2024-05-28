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

        <!-- row -->
        <!-- Row starts -->
        <div class="row">
            <!-- Column starts -->
            <div class="col-xl-12">
                <div class="card accordion accordion-rounded-stylish accordion-bordered" id="search-sec-outer">
                    <div class="accordion-header rounded-lg {{ $collapsed }}" data-bs-toggle="collapse"
                         data-bs-target="#rounded-search-sec">
                        <span class="accordion-header-icon"></span>
                        <h4 class="accordion-header-text m-0">Tìm kiếm</h4>
                        <span class="accordion-header-indicator"></span>
                    </div>
                    <div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec"
                         data-bs-parent="#search-sec-outer">
                        <form action="{{ route('trip.admin.cancel') }}" method="get">
                            @csrf
                            <input type="hidden" name="todo" value="Filter">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <input type="search" name="phone" class="form-control" placeholder="Số điện thoại"
                                           value="{{ old('phone', request()->input('phone')) }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <input type="search" name="name" class="form-control" placeholder="Họ và tên"
                                           value="{{ old('name', request()->input('name')) }}">
                                </div>
                                {{--							<div class="mb-3 col-md-4">--}}

                                {{--								<select name="progress" class="default-select form-control">--}}

                                {{--									<option  {{ request()->input('progress') == 1 ? 'selected="selected"':'' }} value="1">{{ $CfGoProcessArr[1] }}</option>--}}
                                {{--									<option {{ request()->input('progress') == 2 ? 'selected="selected"':'' }} value="2">{{ $CfGoProcessArr[2] }}</option>--}}
                                {{--									<option {{ request()->input('progress') == 3 ? 'selected="selected"':'' }} value="3">{{ $CfGoProcessArr[3] }}</option>--}}
                                {{--									<option {{ request()->input('progress') == 4 ? 'selected="selected"':'' }} value="4">{{ $CfGoProcessArr[4] }}</option>--}}
                                {{--									<option {{ request()->input('progress') == 5 ? 'selected="selected"':'' }} value="5">{{ $CfGoProcessArr[5] }}</option>--}}

                                {{--								</select>--}}
                                {{--							</div>--}}
                                <div class="mb-3 col-md-3">
                                    <input type="date" name="datefrom" class="form-control" placeholder="Ngày bắt đầu"
                                           value="{{ old('datefrom', request()->input('datefrom')) }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <input type="date" name="dateto" class="form-control" placeholder="Ngày kết thúc"
                                           value="{{ old('dateto', request()->input('dateto')) }}">
                                </div>
                                <div class="mb-3 col-md-4 ">
                                    <input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary me-2">
                                    <a href="{{ route('trip.admin.cancel') }}" class="btn btn-danger">Nhập Lại</a>

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

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-lg mb-0">
                                <thead class="">
                                <tr>
                                    <th><strong> STT</strong></th>
                                    <th><strong> Mã BSHIP </strong></th>
                                    <th><strong> Khách hàng </strong></th>
                                    <th><strong> Tài Xế </strong></th>
                                    <th><strong> DV </strong></th>
                                    <th><strong> Loại </strong></th>
                                    <th><strong> Tiền </strong></th>
                                    <th><strong> Thông tin </strong></th>
                                    <th><strong> Trạng thái </strong></th>
                                    <th><strong> Thời gian </strong></th>
                                    <th><strong> Thao tác </strong></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = $drivers->firstItem();
                                @endphp
                                @forelse ($drivers as $page)
                                    <tr>
                                        <td> {{ $i++ }} </td>
                                        <td> BSHIP_{{ $page->id }} </td>
                                        <td>
                                            <strong>Tên:</strong> {{$page->user_name09}}
                                            <br><strong>SĐT:</strong> {{$page->user_phone09}}
                                        </td>
                                        <td>
                                            <strong>Tên:</strong> {{$page->driver_name}}
                                            <br><strong>SĐT:</strong> {{$page->driver_phone}}
                                        </td>
                                        <td>{{ $ServicesArr[$page->service_id] }}
                                        </td>
                                        <td>
                                            {{ $ServicesTypeArr[$page->service_type] }} </td>

                                        <td><strong>Tổng:</strong> {{ number_format($page->cost) }}
                                            <br><strong>Tài
                                                xế:</strong>{{ number_format($page->butl_cost  +  $page->service_cost) }}
                                            <br><strong>Đại
                                                lý:</strong>{{ number_format($page->driver_cost - $page->service_cost) }}
                                            <br><strong>Bảo hiểm:</strong>{{ number_format($page->service_cost) }}
                                            <br><strong>Khuyến
                                                mại:</strong>{{ number_format($page->discount_from_code) }}

                                        </td>
                                        <td>
                                            <strong>Số KM:</strong> {{ $page->distance/1000 }}
                                            <br><strong>Đón:</strong> {{ $page->pickup_address }}
                                            <br><strong>Đến:</strong> {{ $page->drop_address }}
                                            @if($page->drop_second_address)
                                                <br><strong>Đến:</strong> {{ $page->drop_second_address }}
                                            @else
                                            @endif

                                        </td>
                                        <td>

                                            @if ($page->progress == 3)
                                                <span
                                                    class="badge badge-success"> {{ $CfGoProcessArr[$page->progress] }}</span>
                                            @elseif($page->progress == 4)
                                                <span
                                                    class="badge badge-danger"> {{ $CfGoProcessArr[$page->progress] }}</span>
                                            @else
                                                <span
                                                    class="badge badge-warning"> {{ $CfGoProcessArr[$page->progress] }}</span>
                                            @endif
                                        </td>
                                        <td> {{ $page->create_date}} </td>

                                        <td class="text-center">
                                            @if (!in_array($page->service_detail_id, [33]))
                                                @if($page->progress == 4 && $page->log_add_money_request_status === 0)
                                                    <span class="badge badge-warning">Chờ duyệt</span>

                                                @elseif($page->progress == 4 && $page->log_add_money_request_status === 1)
                                                    <span class="badge badge-success">Thành công</span>

                                                @elseif($page->progress == 4 && $page->log_add_money_request_status === 2)
                                                    <span class="badge badge-primary">Thất bại</span>

                                                @elseif($page->progress == 4)
                                                    <a href="{{ route('driver.admin.payment_create', $page->id) }}"
                                                       class="badge badge-danger">Hoàn tiền</a>

                                                @else

                                                @endif

                                            @else

                                            @endif
                                            <br>
                                            @if($page->food_order)
                                                <button type="button"
                                                        class="btn btn-primary shadow btn-xs sharp me-1 mt-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal"
                                                        data-bs-service="food"
                                                        data-bs-id="{{$page->id}}">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                            @elseif($page->delivery_order)
                                                <button type="button"
                                                        class="btn btn-primary shadow btn-xs sharp me-1 mt-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#receiverGoInfoModal"
                                                        data-bs-service="delivery"
                                                        data-bs-id="{{$page->id}}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            @endif
                                        </td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="9"><p>Không có dữ liệu.</p></td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $drivers->onEachSide(2)->appends(Request::input())->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('admin.trip.food_modal')
    @include('admin.trip.delivery_modal')

    <script type="text/javascript">
        'use strict';
        var apiTemp = '{{ route("trip.admin.detail", ["service" => ":service", "go_id" => ":id"] ) }}';
    </script>

    <script src="{{ asset('js/delivery-food-modal.js') }}"></script>

    <script>
        setTimeout(() => {
            document.location.reload();
        }, 60000);
    </script>
@endsection
