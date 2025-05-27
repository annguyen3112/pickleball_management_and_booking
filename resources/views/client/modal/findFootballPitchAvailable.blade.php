<!-- Modal -->
<div class="modal fade" id="findFootballPitchAvailableModal" tabindex="-1" aria-labelledby="findFootballPitchAvailableModal" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('order.findFootballPitchNotInOrderByDateTime') }}">
            @csrf
            <input type="hidden" name="start_at">
            <input type="hidden" name="end_at">
            <div class="modal-content">
                <div class="modal-header bg-success text-light">
                    <h5 class="modal-title">Tìm sân trống</h5>
                    <button type="button" class="btn-close text-light" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="inputDate" class="col-sm-4 col-form-label">
                            Chọn ngày <span class="text-danger">(*)</span>
                        </label>
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
                        <div>Kết quả</div>
                        <div class="mt-2 order-time">
                        </div>
                        <div class="alert alert-danger error error-hide"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success btn-find-football-pitch">Tìm kiếm</button>
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
    
        // function validateForm(event) {
        //     if (!datePicker.value || !startTimePicker.value || !endTimePicker.value) {
        //         alert("Vui lòng chọn ngày và giờ đặt sân.");
        //         event.preventDefault();
        //     }
        // }
        datePicker.addEventListener("change", updateMinTime);
        startTimePicker.addEventListener("change", updateEndTime);
        updateMinTime();
    });
</script>