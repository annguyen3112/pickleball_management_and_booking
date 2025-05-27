{{-- Modal --}}
<div class="modal fade" id="info-customer-modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-light">
                <h5 class="modal-title text-light fw-bold">Thông tin khách hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    @method('put')
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">
                            Tên khách hàng <span class="text-danger">*</span>
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
                    <div class="text-center">
                        <form action="" method="post">
                            @csrf
                            @method('put')
                        <button class="btn-update-customer btn btn-success" type="button">Cập nhật thông tin</button>
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
        const info_customer_modal = $('#info-customer-modal');

        function showUser(id) {
            const url = "{{ route('user.showCustomer') }}/" + id;

            $.ajax({
                type: "get",
                url: url,
                success: function(response) {
                    response = response.data;
                    const form = info_customer_modal.find('form');
                    form.find('input[name="name"]').val(response.name);
                    form.find('input[name="email"]').val(response.email);
                    form.find('input[name="phone"]').val(response.phone);
                    form.find('input[name="address"]').val(response.address);
                }
            });
        }

        info_customer_modal.on('click', '.btn-update-customer', function() {
            const form = $(this).parents("form");
            $.ajax({
                type: "post",
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    info_customer_modal.modal('hide');
                    table_customer.DataTable().ajax.reload();
                    $.toast({
                        heading: "Thành công",
                        text: response.message,
                        showHideTransition: "plain",
                        icon: 'success',
                        position: "bottom-right",
                    });
                },
                error: function(response) {
                    setError(info_customer_modal.find('.error-name'), response.responseJSON.errors.name);
                    setError(info_customer_modal.find('.error-email'), response.responseJSON.errors.email);
                    setError(info_customer_modal.find('.error-phone'), response.responseJSON.errors.phone);
                    setError(info_customer_modal.find('.error-address'), response.responseJSON.errors.address);
                },
            });
        });
    </script>
@endpush
