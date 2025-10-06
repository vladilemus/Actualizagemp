<?php
header("Pragma: ");
header("Cache-Control: ");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Description: File Transfer");

//LO ANTERIOR ESPARA INDICARLE AL NAVEGARO QUE VAMOS A DESCARGAR UN EXCEL

session_start();

include_once("../../configuracion_sistema/configuracion.php");
include_once("../../librerias/PDOConsultas.php");
include_once('../libreria/Reporte.php');

//VEMOS SI SE ESTAN MANDANDO LOS DATOS POR EL FORMULARIO
//print_r($_POST);
//die("LINEA DE RECEPCION DE LOS DATOS");

$campos = $_POST['campos'];
$tabla = $_POST['tabla'];
$tabla_join = $_POST['tabla_join'];
$strWhere = $_POST['strWhere'];
$cadena_busqueda = $_POST['cadena_busqueda'];
$query_principal = "";
header("Content-Disposition: attachment; filename=Reporte_" . $tabla . "_" . date("H:i:s") . ".xls");

$query_principal .= "SELECT " . $campos . " FROM " . $tabla . " " . $tabla_join . " " . $strWhere . " " . $cadena_busqueda;

//die($query_principal);

global $CFG_HOST, $CFG_USER, $CFG_DBPWD, $CFG_DBASE, $CFG_TIPO;

$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
$predatos = $consulta->executeQuery($query_principal);
$vector_campos = array_keys($predatos[0]);
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>DESCARGA DE EXCEL</title>
    <style type="text/css">
        .tftable {
            font-size: 12px;
            color: #333333;
            width: 100%;
            border-width: 1px;
            border-color: #b7b7b7;
            border-collapse: collapse;
        }

        .tftable th {
            color: #ffffff;
            font-size: 14px;
            background-color: #8A2036;
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #b7b7b7;
            text-align: left;
        }

        .tftable tr {
            background-color: #f9f9f9;
        }

        .tftable td {
            font-size: 12px;
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #b7b7b7;
        }

        .tftable tr:hover {
            background-color: #ffffff;
        }
    </style>
</head>

<body>
<table class="tftable">
    <tr>
        <?php
        for ($i = 0, $iMax = count($vector_campos); $i < $iMax; $i++) {
            echo '<th>' . strtoupper($vector_campos[$i]) . '</th>';
        }
        ?>
    </tr>
    <?php
    foreach ($predatos as $key => &$val) {
        echo '<tr>';
        for ($i = 0, $iMax = count($vector_campos); $i < $iMax; $i++) {
            echo ' <td>' . utf8_decode($val[$vector_campos[$i]]) . '</td>';
        }
        echo '</tr>';
    }
    ?>
</table>

</body>

</html>