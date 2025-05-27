@extends('admin.extend')
@section('admin_content')
    <main id="main" class="main">
        {{-- Tiêu đề --}}
        <div class="pagetitle">
            <h1>Quản lý khách hàng</h1>
        </div>
        {{ Breadcrumbs::render('customer') }}
        @include('admin.layouts.alert')
        {{-- Body --}}
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Danh sách khách hàng</h5>
                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal"
                        data-bs-target="#add-customer-modal">Thêm khách hàng
                    </button>
                    <table data-url="{{ route('user.fetchCustomer') }}" id="table_customer" class="display"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên</th>
                                <th>Điện thoại</th>
                                <th>Email</th>
                                <th>Địa chỉ</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
    </main>
    @include('admin.modal.customer.create')
    @include('admin.modal.customer.info')
    @include('admin.modal.customer.role')
    @push('scripts')
        <script>
            const isAdmin = @json(auth()->user()->role === 3);
            const table_customer = $("#table_customer");
            const add_customer_modal = $('#add-customer-modal');
            table_customer.DataTable({
                ajax: table_customer[0].dataset.url,
                columns: [{
                        data: "id",
                    },
                    {
                        data: "name",
                    },
                    {
                        data: "phone",
                    },
                    {
                        data: "email",
                    },
                    {
                        data: "address",
                        orderable: false,
                    },
                    {
                        data: "id",
                        orderable: false,
                        render: function(data, type, row) {
                            if (isAdmin) {
                                return `<button data-bs-toggle="modal"
                                            data-bs-target="#role-customer-modal" data-id="${data}" class="text-light btn btn-warning btn-role-customer">
                                            <i class="bi bi-person-gear"></i>
                                        </button>`;
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        data: "id",
                        orderable: false,
                        render: function(data, type, row) {
                            const btn =
                                `<button data-bs-toggle="modal"
                                    data-bs-target="#info-customer-modal" data-id="${data}" class="text-light btn btn-info">
                                    <i class="bi bi-eye-fill"></i>
                                </button>`;
                            return btn;
                        },
                    },
                    {
                        data: "id",
                        orderable: false,
                        render: function(data, type, row) {
                            const btn =
                                `<form method="post" action="{{ route('user.destroyCustomer') }}/${data}">
                                    @csrf
                                    @method('delete')
                                <button type="submit" data-id="${data}" class="confirm-btn btn-delete-customer btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                </form>`;
                            return btn;
                        },
                    },
                ],
            });

            table_customer.on('click', '.btn-info', function(e) {
                const userId = $(this).data('id');
                info_customer_modal[0].dataset.user_id = userId;
                showUser(userId);
                info_customer_modal.find('form').attr('action', "{{ route('user.updateCustomer') }}/" + userId);
            });

            add_customer_modal.on('click', '.btn-add-customer', function() {
                const form = add_customer_modal.find('form');
                $.ajax({
                    type: "post",
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(response) {
                        add_customer_modal.modal('hide');
                        add_customer_modal.find('input').val('');
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
                        setError(add_customer_modal.find('.error-name'), response.responseJSON.errors.name);
                        setError(add_customer_modal.find('.error-email'), response.responseJSON.errors
                            .email);
                        setError(add_customer_modal.find('.error-phone'), response.responseJSON.errors
                            .phone);
                        setError(add_customer_modal.find('.error-address'), response.responseJSON.errors
                            .address);
                        setError(add_customer_modal.find('.error-password'), response.responseJSON.errors
                            .password);
                        setError(add_customer_modal.find('.error-confirm_password'), response.responseJSON
                            .errors.confirm_password);
                    },
                });
            });

            table_customer.on('click', '.btn-role-customer', function() {
                const userId = $(this).data('id');
                $('#user_id').val(userId);
                $('#role-customer-modal').modal('show');
            });


            function setError(el, value) {
                if (!value) {
                    el.html('');
                    return;
                }
                el.html(value[0]);
            }

            $('#role-customer-form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const userId = $('#user_id').val();
                const role = $('#role').val();
                const url = "/api/updateRoleCustomer/" + userId;

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    success: function(response) {
                        $('#role-customer-modal').modal('hide'); 
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
                        alert("Cập nhật thất bại, vui lòng thử lại!");
                    },
                });
            });

        </script>
    @endpush
@endsection
