
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #e0e0e0;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            padding: 5%;
        }

        .section {
            flex: 1;
            padding: 20px;
            margin: 10px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Ajuste de ancho para secciones */
        .section:first-child {
            width: 50%;
        }

        .section:last-child {
            width: 45%;
            text-align: center; /* Centrar contenido del segundo section */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        /* Botones */
        .btn, .btnn {
            background-color: #4CAF50;
            color: black;
            border: none;
            padding: 10px 20px;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        .btn:hover, .btnn:hover {
            background-color: #45a049;
            color: #ffffff;
        }

        .section label {
            font-size: 18px;
            font-weight: bold;
            color: black;
        }

        hr {
            border: 1px solid black;
            width: 100%;
        }

        /* Input file */
        input[type="file"] {
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            width: 100%;
            margin-bottom: 15px;
        }

    </style>
    <link href="assets/sweet/sweetalert2.css" rel="stylesheet" type="text/css"/>
    <script src="js_sistema/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
</head>

<body>
    <div class="container">
        <div class="section" style="text-align: center;">
            <div>
                <!-- Botón para generar el txt de pendientes -->
                <label>DESCARGA DE PETICIONES PENDIENTES</label><br><br>
                <button onclick="window.open('descargar_txt_Pendientes.php', '_blank');" class="btn">Generar archivo TXT de Pendientes</button><br><br>

                <!-- Línea horizontal negra -->
                <hr>

                <!-- Botón para generar el txt de realizadas -->
                <label>DESCARGA DE PETICIONES REALIZADAS</label><br><br>
                <button onclick="window.open('descargar_txt_Realizadas.php', '_blank');" class="btn">Generar archivo TXT de Realizadas</button>
            </div>
        </div>

        <div class="section">
            <div>
                <!-- carga del archivo del sat -->
                <br action="carga_archivo.php" method="post" enctype="multipart/form-data">
                    <label for="file">Sube el archivo_sat.txt</label>
                    <br></br>
                    <input type="file" name="file" id="file">
                    <input type="submit" class="btnn" value="Subir Archivo">
                </form>
            </div>
        </div>
    </div>
</body>
<script src="assets/sweet/sweetalert2.js" type="text/javascript"></script>
<script src="assets/vendor/libs/jquery/jquery.js"></script>

</html>
<script>
    $(document).ready(function() {
        $('form').submit(function(event) {
        event.preventDefault(); // Evita el envío del formulario
        var formData = new FormData(this);
        $.ajax({
            url: "carga_archivo.php",
            type: "post",
            dataType: "json",
            data: formData,
            processData: false,  // Evita que jQuery procese los datos
            contentType: false,  // Evita que jQuery establezca el Content-Type
            success: function (res) {
                if (typeof res === 'string') {
                    res = JSON.parse(res); // Si es un string, parsearlo
                }
                if (res.status === 1) {
                    Swal.fire({
                        position: 'top-center',
                        title: 'Exito',
                        text: 'Se actualizo correctamente.',
                        icon: 'success',
                        showConfirmButton: true,
                    });
                    
                } else if (res.status === 2) {
                    // Maneja el error de registro
                    Swal.fire({
                        position: 'top-center',
                        title: 'Error',
                        text: 'Se se produjo un error.',
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
                    title: 'Error de red',
                    text: 'Error al validar. Por favor, intenta de nuevo.',
                    icon: 'error',
                    showConfirmButton: true,
                });
            }
        });
    })
})
</script>