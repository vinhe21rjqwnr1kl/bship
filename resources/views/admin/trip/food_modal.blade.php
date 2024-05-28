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
                                    <th scope="col">SĐT</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="restaurant-name"></td>
                                    <td class="restaurant-address"></td>
                                    <td class="restaurant-phone"></td>
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
                                    <th scope="col">Giá tiền</th>
                                    <th scope="col">Hình ảnh</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <div class="my-2 mx-4" style="text-align:right"><strong>Tổng tiền: </strong><span
                                    id="total-order-price"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
