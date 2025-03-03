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
                        <form action="{{ route('orders.admin.index' ) }}" method="get">
                            @csrf
                            <input type="hidden" name="todo" value="Filter">
                            <div class="row">
                                {{--                                <div class="mb-12 col-md-12">--}}
                                {{--                                    <div class="parent-tags">--}}
                                {{--                                        <div class="wrapper-tags">--}}
                                {{--                                            <input type="hidden" name="tags" id="tags_input"--}}
                                {{--                                                   value="{{ old('tags', request()->input('tags')) }}">--}}
                                {{--                                            <input type="text" id="input-tag-search" class="input-tag"--}}
                                {{--                                                   placeholder="Tìm kiểm chuyến theo tên tỉnh/ thành phố">--}}
                                {{--                                        </div>--}}
                                {{--                                        <span class="tags-length">0 Thẻ</span>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                {{--                                <div class="mb-3 col-md-4">--}}
                                {{--                                    <input type="search" name="goid" class="form-control" placeholder="Mã chuyến đi"--}}
                                {{--                                           value="{{ old('phone', request()->input('goid')) }}">--}}
                                {{--                                </div>--}}
                                <div class="mb-3 col-md-4">
                                    <input type="search" name="phone" class="form-control" placeholder="Số điện thoại"
                                           value="{{ old('phone', request()->input('phone')) }}">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <input type="search" name="name" class="form-control" placeholder="Họ và tên"
                                           value="{{ old('name', request()->input('name')) }}">
                                </div>
                                <div class="mb-3 col-md-4">

                                    {{--                                    <select name="status" class="default-select form-control">--}}
                                    {{--                                        @foreach($statuses as  $status)--}}
                                    {{--                                            <option--}}
                                    {{--                                                {{ request()->input('status') == $status['name'] ? 'selected="selected"':'' }} value="{{ $status['name'] }}">{{ $status['name'] }}</option>--}}
                                    {{--                                        @endforeach--}}

                                    {{--                                    </select>--}}
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
                                    {{--                                    <input type="submit" name="excel" value="Excel" class="btn btn-primary me-2">--}}
                                    <a href="{{ route('orders.admin.index') }}" class="btn btn-danger">Nhập
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
                                    <th><strong> Liên quan </strong></th>
                                    <th><strong> Người trả tiền </strong></th>
                                    <th><strong> Đại lý </strong></th>
                                    <th><strong> Tiền tệ </strong></th>
                                    <th><strong> Phương pháp </strong></th>
                                    <th><strong> Tiền </strong></th>
                                    <th><strong> Giảm giá </strong></th>
                                    <th><strong> Tổng </strong></th>
                                    <th><strong> Loại </strong></th>
                                    <th><strong> Trạng thái </strong></th>
                                    <th><strong> Ngày </strong></th>
                                    <th><strong> Hoạt động </strong></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = $transactions->firstItem();
                                @endphp
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td> {{ $i++ }} </td>
                                        <td>
                                            @if($transaction->order)
                                                {{ $transaction->order->reference }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaction->user)
                                                {{ $transaction->user->name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaction->vendor)
                                                {{ $transaction->vendor->name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaction->currency)
                                                {{ $transaction->currency->name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaction->withdrawalMethod)
                                                {{ $transaction->withdrawalMethod->method_name }}
                                            @endif
                                        </td>
                                        <td> {{ $transaction->amount }} </td>
                                        <td> {{ $transaction->discount_amount }} </td>
                                        <td> {{ $transaction->total_amount }} </td>
                                        <td> {{ $transaction->transaction_type }} </td>
                                        <td> {{ $transaction->status }} </td>
                                        <td> {{ $transaction->transaction_date }} </td>

                                        {{--                                        <td>--}}
                                        {{--                                            @if($page->user)--}}
                                        {{--                                                <strong>Tên:</strong> {{ $page->user->name }}<br>--}}
                                        {{--                                                <strong>Phone:</strong> {{ $page->user->phone }}--}}
                                        {{--                                            @else--}}
                                        {{--                                                <strong>Không tìm thấy khách hàng</strong>--}}
                                        {{--                                            @endif--}}
                                        {{--                                        </td>--}}
                                        {{--                                        <td>--}}
                                        {{--                                            @if($page->restaurant)--}}
                                        {{--                                                <strong>Tên:</strong> {{ $page->restaurant->name }}<br>--}}
                                        {{--                                                <strong>Phone:</strong> {{ $page->restaurant->phone }}<br>--}}
                                        {{--                                                <strong>Địa chỉ:</strong> {{ $page->restaurant->address }}--}}
                                        {{--                                            @else--}}
                                        {{--                                                <strong>Không tìm thấy cửa hàng</strong>--}}
                                        {{--                                            @endif--}}
                                        {{--                                        </td>--}}
                                        {{--                                        <td>--}}
                                        {{--                                            @if($page->driver)--}}
                                        {{--                                                <strong>Tên:</strong> {{ $page->driver->name }}<br>--}}
                                        {{--                                                <strong>Phone:</strong> {{ $page->driver->phone }}<br>--}}
                                        {{--                                            @else--}}
                                        {{--                                                <strong>Không tìm thấy tài xế</strong>--}}
                                        {{--                                            @endif--}}
                                        {{--                                        </td>--}}

                                        {{--                                        <td>--}}
                                        {{--                                            @if($page->tripRequest)--}}
                                        {{--                                                <strong>Tổng:</strong> {{ number_format($page->tripRequest->cost) }}<br>--}}
                                        {{--                                                <strong>Tài--}}
                                        {{--                                                    xế:</strong> {{ number_format($page->tripRequest->driver_cost) }}--}}
                                        {{--                                                <br>--}}
                                        {{--                                                <strong>Đại--}}
                                        {{--                                                    lý:</strong> {{ number_format($page->tripRequest->butl_cost) }}--}}
                                        {{--                                                <strong>Khuyến--}}
                                        {{--                                                    mãi:</strong> {{ number_format($page->tripRequest->discount_cost) }}--}}
                                        {{--                                                <strong>VAT:</strong> {{ number_format($page->tripRequest->money_vat) }}--}}
                                        {{--                                            @else--}}
                                        {{--                                                <strong>Không tìm được chuyến</strong>--}}
                                        {{--                                            @endif--}}
                                        {{--                                        </td>--}}
                                        {{--                                        <td>--}}
                                        {{--                                            <span class="badge badge-warning">{{ $page->payment_method }}</span>--}}
                                        {{--                                        </td>--}}
                                        {{--                                        <td>{{ $page->delivery_address }}</td>--}}
                                        {{--                                        <td>--}}
                                        {{--                                            @if($page->status == 'Pending')--}}
                                        {{--                                                <span class="badge badge-warning">{{ __('Chưa giải quyết') }}</span>--}}
                                        {{--                                            @elseif($page->status == 'Delivered')--}}
                                        {{--                                                <span class="badge badge-success">{{ __('Đã giao hàng') }}</span>--}}
                                        {{--                                            @elseif($page->status == 'Confirmed')--}}
                                        {{--                                                <span class="badge badge-success">{{ __('Đã xác nhận') }}</span>--}}
                                        {{--                                            @elseif($page->status == 'Cancelled')--}}
                                        {{--                                                <span class="badge badge-danger">{{ __('Đã hủy') }}</span>--}}
                                        {{--                                            @endif--}}
                                        {{--                                        </td>--}}
                                        {{--                                        <td>{{ $page->created_at }}</td>--}}
                                        <td class="text-center">
                                            <a href="{{ route('orders.admin.details', ['id' => $transaction->id]) }}"
                                               class="btn btn-primary shadow btn-xs sharp me-1 mt-2"><i
                                                    class="fas fa-eye"></i></a>

                                            {{--                                            @if($page->tripRequest)--}}
                                            {{--                                                <button type="button"--}}
                                            {{--                                                        class="btn btn-primary shadow btn-xs sharp me-1 mt-2"--}}
                                            {{--                                                        data-bs-toggle="modal"--}}
                                            {{--                                                        data-bs-target="#exampleModal"--}}
                                            {{--                                                        data-bs-service="food"--}}
                                            {{--                                                        data-bs-id="{{$page->tripRequest->id}}">--}}
                                            {{--                                                    <i class="fas fa-eye"></i>--}}
                                            {{--                                                </button>--}}
                                            {{--                                            @endif--}}
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
                        {{ $transactions->onEachSide(2)->appends(Request::input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    @include('admin.trip.food_modal')--}}

    <script type="text/javascript">
        'use strict';
        {{--        var apiTemp = '{{ route("trip.admin.detail.fail", ["service" => ":service", "go_request_id" => ":id"] ) }}';--}}

    </script>

    {{--    <script src="{{ asset('js/delivery-food-modal.js') }}"></script>--}}
@endsection
