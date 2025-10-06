$(document).ready(function () {
    $("#btn_recupera").click(function () {
        if ($('#txtnomusuario').val().length > 0 && $('#txtemail').val().length > 0 && $('#txtpregunta').val().length > 0) {
            capchacorreo($("#txtemail").val());
        } else {

        }
    });
});