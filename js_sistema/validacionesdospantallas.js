// Seleccionar el formulario y agregar un evento al submit
document.getElementById('form_dosp').addEventListener('submit', function(event) {
    event.preventDefault();

    // Capturar los valores de los campos del formulario
    const clave_sp = document.getElementById('clave_sp').value;
    const rfc = document.getElementById('rfc').value;
    const nombre = document.getElementById('nombre').value;
    const cp = document.getElementById('cp').value;
    const opciones = document.getElementById('opciones').value;
    const comentarios = document.getElementById('comentarios').value;
    const email = document.getElementById('email').value;
    const curp = document.getElementById('curp').value;

    // Crear el objeto formData
    const formData = {
        claveSp: clave_sp,
        rfc: rfc,
        nombre: nombre,
        cp: cp,
        opciones: opciones,
        comentarios: comentarios,
        email: email,
        curp: curp
    };

    // Envía los datos usando AJAX
    $.ajax({
        url: "ajax_sistema/dospantallas_ajax.php",
        type: "post",
        dataType: "json",
        data: formData,
        success: function (res) {
            if (res.status === 1) {
                Swal.fire({
                    position: 'top-center',
                    title: 'Datos correctos',
                    text: 'Se mandará un correo electrónico al servidor para indicar su estatus.',
                    icon: 'success',
                    showConfirmButton: true,
                }).then((result) => {
                    if (result.isConfirmed){
                        window.location.href = 'https://actualizagem.edomex.gob.mx/admcaptura/index.php?mod=12';
                    }
                });

            } else if (res.status === 2) {
                Swal.fire({
                    position: 'top-center',
                    title: 'Datos incorrectos',
                    text: 'El servidor indica que los datos proporcionados son incorrectos.',
                    icon: 'error',
                    showConfirmButton: true,
                });

            } else if (res.status === 3) {
                Swal.fire({
                    position: 'top-center',
                    title: 'Error en la consulta',
                    text: 'Ocurrió un error general en la consulta. Inténtelo de nuevo.',
                    icon: 'error',
                    showConfirmButton: true,
                });

            } else if (res.status === 4) {
                Swal.fire({
                    position: 'top-center',
                    title: 'Error al mandar el correo',
                    text: 'Ocurrió un error al enviar el correo. Comuníquese con soporte.',
                    icon: 'error',
                    showConfirmButton: true,
                });
            } 
        },
        error: function (xhr, status, error) {
            // Maneja los errores
            console.error('Error en la petición:', error);
            Swal.fire({
                position: 'top-center',
                title: 'Datos correctos',
                text: 'Se mandará un correo electrónico al servidor para indicar su estatus.',
                icon: 'success',
                showConfirmButton: true,
            }).then((result) => {
                if (result.isConfirmed){
                    window.location.href = 'https://actualizagem.edomex.gob.mx/admcaptura/index.php?mod=12';
                }
            });
        }
    });
});
