{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')
    <input type="hidden" id="all-discounts" name="all-discounts" value="{{ json_encode($allDiscounts) }}">
    <input type="hidden" id="flash-types" value="{{ json_encode($flashTypes) }}">

    <div class="container-fluid">
        <form action="{{ route('admin.flash_sale.update', $flashSale->id) }}" method="POST"
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
                                               value="{{ $flashSale->title }}">
                                        @error('title')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
{{--                                    <div class="form-group col-3">--}}
{{--                                        <label>Loại</label>--}}
{{--                                        <select name="type" id="type" class="default-select form-control">--}}
{{--                                            @foreach($flashTypes as $key => $item)--}}
{{--                                                <option {{ $flashSale->type == $key ? 'selected' : '' }} value="{{$key}}">{{$item}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
                                    <div class="form-group col-3">
                                        <label>Trạng thái</label>
                                        <select name="status" id="status" class="default-select form-control">
                                            <option {{ $flashSale->status == 1 ? 'selected' : '' }} value="1"> Hiển thị</option>
                                            <option {{ $flashSale->status == 0 ? 'selected' : '' }} value="0">Không hiển thị</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="start_date">Bắt đầu</label>
                                        <input type="datetime-local" name="start_date" id="start_date"
                                               class="form-control"
                                               value="{{ $flashSale->start_date }}">
                                        @error('start_date')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="end_date">Kết thúc</label>
                                        <input type="datetime-local" name="end_date" id="end_date" class="form-control"
                                               value="{{ $flashSale->end_date }}">
                                        @error('end_date')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="accordion__body p-4 collapse show col-6" id="with-feature-image"
                                         data-bs-parent="#accordion-feature-image">
                                        <div class="featured-img-preview img-parent-box">

                                            <img src="{{ $flashSale->banner ?? asset('images/noimage.jpg') }}" class="avatar img-for-onchange"
                                                 alt="{{ $flashSale->title ?? __('common.image') }}" width="100px" height="100px"
                                                 title="{{ $flashSale->title ?? __('common.image') }}">

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
                    <h6 class="">Khuyến mãi tham gia Flash Sale</h6>
                    <button type="button" class="btn btn-primary btn-xs" id="addDiscountBtn">Thêm khuyến mãi</button>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg mb-0" id="discountsTable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Mã</th>
                                <th>Tiêu đề</th>
                                <th>Giảm</th>
                                <th>Loại</th>
                                <th>SLượng</th>
                                <th>Đã SD</th>
                                <th>Tắt/Bật</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($flashSale->flashSaleDetails as $detail)
                                <tr>
                                    <input type="hidden" name="discounts[{{ $detail->discount_id }}][id]" value="{{ $detail->discount->id }}">
                                    <td><img class="rounded" src="{{ $detail->discount->image ?? '' }}" width="70"
                                             height="50"
                                             alt="{{$detail->discount->discount_code}}"/></td>
                                    <td>{{ $detail->discount->discount_code }}</td>
                                    <td class="w-20">{{ $detail->discount->title }}</td>
                                    <td class="w-6">{{ number_format($detail->discount->discount_value) ?? '' }} {{ $detail->discount->discount_type == 1 ? '%' : 'đ' }}</td>
                                    <td>
                                        <select name="discounts[{{ $detail->discount_id }}][type]"
                                                id="type" class="default-select form-control">
                                            @foreach($flashTypes as $key => $item)
                                                <option {{ $detail->type == $key ? 'selected' : '' }} value="{{$key}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="width: 136px; word-wrap: break-word;">
                                        <input type="number" name="discounts[{{ $detail->discount_id }}][max_usage]"
                                               value="{{ $detail->max_usage }}" class="form-control" required>
                                    </td>
                                    <td class="w-6">{{ $detail->number_user_usage }}</td>

                                    <td>
                                        <div class="toggle-switch">
                                            <label for="show-checkbox-{{$detail->id}}">
                                                <input id="show-checkbox-{{$detail->id}}" type="checkbox"
                                                       name="discounts[{{ $detail->discount_id }}][status]" value="1"
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

    <!-- Modal for selecting discounts -->
    <div class="modal fade" id="discountModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chọn Khuyến Mãi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" id="availableDiscountsTable">
                        <thead>
                        <tr>
                            <th>
                                <strong>
                                    <input class="form-check-input" type="checkbox" name="choose_all"
                                           id="choose_all">
                                </strong>
                            </th>
                            <th>Mã</th>
                            <th>Tiêu đề</th>
                            <th>Giảm</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="addSelectedDiscounts">Thêm <span
                                id="selected-count"></span></button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('inline-scripts')
    <script>
        const chooseAll = document.getElementById('choose_all');
        const checkboxes = document.querySelectorAll('.choose_item');
        const selectedCount = document.getElementById('selected-count');

        // Chọn tất cả checkbox
        chooseAll.addEventListener('change', function () {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Cập nhật khi chọn checkbox đơn lẻ
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                if (!this.checked) {
                    chooseAll.checked = false;
                } else if (Array.from(checkboxes).every(checkbox => checkbox.checked)) {
                    chooseAll.checked = true;
                }
            });
        });

    </script>

    <script>
        $(document).ready(function () {
            let selectedDiscounts = [];
            let tempSelectedDiscounts = []; // Biến tạm thời để lưu trạng thái checked/unchecked
            let allDiscounts = JSON.parse($('#all-discounts').val());
            let flashTypes = JSON.parse($('#flash-types').val());

            // Load previously selected discounts
            $('input[type="hidden"][name*="[id]"]').each(function () {
                selectedDiscounts.push(parseInt($(this).val()));
            });

            // Open discount modal
            $('#addDiscountBtn').click(function () {
                let tbody = $('#availableDiscountsTable tbody');
                tbody.empty();
                allDiscounts.forEach(function (discount) {
                    let checked = selectedDiscounts.includes(discount.id) ? 'checked' : '';
                    tbody.append(`
                    <tr>
                        <td><input type="checkbox" class="form-check-input choose_item discount-checkbox" value="${discount.id}" ${checked}></td>
                        <td>${discount.discount_code}</td>
                        <td>${discount.title}</td>
                        <td class="w-6">${new Intl.NumberFormat().format(discount.discount_value)} ${discount.discount_type == 1 ? '%' : 'đ'}</td>
                    </tr>
                `);
                });
                // Cập nhật trạng thái cho biến tạm thời
                tempSelectedDiscounts = [...selectedDiscounts];
                $('#discountModal').modal('show');
            });

            // Xử lý khi check/uncheck discount
            $(document).on('change', '.discount-checkbox', function () {
                let discountId = parseInt($(this).val());
                if (this.checked) {
                    if (!tempSelectedDiscounts.includes(discountId)) {
                        tempSelectedDiscounts.push(discountId);
                    }
                } else {
                    tempSelectedDiscounts = tempSelectedDiscounts.filter(id => id !== discountId);
                }
            });

            // Add selected discounts
            $('#addSelectedDiscounts').click(function () {
                // $('.discount-checkbox:checked').each(function () {
                //     let discountId = $(this).val();
                //     console.log(discountId);
                //     if (!selectedDiscounts.includes(parseInt(discountId))) {
                //         selectedDiscounts.push(parseInt(discountId));
                //         addDiscountToTable(discountId, flashTypes);
                //     }
                // });

                // Tạo mảng các discount hiện tại trong bảng
                let currentDiscounts = getCurrentDiscounts();
                // Tạo mảng các discount đã chọn
                let newSelectedDiscounts = [...tempSelectedDiscounts];

                // So sánh và xóa các discount không còn được chọn
                currentDiscounts.forEach(function (discountId) {
                    if (!newSelectedDiscounts.includes(discountId)) {
                        // Xóa discount không còn được chọn
                        $(`#discountsTable input[name="discounts[${discountId}][id]"]`).closest('tr').remove();
                    }
                });

                // Cập nhật mảng selectedDiscounts với các giá trị trong biến tạm thời
                selectedDiscounts = [...newSelectedDiscounts];

                // Thêm các discount mới vào bảng
                newSelectedDiscounts.forEach(function (discountId) {
                    if (!currentDiscounts.includes(discountId)) {
                        addDiscountToTable(discountId, flashTypes);
                    }
                });

                $('#discountModal').modal('hide');
            });

            // Remove discount
            $(document).on('click', '.removeDiscountBtn', function () {
                let discountId = $(this).closest('tr').find('input[type="hidden"][name*="[id]"]').val();
                selectedDiscounts = selectedDiscounts.filter(id => id !== parseInt(discountId));
                $(this).closest('tr').remove();
            });

            function addDiscountToTable(discountId, flashTypes) {
                if ($(`#discountsTable input[name="discounts[${discountId}][id]"]`).length === 0) {
                    let discount = allDiscounts.find(d => d.id === parseInt(discountId));
                    let options = '';
                    for (let key in flashTypes) {
                        options += `<option value="${key}">${flashTypes[key]}</option>`;
                    }
                    let imageUrl = discount.image !== undefined ? discount.image : '';
                    let row = `
                <tr>
                    <input type="hidden" name="discounts[${discountId}][id]" value="${discountId}">
                    <td><img class="rounded" src="${imageUrl}" width="70" height="50" alt="${discount.discount_code}"/></td>
                    <td>${discount.discount_code}</td>
                    <td class="w-20">${discount.title}</td>
                    <td class="w-6">${new Intl.NumberFormat().format(discount.discount_value)} ${discount.discount_type == 1 ? '%' : 'đ'}</td>
                    <td>
                        <select name="discounts[${discountId}][type]" id="type" class="default-select form-control">
                            ${options}
                        </select>
                    </td>
                    <td>
                        <input type="number" name="discounts[${discountId}][max_usage]" class="form-control" value="1" required>
                    </td>
                    <td class="w-6">0</td>
                    <td>
                        <div class="toggle-switch">
                            <label for="show-checkbox-${discountId}">
                                <input id="show-checkbox-${discountId}" type="checkbox"
                                       name="discounts[${discountId}][status]" value="1"
                                       checked
                                       class="display-none w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <span><small></small></span>
                            </label>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger shadow btn-xs sharp me-1 removeDiscountBtn">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
                    $('#discountsTable tbody').append(row);
                }
            }
            function getCurrentDiscounts() {
                let currentDiscounts = [];
                $('#discountsTable input[type="hidden"][name*="[id]"]').each(function() {
                    currentDiscounts.push(parseInt($(this).val()));
                });
                return currentDiscounts;
            }
        });
    </script>
@endpush
