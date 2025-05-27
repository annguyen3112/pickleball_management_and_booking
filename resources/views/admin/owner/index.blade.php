@extends('admin.extend')
@section('admin_content')
    <main id="main" class="main">
        {{-- Tiêu đề --}}
        <div class="pagetitle">
            <h1>Quản lý chủ sân</h1>
        </div>
        {{ Breadcrumbs::render('owner') }}
        @include('admin.layouts.alert')
        {{-- Body --}}
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Danh sách chủ sân</h5>
                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal"
                        data-bs-target="#add-owner-modal">Thêm chủ sân
                    </button>
                    <table data-url="{{ route('user.fetchOwner') }}" id="table_owner" class="display"
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
    @include('admin.modal.owner.create')
    @include('admin.modal.owner.info')
    @include('admin.modal.owner.role')
    @push('scripts')
        <script>
            const table_owner = $("#table_owner");
            const add_owner_modal = $('#add-owner-modal');
            table_owner.DataTable({
                ajax: table_owner[0].dataset.url,
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
                            return `<button data-bs-toggle="modal"
                                        data-bs-target="#role-owner-modal" data-id="${data}" class="text-light btn btn-warning btn-role-owner">
                                        <i class="bi bi-person-gear"></i>
                                    </button>`;
                        }
                    },
                    {
                        data: "id",
                        orderable: false,
                        render: function(data, type, row) {
                            const btn =
                                `<button data-bs-toggle="modal"
                                    data-bs-target="#info-owner-modal" data-id="${data}" class="text-light btn btn-info">
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
                                `<form method="post" action="{{ route('user.destroyOwner') }}/${data}">
                                    @csrf
                                    @method('delete')
                                <button type="submit" data-id="${data}" class="confirm-btn btn-delete-owner btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                </form>`;
                            return btn;
                        },
                    },
                ],
            });

            table_owner.on('click', '.btn-info', function(e) {
                const ownerId = $(this).data('id');
                info_owner_modal[0].dataset.owner_id = ownerId;
                showOwner(ownerId);
                info_owner_modal.find('form').attr('action', "{{ route('user.updateOwner') }}/" + ownerId);
            });

            add_owner_modal.on('click', '.btn-add-owner', function() {
                const form = add_owner_modal.find('form');
                $.ajax({
                    type: "post",
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(response) {
                        add_owner_modal.modal('hide');
                        add_owner_modal.find('input').val('');
                        table_owner.DataTable().ajax.reload();

                        $.toast({
                            heading: "Thành công",
                            text: response.message,
                            showHideTransition: "plain",
                            icon: 'success',
                            position: "bottom-right",
                        });

                    },
                    error: function(response) {
                        setError(add_owner_modal.find('.error-name'), response.responseJSON.errors.name);
                        setError(add_owner_modal.find('.error-email'), response.responseJSON.errors
                            .email);
                        setError(add_owner_modal.find('.error-phone'), response.responseJSON.errors
                            .phone);
                        setError(add_owner_modal.find('.error-address'), response.responseJSON.errors
                            .address);
                        setError(add_owner_modal.find('.error-password'), response.responseJSON.errors
                            .password);
                        setError(add_owner_modal.find('.error-confirm_password'), response.responseJSON
                            .errors.confirm_password);
                    },
                });
            });
            
            table_owner.on('click', '.btn-role-owner', function() {
                const userId = $(this).data('id');
                $('#user_id').val(userId);
                $('#role-owner-modal').modal('show');
            });


            function setError(el, value) {
                if (!value) {
                    el.html('');
                    return;
                }
                el.html(value[0]);
            }

            $('#role-owner-form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const userId = $('#user_id').val();
                const role = $('#role').val();
                const url = "/api/updateRoleOwner/" + userId;

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    success: function(response) {
                        $('#role-owner-modal').modal('hide'); 
                        table_owner.DataTable().ajax.reload(); 
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
