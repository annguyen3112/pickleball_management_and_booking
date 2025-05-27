{{-- Modal --}}
<div class="modal fade" id="info-equipment-modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-light">
                <h5 class="modal-title text-light">Chỉnh sửa thông tin dụng cụ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    @method('put')
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
                    <div class="text-center">
                        <form action="" method="post">
                            @csrf
                            @method('put')
                        <button class="btn-update-equipment btn btn-success" type="button">Cập nhật thông tin dụng cụ</button>
                        </form>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const info_equipment_modal = $('#info-equipment-modal');

        function showEquipment(id) {
            const url = "{{ route('equipment.showEquipment') }}/" + id;

            $.ajax({
                type: "get",
                url: url,
                success: function(response) {
                    response = response.data;
                    const form = info_equipment_modal.find('form');
                    form.find('input[name="name"]').val(response.name);
                    form.find('input[name="price"]').val(response.price);
                    form.find('input[name="description"]').val(response.description);
                }
            });
        }

        info_equipment_modal.on('click', '.btn-update-equipment', function() {
            const form = $(this).parents("form");
            $.ajax({
                type: "post",
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    info_equipment_modal.modal('hide');
                    table_equipment.DataTable().ajax.reload();
                    $.toast({
                        heading: "Thành công",
                        text: response.message,
                        showHideTransition: "plain",
                        icon: 'success',
                        position: "bottom-right",
                    });
                },
                error: function(response) {
                    setError(info_equipment_modal.find('.error-name'), response.responseJSON.errors.name);
                    setError(info_equipment_modal.find('.error-price'), response.responseJSON.errors.price);
                    setError(info_equipment_modal.find('.error-description'), response.responseJSON.errors.description);
                },
            });
        });
    </script>
@endpush
