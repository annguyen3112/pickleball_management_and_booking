{{-- Modal --}}
<div class="modal fade" id="role-owner-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-gradient bg-success text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-gear"></i> Chỉnh sửa phân quyền</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <form id="role-owner-form" method="post">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-shield-lock"></i> Phân quyền <span class="text-danger">*</span>
                        </label>
                        <select name="role" id="role" class="form-select border-success">
                            <option value="CourtOwner">🔑 Chủ sân</option>
                            <option value="Employee">📋 Quản lý sân</option>
                            <option value="Client">👤 Khách hàng</option>
                        </select>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-4">
                            Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
