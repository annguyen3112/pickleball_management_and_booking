<!-- Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('order.clientStore') }}">
            @csrf
            <input type="hidden" name="start_at">
            <input type="hidden" name="end_at">
            <input type="hidden" name="football_pitch_id" value="{{ $footballPitch->id }}">
            
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
                                <label for="inputDate" class="col-sm-4 col-form-label">Chọn ngày <span class="text-danger">(*)</span></label>
                                <div class="col-sm-8">
                                    <input type="date" id="datePicker" class="datepicker form-control" min="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputTime" class="col-sm-4 col-form-label">Chọn giờ bắt đầu - kết thúc <span class="text-danger">(*)</span></label>
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <input type="time" id="startTimePicker" class="timepicker form-control">
                                        </div>
                                        <div class="col">
                                            <input type="time" id="endTimePicker" class="timepicker form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Họ và tên <span class="text-danger">(*)</span></label>
                                <div class="col-sm-8">
                                    <input placeholder="Nhập họ và tên" required type="text" name="name"
                                        class="form-control"
                                        @if (Auth::check()) value="{{ auth()->user()->name }}" @endif>
                                    <div class="text-danger error-name alert-danger error error-hide"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Số điện thoại <span class="text-danger">(*)</span></label>
                                <div class="col-sm-8">
                                    <input placeholder="Nhập số điện thoại" required type="number" name="phone"
                                        class="form-control"
                                        @if (Auth::check()) value="{{ auth()->user()->phone }}" @endif>
                                    <div class="text-danger error-phone alert-danger error error-hide"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input placeholder="Nhập email" type="email" name="email" class="form-control"
                                        @if (Auth::check()) value="{{ auth()->user()->email }}" @endif>
                                </div>
                            </div>
                            <div class="row">
                                <div class="alert alert-danger alert-main error error-hide"></div>
                            </div>
                            <div class="row">
                                <div class="check">
                                    <button type="button" data-url="{{ route('order.check') }}"
                                        class="btn btn-info text-light btn-check-order">Kiểm tra sân</button>
                                    {{-- <button type="button" 
                                        class="btn btn-success text-light btn-select-service" data-bs-toggle="modal" data-bs-target="#selectServiceModal">
                                            Chọn dịch vụ đi kèm
                                        </button> --}}
                                </div>
                            </div>
                        </div>    

                        <div class="col-md-6">
                            <h5 class="text-center mb-3"><b>Chọn dịch vụ đi kèm</b></h5>
                            <ul class="list-group" id="equipmentList">

                            </ul>
                            <p class="text-center mt-3">
                                <strong>Tổng giá dịch vụ: </strong>
                                <span id="totalEquipmentPrice" class="fw-bold text-success">0 đ</span>
                            </p>
                            <div id="selectedServicesContainer"></div>
                        </div>
                    </div> <!-- End row -->
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
        const datePicker = document.getElementById("datePicker");
        const startTimePicker = document.getElementById("startTimePicker");
        const endTimePicker = document.getElementById("endTimePicker");
        const selectedServicesInput = document.getElementById("selectedServices");
        const equipmentList = document.getElementById("equipmentList");
        const btnOrder = document.querySelector(".btn-order");
    
        if (!datePicker || !startTimePicker || !endTimePicker) return;
    
        function updateMinTime() {
            const today = new Date();
            const selectedDate = new Date(datePicker.value);
            const currentHours = today.getHours().toString().padStart(2, '0');
            const currentMinutes = today.getMinutes().toString().padStart(2, '0');
            const currentTime = `${currentHours}:${currentMinutes}`;
    
            if (selectedDate.toDateString() === today.toDateString()) {
                startTimePicker.min = currentTime;
            } else {
                startTimePicker.min = "00:00";
            }
    
            if (startTimePicker.value < startTimePicker.min) {
                startTimePicker.value = startTimePicker.min;
            }
        }
    
        function updateEndTime() {
            endTimePicker.min = startTimePicker.value;
        }
    
        function validateForm(event) {
            if (!datePicker.value || !startTimePicker.value || !endTimePicker.value) {
                alert("Vui lòng chọn ngày và giờ đặt sân.");
                event.preventDefault();
            }
            updateSelectedServices();
        }
    
        function fetchEquipments() {
            fetch("{{ route('equipment.fetchEquipment') }}")
                .then(response => response.json())
                .then(data => {
                    if (!data || !data.data || data.data.length === 0) {
                        equipmentList.innerHTML = "<li class='list-group-item text-danger'>Không có dịch vụ nào khả dụng</li>";
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

                    equipmentList.innerHTML = html;

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
                    equipmentList.innerHTML = "<li class='list-group-item text-danger'>Lỗi tải danh sách dịch vụ</li>";
                });
        }

        function updateSelectedServices() {
            let selectedServicesContainer = document.getElementById("selectedServicesContainer");
            selectedServicesContainer.innerHTML = "";
            let totalEquipmentPrice = 0;

            document.querySelectorAll(".service-checkbox:checked").forEach(checkbox => {
                let equipmentId = checkbox.value;
                let quantityInput = document.querySelector(`.input-group[data-id="${equipmentId}"] .quantity-input`);
                let quantity = parseInt(quantityInput.value, 10);
                let price = parseInt(checkbox.getAttribute("data-price"), 10);

                totalEquipmentPrice += quantity * price;

                let hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "equipment_ids[]";
                hiddenInput.value = `${equipmentId}:${quantity}`;
                selectedServicesContainer.appendChild(hiddenInput);
            });

            document.getElementById("totalEquipmentPrice").textContent = new Intl.NumberFormat().format(totalEquipmentPrice) + " đ";
        }

        const orderModal = document.getElementById("orderModal");
        if (orderModal) {
            orderModal.addEventListener("show.bs.modal", fetchEquipments);
        }
    
        datePicker.addEventListener("change", updateMinTime);
        startTimePicker.addEventListener("change", updateEndTime);
        btnOrder.addEventListener("click", validateForm);
    
        updateMinTime();
    });
    </script>
    


