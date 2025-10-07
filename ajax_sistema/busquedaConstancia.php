<?php
require_once '../configuracion_sistema/configuracion.php';
require_once '../librerias/PDOConsultas.php';

$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

// Obtener término de búsqueda
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$resultados = [];

if ($q !== '') {

    // Armamos el SQL (usando LIKE genérico)
    $sql = "SELECT cve_adscricpion, clave_adscripcion, desc_adscripcion
            FROM cat_adscripciones
            WHERE clave_adscripcion LIKE '%$q%'
               OR desc_adscripcion LIKE '%$q%'
            LIMIT 10";

    // Ejecutamos la consulta
    $datos = $consulta->executeQuery($sql);

    // Armamos arreglo con el formato que el JS espera
    foreach ($datos as $row) {
        $resultados[] = [
            'id'   => $row['clave_adscripcion'],
            'text' => $row['clave_adscripcion'] . ' - ' . $row['desc_adscripcion']
        ];
    }
}

// Enviamos como JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode($resultados);
