<?php
//Aqui se van a ejecutar lo querys para la desactivacion de los demas modulos para todos los tipos de roles.
session_start();
include_once("../configuracion_sistema/configuracion.php");
include_once '../librerias/PDOConsultas.php';
global $CFG_HOST, $CFG_USER, $CFG_DBPWD, $CFG_DBASE, $CFG_TIPO;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $consulta = new PDOConsultas();
    $consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
    $query_modulos="UPDATE  sb_modulo 
                    SET status_modulo=0 
                    WHERE cve_modulo NOT IN (1,2,3,4,5,6,7,50,51,52,90,91,92)";
   $consulta->executeQuery($query_modulos);
   $query_vaciado="TRUNCATE conteos";
   $consulta->executeQuery($query_vaciado);
   $query_inserta_productos="INSERT INTO  conteos (cve_producto, estatus_conteo1, 
                                estatus_conteo2, des_producto, estatus_producto)
                                SELECT cve_producto,'NOCONTADO' AS conteo1,'NOCONTADO' AS conteo2,
                                des_producto,estatus_producto FROM cat_productos;  ";
    $consulta->executeQuery($query_inserta_productos);
   //HASTA ESTE PUNTO SE CIERRAN LOS MODULOS PARA QUE SOLO SE QUEDEN LOS CONTEOS, AHORA SOLO QUEDA POR PASAR LA BASE
   echo "OK";
} else {
    http_response_code(405);
    echo "Método no permitido";
}
