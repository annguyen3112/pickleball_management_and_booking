@extends('admin.extend')
@section('admin_content')
    <main id="main" class="main">
        {{-- Tiêu đề --}}
        <div class="pagetitle">
            <h1>Quản lý dụng cụ</h1>
        </div>
        {{ Breadcrumbs::render('equipment') }}
        @include('admin.layouts.alert')
        {{-- Body --}}
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Danh sách dụng cụ</h5>
                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal"
                        data-bs-target="#add-equipment-modal">Thêm dụng cụ
                    </button>
                    <table data-url="{{ route('equipment.fetchEquipment') }}" id="table_equipment" class="display"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên</th>
                                <th>Giá</th>
                                <th>Mô tả</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
    </main>
    @include('admin.modal.equipment.create')
    @include('admin.modal.equipment.info')
    @push('scripts')
        <script>
            const table_equipment = $("#table_equipment");
            const add_equipment_modal = $('#add-equipment-modal');
            table_equipment.DataTable({
                ajax: table_equipment[0].dataset.url,
                columns: [{
                        data: "id",
                    },
                    {
                        data: "name",
                    },
                    {
                        data: "price",
                    },
                    {
                        data: "description",
                    },
                    {
                        data: "id",
                        orderable: false,
                        render: function(data, type, row) {
                            const btn =
                                `<button data-bs-toggle="modal"
                                    data-bs-target="#info-equipment-modal" data-id="${data}" class="text-light btn btn-info">
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
                                `<form method="post" action="{{ route('equipment.destroyEquipment') }}/${data}">
                                    @csrf
                                    @method('delete')
                                <button type="submit" data-id="${data}" class="confirm-btn btn-delete-equipment btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                </form>`;
                            return btn;
                        },
                    },
                ],
            });

            table_equipment.on('click', '.btn-info', function(e) {
                const equipmentId = $(this).data('id');
                info_equipment_modal[0].dataset.equipment_id = equipmentId;
                showEquipment(equipmentId);
                info_equipment_modal.find('form').attr('action', "{{ route('equipment.updateEquipment') }}/" + equipmentId);
            });

            add_equipment_modal.on('click', '.btn-add-equipment', function() {
                const form = add_equipment_modal.find('form');
                $.ajax({
                    type: "post",
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(response) {
                        add_equipment_modal.modal('hide');
                        add_equipment_modal.find('input').val('');
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
                        setError(add_equipment_modal.find('.error-name'), response.responseJSON.errors.name);
                        setError(add_equipment_modal.find('.error-price'), response.responseJSON.errors
                            .price);
                        setError(add_equipment_modal.find('.error-description'), response.responseJSON.errors
                            .description);
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

        </script>
    @endpush
@endsection
