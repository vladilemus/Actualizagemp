<?php

include_once("configuracion_sistema/configuracion.php");
include_once 'librerias/PDOConsultas.php';

$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

//cve de peticion
$cve_encoded = $_GET['cve']; // Obtener el valor codificado de 'cve'
$cve = base64_decode($cve_encoded); // Decodificar el valor de 'cve'

//consulta
$consulta->where("cve_peticion", $cve);
$datosp = $consulta->select("det_peticiones");


//variables sp
$cve_sp = $datosp[0]['clave_sp'];
$rfc = $datosp[0]['rfc'];
$nombre =$datosp[0]['nombre'];
$codigopos = $datosp[0]['codigo_post'];
$rut = $datosp[0]['nombre_encriptado'];
$curp = $datosp[0]['curp'];

//ruta 
$ruta = 'https://actualizagem.edomex.gob.mx/descargar-constancia/'.$rut;

$consulta->columns = array('email');
$consulta->where("clave_sp", $cve_sp);
$datossp = $consulta->select("dt_sp_erroneos");

//variable remitente
$email = $datossp[0]['email'];



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dos Secciones Horizontales con Separador</title>
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
    padding: 10px; /* Reduces padding */
    margin: 10px;
    background-color: #ffffff;
    border: 1px solid #ccc;
    border-radius: 20px; /* Bordes redondeados */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center; /* Removed justify-content: center */
}


        /* Ajuste de ancho para secciones */
        .section:first-child {
            width: 50%; /* Ancho de la primera sección (PDF) */
        }

        .section:last-child {
            width: 45%; /* Ancho de la segunda sección (Formulario) */
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
    </style>
</head>

<body>

    <div class="header-section">

    </div>

    <div class="container">
        <div class="section">
            <h4>CONSTANCIA DE SITUACION FISCAL DEL SERVIDOR PUBLICO:<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?> CON CLAVE <?php echo htmlspecialchars($cve_sp, ENT_QUOTES, 'UTF-8'); ?></h4>
            <iframe src= "<?php echo $ruta;?>" width="100%" height="600px" style="border-radius: 15px;">
                Este navegador no soporta la visualización de PDF. Por favor, descarga el PDF para verlo:
                <a href= "<?php echo $ruta;?>">Descargar PDF</a>.
                <?php
                print_r($ruta);
                ?>
            </iframe>
        </div>

        <div class="section">
            <h2>INFORMACION PROPORCIONADA POR EL SERVIDOR PUBLICO</h2>

            <div class="form-box">
                <h1>Comparación de datos</h1>
                <form id="form_dosp">
                    <div class="row">
                        <div class="col-6">
                            <label for="clave_sp">Clave Servidor</label>
                            <input type="text" id="clave_sp" value="<?php echo $cve_sp; ?>">
                        </div>
                        <div class="col-6">
                            <label for="rfc">RFC</label>
                            <input type="text" id="rfc" value="<?php echo $rfc; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="nombre">Nombre <small class="red-text">* Capture empezando por Nombre, Apellido Paterno, Apellido Materno sin acentos</small> </label>
                            <input type="text" id="nombre" value="<?php echo $nombre; ?>">
                        </div>
                        <div class="col-6">
                            <label for="cp">Código Postal Fiscal</label>
                            <input type="text" id="cp" value="<?php echo $codigopos; ?>">
                        </div>
                        <div class="col-6">
                            <label for="email">Email</label>
                            <input type="text" id="email" value="<?php echo $email; ?>">
                        </div>
                        <div class="col-6">
                            <label for="email">Curp</label>
                            <input type="text" id="curp" value="<?php echo $curp; ?>">
                        </div>
                    </div>
                    <label for="opciones">¿Es correcta la información?:</label>
                    <select id="opciones" name="opciones">
                        <option value="">--SELECCIONA UNA OPCCION--</option>
                        <option value="TRUE">Son correctos</option>
                        <option value="FALSE">No son correctos</option>
                    </select>
                    <label for="comentarios">Comentarios:</label>
                    <textarea id="comentarios" name="comentarios" rows="4" placeholder="Escribe aquí tus comentarios..."></textarea>
                    <button class="btn" id="btn_enviar">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script src = "js_sistema/validacionesdospantallas.js"></script>
