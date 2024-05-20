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
                                                   placeholder="Tìm kiểm chuyến theo tên tỉnh/ thành phố">
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
                                <div class="mb-3 col-md-4">

                                    <select name="progress" class="default-select form-control">
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
                                    <th><strong> Mã BUTL </strong></th>
                                    <th><strong> Khách hàng </strong></th>
                                    <th><strong> Tài Xế </strong></th>
                                    <th><strong> DV </strong></th>
                                    <th><strong> Loại </strong></th>
                                    <th><strong> Tiền </strong></th>
                                    <th><strong> Thông tin </strong></th>
                                    <th><strong> Trạng thái </strong></th>
                                    <th><strong> Tạo bởi </strong></th>
                                    <th><strong> Thời gian </strong></th>
                                    <th><strong> Trạng thái </strong></th>
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
                                        <td> BUTL_{{ $page->go_id }} </td>
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

                                        <td>
                                            <strong>Tổng:</strong> {{ number_format($page->cost - $page->discount_from_code) }}
                                            <br><strong>Tài
                                                xế:</strong>{{ number_format($page->butl_cost  +  $page->service_cost ) }}
                                            <br><strong>Đại
                                                lý:</strong>{{ number_format($page->driver_cost - $page->service_cost) }}
                                            <br><strong>Bảo hiểm:</strong>{{ number_format($page->service_cost) }}
                                            <br><strong>Khuyến
                                                mại:</strong>{{ number_format($page->discount_from_code) }}
                                            <br><strong>Thanh toán:</strong>{{ $page->payment_status == "PAID" ? " Online" : " Tiền mặt" }}
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
                                        <td>
                                            @if ($page->go_type == 2)
                                                <span class="badge badge-warning"> Tài xế</span>
                                            @else
                                                @if ($page->go_request_id == 1000)
                                                    <span class="badge badge-danger"> Admin</span>
                                                @else
                                                    <span class="badge badge-success">Khách</span>
                                                @endif
                                            @endif

                                        </td>

                                        <td> {{ $page->go_create_date}} </td>
                                        <td class="text-center">
                                            @if($userId ==1)
                                                <a href="{{ route('trip.admin.status', $page->go_id) }}"
                                                   class="btn btn-primary shadow btn-xs sharp me-1 mt-2"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                            @else
                                                Liên hệ Admin
                                            @endif

                                            @if($page->service_id == 3 && $page->food_order_id)
                                                <button type="button"
                                                        class="btn btn-primary shadow btn-xs sharp me-1 mt-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal"
                                                        data-bs-service-id="{{$page->service_id}}"
                                                        data-bs-id="{{$page->go_id}}">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                            @elseif($page->service_id == 4)
                                                <button type="button"
                                                        class="btn btn-primary shadow btn-xs sharp me-1 mt-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#receiverGoInfoModal"
                                                        data-bs-service-id="{{$page->service_id}}"
                                                        data-bs-id="{{$page->go_id}}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($page->progress == 4 && $page->log_add_money_request_status === 0)
                                                <span class="badge badge-warning">Chờ duyệt</span>

                                            @elseif($page->progress == 4 && $page->log_add_money_request_status === 1)
                                                <span class="badge badge-success">Thành công</span>

                                            @elseif($page->progress == 4 && $page->log_add_money_request_status === 2)
                                                <span class="badge badge-primary">Thất bại</span>

                                            @elseif($page->progress == 4)
                                                <a href="{{ route('driver.admin.payment_create', $page->go_id) }}"
                                                   class="badge badge-danger">Hoàn tiền</a>

                                            @else

                                            @endif
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

    {{--    Modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông tin chi tiết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-responsive-sm mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">Cửa hàng</th>
                                        <th scope="col">Địa chỉ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="restaurant-name"></td>
                                        <td class="restaurant-address"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-responsive-sm mb-0" id="prrductsOrder">
                                    <thead>
                                    <tr>
                                        <th scope="col">Tên sản phẩm</th>
                                        <th scope="col">Kích cỡ</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Hình ảnh</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    Modal --}}
    <div class="modal fade" id="receiverGoInfoModal" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông tin chi tiết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>Người nhận:</strong> <span class="receiver-name"></span>
                                    <br><strong>Số điện thoại:</strong> <span class="receiver-phone"></span>
                                    <br><strong>Địa chỉ:</strong> <span class="receiver-address"></span>
                                </div>
                                <div>
                                    <strong>Kích thước món đồ:</strong> <span class="product-size"></span>
                                    <br><strong>Cân nặng:</strong> <span class="product-weight"></span>
                                    <br><strong>Loại:</strong> <span class="product-category"></span>
                                </div>
                            </div>
                            <div>
                                <strong>Hình ảnh:</strong>
                                <div id="image-container" class="d-flex justify-content-center flex-wrap">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function renderTableInfo(data) {
            var restaurantName = exampleModal.querySelector('.restaurant-name');
            var restaurantAddress = exampleModal.querySelector('.restaurant-address');
            restaurantName.textContent = '';
            restaurantAddress.textContent = '';
            restaurantName.textContent = data.restaurant_name;
            restaurantAddress.textContent = data.restaurant_address;
        }

        function renderTableProductsOrder(data) {
            var tableBody = document.querySelector('#prrductsOrder tbody');
            tableBody.textContent = '';
            data.forEach(function (item) {
                var row = document.createElement('tr');
                row.innerHTML =
                    '<td>' + item.name + '</td>' +
                    '<td>' + item.size_name + '</td>' +
                    '<td>' + item.quantity + '</td>' +
                    '<td><img src="' + item.img_url + '" alt="' + item.name + '"class="img-fluid rounded" style="max-width: 150px;"></td>';
                tableBody.appendChild(row);
            });
        }

        async function renderImage(imageUrls) {
            var container = document.getElementById('image-container');
            container.innerHTML = '';
            if (imageUrls) {
                var cleanedJsonString = imageUrls.replace(/\\/g, '');
                var jsonObject = JSON.parse(cleanedJsonString);

                try {
                    var promises = [];
                    for (let imageUrl of Object.values(jsonObject)) {
                        if (imageUrl !== '') {
                            var imgPromise = new Promise((resolve, reject) => {
                                var imgElement = document.createElement('img');
                                imgElement.onload = function () {
                                    resolve(imgElement);
                                };
                                imgElement.onerror = function () {
                                    reject(new Error('Failed to load image: ' + imageUrl));
                                };
                                imgElement.src = imageUrl;
                            });
                            promises.push(imgPromise);
                        }
                    }
                    var images = await Promise.all(promises);
                    images.forEach(imgElement => {
                        imgElement.classList.add('rounded', 'my-2', 'mx-2', 'col-md-9');
                        container.appendChild(imgElement);
                    });
                } catch (error) {
                    console.error(error);
                }
            }
        }

        function renderDeliveryGoInfo(data) {
            var name = receiverGoInfoModal.querySelector('.receiver-name');
            var phone = receiverGoInfoModal.querySelector('.receiver-phone');
            var address = receiverGoInfoModal.querySelector('.receiver-address');
            var size = receiverGoInfoModal.querySelector('.product-size');
            var weight = receiverGoInfoModal.querySelector('.product-weight');
            var category = receiverGoInfoModal.querySelector('.product-category');
            name.textContent = "";
            phone.textContent = "";
            address.textContent = "";
            size.textContent = "";
            weight.textContent = "";
            category.textContent = "";
            if (data) {
                name.textContent = data.receiver_name;
                phone.textContent = data.receiver_phone;
                address.textContent = data.receiver_address;
                size.textContent = data.product_size;
                weight.textContent = data.product_weight;
                category.textContent = data.product_category;
            }
        }

        async function fetchData(api) {
            try {
                const response = await fetch(api);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            } catch (error) {
                console.error('There was a problem with your fetch operation:', error);
                throw error;
            }
        }

        async function handleService(serviceId, api) {
            try {
                const data = await fetchData(api);
                if (serviceId == 3) {
                    renderTableInfo(data.data);
                    renderTableProductsOrder(data.order_items);
                } else if (serviceId == 4) {
                    renderDeliveryGoInfo(data.data);
                    renderImage(data.data.product_image);
                } else {
                    console.error('Unknown serviceId:', serviceId);
                }
            } catch (error) {
                // Handle errors
            }
        }

        var exampleModal = document.getElementById('exampleModal');
        var receiverGoInfoModal = document.getElementById('receiverGoInfoModal');

        receiverGoInfoModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var serviceId = button.getAttribute('data-bs-service-id');
            var id = button.getAttribute('data-bs-id');
            var api = window.location.origin.concat(`/admin/trip/detail/${serviceId}/${id}/api`);
            if (serviceId == 3 || serviceId == 4) {
                handleService(serviceId, api);
            } else {
                console.error('Invalid serviceId:', serviceId);
            }
        })

        exampleModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var serviceId = button.getAttribute('data-bs-service-id');
            var id = button.getAttribute('data-bs-id');
            var api = window.location.origin.concat(`/admin/trip/detail/${serviceId}/${id}/api`);
            if (serviceId == 3 || serviceId == 4) {
                handleService(serviceId, api);
            } else {
                console.error('Invalid serviceId:', serviceId);
            }
        })

    </script>

@endsection
