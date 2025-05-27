// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher("495ad64c5c478e2cb324", {
    cluster: "ap1",
});

var channel = pusher.subscribe("quanlysanbong-channel-client");
channel.bind("store-order", function (data) {
    DATATABLE_ORDER_UNPAID.DataTable().ajax.reload();
    DATATABLE_ORDER.DataTable().ajax.reload();
    $.toast({
        heading: "Thông báo",
        text: "Đã có yêu cầu đặt sân mới - Mã đặt sân: " + data.order.code,
        showHideTransition: "plain",
        icon: "info",
        position: "top-right",
        stack: 4,
        hideAfter: false,
    });
});

var channelCancel = pusher.subscribe("quanlysanbong-channel-client-cancel");
channelCancel.bind("store-order-cancel", function (data) {
    DATATABLE_ORDER_UNPAID.DataTable().ajax.reload();
    DATATABLE_ORDER.DataTable().ajax.reload();
    $.toast({
        heading: "Thông báo",
        text: "Đơn đặt sân đã bị hủy - Mã đặt sân: " + data.order.code,
        showHideTransition: "plain",
        icon: "error",
        position: "top-right",
        stack: 4,
        hideAfter: false,
    });
});

var channelPayment = pusher.subscribe("quanlysanbong-channel-client-payment");
channelPayment.bind("confirm-payment", function (data) {
    DATATABLE_ORDER_UNPAID.DataTable().ajax.reload();
    DATATABLE_ORDER.DataTable().ajax.reload();
    $.toast({
        heading: "Thông báo",
        text: "Khách hàng đã xác nhận thanh toán - Mã đặt sân: " + data.order.code + ". Vui lòng kiểm tra và xác nhận thanh toán.",
        showHideTransition: "slide",
        icon: "success",
        position: "top-right",
        stack: 4,
        hideAfter: false,
    });
});

