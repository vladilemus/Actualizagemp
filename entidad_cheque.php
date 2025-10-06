<?php
//obtenemso la fecha actual
$fechaActual = date("Y-m-d");
?>
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

        .section:first-child {
            width: 50%;
        }

        .section:last-child {
            width: 45%;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .btn {
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
            width: 100%;
            box-sizing: border-box;
        }

        .btn:hover {
            background-color: #45a049;
            color: #ffffff;
        }

        .section label {
            font-size: 16px;
            font-weight: bold;
            color: black;
            display: block;
            margin-bottom: 5px;
        }

        hr {
            border: 1px solid black;
            width: 100%;
        }

        input[type="text"] {
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 15px;
            font-size: 16px;
            width: 100%;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .col-12, .col-8, .col-6, .col-5, .col-4, .col-3, .col-2 {
            padding: 10px;
            box-sizing: border-box;
        }

        .col-12 {
            width: 100%;
        }

        .col-8 {
            width: 66.66%;
        }

        .col-6 {
            width: 50%;
        }

        .col-5 {
            width: 41.66%;
        }

        .col-4 {
            width: 33.33%;
        }

        .col-3 {
            width: 25%;
        }

        .col-2 {
            width: 16.66%;
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group input {
            flex: 1;
        }

    </style>
    <link href="assets/sweet/sweetalert2.css" rel="stylesheet" type="text/css"/>
    <script src="js_sistema/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
</head>

<body>

    <div class="container">
        <div class="section" style="text-align: center;">

            <form action="post" id="form_cheq">
                <div class="row">

                    <div class="col-4">
                        <label for="">INTRODUSCA LA CLAVE DE SERVIDOR PUBLICO:</label>
                    </div>

                    <div class="col-4">
                        <input type="text" name="file" id="clave_sp" maxlength="9" pattern="\d{1,9}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);" required>
                    </div>

                    <div class="col-4">
                        <button class="btn" id="btn-enviar">BUSCAR</button>
                    </div>
                    <hr>

                    <!-- FORMULARIO QUE SE AUTO LLENARA -->
                    <div class="col-8">
                        <label for="">NOMBRE DEL SERVIDOR PUBLICO</label>
                        <input type="text" id="nombre" readonly>
                    </div>

                    <div class="col-4">
                        <label for="">CLAVE DEL SERVIDOR PUBLICO</label>
                        <input type="text" id="clave_spII" readonly>
                    </div>
                    
                    <div class="col-6">
                        <label for="">RFC</label>
                        <input type="text" id="rfc" readonly>
                    </div>

                    <div class="col-6">
                        <label for="">CURP</label>
                        <input type="text" id="curp" readonly>
                    </div>
                    
                    <div class="col-4">
                        <label for="">FECHA DE ENTREGA</label>
                        <input type="text" id="fentrega" value="<?php echo date('Y-m-d'); ?>" readonly>
                    </div>

                    <div class="col-4">
                        <label for="">CODIGO ADSCRIOPCION</label>
                        <input type="text" id="ads" readonly>
                    </div>

                    <div class="col-4">
                        <label for="">CENTRO DE TRABAJO</label>
                        <input type="text" id="centro" readonly>
                    </div>

                    <div class="col-6">
                        <label for="">NUMERO DEL CHEQUE</label>
                        <input type="hidden" id="numcheque" readonly>
                    </div>

                    <div class="col-6">
                        <label for="">IMPORTE DEL CHEQUE</label>
                        <input type="hidden" id="importe" readonly>
                    </div>

                    <!-- Contenedor dinámico movido aquí -->
                    <div id="cheques-dinamicos-container" class="col-12"></div>

                    <div class="col-3">
                        <label for="">CANTIDAD DE CHEQUES</label>
                        <input type="text" id="cant" readonly>
                    </div>

                    <div class="col-3">
                        <label for="">ESTATUS DEL ACTUALIZA GEM</label>
                        <input type="text" id="actualizagem" readonly>
                    </div>
                    
                    <div class="col-3">
                        <label for="">ESTATUS CHEQUE</label>
                        <select name="" id="" style="padding: 10px; background-color: #f2f2f2; border: 1px solid #ccc; border-radius: 15px; font-size: 16px; width: 100%; box-sizing: border-box;">
                            <option value="">--SELECCIONA UNA OPCION--</option>
                            <option value="true">ENTREGADO</option>
                            <option value="false">CANCELADO</option>
                        </select>
                    </div>

                    <div class="col-3">
                        <button class="btn" id="btn-enviarII">CONFIRMAR ENTREGA</button>
                    </div>

                </div>
            </form>

        </div>
    </div>

</body>

<script src="assets/sweet/sweetalert2.js" type="text/javascript"></script>
<script src="assets/vendor/libs/jquery/jquery.js"></script>
<script src="js_sistema/validacionescheques.js"></script>
</html>
