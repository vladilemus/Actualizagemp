document.getElementById('form_cheq').addEventListener('submit', function(event) {
    event.preventDefault();

    // Capturar los valores de los campos del formulario
    const clave_sp = document.getElementById('clave_sp').value;
    const button = document.getElementById('btn-enviar');

    if (clave_sp.length !== 9) {
        Swal.fire({
            position: 'top-center',
            title: 'ERROR',
            text: 'La clave del servidor público debe tener 9 dígitos.',
            icon: 'error',
            showConfirmButton: true,
        });
        return;  // Detener la ejecución si el campo no está lleno
    }

    // Crear array para los datos
    const formData = {
        ClaveSp: clave_sp
    };

    // Enviar los datos usando AJAX
    $.ajax({
        url: "ajax_sistema/busqueda_cheq.php",
        type: "post",
        dataType: "json",
        data: formData,
        success: function(res) {
            if (res.status === 1) {
                // Clave no válida o sin datos
                Swal.fire({
                    position: 'top-center',
                    title: 'CLAVE DEL SERVIDOR PUBLICO INVÁLIDA',
                    text: 'No se encontraron datos relacionados con esta clave de Servidor público.',
                    icon: 'error',
                    showConfirmButton: true,
                });
            } else if (res.status === 3){
                Swal.fire({
                    position: 'top-center',
                    title: 'NO SE ENCONTRARON CHEQUES',
                    text: 'Este servidor publico no resivira cheque.',
                    icon: 'error',
                    showConfirmButton: true,
                });
            }else if (res.status === 4){
                Swal.fire({
                    position: 'top-center',
                    title: 'Cheque entregado',
                    text: 'El Cheque ya fue entregado.',
                    icon: 'error',
                    showConfirmButton: true,
                });
            }else if (res.status === 5){
                Swal.fire({
                    position: 'top-center',
                    title: 'CHEQUE CANSELADO',
                    text: 'Este cheque fue canselado por que ya paso la fecha limite.',
                    icon: 'error',
                    showConfirmButton: true,
                });
            }else {
                // Si hay datos, verificar el contenido de los arrays
                const unidadData = res.unidad;
                const chequeData = res.cheque;  // Array de cheques
                const erroneoData = res.erroneo[0];

                // Rellenar los datos del servidor público
                document.getElementById('nombre').value = erroneoData.nombre;
                document.getElementById('clave_spII').value = erroneoData.clave_sp;
                document.getElementById('rfc').value = erroneoData.rfc;
                document.getElementById('curp').value = erroneoData.curp;
                // Verificar si erroneoData.estatus es null, undefined o vacío
                document.getElementById('actualizagem').value = erroneoData.estatus ? erroneoData.estatus : 'DESACTUALIZADO';
                document.getElementById('cant').value = chequeData.length;
                document.getElementById('centro').value = unidadData[0].ley_ads.trim();
                document.getElementById('ads').value = erroneoData.ley_adscripcion;

                //CREAMOS UN CONTENEDOR Y LO LIMPIAMOS
                const container = document.getElementById('cheques-dinamicos-container');
                container.innerHTML = '';  // Limpiamos el contenedor para nuevos cheques

                chequeData.forEach(function(cheque, index) {
                    const chequeDiv = document.createElement('div');
                    chequeDiv.classList.add('row', 'mt-2');  // Añadimos diseño de fila y margen superior

                    // Creamos los input para el cheque actual
                    chequeDiv.innerHTML = `
                        <div class="col-6">
                            <label for="">NUMERO DEL CHEQUE ${index + 1}</label>
                            <input type="text" id="numcheque_${index}" value="${cheque.numero_cheque}" readonly>
                        </div>
                        <div class="col-6">
                            <label for="">IMPORTE DEL CHEQUE ${index + 1}</label>
                            <input type="text" id="importe_${index}" value="${cheque.importe}" readonly>
                        </div>
                    `;

                    // Añadir los nuevos inputs al contenedor dinámico
                    container.appendChild(chequeDiv);
                });
            }
        },
        error: function(err) {
            console.log("Error en la consulta AJAX:", err);
        }
    });
});

document.getElementById('btn-enviarII').addEventListener('click', function(event){
    event.preventDefault();

    const nombre = document.getElementById('nombre').value;
    const clave_spII = document.getElementById('clave_spII').value;

    if(nombre === '' || clave_spII === ''){
        Swal.fire({
            position: 'top-center',
            title: 'ERROR',
            text: 'El formulario debe estar completo antes de confirmar la entrega.',
            icon: 'error',
            showConfirmButton: true,
        });
        return;
    }

    const estatusCheque = document.querySelector('select').value;

    const formData = {
        estatusCheque: estatusCheque,
        clave_sp: clave_spII
    };

    $.ajax({
        url: "ajax_sistema/actualizar_cheque.php",
        type: "post",
        dataType: "json",
        data: formData,
        success: function(res) {
            if (res.status === 1) {
                Swal.fire({
                    position: 'top-center',
                    title: 'REGISTRO DE ENTREGA EXITOSA',
                    text: 'Se registró la entrega del cheque exitosamente.',
                    icon: 'success',
                    showConfirmButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();  // Recarga la página
                    }
                });
            } else if (res.status === 2) {
                Swal.fire({
                    position: 'top-center',
                    title: 'CANCELACIÓN EXITOSA',
                    text: 'Se registró la cancelación del cheque exitosamente.',
                    icon: 'success',
                    showConfirmButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();  // Recarga la página
                    }
                });
            }else if (res.status === 3) {
                Swal.fire({
                    position: 'top-center',
                    title: 'OPCION INVALIDA',
                    text: 'Favor de seleccionar una opcion valida.',
                    icon: 'error',
                    showConfirmButton: true,
                });
            }
        },
        error: function (xhr, status, error) {
            // Maneja los errores
            console.error('Error en peticion:', error);
            Swal.fire({
                position: 'top-center',
                title: 'ERROR EN LA CONSULTA',
                text: 'Se produjo un error en la cosnulta favor de comunicarse con el Admin.',
                icon: 'error',
                showConfirmButton: true,
            });
        }
    });
});