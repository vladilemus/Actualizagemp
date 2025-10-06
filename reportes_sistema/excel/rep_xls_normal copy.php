<?php
session_start();
include_once("../../configuracion_sistema/configuracion.php");
include_once("../../librerias/PDOConsultas.php");
include_once('../libreria/Reporte.php');

header("Pragma: ");
header("Cache-Control: ");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Description: File Transfer");

$campos = base64_decode($_GET['chain1']);
$tabla = base64_decode($_GET['chain2']);
$tabla_join = base64_decode($_GET['chain3']);
$strWhere = base64_decode($_GET['chain4']);
$cadena_busqueda = base64_decode($_GET['chain5']);

header("Content-Disposition: attachment; filename=Reporte_" . $tabla . "_" . date("H:i:s") . ".xls");
$query_principal .= "SELECT " . $campos . " FROM " . $tabla . " " . $tabla_join . " " . $strWhere . " " . $cadena_busqueda;
$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
$predatos = $consulta->executeQuery($query_principal);
$vector_campos = array_keys($predatos[0]);

?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>DESCARGA DE EXCEL</title>
    <style type="text/css">
        .tftable {
            font-size: 12px;
            color: #333333;
            width: 100%;
            border-width: 1px;
            border-color: #c4c4c4;
            border-collapse: collapse;
        }

        .tftable th {
            color: #ffffff;
            font-size: 14px;
            background-color: #8A2036;
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #8A2036;
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
            border-color: #c4c4c4;
        }

        .tftable tr:hover {
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <table class="tftable" border="1">
        <tr>
            <?php
            for ($i = 0; $i < count($vector_campos); $i++) {
                echo '<th>' . strtoupper($vector_campos[$i]) . '</th>';
            }
            ?>
        </tr>
        <?php
        foreach ($predatos as $key => &$val) {
            echo '<tr>';
            for ($i = 0; $i < count($vector_campos); $i++) {
                echo ' <td>' . utf8_decode($val[$vector_campos[$i]]) . '</td>';
            }
            echo '</tr>';
        }
        ?>
    </table>

</body>

</html>