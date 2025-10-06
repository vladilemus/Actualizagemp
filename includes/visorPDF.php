<?php
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=documento.pdf");
$str_check = FALSE;
include_once("../configuracion/configuracion.php");
include_once '../librerias/PDOConsultas.php';
$valor = "";
$valor = $_GET['valor'];
$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0],$CFG_TIPO[0]); //connect to database
$consulta->where("cve_plantilla", $valor, "=");
$resultado = $consulta->select("sb_plantillas");
foreach ($resultado as $key => &$val) {
    $ruta = $val['ruta'];
}
readfile("C:/wamp64/www/plantilla/".$ruta);


