<?php

require_once '../configuracion_sistema/configuracion.php';
require_once '../librerias/PDOConsultas.php';

$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

//sepramos las variables a utilizar 
$periodo = $_POST['periodo'] ?? '';
$anio = $_POST['anio'] ?? '';

//ruta de ubicacion de archivos
$basePath = "C:/wamp64/www/capturagem/actualizagem/storage/app/public/constancias/";

//consulta 
$sql = "    SELECT *
    FROM det_peticiones
    WHERE fecha_captura BETWEEN '$inicio' AND '$fin' ";

//ejecutamos la consulta
$resultado = $consulta->executeQuery($sql);

// Crear carpeta temporal para ZIP
$zipDir = __DIR__ . '/tmp_zip';
if (!is_dir($zipDir)) {
    mkdir($zipDir, 0777, true);
}

$zipName = "Constancias_{$anio}_{$periodo}_{$adsc}.zip";
$zipPath = $zipDir . '/' . $zipName;

// Crear el ZIP
$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    die(json_encode(['status' => 'error', 'msg' => 'No se pudo crear el archivo ZIP']));
}

$archivosAgregados = 0;

foreach ($resultados as $row) {
    $pdfFile = $basePath . $row['nombre_encriptado'];

    if (file_exists($pdfFile)) {
        $nombreDentroZip = $row['nombre_archivo'] ?: basename($pdfFile);
        $zip->addFile($pdfFile, $nombreDentroZip);
        $archivosAgregados++;
    }
}

$zip->close();

if ($archivosAgregados === 0) {
    unlink($zipPath);
    die(json_encode(['status' => 'error', 'msg' => 'No se encontraron archivos PDF en la ruta configurada']));
}

// Enviar archivo ZIP al navegador
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . basename($zipPath) . '"');
header('Content-Length: ' . filesize($zipPath));
readfile($zipPath);

// Opcional: limpiar después de descargar
unlink($zipPath);
exit;
