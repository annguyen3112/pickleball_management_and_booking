const BASE_URL = location.origin;
const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
const BASE_URL_API = {
    getAllOrder: BASE_URL + '/api/order_all',
    getFootballPitch: BASE_URL + '/api/footballPitch',
    getEquipment: BASE_URL + '/api/equipment',
    getOrder: BASE_URL + '/api/order',
    postOrder: BASE_URL + '/api/order',
    showOrder: BASE_URL + "/api/order/",//id
    showEquipment: BASE_URL + "/api/equipment/",//id
    deleteOrder: BASE_URL + "/api/order/",//id
    updateOrder: BASE_URL + "/api/order/",//id
    maintainFootballPitch: BASE_URL + '/api/footballPitchMaintenance/',//id
    deleteFootballPitch: BASE_URL + '/api/footballPitch/',//id
    deleteEquipment: BASE_URL + '/api/equipment/',//id
    getBankInformation: BASE_URL + '/api/bank_information',
    showBankInformation: BASE_URL + '/api/bank_information/',//id
    putBankInformation: BASE_URL + '/api/bank_information/',//id
    deleteBankInformation: BASE_URL + '/api/bank_information/',//id
    changeDisplayBankInformation: BASE_URL + '/api/bank_information_change_display/',//id
};

function getPitchType(url) {
    $.ajax({
        type: "get",
        url: url,
        success: function (response) {
            $('#update-pitch-type-modal input[name=quantity]').val(response.quantity);
            $('#update-pitch-type-modal textarea[name=description]').html(response.description);
        }
    });
}

function getEquipment(url) {
    $.ajax({
        type: "get",
        url: url,
        success: function (response) {
            const equipment = response.data ? response.data : response;

            $('#update-equipment-modal textarea[name=name]').html(equipment.name);
            $('#update-equipment-modal input[name=price]').val(equipment.price);
            $('#update-equipment-modal textarea[name=description]').html(equipment.description);
        }
    });
}


