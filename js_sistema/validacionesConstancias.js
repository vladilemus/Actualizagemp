$(document).ready(function () {

    /// -----FUNCION ENCARGADA DE BUSCAR LAS ADCRIPCIONES

    const $input = $('#adsc');
    const $suggestions = $('#suggestions');
    let delayTimer;

    $input.on('keyup', function () {
        clearTimeout(delayTimer);
        const query = $(this).val().trim();

        if (query.length < 2) {
            $suggestions.empty();
            return;
        }

        delayTimer = setTimeout(function () {
            $.ajax({
                url: 'ajax_sistema/busquedaConstancia.php',
                type: 'GET',
                data: { q: query },
                dataType: 'json',
                success: function (data) {
                    $suggestions.empty();
                    if (data.length > 0) {
                        $.each(data, function (index, item) {
                            const option = $('<div>')
                                .text(item.text) // ✅ aquí usamos "text" (clave correcta)
                                .on('click', function () {
                                    $input.val(item.id); // ✅ coloca el valor correcto en el input
                                    $suggestions.empty();
                                });
                            $suggestions.append(option);
                        });
                    } else {
                        $suggestions.html('<div>No se encontraron resultados</div>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error en la búsqueda:', error);
                }
            });
        }, 300); // pequeña pausa para no saturar el servidor
    });

    //FUNCION ENCARGADA DE LA BUSUQEDA DE USUARIOS
    const $inputClsp = $('#clsp');
    const $suggestionsClsp = $('#suggestions-clsp');
    let delayTimerClsp;

    $inputClsp.on('keyup', function () {
        clearTimeout(delayTimerClsp);
        const query = $(this).val().trim();

        if (query.length < 2) {
            $suggestionsClsp.empty();
            return;
        }

        delayTimerClsp = setTimeout(function () {
            $.ajax({
                url: 'ajax_sistema/busquedaClsp.php', // <-- archivo PHP que haga la búsqueda por clave de SP
                type: 'GET',
                data: { q: query },
                dataType: 'json',
                success: function (data) {
                    $suggestionsClsp.empty();
                    if (data.length > 0) {
                        $.each(data, function (index, item) {
                            const option = $('<div>')
                                .text(item.text) // Ej: "12345 - NOMBRE DEL SP"
                                .on('click', function () {
                                    $inputClsp.val(item.id);
                                    $suggestionsClsp.empty();
                                });
                            $suggestionsClsp.append(option);
                        });
                    } else {
                        $suggestionsClsp.html('<div>No se encontraron resultados</div>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error en la búsqueda:', error);
                }
            });
        }, 300);
    });

    //funcion encargada de 
    $('#form_constancias').on('submit', function (e) {
        e.preventDefault();

        const periodo = $('#periodo').val().trim();
        const anio = $('#anio').val().trim();
        const adsc = $('#adsc').val().trim();
        const clsp = $('#clsp').val().trim();

        // Enviar por AJAX
        $.ajax({
            url: 'ajax_sistema/procesarConstancia.php', // PHP que procesará los datos
            type: 'POST',
            data: { periodo, anio, adsc, clsp },
            dataType: 'json',
            success: function(resp) {
                if (resp.status === 'ok') {
                    alert('Constancia generada correctamente!');
                    // Aquí puedes mostrar un enlace al PDF o resetear el formulario
                    // window.open(resp.url, '_blank');
                } else {
                    alert('Error: ' + resp.msg);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Ocurrió un error al procesar la constancia.');
            }
        });
    });

    // Ocultar sugerencias si se hace clic fuera
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#adsc, #suggestions').length) {
            $suggestions.empty();
        }
    });
});
