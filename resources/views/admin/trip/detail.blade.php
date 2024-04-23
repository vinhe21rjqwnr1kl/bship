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
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-lg mb-0">
                                <thead class="">
                                <tr>
                                    <th><strong> STT</strong></th>
                                    <th><strong> Mã BUTL </strong></th>
                                    <th><strong> Khách hàng </strong></th>
                                    <th><strong> Tài Xế </strong></th>
                                    <th><strong> DV </strong></th>
                                    <th><strong> Loại </strong></th>
                                    <th><strong> Tiền </strong></th>
                                    <th><strong> Thông tin </strong></th>
                                    <th><strong> Thông tin thêm </strong></th>
                                    <th><strong> Trạng thái </strong></th>
                                    <th><strong> Tạo bởi </strong></th>
                                    <th><strong> Thời gian </strong></th>
                                    <th><strong> Trạng thái </strong></th>
                                    <th><strong> Thao tác </strong></th>
                                </tr>
                                </thead>
                                <tbody>


                                    <tr>
                                        <td> {{ 1 }} </td>
                                        <td> BUTL_{{ $data->go_id }} </td>
                                        <td>
                                            <strong>Tên:</strong> {{$data->user_name09}}
                                            <br><strong>SĐT:</strong> {{$data->user_phone09}}
                                        </td>
                                        <td>
                                            <strong>Tên:</strong> {{$data->driver_name}}
                                            <br><strong>SĐT:</strong> {{$data->driver_phone}}
                                        </td>
                                        <td>{{ $ServicesArr[$data->service_id] }}
                                        </td>
                                        <td>
                                            {{ $ServicesTypeArr[$data->service_type] }} </td>

                                        <td>
                                            <strong>Tổng:</strong> {{ number_format($data->cost - $data->discount_from_code) }}
                                            <br><strong>Tài
                                                xế:</strong>{{ number_format($data->butl_cost  +  $data->service_cost ) }}
                                            <br><strong>Đại
                                                lý:</strong>{{ number_format($data->driver_cost - $data->service_cost) }}
                                            <br><strong>Bảo hiểm:</strong>{{ number_format($data->service_cost) }}
                                            <br><strong>Khuyến
                                                mại:</strong>{{ number_format($data->discount_from_code) }}

                                        </td>
                                        <td>
                                            <strong>Số KM:</strong> {{ $data->distance/1000 }}
                                            <br><strong>Đón:</strong> {{ $data->pickup_address }}
                                            <br><strong>Đến:</strong> {{ $data->drop_address }}
                                            @if($data->drop_second_address)
                                                <br><strong>Đến:</strong> {{ $data->drop_second_address }}
                                            @else
                                            @endif

                                        </td>
                                        <td>
                                            <strong>Cửa hàng:</strong> {{ $data->restaurant_name }}
                                            <br><strong>Địa chỉ:</strong> {{ $data->restaurant_address }}
                                            <br><strong>Sản phẩm:</strong> {{ $data->food_product_name }}
                                        </td>
                                        <td>

                                            @if ($data->progress == 3)
                                                <span
                                                    class="badge badge-success"> {{ $CfGoProcessArr[$data->progress] }}</span>
                                            @elseif($data->progress == 4)
                                                <span
                                                    class="badge badge-danger"> {{ $CfGoProcessArr[$data->progress] }}</span>
                                            @else
                                                <span
                                                    class="badge badge-warning"> {{ $CfGoProcessArr[$data->progress] }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->go_type == 2)
                                                <span class="badge badge-warning"> Tài xế</span>
                                            @else
                                                @if ($data->go_request_id == 1000)
                                                    <span class="badge badge-danger"> Admin</span>
                                                @else
                                                    <span class="badge badge-success">Khách</span>
                                                @endif
                                            @endif

                                        </td>

                                        <td> {{ $data->create_date}} </td>
                                        <td class="text-center">
                                            @if($userId ==1)
                                                <a href="{{ route('trip.admin.status', $data->go_id) }}"
                                                   class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                            @else
                                                Liên hệ Admin
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($data->progress == 4)
                                                <a href="{{ route('driver.admin.payment_create', $data->go_id) }}"
                                                   class="btn btn-danger">Hoàn tiền</a>
                                            @else

                                            @endif

                                        </td>

                                    </tr>

{{--                                    <tr>--}}
{{--                                        <td class="text-center" colspan="10"><p>Không có dữ liệu.</p></td>--}}
{{--                                    </tr>--}}


                                </tbody>
                            </table>
                        </div>
                    </div>
{{--                    <div class="card-footer">--}}
{{--                        {{ $drivers->onEachSide(2)->appends(Request::input())->links() }}--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>

    </div>
@endsection
