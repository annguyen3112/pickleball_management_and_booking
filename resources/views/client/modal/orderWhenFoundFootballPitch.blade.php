<!-- Modal -->
<div class="modal fade" id="orderModalWhenFoundFootballPitch" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('order.clientStore') }}">
            @csrf
            <input type="hidden" name="start_at">
            <input type="hidden" name="end_at">
            <input type="hidden" name="football_pitch_id">
            <div class="modal-content">
                <div class="modal-header bg-success text-light">
                    <h5 class="modal-title" id="exampleModalLabel">Đặt sân</h5>
                    <button type="button" class="btn-close text-light" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Họ và tên <span
                                        class="text-danger">(*)</span></label>
                                <div class="col-sm-8">
                                    <input placeholder="Nhập tên" required type="text" name="name"
                                        class="form-control"
                                        @if (Auth::check()) value="{{ auth()->user()->name }}" @endif
                                    >
                                    <div class="text-danger error-name alert-danger error error-hide"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Số điện thoại <span
                                        class="text-danger">(*)</span></label>
                                <div class="col-sm-8">
                                    <input placeholder="Nhập số điện thoại" required type="number" name="phone"
                                        class="form-control"
                                        @if (Auth::check()) value="{{ auth()->user()->phone }}" @endif
                                        >
                                    <div class="text-danger error-phone alert-danger error error-hide"></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input placeholder="Nhập email" type="email" name="email" class="form-control"
                                    @if (Auth::check()) value="{{ auth()->user()->email }}" @endif
                                    >
                                    <div class="text-danger error-email alert-danger error error-hide"></div>
                                </div>

                            </div>
                            
                            <div class="row">
                                <div class="alert alert-danger alert-main error error-hide"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-center mb-3"><b>Chọn dịch vụ đi kèm</b></h5>
                            <ul class="list-group" id="equipmentList1">
                                <!-- Danh sách dịch vụ được load từ AJAX -->
                            </ul>
                            <p class="text-center mt-3">
                                <strong>Tổng giá dịch vụ: </strong>
                                <span id="totalEquipmentPrice1" class="fw-bold text-success">0 đ</span>
                            </p>
                            <div id="selectedServicesContainer1"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success btn-order">Đặt sân</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectedServicesInput = document.getElementById("selectedServices1");
        const equipmentList1 = document.getElementById("equipmentList1");
        const btnOrder = document.querySelector(".btn-order");

    
        function fetchEquipments() {
            fetch("{{ route('equipment.fetchEquipment') }}")
                .then(response => response.json())
                .then(data => {
                    if (!data || !data.data || data.data.length === 0) {
                        equipmentList1.innerHTML = "<li class='list-group-item text-danger'>Không có dịch vụ nào khả dụng</li>";
                        return;
                    }

                    let html = data.data.map(item => `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <input class="form-check-input me-2 service-checkbox" type="checkbox" value="${item.id}" data-price="${item.price}">
                                ${item.name}
                                <span class="text-success fw-bold">${new Intl.NumberFormat().format(item.price)} đ</span>
                            </div>
                            <div class="input-group" style="width: 100px; display: none;" data-id="${item.id}">
                                <button class="btn btn-outline-secondary btn-decrease" type="button">-</button>
                                <input type="text" class="form-control text-center quantity-input" value="1" readonly>
                                <button class="btn btn-outline-secondary btn-increase" type="button">+</button>
                            </div>
                        </li>
                    `).join("");

                    equipmentList1.innerHTML = html;

                    document.querySelectorAll(".service-checkbox").forEach(checkbox => {
                        checkbox.addEventListener("change", function () {
                            let inputGroup = document.querySelector(`.input-group[data-id="${this.value}"]`);
                            if (this.checked) {
                                inputGroup.style.display = "flex";
                                updateSelectedServices();
                            } else {
                                inputGroup.style.display = "none";
                                inputGroup.querySelector(".quantity-input").value = 1;
                                updateSelectedServices();
                            }
                        });
                    });

                    document.querySelectorAll(".btn-increase").forEach(button => {
                        button.addEventListener("click", function () {
                            let input = this.previousElementSibling;
                            input.value = parseInt(input.value) + 1;
                            updateSelectedServices();
                        });
                    });

                    document.querySelectorAll(".btn-decrease").forEach(button => {
                        button.addEventListener("click", function () {
                            let input = this.nextElementSibling;
                            if (parseInt(input.value) > 1) {
                                input.value = parseInt(input.value) - 1;
                                updateSelectedServices();
                            }
                        });
                    });
                })
                .catch(error => {
                    console.error("Lỗi khi tải danh sách dịch vụ:", error);
                    equipmentList1.innerHTML = "<li class='list-group-item text-danger'>Lỗi tải danh sách dịch vụ</li>";
                });
        }

        function updateSelectedServices() {
            let selectedServicesContainer1 = document.getElementById("selectedServicesContainer1");
            selectedServicesContainer1.innerHTML = "";
            let totalEquipmentPrice1 = 0;

            document.querySelectorAll(".service-checkbox:checked").forEach(checkbox => {
                let equipmentId = checkbox.value;
                let quantityInput = document.querySelector(`.input-group[data-id="${equipmentId}"] .quantity-input`);
                let quantity = parseInt(quantityInput.value, 10);
                let price = parseInt(checkbox.getAttribute("data-price"), 10);

                totalEquipmentPrice1 += quantity * price;

                let hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "equipment_ids[]";
                hiddenInput.value = `${equipmentId}:${quantity}`;
                selectedServicesContainer1.appendChild(hiddenInput);
            });

            document.getElementById("totalEquipmentPrice1").textContent = new Intl.NumberFormat().format(totalEquipmentPrice1) + " đ";
        }

        const orderModalWhenFoundFootballPitch = document.getElementById("orderModalWhenFoundFootballPitch");
        if (orderModalWhenFoundFootballPitch) {
            orderModalWhenFoundFootballPitch.addEventListener("show.bs.modal", fetchEquipments);
        }
    });
</script>
