<?php
session_start();
require '../configuracion/configuracion.php';
require '../librerias/PDOConsultas.php';
require('libreria/Reporte.php');

//header("Pragma: ");
//header("Cache-Control: ");
//header("Content-Type: application/force-download");
//header("Content-Type: application/octet-stream");
//header("Content-Type: application/download");
//header("Content-Description: File Transfer");
//header("Content-Disposition: attachment; filename=Reporte_Global_" . date("H:i:s") . ".xls");
GLOBAL $CFG_DBASE,$CFG_HOST,$CFG_USER,$CFG_DBPWD,$CFG_TIPO;
$vector_campos = array("nombre", "percepcion1", "ofrecimiento1", "percepcion2", "ofrecimiento2", "percepcion3", "ofrecimiento3");
$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
////AUMENTO DE TIEMPO DE EJECUCION

$consulta->executeQuery("set statement_timeout = '6000 s'");

//
$predatos = $consulta->executeQuery("SELECT  nombre,cve_suteym, nombre, estatus, cve_nomina, tipo, of1, of2, of3 
	FROM conceptosuteym
	WHERE 
	cve_nomina!=0  ");
$cadena2 = "";
$cadena3 = "";
$cadena4 = "";
$cadena2 = 'SELECT perded,
       CASE';
$tope = 0;

foreach ($predatos as $key => &$val) {
    //echo $val['cve_nomina'] . '--' . $val['of1'] . '--' . $val['of2'] . '--' . $val['of3'] . '</br>';
    $cadena2 = $cadena2 . " WHEN perded=" . $val['cve_nomina'] . " THEN SUM(imp)* (" . $val['of1'] . ")";
    $cadena3 = $cadena3 . " WHEN perded=" . $val['cve_nomina'] . " THEN SUM(imp)* (" . $val['of2'] . ")";
    $cadena4 = $cadena4 . " WHEN perded=" . $val['cve_nomina'] . " THEN SUM(imp)* (" . $val['of3'] . ")";
}

$modulo_acceso = $consulta->executeQuery("SELECT s.nombre as nombre,t.perded AS percepcion1,t.su AS ofrecimiento1,
		 t2.perded AS percepcion2,t2.su1 AS ofrecimiento2,
		 t3.perded AS percepcion3,t3.su3 AS ofrecimiento3
FROM (
" . $cadena2 . "
		  END AS su
    FROM comp2021 c 
      WHERE left(neccat,1)!='A'
	 GROUP BY perded
	 ORDER BY perded ) AS t 
	 						LEFT OUTER JOIN 
	 (
         " . $cadena2 . $cadena3 . "
		  END AS su1
    FROM comp2021 c 
      WHERE left(neccat,1)!='A'
	 GROUP BY perded
	  ORDER BY perded ) AS t2 ON  t.perded=t2.perded
	  LEFT OUTER JOIN 
	 (" . $cadena2 . $cadena3 . "
		  END AS su3
    FROM comp2021 c 
      WHERE left(neccat,1)!='A'
	 GROUP BY perded
	  ORDER BY perded ) AS t3 ON  t.perded=t3.perded  
	left outer JOIN cat_conceptos_m4 s ON s.clave_nomina2=t.perded
	WHERE 
	t.su IS NOT NULL AND t2.su1 IS NOT NULL");
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>DESCARGA DE EXCEL</title>
    <style type="text/css">
        .tftable {
            font-size:12px;
            color:#333333;
            width:100%;
            border-width: 1px;
            border-color: #a9a9a9;
            border-collapse: collapse;
        }
        .tftable th {
            color: #ffffff;
            font-size: 14px;
            background-color: #94CA55;
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #94CA55;
            text-align: left;
        }
        .tftable tr {
            background-color:#e9e9e9;
        }
        .tftable td {
            font-size:12px;
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #a9a9a9;
        }
        .tftable tr:hover {
            background-color:#ffffff;
        }
    </style>
</head>
<body>
    <table class="tftable" border="1">
        <tr>
            <?php
            for ($i = 0; $i < count($vector_campos); $i++) {
                echo '<th>' .strtoupper($vector_campos[$i]) . '</th>';
            }
            ?>
        </tr>
        <?php
        foreach ($modulo_acceso as $key => &$val) {
            echo '<tr>';
            for ($i = 0; $i < count($vector_campos); $i++) {
                echo ' <td>' . $val[$vector_campos[$i]] . '</td>';
            }
            echo '</tr>';
        }
        ?>
    </table>

</body>
</html>