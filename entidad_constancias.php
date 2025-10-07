<?php

include_once("configuracion_sistema/configuracion.php");
include_once 'librerias/PDOConsultas.php';

$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de descar Constancias</title>
    <style>
        body {
            background-color: #e0e0e0;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .header-section {
            width: 100%;
            height: 40px;
            background-color: transparent;
            color: #000;
            padding: 10px 0;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            padding: 20px;
        }

        .section {
            flex: 1;
            padding: 10px;
            /* Reduces padding */
            margin: 10px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 20px;
            /* Bordes redondeados */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Removed justify-content: center */
        }


        /* Ajuste de ancho para secciones */
        .section:first-child {
            width: 50%;
            /* Ancho de la primera sección (PDF) */
        }

        .section:last-child {
            width: 45%;
            /* Ancho de la segunda sección (Formulario) */
        }

        .form-box {
            background: #E6E6E6;
            border-radius: 12px;
            padding: 30px;
            width: 100%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .form-box input,
        .form-box select,
        .form-box textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #D9D9D9;
            border-radius: 12px;
            font-size: 16px;
            color: #000000;
            background-color: white;
            font-weight: bold;
            box-sizing: border-box;
        }

        .form-box textarea {
            resize: none;
        }

        .form-box label {
            font-size: 14px;
            font-weight: 600;
            color: #434343;
            margin-bottom: 5px;
            display: block;
        }

        .btn {
            background-color: #4CAF50;
            color: black;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            background-color: #45a049;
        }

        .red-text {
            color: red;
        }

        .suggestions-box {
            position: absolute;
            background: #fff;
            border: 1px solid #ccc;
            width: 100%;
            max-height: 180px;
            overflow-y: auto;
            border-radius: 8px;
            z-index: 9999;
        }

        .suggestions-box div {
            padding: 8px;
            cursor: pointer;
        }

        .suggestions-box div:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <div class="header-section">

    </div>

    <div class="container">
        <div class="section">
            <h2>CONSTANCIAS DE SITUACION FISCAL</h2>
            <div class="form-box">
                <form id="form_constancias">
                    <div class="row">
                        <div class="col-3">
                            <Label>Peridodo</Label>
                            <select name="periodo" id="periodo">
                                <option value="">--SELECCIONE UNA OPCIÓN--</option>
                                <option value="01">01 - 1ª Quincena de Enero</option>
                                <option value="02">02 - 2ª Quincena de Enero</option>
                                <option value="03">03 - 1ª Quincena de Febrero</option>
                                <option value="04">04 - 2ª Quincena de Febrero</option>
                                <option value="05">05 - 1ª Quincena de Marzo</option>
                                <option value="06">06 - 2ª Quincena de Marzo</option>
                                <option value="07">07 - 1ª Quincena de Abril</option>
                                <option value="08">08 - 2ª Quincena de Abril</option>
                                <option value="09">09 - 1ª Quincena de Mayo</option>
                                <option value="10">10 - 2ª Quincena de Mayo</option>
                                <option value="11">11 - 1ª Quincena de Junio</option>
                                <option value="12">12 - 2ª Quincena de Junio</option>
                                <option value="13">13 - 1ª Quincena de Julio</option>
                                <option value="14">14 - 2ª Quincena de Julio</option>
                                <option value="15">15 - 1ª Quincena de Agosto</option>
                                <option value="16">16 - 2ª Quincena de Agosto</option>
                                <option value="17">17 - 1ª Quincena de Septiembre</option>
                                <option value="18">18 - 2ª Quincena de Septiembre</option>
                                <option value="19">19 - 1ª Quincena de Octubre</option>
                                <option value="20">20 - 2ª Quincena de Octubre</option>
                                <option value="21">21 - 1ª Quincena de Noviembre</option>
                                <option value="22">22 - 2ª Quincena de Noviembre</option>
                                <option value="23">23 - 1ª Quincena de Diciembre</option>
                                <option value="24">24 - 2ª Quincena de Diciembre</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="">Año</label>
                            <input type="text" name="anio" id="anio" placeholder="colocar el año del perido">
                        </div>
                        <div class="col-3" style="position: relative;">
                            <label for="">Secretaría</label>
                            <input type="text" name="adsc" id="adsc" placeholder="colocar el nombre o código de la dependencia" autocomplete="off">
                            <div id="suggestions" class="suggestions-box"></div>
                        </div>

                        <div class="col-3" style="position: relative;">
                            <label for="">Servidor Público</label>
                            <input type="text" name="clsp" id="clsp" placeholder="colocar la clave del servidor público" autocomplete="off">
                            <div id="suggestions-clsp" class="suggestions-box"></div>
                        </div>

                        <button class="btn" id="btn_enviar">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<script src="js_sistema/validacionesConstancias.js"></script>