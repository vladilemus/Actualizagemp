<?php

require_once '../configuracion_sistema/configuracion.php';
require_once '../librerias/PDOConsultas.php';

$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

// Obtener término de búsqueda
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$resultados = [];

if ($q !== ''){

    //armamos la conuslta
    $sql = "SELECT cve_peticion, clave_sp, nombre
            FROM det_peticiones
            WHERE clave_sp LIKE '%$q%'
                OR nombre LIKE '%$q%'
            LIMIT 10";
    
    //EJECUTAMOS LA CONSULTA
    $datos = $consulta->executeQuery($sql);

    //armamos el formato js
    foreach($datos as $row){
        $resultados[] = [
            'id' => $row['clave_sp'],
            'text' => $row['clave_sp'] . ' - ' . $row['nombre']
        ];
    }

}

//enviamos el perro reusltado
header('Content-Type: application/json; charset=utf-8');
echo json_encode($resultados);
