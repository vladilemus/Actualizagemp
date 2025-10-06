<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leer Excel en PHP</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');

        :root {
            --color-primario: #1A1A1A;  /* Negro */
            --color-secundario: #541F2D; /* Vino */
            --color-terciario: #A08459;  /* Café dorado */
            --color-cuaternario: #CCB694; /* Beige */

            --fondo-claro: #f4f4f4;
            --fondo-container: white;
            --fondo-tabla-header: var(--color-secundario);

            --color-texto: var(--color-primario);
            --color-texto-secundario: #777;

            --fuente-principal: "Poppins", serif;
        }

        body {
            background-color: var(--fondo-claro);
            font-family: "Poppins", serif;
            text-align: center;
            padding: 20px;
        }

        .txt-title {
            font-size: 2rem;
            color: var(--color-primario);
            font-weight: 700;
            margin: 0;
        }

        .txt-t {
            font-size: 1.1rem;
            margin-bottom: 50px;
        }

        .container {
            background: var(--fondo-container);
            padding: 60px;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            margin: auto;
            max-width: 600px;
        }

        input[type="file"] {
            display: block;
            margin: 10px auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn {
            background: var(--color-secundario);
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 1.1rem;
            transition: background 0.3s;
            margin-top: 50px;
        }

        .btn:hover {
            background: var(--color-cuaternario);
            color: var(--color-primario);
        }

        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container">
    <h2 class="txt-title">EXPORTAR EXCEL</h2>
    <p class="txt-t">Solo archivos xlsx</p>
    <input type="file" id="fileInput" class="btn-show" accept=".xlsx">
    <button class="btn" id="uploadBtn">Subir y Leer</button>
</div>

<script>
    $(document).ready(function() {
        $("#uploadBtn").click(function(event) {
            event.preventDefault();
            var fileInput = $("#fileInput")[0];
            var file = fileInput.files[0];

            if (!file) {
                Swal.fire({
                    icon: 'warning',
                    title: '⚠️ Archivo no seleccionado',
                    text: 'Por favor, selecciona un archivo .xlsx antes de continuar.'
                });
                return;
            }

            // Validar la extensión del archivo
            var fileName = file.name;
            var fileExtension = fileName.split('.').pop().toLowerCase();
            if (fileExtension !== "xlsx") {
                Swal.fire({
                    icon: 'error',
                    title: '❌ Formato incorrecto',
                    text: 'El archivo debe estar en formato .xlsx.',
                });
                return;
            }

            var formData = new FormData();
            formData.append("file", file);

            $("#uploadBtn").prop("disabled", true).text("Procesando...");

            $.ajax({
                url: "carga_excel.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    $("#uploadBtn").prop("disabled", false).text("Subir y Leer");

                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: '✅ Archivo leído correctamente',
                            text: response.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '❌ Error al procesar el archivo',
                            text: response.message
                        });
                    }

                    $("#fileInput").val("");
                },
                error: function(xhr, status, error) {
                    console.error("Error AJAX:", error);
                    $("#uploadBtn").prop("disabled", false).text("Subir y Leer");

                    Swal.fire({
                        icon: 'error',
                        title: '❌ Error en la carga',
                        text: 'Ocurrió un error al subir el archivo. Inténtalo nuevamente.'
                    });
                }
            });
        });
    });
</script>

</body>
</html>
