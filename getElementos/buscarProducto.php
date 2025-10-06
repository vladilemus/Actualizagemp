<?php
/// ESTABLESCO LAS LAS LIBRERIAS PARA LAS CONSULTAS
global $CFG_HOST, $CFG_USER, $CFG_DBPWD, $CFG_DBASE, $CFG_TIPO;
include_once("../configuracion_sistema/configuracion.php");
include_once '../librerias/PDOConsultas.php';
//CREO EL OBJETO PARA LA CREACION DE LAS CONSULTAS
$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

$tipo = $_GET['tipo'];
$valor = $_GET['valor'];

// Crear la consulta SQL según el tipo se creo una vista para esto
if ($tipo == 'descripcion') {
    $query = "SELECT 
a.cve_producto AS cve_producto,a.cve_partida AS cve_partida,
c.num_partida AS num_partida,c.des_partida AS des_partida,
a.num_producto AS num_producto,a.des_producto AS des_producto,
a.cve_tipo_unidad AS cve_tipo_unidad,b.des_tipo_unidad AS des_tipo_unidad,
a.estatus_producto AS estatus_producto
FROM ((cat_productos a
LEFT JOIN cat_tipo_unidad b ON((a.cve_tipo_unidad = b.cve_tipo_unidad)))
LEFT JOIN cat_partidas c ON((a.cve_tipo_unidad = c.cve_partida)))
WHERE a.des_producto LIKE '%".$valor."%'";
} else {
    $query = "SELECT 
a.cve_producto AS cve_producto,a.cve_partida AS cve_partida,
c.num_partida AS num_partida,c.des_partida AS des_partida,
a.num_producto AS num_producto,a.des_producto AS des_producto,
a.cve_tipo_unidad AS cve_tipo_unidad,b.des_tipo_unidad AS des_tipo_unidad,
a.estatus_producto AS estatus_producto
FROM ((cat_productos a
LEFT JOIN cat_tipo_unidad b ON((a.cve_tipo_unidad = b.cve_tipo_unidad)))
LEFT JOIN cat_partidas c ON((a.cve_tipo_unidad = c.cve_partida)))
WHERE a.num_producto LIKE '%".$valor."%'";
}
//echo  $query;
$records =$consulta->executeQuery($query);
$JSONDATOS = $consulta->arrayToJson($records);
echo $JSONDATOS;
//echo $JSONDATOS;
// Supongamos que obtienes un array $producto
// Devuelve los datos en formato JSON
//echo json_encode($JSONDATOS);
