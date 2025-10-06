
$(document).ready(function () {
    $('#txtnomusuario').val("");
    $('#txtpasswd').val("");
    $('#btningresa').click(function () {
        destruyedatos();
    });
    $('#btnRecupera').click(function () {
        capchacorreo();
    });
});
