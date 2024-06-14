{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">


        @php
            $collapsed = 'collapsed';
            $show = '';
        @endphp

        @if(!empty(request()->service_type) || !empty(request()->name) || !empty(request()->phone) || !empty(request()->goid) || !empty(request()->progress) || !empty(request()->tags) || !empty(request()->datefrom) || !empty(request()->dateto))
            @php
                $collapsed = '';
                $show = 'show';
            @endphp
        @endif
        @php
            $current_user   = auth()->user();
            $roles            =    $current_user->roles->toArray();
            $role_id            =   ($roles[0]['pivot']['role_id']);
            $user_name      = isset($current_user->full_name) ? $current_user->full_name : '';
            $user_email         = isset($current_user->email) ? $current_user->email : '';
            $userId         = isset($current_user->id) ? $current_user->id : '';
            $userImg        = HelpDesk::user_img($current_user->profile);

        @endphp
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
                        <form action="{{ route('trip.admin.index', $service_id ) }}" method="get">
                            @csrf
                            <input type="hidden" name="todo" value="Filter">
                            <div class="row">
                                <div class="mb-12 col-md-12">
                                    <div class="parent-tags">
                                        <div class="wrapper-tags">
                                            <input type="hidden" name="tags" id="tags_input"
                                                   value="{{ old('tags', request()->input('tags')) }}">
                                            <input type="text" id="input-tag-search" class="input-tag"
                                                   placeholder="Tìm kiểm chuyến theo tỉnh/thành, quận/huyện, xã/phường">
                                            <div id="search-results" class="suggestions"></div>
                                            <button type="button" style="cursor: pointer"
                                                    class="btn btn-xs btn-warning btn-choose">
                                                chọn
                                            </button>
                                        </div>
                                        <span class="tags-length">0 Thẻ</span>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <input type="search" name="goid" class="form-control" placeholder="Mã chuyến đi"
                                           value="{{ old('phone', request()->input('goid')) }}">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <input type="search" name="phone" class="form-control" placeholder="Số điện thoại"
                                           value="{{ old('phone', request()->input('phone')) }}">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <input type="search" name="name" class="form-control" placeholder="Họ và tên"
                                           value="{{ old('name', request()->input('name')) }}">
                                </div>

                                @if($service_id == 0)
                                    <div class="mb-3 col-md-4">
                                        <select name="service_type" class="default-select form-control">
                                            <option value="0">-- Tất cả --</option>
                                            @foreach($ServicesTypeArr as $key => $serviceType)
                                                <option
                                                    {{ request()->input('service_type') == $key ? 'selected="selected"':'' }} value="{{ $key }}">{{ $ServicesTypeArr[$key] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="mb-3 col-md-4">
                                    <select name="progress" class="default-select form-control">
                                        <option value="0">-- Tất cả --</option>
                                        <option
                                            {{ request()->input('progress') == 3 ? 'selected="selected"':'' }} value="3">{{ $CfGoProcessArr[3] }}</option>
                                        <option
                                            {{ request()->input('progress') == 1 ? 'selected="selected"':'' }} value="1">{{ $CfGoProcessArr[1] }}</option>
                                        <option
                                            {{ request()->input('progress') == 2 ? 'selected="selected"':'' }} value="2">{{ $CfGoProcessArr[2] }}</option>
                                        <option
                                            {{ request()->input('progress') == 4 ? 'selected="selected"':'' }} value="4">{{ $CfGoProcessArr[4] }}</option>
                                        <option
                                            {{ request()->input('progress') == 5 ? 'selected="selected"':'' }} value="5">{{ $CfGoProcessArr[5] }}</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <input type="date" name="datefrom" class="form-control" placeholder="Ngày bắt đầu"
                                           value="{{ old('datefrom', request()->input('datefrom')) }}">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <input type="date" name="dateto" class="form-control" placeholder="Ngày kết thúc"
                                           value="{{ old('dateto', request()->input('dateto')) }}">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary me-2">
                                    <input type="submit" name="excel" value="Excel" class="btn btn-primary me-2">
                                    <a href="{{ route('trip.admin.index',$service_id) }}" class="btn btn-danger">Nhập
                                        Lại</a>
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
                                    <th><strong> Tiền </strong></th>
                                    {{--                                    <th><strong> Phương thức </strong></th>--}}
                                    <th><strong> Thông tin </strong></th>
                                    {{--                                    <th><strong> Tạo bởi </strong></th>--}}
                                    <th><strong> Thời gian </strong></th>
                                    {{--                                    <th><strong> Mã GSM </strong></th>--}}
                                    <th><strong> Trạng thái </strong></th>
                                    <th><strong> Hành động </strong></th>
                                    {{--                                    <th><strong> Hoàn tiền </strong></th>--}}
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
                                        <td style="min-width: 150px; word-wrap: break-word;">
                                            <strong>Tên:</strong> {{$page->user_name09}}
                                            <br><strong>SĐT:</strong> {{$page->user_phone09}}
                                        </td>
                                        <td style="min-width: 150px; word-wrap: break-word;">
                                            <strong>Tên:</strong> {{$page->driver_name}}
                                            <br><strong>SĐT:</strong> {{$page->driver_phone}}
                                        </td>
                                        <td style="min-width: 120px; word-wrap: break-word;">
                                            {{ $ServicesArr[$page->service_id] }} <br>
                                            {{ $ServicesTypeArr[$page->service_type] }}
                                        </td>
                                        <td style="min-width: 150px; word-wrap: break-word;">
                                            <strong>Tổng:</strong> {{ number_format($page->cost - $page->discount_from_code) }}
                                            <br><strong>Tài
                                                xế:</strong> {{ number_format($page->butl_cost  +  $page->service_cost ) }}
                                            <br><strong>Đại
                                                lý:</strong> {{ number_format($page->driver_cost - $page->service_cost) }}
                                            <br><strong>Bảo hiểm:</strong> {{ number_format($page->service_cost) }}
                                            <br><strong>VAT:</strong> {{ number_format($page->money_vat) }}
                                            <br><strong>Khuyến
                                                mại:</strong> {{ number_format($page->discount_from_code) }}
                                        </td>

                                        <td style="min-width: 350px; word-wrap: break-word;">
                                            <strong>Số KM:</strong> {{ $page->distance/1000 }}
                                            <br><strong>Đón:</strong> {{ $page->pickup_address }}
                                            <br><strong>Đến:</strong> {{ $page->drop_address }}
                                            @if($page->drop_second_address)
                                                <br><strong>Đến:</strong> {{ $page->drop_second_address }}
                                            @else
                                            @endif
                                            @if($page->order_id_gsm)
                                                <br><br><strong>Mã GSM: </strong>{{ $page->order_id_gsm }}
                                            @endif
                                        </td>

                                        <td style="min-width: 135px; word-wrap: break-word;"> {{ $page->create_date}} </td>

                                        <td>
                                            @if ($page->progress == 3)
                                                <span
                                                    class="badge badge-success mt-1"> {{ $CfGoProcessArr[$page->progress] }}</span>
                                            @elseif($page->progress == 4)
                                                <span
                                                    class="badge badge-danger mt-1"> {{ $CfGoProcessArr[$page->progress] }}</span>
                                            @else
                                                <span
                                                    class="badge badge-warning mt-1"> {{ $CfGoProcessArr[$page->progress] }}</span>
                                            @endif
                                            <br>
                                            @if ($page->go_type == 2)
                                                <span class="badge badge-warning mt-1"> Tài xế</span>
                                            @else
                                                @if ($page->go_request_id == 1000)
                                                    <span class="badge badge-danger mt-1"> Admin</span>
                                                @else
                                                    <span class="badge badge-success mt-1">Khách</span>
                                                @endif
                                            @endif

                                            @if($page->payment_status == "PAID")
                                                <span class="badge badge-success mt-1">Chuyển khoản</span>
                                            @else
                                                <span class="badge badge-warning mt-1">Tiền mặt</span>
                                            @endif
                                        </td>
                                        <td class="text-center" style="min-width: 120px; word-wrap: break-word;">
                                            @if($userId ==1)
                                                <a href="{{ route('trip.admin.status', $page->id) }}"
                                                   class="btn btn-primary shadow btn-xs sharp me-1 mt-2"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                            @else

                                            @endif

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
                                            <div class="mt-2">
                                                @if (in_array($page->service_detail_id, [33]) && $page->go_request_id != 1000)

                                                @else
                                                    @if($page->progress == 4 && $page->log_add_money_request_status === 0)
                                                        <span class="badge badge-warning">Chưa duyệt</span>
                                                    @elseif($page->progress == 4 && $page->log_add_money_request_status === 1)
                                                        <span class="badge badge-success">Đã duyệt</span>
                                                    @elseif($page->progress == 4 && $page->log_add_money_request_status === 2)
                                                        <span class="badge badge-primary">Xóa</span>
                                                    @elseif($page->progress == 4)
                                                        <a href="{{ route('driver.admin.payment_create', $page->id) }}"
                                                           class="badge badge-danger">Hoàn tiền</a>
                                                    @else

                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="10"><p>Không có dữ liệu.</p></td>
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

        let jsonUrl = "{{ asset('json/data.json') }}";

        // setTimeout(() => {
        //     document.location.reload();
        // }, 60000);

        var apiTemp = '{{ route("trip.admin.detail", ["service" => ":service", "go_id" => ":id"] ) }}';
    </script>

    <script src="{{ asset('js/delivery-food-modal.js') }}"></script>
@endsection
