{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">
        <form action="{{ route('admin.flash_sale.golden_hours.update', $data->id) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <h6 class="">Thông tin cơ bản</h6>
                </div>

                <div class="card-body">
                    <div class="basic-form">
                        <div class="row align-items-center">

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label for="title">Tiêu đề</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                               value="{{ $data->title }}">
                                        @error('title')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Trạng thái</label>
                                        <select name="status" id="status" class="default-select form-control">
                                            <option {{ $data->status == 1 ? 'selected' : '' }} value="1"> Hiển thị
                                            </option>
                                            <option {{ $data->status == 0 ? 'selected' : '' }} value="0">Không hiển
                                                thị
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="start_date">Bắt đầu</label>
                                        <input type="datetime-local" name="start_date" id="start_date"
                                               class="form-control"
                                               value="{{ $data->start_date }}">
                                        @error('start_date')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="end_date">Kết thúc</label>
                                        <input type="datetime-local" name="end_date" id="end_date" class="form-control"
                                               value="{{ $data->end_date }}">
                                        @error('end_date')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="accordion__body p-4 collapse show col-6" id="with-feature-image"
                                         data-bs-parent="#accordion-feature-image">
                                        <div class="featured-img-preview img-parent-box">

                                            <img src="{{ $data->banner ?? asset('images/noimage.jpg') }}"
                                                 class="avatar img-for-onchange"
                                                 alt="{{ $data->title ?? __('common.image') }}" width="100px"
                                                 height="100px"
                                                 title="{{ $data->title ?? __('common.image') }}">

                                            <div class="form-file">
                                                <input type="file" class="ps-2 form-control img-input-onchange"
                                                       name="data[meta][4][value]" accept=".png, .jpg, .jpeg"
                                                       id="BlogMeta4Value">
                                            </div>
                                        </div>
                                        @error('data.meta.1.value')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="">Cửa hàng tham gia Khung giờ vàng</h6>
                    <button type="button" class="btn btn-primary btn-xs" id="addDiscountBtn">Thêm</button>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg mb-0" id="discountsTable">
                            <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Mã</th>
                                <th>Tên</th>
                                <th>Tắt/Bật</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data->flashSaleDetails as $detail)
                                <tr>
                                    <input type="hidden" name="discounts[{{ $detail->restaurant_id }}][id]"
                                           value="{{ $detail->restaurant->id }}">
                                    <td><img class="rounded" src="{{ $detail->restaurant->avatar ?? '' }}" width="70"
                                             height="50"
                                             alt="{{$detail->restaurant->name}}"/></td>
                                    <td class="w-20">{{ $detail->restaurant->id }}</td>
                                    <td class="w-20">{{ $detail->restaurant->name }}</td>

                                    <td>
                                        <div class="toggle-switch">
                                            <label for="show-checkbox-{{$detail->id}}">
                                                <input id="show-checkbox-{{$detail->id}}" type="checkbox"
                                                       name="discounts[{{ $detail->restaurant_id }}][status]" value="1"
                                                       {{ $detail->status == 1 ? 'checked' : '' }}
                                                       class="display-none w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <span><small></small></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button"
                                                class="btn btn-danger shadow btn-xs sharp me-1 removeDiscountBtn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer pt-0 text-end">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>

    <!-- Modal for selecting restaurants -->
    <div class="modal fade" id="discountModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chọn Cửa Hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="restaurantSearch" placeholder="Tìm kiếm tên cửa hàng...">
                        <button class="btn btn-outline-secondary" type="button" id="searchBtn">Tìm kiếm</button>
                    </div>
                    <table class="table" id="availableDiscountsTable">
                        <thead>
                        <tr>
                            <th><input class="form-check-input" type="checkbox" id="choose_all"></th>
                            <th>Mã</th>
                            <th>H/A</th>
                            <th>Tên SP</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Will be populated by JavaScript -->
                        </tbody>
                    </table>
                    <div id="pagination-links"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="addSelectedDiscounts">Thêm <span id="selected-count"></span></button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('inline-scripts')
    <script>
        $(document).ready(function () {
            // Open modal and load restaurant data with pagination
            $('#addDiscountBtn').on('click', function () {
                loadRestaurants();
            });

            // Search functionality
            $('#searchBtn').on('click', function () {
                loadRestaurants($('#restaurantSearch').val());
            });

            // Pagination links click
            $(document).on('click', '#pagination-links a', function (e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                loadRestaurants($('#restaurantSearch').val(), page);
            });

            // Load restaurants with AJAX
            function loadRestaurants(search = '', page = 1) {
                $.ajax({
                    url: '{{ route("admin.flash_sale.restaurant.list") }}',
                    method: 'GET',
                    data: {
                        search: search,
                        page: page
                    },
                    success: function (response) {
                        $('#availableDiscountsTable tbody').html(response);
                        $('#discountModal').modal('show');
                    }
                });
            }

            // Add selected restaurants to the flash sale detail
            $('#addSelectedDiscounts').on('click', function () {
                $('#availableDiscountsTable tbody input[type="checkbox"]:checked').each(function () {
                    var restaurantId = $(this).val();
                    var name = $(this).data('name');
                    var imgSrc = $(this).data('img');

                    // Kiểm tra xem nhà hàng đã tồn tại trong bảng chưa
                    if ($('#discountsTable tbody input[value="' + restaurantId + '"]').length > 0) {
                        alert('Nhà hàng đã được thêm trước đó.');
                        return; // Bỏ qua nếu đã tồn tại
                    }

                    // Append selected restaurant to the flash sale detail table
                    var newRow = `<tr>
                    <input type="hidden" name="discounts[${restaurantId}][id]" value="${restaurantId}">
                    <td><img class="rounded" src="${imgSrc}" width="70" height="50" alt="${name}"/></td>
                    <td class="w-20">${restaurantId}</td>
                    <td class="w-20">${name}</td>
                    <td>
                        <div class="toggle-switch">
                            <label for="show-checkbox-${restaurantId}">
                                <input id="show-checkbox-${restaurantId}" type="checkbox" name="discounts[${restaurantId}][status]" value="1" checked class="display-none w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <span><small></small></span>
                            </label>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger shadow btn-xs sharp me-1 removeDiscountBtn">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;

                    $('#discountsTable tbody').append(newRow);
                });

                $('#discountModal').modal('hide');
            });
        });

        $(document).on('click', '.removeDiscountBtn', function () {
            $(this).closest('tr').remove();
        });
    </script>
@endpush
