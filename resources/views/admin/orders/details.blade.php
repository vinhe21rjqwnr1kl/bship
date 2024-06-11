{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">


        @php
            $collapsed = '';
            $show = 'show';
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
                        <div class="">Đơn hàng</div>
                        <h4 class="accordion-header-text m-0">#{{ $details->id }}</h4>
                        <span class="accordion-header-indicator"></span>
                    </div>
                    <div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec"
                         data-bs-parent="#search-sec-outer">
                        <form action="{{ route('orders.admin.update', $details->id) }}" method="POST">
                            @csrf
                            <div class="">
                                <div class="row align-items-start">
                                    <div class="col">
                                        <div class="mb-3">
                                            <h5>Thông tin chung</h5>
                                        </div>
                                        <div class="mb-3">
                                            <div>
                                                <label>Khách hàng: </label>
                                                @if($details->user)
                                                    <strong>{{$details->user->name}}</strong><br>
                                                    <label>Phone: </label>
                                                    <strong>{{$details->user->phone}}</strong>

                                                @else
                                                    <strong>Không tìm thấy khách hàng</strong>
                                                @endif
                                            </div>
                                            <div>
                                                <label>Tài xế: </label>
                                                @if($details->driver)
                                                    <strong>{{$details->driver->name}}</strong><br>
                                                    <label>Phone: </label>
                                                    <strong>{{$details->driver->phone}}</strong>

                                                @else
                                                    <strong>Không tìm thấy tài xế</strong>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="mb-3">
                                            <label>Ngày đặt hàng</label><br>
                                            <input class="form-control" type="datetime-local" name="create_at"
                                                   value="{{ $details->created_at }}">
                                        </div>
                                        <div class="mb-3">
                                            <label>Trạng thái</label><br>
                                            <div>
                                                <select name="status" class="default-select form-control">
                                                    @foreach($statuses as  $status)
                                                        <option
                                                                {{ $details->status == $status['name'] ? 'selected="selected"':'' }} value="{{ $status['name'] }}">
                                                            @if($status['name'] == 'Pending')
                                                                {{ __('Chưa giải quyết') }}
                                                            @elseif($status['name'] == 'Delivered')
                                                                {{ __('Đã giao hàng') }}
                                                            @elseif($status['name'] == 'Confirmed')
                                                                {{ __('Đã xác nhận') }}
                                                            @elseif($status['name'] == 'Cancelled')
                                                                <span
                                                                        class="badge badge-danger">{{ __('Đã hủy') }}</span>
                                                            @endif
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <h5>Địa chỉ giao hàng</h5>
                                        </div>
                                        <div class="mb-3">
                                            <div>{{ $details->delivery_address }}</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <h5>Tiền chuyến</h5>
                                        </div>
                                        <div class="mb-3">
                                            <div>
                                                @if($details->tripRequest)
                                                    <strong>Phương thức thanh toán: </strong>
                                                    <span>{{$details->payment_method}}</span><br>
                                                    <strong>Tổng: </strong>
                                                    <span>{{number_format($details->tripRequest->cost)}}</span><br>
                                                    <strong>Tài xế: </strong>
                                                    <span>{{number_format($details->tripRequest->driver_cost)}}</span>
                                                    <br>
                                                    <strong>Đại lý: </strong>
                                                    <span>{{number_format($details->tripRequest->butl_cost)}}</span><br>
                                                    <strong>Khuyến mãi: </strong>
                                                    <span>{{number_format($details->tripRequest->discount_cost)}}</span>
                                                    <br>
                                                    <strong>VAT: </strong>
                                                    <span>{{number_format($details->tripRequest->money_vat)}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row border-top">
                                    <div class="mt-3">
                                        <strong>Ghi chú: </strong><span>{{$details->note}}</span>
                                    </div>
                                </div>
                                <div class="row border-top mt-3">
                                    <div class="mt-3">
                                        {{--                                    <button class="btn btn-success">Cập nhật</button>--}}
                                        {{--                                    @can('Controllers > UsersController > create')--}}
                                        <button type="submit" class="btn btn-primary">{{ __('Cập nhật') }}</button>
                                        {{--                                    @endcan--}}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Column starts -->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ $details->restaurant->name ?? 'Không tìm thấy cửa hàng' }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-responsive-lg mb-0">
                                    <thead class="">
                                    <tr>
                                        <th><strong> Hình ảnh </strong></th>
                                        <th><strong> Sản phẩm </strong></th>
                                        <th><strong> Topping </strong></th>
                                        <th><strong> Đơn giá </strong></th>
                                        <th><strong> Số lượng </strong></th>
                                        <th><strong> Tổng </strong></th>
                                        {{--                                    <th> <strong> Hoàn trả </strong> </th>--}}
                                        <th><strong> Ghi chú </strong></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($details->items)
                                        @forelse ($details->items as $item)
                                            <tr>
                                                {{--                                        <td> {{ $i++ }} </td>--}}
                                                @if($item->product)
                                                    <td>
                                                        <img src="{{ $item->product->img_url }}"
                                                             alt="{{ $item->product->name }}"
                                                             class="img-fluid rounded" style="max-width: 11rem;">
                                                    </td>
                                                    <td> {{ $item->product->name }}</td>
                                                    <td>
                                                        @if($item->food_order_item_toppings)
                                                            @foreach($item->food_order_item_toppings as $key => $topping )
                                                                {{ $topping->topping->name }}
                                                                : {{ number_format($topping->additional_price) }}
                                                                <br>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td> {{ number_format($item->price) }}</td>
                                                    <td> x {{ $item->quantity }}</td>

                                                    @php
                                                        $totalPrice = $item->price * $item->quantity;
                                                        $totalTopping = 0;
                                                        foreach ($item->food_order_item_toppings as $key => $topping) {
                                                            $totalTopping += $topping->additional_price;
                                                        }
                                                        $total = $totalPrice + ($totalTopping * $item->quantity);
                                                    @endphp

                                                    <td> {{ number_format($total) }}</td>
                                                    <td> {{ $item->note }}</td>
                                                    {{--                                        <td></td>--}}
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="10"><p>Không có dữ liệu.</p></td>
                                            </tr>
                                        @endforelse
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex flex-row-reverse">
                                <div class="mx-3 mt-4" style="font-size: 16px">
                                    <h4>Tổng phụ: {{ number_format($details->price) }}</h4>
                                    <h4>Khuyến mãi: {{ number_format($details->discount_price) }}</h4>
                                    <h4>Tổng: {{ number_format($details->price - $details->discount_price) }}</h4>
                                </div>
                            </div>
                        </div>
                        {{--                    <div class="card-footer">--}}
                        {{--                        {{ $Prices->onEachSide(2)->appends(Request::input())->links() }}--}}
                        {{--                    </div>--}}
                    </div>
                </div>
            </div>

        </div>
@endsection
