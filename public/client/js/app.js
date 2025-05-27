$(document).ready(function () {
    const DatePicker = $("#orderModal .datepicker");
    const TimePicker = $("#orderModal .timepicker");
    const DatePickerFindTimeModal = $("#findTimeModal .datepicker");
    const DatePickerFindFbModal = $(
        "#findFootballPitchAvailableModal .datepicker"
    );
    const TimePickerFindFbModal = $(
        "#findFootballPitchAvailableModal .timepicker"
    );
    const now = new Date();
    const date = now.toISOString().split("T")[0];
    if (DatePicker[0]) {
        DatePicker[0].value = date;
    }

    let hours = now.getHours();
    let minutes = now.getMinutes();

    if (minutes > 0) {
        hours += 1;
    }

    const formattedHour = hours.toString().padStart(2, "0");

    if (TimePicker[0]) {
        TimePicker[0].value = `${formattedHour}:00:00`;
        TimePicker[1].value = `${(hours + 1).toString().padStart(2, "0")}:00:00`;
    }

    //modal tim san theo thoi gian
    DatePickerFindFbModal[0].value = date;

    if (TimePickerFindFbModal[0]) {
        TimePickerFindFbModal[0].value = `${formattedHour}:00:00`;
        TimePickerFindFbModal[1].value = `${(hours + 1).toString().padStart(2, "0")}:00:00`;
    }

    //
    if (DatePickerFindTimeModal[0]) {
        DatePickerFindTimeModal[0].value = date;
    }
    //dat san theo thoi gian
    $(document).on("click", "#orderModal .btn-order", function () {
        const start = DatePicker[0].value + " " + TimePicker[0].value;
        const end = DatePicker[0].value + " " + TimePicker[1].value;
        const form = $(this).parents("form");
        const error = form.find(".alert-main");
        const modal = $("#orderModal");
        const er_name = form.find(".error-name");
        const er_phone = form.find(".error-phone");
        const er_email = form.find(".error-email");
        //console.log(error);
        $('#orderModal input[name="start_at"]')[0].value = start;
        $('#orderModal input[name="end_at"]')[0].value = end;
        console.log(form.serializeArray());

        $.ajax({
            type: "post",
            url: form.attr("action"),
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
                modal.modal("hide");
                error[0].classList.remove("error-show");
                $.toast({
                    heading: "Thành công",
                    text: response.message,
                    showHideTransition: "plain",
                    icon: response.status,
                    position: "bottom-right",
                });
                setTimeout(function () {
                    location.href = response.redirect;
                }, 3000);
            },
            error: function (response) {
                response = response.responseJSON;
                // console.log("Lỗi trả về từ server:", response.responseJSON);
                er_name[0].classList.add("error-hide");
                er_name[0].classList.remove("error-show");
                er_phone[0].classList.add("error-hide");
                er_phone[0].classList.remove("error-show");
                er_phone[0].classList.add("error-hide");
                er_email[0].classList.remove("error-show");
                if (response.errors) {
                    if (response.errors.name) {
                        er_name[0].classList.add("error-show");
                        er_name[0].textContent = response.errors.name;
                    }
                    if (response.errors.phone) {
                        er_phone[0].classList.add("error-show");
                        er_phone[0].textContent = response.errors.phone;
                    }
                    if (response.errors.email) {
                        er_email[0].classList.add("error-show");
                        er_email[0].textContent = response.errors.email;
                    }
                } else {
                    error[0].classList.add("error-show");
                    error[0].textContent = response.message;
                }
            },
        });
    });

    //check san trong hay khong
    $(document).on("click", ".btn-check-order", function () {
        const start = DatePicker[0].value + " " + TimePicker[0].value;
        const end = DatePicker[0].value + " " + TimePicker[1].value;
        const id = $('#orderModal input[name="football_pitch_id"]')[0].value;
        const error = $("#orderModal .alert-main");
        $.ajax({
            type: "get",
            url: $(this).data("url"),
            data: {
                football_pitch_id: id,
                start_at: start,
                end_at: end,
            },
            dataType: "json",
            success: function (response) {
                error[0].classList.add("error-show");
                error[0].classList.add("alert-success");
                error[0].classList.remove("alert-danger");
                error[0].innerHTML = response.message;
                if (response.total_price) {
                    error[0].innerHTML += `<br>Giá sân: ${response.total_price}`;
                }
            },
            error: function (response) {
                response = response.responseJSON;
                error[0].classList.add("error-show");
                error[0].classList.remove("alert-success");
                error[0].classList.add("alert-danger");
                error[0].textContent = response.message;
            },
        });
    });
    // tim thoi gian san da dc dat
    $(document).on("click", ".btn-find-time", function () {
        const form = $(this).closest("form");
        const error = form.find(".error");
        const el = form.find(".order-time");
        const dateRange = $("#dateRangePicker").val().split(" to ");

        let start_date = dateRange[0].trim();
        let end_date = dateRange[1] ? dateRange[1].trim() : start_date;
        //console.log(start_date, end_date);
        error.removeClass("error-show alert-success alert-danger").addClass("error-hide");

        $.ajax({
            type: "get",
            url: form.attr("action"),
            data: {
                football_pitch_id: form.find("input[name='football_pitch_id']").val(),
                start_date: start_date,
                end_date: end_date
            },
            dataType: "json",
            success: function (response) {
                el.html("");

                if (response.message) {
                    error.removeClass("error-hide alert-danger").addClass("error-show alert-success");
                    error.text(response.message);
                }

                if (response.data && response.data.length > 0) {
                    let content = `<div class="row">`;

                    response.data.forEach((booking) => {
                        // Định dạng lại ngày thành d-m-Y
                        let formattedDate = new Date(booking.date).toLocaleDateString("vi-VN");

                        content += `
                            <div class="col-md-6 mb-3">
                                <div class="card shadow-sm border-primary">
                                    <div class="card-body text-center">
                                        <h6 class="card-title text-primary"><i class="bi bi-calendar-event"></i> Ngày: ${formattedDate}</h6>
                                        <p class="mb-1"><strong><i class="bi bi-clock"></i> Bắt đầu:</strong> ${booking.start_at}</p>
                                        <p class="mb-0"><strong><i class="bi bi-clock-fill"></i> Kết thúc:</strong> ${booking.end_at}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    content += `</div>`;
                    el.append(content);
                } else {
                    el.html(`
                        <div class="alert alert-info text-center">
                            <i class="bi bi-info-circle"></i> Không có lịch đặt trong khoảng thời gian này
                        </div>
                    `);
                }
            },
            error: function (response) {
                response = response.responseJSON;
                error.removeClass("error-hide alert-success").addClass("error-show alert-danger");
                error.text(response.message);
            },
        });
    });

    //tim san trong voi thoi gian
    $(document).on(
        "click",
        "#findFootballPitchAvailableModal .btn-find-football-pitch",
        function () {
            const start =
                DatePickerFindFbModal[0].value +
                " " +
                TimePickerFindFbModal[0].value;
            const end =
                DatePickerFindFbModal[0].value +
                " " +
                TimePickerFindFbModal[1].value;
            $(
                '#findFootballPitchAvailableModal input[name="start_at"]'
            )[0].value = start;
            $(
                '#findFootballPitchAvailableModal input[name="end_at"]'
            )[0].value = end;
            const form = $(this).parents("form");
            const el = form.find(".order-time");
            const error = form.find(".error");
            error[0].classList.add("error-hide");
            error[0].classList.remove("error-show");
            $.ajax({
                type: "post",
                url: form.attr("action"),
                data: form.serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.data) {
                        el.html("");
                        let content = "";
                        for (i in response.data) {
                            content += `
                        <div class="mb-3 row align-items-center">
                            <div class="col-8 ml-2">
                                ${response.data[i].name}<span class="text-secondary"> | ${response.data[i].description} </span>
                                <div class="fw-bold">Giá: ${response.data[i].total_price}</div>
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-success show-modal-when-found" data-bs-toggle="modal"
                                data-bs-target="#orderModalWhenFoundFootballPitch" 
                                data-football_pitch_id="${response.data[i].football_pitch_id}" data-start_at="${response.data[i].start_at}" data-end_at="${response.data[i].end_at}" >
                                    Đặt ngay
                                </button>
                            </div>
                        </div>
                        `;
                        }
                        el.append(content);
                    }
                },
                error: function (response) {
                    el.html("");
                    response = response.responseJSON;
                    error[0].classList.add("error-show");
                    error[0].textContent = response.message;
                },
            });
        }
    );
    //cap nhat khi nhan dat ngay
    $(document).on("click", ".show-modal-when-found", function (e) {
        const modalForm = $('#orderModalWhenFoundFootballPitch form');
        modalForm.find('input[name="football_pitch_id"]').val($(this).data("football_pitch_id"));
        modalForm.find('input[name="start_at"]').val($(this).data("start_at"));
        modalForm.find('input[name="end_at"]').val($(this).data("end_at"));
    });
    //dat san khi nhan dat ngay o mo modal tim san trong theo thoi gian
    $(document).on("click", "#orderModalWhenFoundFootballPitch .btn-order", function () {
        const form = $(this).parents("form");
        const error = form.find(".alert-main");
        const modal = $("#orderModalWhenFoundFootballPitch");
        const er_name = form.find(".error-name");
        const er_phone = form.find(".error-phone");
        const er_email = form.find(".error-email");
        $.ajax({
            type: "post",
            url: form.attr("action"),
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
                modal.modal("hide");
                error[0].classList.remove("error-show");
                $.toast({
                    heading: "Thành công",
                    text: response.message,
                    showHideTransition: "plain",
                    icon: response.status,
                    position: "bottom-right",
                });
                setTimeout(function () {
                    location.href = response.redirect;
                }, 3000);
            },
            error: function (response) {
                response = response.responseJSON;
                er_name[0].classList.add("error-hide");
                er_name[0].classList.remove("error-show");
                er_phone[0].classList.add("error-hide");
                er_phone[0].classList.remove("error-show");
                er_phone[0].classList.add("error-hide");
                er_email[0].classList.remove("error-show");
                if (response.errors) {
                    if (response.errors.name) {
                        er_name[0].classList.add("error-show");
                        er_name[0].textContent = response.errors.name;
                    }
                    if (response.errors.phone) {
                        er_phone[0].classList.add("error-show");
                        er_phone[0].textContent = response.errors.phone;
                    }
                    if (response.errors.email) {
                        er_email[0].classList.add("error-show");
                        er_email[0].textContent = response.errors.email;
                    }
                } else {
                    error[0].classList.add("error-show");
                    error[0].textContent = response.message;
                }
            },
        });
    });
    $(document).on("click", ".confirm-btn", function (e) {
        const result = confirm("Bạn có chắc chắn không ?");
        if (!result) {
            e.preventDefault();
        }
    });
});
