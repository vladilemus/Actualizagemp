
//function correo() {
  //  window.location.href = "correo.php";
//}

function scrollToFooter() {
    document.getElementById("footer").scrollIntoView({ behavior: 'smooth' });
}


document.getElementById('formAuthentication').addEventListener('submit', function (event){
    event.preventDefault() // Evita el envío del formulario por defecto

    //capturamos el valor del input
    const clavesp = document.getElementById('clave-servidor').value;

    const formData = {
        ClavedeServidor: clavesp
    };
    //enviamos los datos usando el ajax
    $.ajax({
        url: "/captura_datos/ajax_sistema/buscarcsp.php",
        type: "post",
        dataType: "json",
        data: formData,
        success: function (res){
            if (res.status === 1){

            } else if (res.status === 2){

            }
        },
        error: function (xhr, status, error) {
            // Maneja los errores
            console.error('Error al enviar el formulario:', error);
            Swal.fire({
                position: 'top-center',
                title: 'Error de red',
                text: 'Error al enviar el formulario. Por favor, intenta de nuevo.',
                icon: 'error',
                showConfirmButton: true,
            });
        }
    })

});
/*
1.Sus datos ya estan actualizados
2.sus datos deben de ser actualizados
*/
