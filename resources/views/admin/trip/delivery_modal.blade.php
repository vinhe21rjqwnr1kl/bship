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
