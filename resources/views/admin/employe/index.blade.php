@extends('admin.extend')
@section('admin_content')
    <main id="main" class="main">
        {{-- Tiêu đề --}}
        <div class="pagetitle">
            <h1>Quản lý nhân viên</h1>
        </div>
        {{ Breadcrumbs::render('employe') }}
        @include('admin.layouts.alert')
        {{-- Body --}}
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Danh sách nhân viên</h5>
                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal"
                        data-bs-target="#add-employe-modal">Thêm nhân viên
                    </button>
                    <table data-url="{{ route('user.fetchEmploye') }}" id="table_employe" class="display"
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
    @include('admin.modal.employe.create')
    @include('admin.modal.employe.info')
    @include('admin.modal.employe.role')
    @push('scripts')
        <script>
            const isAdmin = @json(auth()->user()->role === 3);
            const table_employe = $("#table_employe");
            const add_employe_modal = $('#add-employe-modal');
            table_employe.DataTable({
                ajax: table_employe[0].dataset.url,
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
                                            data-bs-target="#role-employe-modal" data-id="${data}" class="text-light btn btn-warning btn-role-employe">
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
                                    data-bs-target="#info-employe-modal" data-id="${data}" class="text-light btn btn-info">
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
                                `<form method="post" action="{{ route('user.destroyEmploye') }}/${data}">
                                    @csrf
                                    @method('delete')
                                <button type="submit" data-id="${data}" class="confirm-btn btn-delete-employe btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                </form>`;
                            return btn;
                        },
                    },
                ],
            });

            table_employe.on('click', '.btn-info', function(e) {
                $('#info-employe-modal')[0].dataset.user_id = $(this).data('id');
                const tab1_content = $('#bordered-justified-employe-tab1-content');
                tab1_content.html('');
                fetchIdentityPapers($(this).data('id'));
                showUser($(this).data('id'));
                $('#bordered-justified-employe-tab2 form').attr('action', "{{ route('user.updateEmploye') }}/" + $(this).data('id'));
            });

            add_employe_modal.on('click', '.btn-add-employe', function() {
                const form = add_employe_modal.find('form');
                $.ajax({
                    type: "post",
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(response) {
                        add_employe_modal.modal('hide');
                        add_employe_modal.find('input').val('');
                        table_employe.DataTable().ajax.reload();

                        $.toast({
                            heading: "Thành công",
                            text: response.message,
                            showHideTransition: "plain",
                            icon: 'success',
                            position: "bottom-right",
                        });

                    },
                    error: function(response) {
                        setError(add_employe_modal.find('.error-name'), response.responseJSON.errors.name);
                        setError(add_employe_modal.find('.error-email'), response.responseJSON.errors
                            .email);
                        setError(add_employe_modal.find('.error-phone'), response.responseJSON.errors
                            .phone);
                        setError(add_employe_modal.find('.error-address'), response.responseJSON.errors
                            .address);
                        setError(add_employe_modal.find('.error-password'), response.responseJSON.errors
                            .password);
                        setError(add_employe_modal.find('.error-confirm_password'), response.responseJSON
                            .errors.confirm_password);
                    },
                });
            });

            function setError(el, value) {
                if (!value) {
                    el.html('');
                    return;
                }
                el.html(value[0]);
            }

            function fetchIdentityPapers(id) {
                const url = "{{ route('identity_paper.showByUserId') }}" + '/' + id;
                let baseStorageUrl = "{{ asset('storage') }}";

                $.ajax({
                    type: "get",
                    url: url,
                    success: function(response) {
                        response = response.data;
                        const tab1_content = $('#bordered-justified-employe-tab1-content');
                        tab1_content.html('');

                        $.each(response, function(i, v) {
                            let imageUrl = v.image.startsWith('http') ? v.image : `${baseStorageUrl}/${v.image}`;

                            imageUrl = imageUrl.replace(/([^:]\/)\/+/g, "$1");

                            const content = `<div class="card col-md-4">
                                <div class="card-body">
                                    <h5 class="card-title text-center">${v.name}</h5>
                                    <img src="${imageUrl}" class="card-img-bottom" alt="Không thể tải ảnh" style="max-width:100%; height:auto;">
                                    <form method="post" action="{{ route('identity_paper.destroy') }}/${v.id}">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn-delete-identity-paper btn btn-danger btn-block mt-2">Xóa</button>
                                    </form>
                                </div>
                            </div>`;
                            tab1_content.append(content);
                        });
                    },
                    error: function(response) {
                        console.error("Lỗi khi lấy giấy tờ: ", response);
                    }
                });
            }

            $(document).on('click', '.btn-delete-identity-paper', function() {
                const result = confirm('Bạn có chắc chắn muốn xóa?');
                if (!result) return;
                const form = $(this).parents('form');
                $.ajax({
                    type: "post",
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(response) {
                        const id = $('#info-employe-modal')[0].dataset.user_id;
                        fetchIdentityPapers(id);
                        $.toast({
                            heading: "Thành công",
                            text: response.message,
                            showHideTransition: "plain",
                            icon: 'success',
                            position: "bottom-right",
                        });
                    },
                    error: function(response) {
                        response = response.responseJSON;
                        $.toast({
                            heading: "Thất bại",
                            text: response.message,
                            showHideTransition: "plain",
                            icon: 'error',
                            position: "bottom-right",
                        });
                    }
                });
            });

            table_employe.on('click', '.btn-role-employe', function() {
                const userId = $(this).data('id');
                $('#user_id').val(userId);
                $('#role-employe-modal').modal('show');
            });

            $('#role-employe-form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const userId = $('#user_id').val();
                const role = $('#role').val();
                const url = "/api/updateRoleEmploye/" + userId;

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    success: function(response) {
                        $('#role-employe-modal').modal('hide');
                        table_employe.DataTable().ajax.reload();
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
