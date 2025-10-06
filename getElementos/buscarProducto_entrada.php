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

    $query = "SELECT * FROM (
SELECT 
    cp.cve_producto, cp.cve_partida, cp.num_partida, cp.des_partida,
    cp.num_producto, cp.des_producto, cp.cve_tipo_unidad, cp.des_tipo_unidad, kp.ultimo_kardex, kp.cantidad, kp.existencias
FROM (
    SELECT 
        a.cve_producto, a.cve_partida, c.num_partida, c.des_partida,
        a.num_producto, a.des_producto, a.cve_tipo_unidad, b.des_tipo_unidad,
        a.estatus_producto
    FROM cat_productos a
    LEFT JOIN cat_tipo_unidad b ON a.cve_tipo_unidad = b.cve_tipo_unidad
    LEFT JOIN cat_partidas c ON a.cve_partida = c.cve_partida
) AS cp
INNER JOIN (
    SELECT 
        kardex.cve_producto, MAX(kardex.cve_kardex) AS ultimo_kardex, kardex.cantidad, kardex.existencias
    FROM kardex_productos kardex
    INNER JOIN (
        SELECT cve_producto, MAX(cve_kardex) AS max_kardex
        FROM kardex_productos
        GROUP BY cve_producto
    ) AS ultimo ON kardex.cve_producto = ultimo.cve_producto AND kardex.cve_kardex = ultimo.max_kardex
    GROUP BY kardex.cve_producto
) AS kp ON cp.cve_producto = kp.cve_producto) AS vista WHERE des_producto LIKE '%".$valor."%'";

} else {
    $query = "SELECT * FROM (
SELECT 
    cp.cve_producto, cp.cve_partida, cp.num_partida, cp.des_partida,
    cp.num_producto, cp.des_producto, cp.cve_tipo_unidad, cp.des_tipo_unidad, kp.ultimo_kardex, kp.cantidad, kp.existencias
FROM (
    SELECT 
        a.cve_producto, a.cve_partida, c.num_partida, c.des_partida,
        a.num_producto, a.des_producto, a.cve_tipo_unidad, b.des_tipo_unidad,
        a.estatus_producto
    FROM cat_productos a
    LEFT JOIN cat_tipo_unidad b ON a.cve_tipo_unidad = b.cve_tipo_unidad
    LEFT JOIN cat_partidas c ON a.cve_partida = c.cve_partida

) AS cp
INNER JOIN (
    SELECT 
        kardex.cve_producto, MAX(kardex.cve_kardex) AS ultimo_kardex, kardex.cantidad, kardex.existencias
    FROM kardex_productos kardex
    INNER JOIN (
        SELECT cve_producto, MAX(cve_kardex) AS max_kardex
        FROM kardex_productos
        GROUP BY cve_producto
    ) AS ultimo ON kardex.cve_producto = ultimo.cve_producto AND kardex.cve_kardex = ultimo.max_kardex
    GROUP BY kardex.cve_producto
) AS kp ON cp.cve_producto = kp.cve_producto) AS vista WHERE num_producto LIKE '%".$valor."%'";
}
//echo  $query;
$records =$consulta->executeQuery($query);
if(count($records)==0){
    //SI NO SE ENCUENTRA INFORMACION EN EL KARDEX PRINCIPAL SE LANZA EL MENSAJE DE QUE NO EXISTEN
    echo json_encode("NO HAY DATOS");
}else{
    $JSONDATOS = $consulta->arrayToJson($records);
    echo $JSONDATOS;
}
//echo $JSONDATOS;
// Supongamos que obtienes un array $producto
// Devuelve los datos en formato JSON
//echo json_encode($JSONDATOS);
