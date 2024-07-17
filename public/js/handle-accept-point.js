document.addEventListener('DOMContentLoaded', function () {
    const chooseAll = document.getElementById('choose_all');
    const checkboxes = document.querySelectorAll('.choose_item');
    const acceptButton = document.getElementById('handle-selected');
    const selectedCount = document.getElementById('selected-count');
    const actionBar = document.getElementById('action-bar');
    const multipleAcceptForm = document.getElementById('multiple-accept-form');

    // Chọn tất cả checkbox
    chooseAll.addEventListener('change', function () {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateActionBar();
    });

    // Cập nhật khi chọn checkbox đơn lẻ
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            if (!this.checked) {
                chooseAll.checked = false;
            } else if (Array.from(checkboxes).every(checkbox => checkbox.checked)) {
                chooseAll.checked = true;
            }
            updateActionBar();
        });
    });

    // Cập nhật thanh hành động
    function updateActionBar() {
        const checkedCheckboxes = document.querySelectorAll('.choose_item:checked');
        selectedCount.textContent = checkedCheckboxes.length;
        actionBar.style.display = checkedCheckboxes.length > 0 ? 'block' : 'none';
    }

    // Xử lý sự kiện nhấn nút xóa
    acceptButton.addEventListener('click', function () {
        const selectedIds = Array.from(document.querySelectorAll('.choose_item:checked')).map(checkbox => checkbox.value);
        if (selectedIds.length > 0) {
            multipleAcceptForm.submit();
        }
    });
});
