{{-- Modal --}}
<div class="modal fade" id="add-owner-modal" tabindex="-1" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form action="{{ route('user.storeOwner') }}" method="POST">
            @csrf
            <div class="modal-header bg-success text-light">
                <h5 class="modal-title text-light">Thêm chủ sân mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-3 col-form-label">
                        Tên chủ sân <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control">
                        <div class="text-danger error error-name"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-3 col-form-label">
                        Địa chỉ email <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="email" name="email" class="form-control">
                        <div class="text-danger error error-email"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-3 col-form-label">
                        Số điện thoại <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="number" name="phone" class="form-control">
                        <div class="text-danger error error-phone"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-3 col-form-label">
                        Địa chỉ
                    </label>
                    <div class="col-sm-9">
                        <input type="text" name="address" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-3 col-form-label">
                        Mật khẩu <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="password" name="password" class="form-control">
                        <div class="text-danger error error-password"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-3 col-form-label">
                        Nhập lại mật khẩu <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="password" name="confirm_password" class="form-control">
                        <div class="text-danger error error-confirm_password"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn-add-owner btn btn-success">Thêm</button>
            </div>
        </form>
    </div>
</div>
</div>