{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
<form action="{{ route('admin.food_priority.store') }}" method="post">
@csrf

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Nhà hàng</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="restaurant_search">Tìm kiếm nhà hàng</label>
                        <input type="text" name="restaurant_search" id="restaurant_search" class="form-control">
                    </div>
                    <table class="table mt-3" id="restaurant-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated by AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Sản phẩm</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="product_search">Tìm kiếm sản phẩm</label>
                        <input type="text" name="product_search" id="product_search" class="form-control">
                    </div>
                    <table class="table mt-3" id="product-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated by AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer pt-0 text-end">
        <button type="submit" class="btn btn-primary">Tạo</button>
        <a href="{{ route('admin.food_priority.index') }}" class="btn btn-danger">Quay lại</a>
        <a href="{{ route('admin.food_priority.create') }}" class="btn btn-danger">Chọn Lại</a>

    </div>
</form>
</div>

@endsection

@push('inline-scripts')
<script>
    $(document).ready(function () {
        let delayTimer; // Biến lưu trữ thời gian delay

        // Debounce cho tìm kiếm nhà hàng
        $('#restaurant_search').on('input', function () {
            clearTimeout(delayTimer); // Xóa bỏ timer trước đó
            let query = $(this).val();
            delayTimer = setTimeout(function() {
                $.ajax({
                    url: "{{ route('restaurants.search') }}",
                    method: "GET",
                    data: { search: query },
                    success: function (data) {
                        $('#restaurant-table tbody').html(data);
                    }
                });
            }, 300); // Delay 300ms
        });

        // Debounce cho tìm kiếm sản phẩm
        $('#product_search').on('input', function () {
            clearTimeout(delayTimer); // Xóa bỏ timer trước đó
            let query = $(this).val();
            delayTimer = setTimeout(function() {
                $.ajax({
                    url: "{{ route('products.search') }}",
                    method: "GET",
                    data: { search: query },
                    success: function (data) {
                        $('#product-table tbody').html(data);
                    }
                });
            }, 300); // Delay 300ms
        });

        // Xử lý sự kiện click radio của nhà hàng
        $(document).on('change', 'input[name="restaurant_id"]', function () {
            let restaurantId = $(this).val();
            $.ajax({
                url: "{{ route('products.search') }}",
                method: "GET",
                data: { restaurant_id: restaurantId },
                success: function (data) {
                    $('#product-table tbody').html(data);
                }
            });
        });

       // Xử lý sự kiện click radio của sản phẩm
// $(document).on('change', 'input[name="product_id"]', function () {
//     let productId = $(this).val();
//     console.log('Selected Product ID:', productId); // Debugging line
//     $.ajax({
//         url: "{{ route('restaurants.search') }}",
//         method: "GET",
//         data: { product_id: productId },
//         success: function (data) {
//             $('#restaurant-table tbody').html(data);
//         }
//     });
// });
    });
</script>
@endpush


