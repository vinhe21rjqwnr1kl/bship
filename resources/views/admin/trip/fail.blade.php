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
                        <form action="{{ route('trip.admin.fail') }}" method="get">
                            @csrf
                            <input type="hidden" name="todo" value="Filter">
                            <div class="row">
                                <div class="mb-12 col-md-12">
                                    <div class="parent-tags">
                                        <div class="wrapper-tags">
                                            <input type="hidden" name="tags" id="tags_input"
                                                   value="{{ old('tags', request()->input('tags')) }}">
                                            <input type="text" class="input-tag" id="input-tag-search"
                                                   placeholder="Tìm kiểm chuyến theo tỉnh/thành, quận/huyện, xã/phường kiểm chuyến theo tên tỉnh/ thành phố">
                                            <div id="search-results" class="suggestions"></div>
                                            <button type="button" style="cursor: pointer"
                                                    class="btn btn-xs btn-warning btn-choose">
                                                chọn
                                            </button>
                                        </div>
                                        <span class="tags-length">0 Thẻ</span>
                                    </div>
                                </div>

                                {{--                            <div class="mb-3 col-md-4">--}}
                                {{--                                <input type="search" name="id" class="form-control" placeholder="Mã chuyến đi" value="{{ old('id', request()->input('id')) }}">--}}
                                {{--                            </div>--}}

                                <div class="mb-3 col-md-4">
                                    <input type="search" name="phone" class="form-control" placeholder="Số điện thoại"
                                           value="{{ old('phone', request()->input('phone')) }}">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <input type="search" name="name" class="form-control" placeholder="Họ và tên"
                                           value="{{ old('name', request()->input('name')) }}">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <select name="status" class="default-select form-control">
                                        <option
                                            {{ request()->input('status') == 1 ? 'selected="selected"':'' }} value="1">
                                            Tìm tài xế không được
                                        </option>
                                        <option
                                            {{ request()->input('status') == 2 ? 'selected="selected"':'' }}  value="2">
                                            Tìm tạo chuyến thành công
                                        </option>
                                        <option
                                            {{ request()->input('status') == 3 ? 'selected="selected"':'' }} value="3">
                                            Khách hủy tìm chuyến
                                        </option>
                                    </select>
                                </div>
                                <?php
                                $today = date('Y-m-01');
                                ?>

                                <div class="mb-3 col-md-4">
                                    <input type="date" name="datefrom" class="form-control" placeholder="Ngày bắt đầu"
                                           value="{{ old('datefrom', request()->input('datefrom', $today)) }}">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <input type="date" name="dateto" class="form-control" placeholder="Ngày kết thúc"
                                           value="{{ old('dateto', request()->input('dateto')) }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary me-2">
                                    <a href="{{ route('trip.admin.fail') }}" class="btn btn-danger">Nhập Lại</a>
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
                                    {{--									<th> <strong> Mã tạo chuyến</strong> </th>--}}
                                    <th><strong> Mã BSHIP</strong></th>
                                    <th><strong> Khách hàng </strong></th>
                                    <th><strong> DV </strong></th>
                                    {{--                                    <th><strong> Loại </strong></th>--}}
                                    <th><strong> Tiền </strong></th>
                                    <th><strong> Thông tin </strong></th>
                                    <th><strong> Thời gian </strong></th>
                                    <th><strong> Trạng thái </strong></th>
                                    {{--                                    <th><strong> Trạng thái chuyến </strong></th>--}}
                                    <th><strong> Hành động </strong></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = $drivers->firstItem();
                                @endphp
                                @forelse ($drivers as $page)
                                    <tr>
                                        <td> {{ $i++ }} </td>
                                        {{--										<td> {{ $page->id }} </td>--}}
                                        <td style="min-width: 100px; word-wrap: break-word;">
                                            @if($page->trip)
                                                BSHIP_{{ $page->trip->id }}
                                            @endif
                                        </td>
                                        <td style="min-width: 150px; word-wrap: break-word;">
                                            <strong>Tên:</strong> {{$page->user_name09}}
                                            <br><strong>SĐT:</strong> {{$page->user_phone09}}
                                        </td>

                                        <td style="min-width: 120px; word-wrap: break-word;">
                                            {{ $ServicesArr[$page->service_id] }}
                                            <hr>
                                            {{ $ServicesTypeArr[$page->service_type] }}
                                        </td>

                                        <td style="min-width: 150px; word-wrap: break-word;">
                                            <strong>Tổng:</strong> {{ number_format($page->cost) }}
                                            <br><strong>Tài
                                                xế:</strong> {{ number_format($page->butl_cost  +  $page->service_cost) }}
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
                                            @if($page->trip && $page->trip->order_id_gsm)
                                                <br><br><strong>Mã GSM: </strong>{{ $page->trip->order_id_gsm }}
                                            @endif
                                        </td>

                                        <td style="min-width: 135px; word-wrap: break-word;"> {{ $page->create_date}} </td>

                                        <td>
                                            @if ($page->statusmain == 2)
                                                <span class="badge badge-success mt-1"> Tạo chuyến thành công</span>
                                            @elseif($page->statusmain == 1)
                                                <span class="badge badge-danger mt-1"> Không tìm thấy tx</span>
                                            @elseif($page->statusmain == 3)
                                                <span class="badge badge-danger mt-1"> Khách hủy tìm chuyến</span>
                                            @else
                                                <span class="badge badge-warning mt-1"> Đang tìm</span>
                                            @endif

                                            @if($page->trip)
                                                @if ($page->trip->progress == 3)
                                                    <span
                                                        class="badge badge-success mt-1"> {{ $CfGoProcessArr[$page->trip->progress] }}</span>
                                                @elseif($page->trip->progress == 4)
                                                    <span
                                                        class="badge badge-danger mt-1"> {{ $CfGoProcessArr[$page->trip->progress] }}</span>
                                                @else
                                                    <span
                                                        class="badge badge-warning mt-1"> {{ $CfGoProcessArr[$page->trip->progress] }}</span>
                                                @endif
                                            @else

                                            @endif
                                        </td>

                                        <td class="text-center" style="min-width: 120px; word-wrap: break-word;">
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

        let jsonUrl = "{{ asset('json/data.json') }}";
        var apiTemp = '{{ route("trip.admin.detail.fail", ["service" => ":service", "go_request_id" => ":id"] ) }}';
    </script>

    <script src="{{ asset('js/delivery-food-modal.js') }}"></script>

    <script>
        setTimeout(() => {
            document.location.reload();
        }, 60000);
    </script>
@endsection

