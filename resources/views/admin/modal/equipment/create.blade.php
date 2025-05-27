{{-- Modal --}}
<div class="modal fade" id="add-equipment-modal" tabindex="-1" style="display: none;"
aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form action="{{ route('equipment.storeEquipment') }}" method="POST">
            @csrf
            <div class="modal-header bg-success text-light">
                <h5 class="modal-title text-light">Thêm dụng cụ mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-3 col-form-label">
                        Tên dụng cụ <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control">
                        <div class="text-danger error error-name"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-3 col-form-label">
                        Giá <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="number" name="price" class="form-control">
                        <div class="text-danger error error-price"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-3 col-form-label">
                        Mô tả
                    </label>
                    <div class="col-sm-9">
                        <input type="text" name="description" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn-add-equipment btn btn-success">Thêm</button>
            </div>
        </form>
    </div>
</div>
</div>