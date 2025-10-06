<?php
session_start();
include_once("../configuracion_sistema/configuracion.php");
include_once("../librerias/PDOConsultas.php");

global $__SESSION;

$strParamGet = "";
$boolPDF = "";
foreach ($_GET as $item => $value) {
    if (strlen($strParamGet) > 0)
        $strParamGet .= "&";
    $strParamGet .= $item . "=" . $value;
}

//print_r($_SESSION[_CFGSBASE]);

//Botones de Excel y PDF

////////////DATOS DE CONFIGURACION DE LOS REPORTES AUTOMATICOS////////////
switch ($_GET['str_caso']) {
    case 1:
        $campos = "cve_producto, cve_partida, num_producto, 
des_producto, cve_tipo_unidad, estatus_producto";
        $tabla = " cat_productos";
        $tabla_join = "";
        $strWhere = "";
        $cadena_busqueda = "";
        break;
    case 2:
        $campos = " a.cve_contrato, b.des_tipo_contrato, a.categoria, a.codigo, a.nivel,a.rango, c.des_tipo_mando,
        a.cantidad, a.abreviatura, d.des_organismo, a.sueldo_base, a.fortalecimiento, a.gratificacion, 
        a.despensa, a.sueldo_bruto, a.fecha_inicio, a.fecha_fin";
        $tabla = " cat_contratos a";
        $tabla_join = " LEFT JOIN 
                            cat_tipo_contrato b ON a.cve_tipo_contrato=b.cve_tipo_contrato
                        LEFT JOIN cat_tipo_mando c ON a.cve_tipo_mando=c.cve_tipo_mando	
                        LEFT JOIN cat_organismo_aux d ON a.cve_organismo=d.cve_organismo";
        $strWhere = " WHERE a.cve_organismo=" . $__SESSION->getValueSession('cveorganismo');
        $cadena_busqueda = "";
        break;
    case 3:
        $campos = " a.cve_tabuladoreducacion, a.abreviatura, d.des_organismo, a.puesto_funcional, b.des_tipo_mando,
        a.codigo, a.nivel, a.rango, a.sueldo_base, a.gratificacion, a.despensa, a.material_didactico, 
        a.eficiencia, a.fortalecimiento, a.sueldo_bruto, a.fecha_inicio, a.fecha_final";
        $tabla = " cat_tabuladoreducacion a";
        $tabla_join = " LEFT JOIN cat_tipo_mando b ON a.cve_tipo_mando=b.cve_tipo_mando 
        LEFT JOIN cat_organismo_aux d ON a.cve_organismo=d.cve_organismo";
        $strWhere = " WHERE a.cve_organismo=" . $__SESSION->getValueSession('cveorganismo');
        $cadena_busqueda = "";
        break;
    case 4:
        $campos = " a.cve_tabuladormedica, a.abreviatura, d.des_organismo, a.puesto_funcional, b.des_tipo_mando,
        a.codigo, a.nivel, a.rango, a.sueldo_base, a.gratificacion, a.despensa, a.material_didactico,
        a.eficiencia, a.fortalecimiento, a.sueldo_bruto, a.fecha_inicio, a.fecha_final";
        $tabla = " cat_tabuladormedica a";
        $tabla_join = " LEFT JOIN cat_tipo_mando b ON a.cve_tipo_mando=b.cve_tipo_mando 
        LEFT JOIN cat_organismo_aux d ON a.cve_organismo=d.cve_organismo";
        $strWhere = " WHERE a.cve_organismo=" . $__SESSION->getValueSession('cveorganismo');
        $cadena_busqueda = "";
        break;
    default:
        echo "NO SE ENCONTRO NINGUNA COINCIDENCIA INTENTE CON OTRO REPORTE";
        break;
}

$strexcel = "<div class=\"row\"><div class=\"col-md-2 mb-1\"><form method=\"post\" id=\"formreporte\" action=\"reportes_sistema/excel/rep_xls_org.php?\" >";
$strexcel .= "<input type=\"text\" id=\"campos\" name=\"campos\" value=\"$campos\" hidden=\"true\">";
$strexcel .= "<input type=\"text\" id=\"tabla\" name=\"tabla\" value=\"$tabla\" hidden=\"true\">";
$strexcel .= "<input type=\"text\" id=\"tabla_join\" name=\"tabla_join\" value=\"$tabla_join\" hidden=\"true\">";
$strexcel .= "<input type=\"text\" id=\"strWhere\" name=\"strWhere\" value=\"$strWhere\" hidden=\"true\">";
$strexcel .= "<input type=\"text\" id=\"cadena_busqueda\" name=\"cadena_busqueda\" value=\"$cadena_busqueda\" hidden=\"true\">";
$strexcel .= "<button type=\"submit\" value=\"Submit\"><img src=\"imagenes_sistema/excel_reporte.png\"  title=\"DESCARGAR \"  width=\"35\" height=\"35\"  border=\"0\" /></button>";
$strexcel .= "</form></div>";


$strpdf = "<div class=\"col-md-2 mb-1\"><form method=\"post\" id=\"formreporte\" action=\"reportes_sistema/pdf/rep_pdf.php?\" >";
$strpdf .= "<input type=\"text\" id=\"campos\" name=\"campos\" value=\"$campos\" hidden=\"true\">";
$strpdf .= "<input type=\"text\" id=\"tabla\" name=\"tabla\" value=\"$tabla\" hidden=\"true\">";
$strpdf .= "<input type=\"text\" id=\"tabla_join\" name=\"tabla_join\" value=\"$tabla_join\" hidden=\"true\">";
$strpdf .= "<input type=\"text\" id=\"strWhere\" name=\"strWhere\" value=\"$strWhere\" hidden=\"true\">";
$strpdf .= "<input type=\"text\" id=\"cadena_busqueda\" name=\"cadena_busqueda\" value=\"$cadena_busqueda\" hidden=\"true\">";
$strpdf .= "<button type=\"submit\" value=\"Submit\"><img src=\"imagenes_sistema/Icono_pdf.png\"  title=\"DESCARGAR \"  width=\"35\" height=\"35\"  border=\"0\" /></button>";
$strpdf .= "</form></div></div>";

echo $strexcel . $strpdf;

$query_principal = "";
$query_principal .= "SELECT " . $campos . " FROM " . $tabla . " " . $tabla_join . " " . $strWhere . " " . $cadena_busqueda;
//echo $query_principal;


global $CFG_HOST, $CFG_USER, $CFG_DBPWD, $CFG_DBASE, $CFG_TIPO;

$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
$predatos = $consulta->executeQuery($query_principal);

$vector_campos = array_keys($predatos[0]);

if ($consulta->totalRows > 0) {
    ?>
    <style type="text/css">
        .tftable {
            font-size: 10px;
            color: #333333;
            width: 100%;
            border-width: 1px;
            border-color: #c4c4c4;
            border-collapse: collapse;
        }

        .tftable th {
            color: #ffffff;
            font-size: 12px;
            background-color: #8A2036;
            border-width: 1px;
            padding: 0px;
            border-style: solid;
            border-color: #8A2036;
            text-align: left;
        }

        .tftable tr {
            background-color: #f9f9f9;
            padding: 5px;
        }

        .tftable td {
            font-size: 11px;
            border-width: 1px;
            padding: 5px;
            border-style: solid;
            border-color: #c4c4c4;
            text-justify: auto;
            width: 1%;
            white-space: nowrap;
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
            for ($i = 0, $iMax = count($vector_campos); $i < $iMax; $i++) {
                echo '<th>' . strtoupper($vector_campos[$i]) . '</th>';
            }
            ?>
        </tr>
        <?php
        foreach ($predatos as $key => &$val) {
            echo '<tr>';
            for ($i = 0, $iMax = count($vector_campos); $i < $iMax; $i++) {
                echo ' <td>' . $val[$vector_campos[$i]] . '</td>';
            }
            echo '</tr>';
        }
        ?>
    </table>
    </body>
    <?php
} else {
    echo $uno = "No hay registros para mostrar";
}
?>

</html>