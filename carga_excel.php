<?php
require 'vendor/autoload.php';
include_once 'configuracion_sistema/configuracion.php';
include_once 'librerias/PDOConsultas.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
header('Content-Type: application/json');

ob_start();

try {
    if (!isset($_FILES['file'])) {
        echo json_encode(['status' => 2, 'message' => 'No se ha subido ningún archivo.']);
        exit();
    }

    $file = $_FILES['file'];
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

    // Validar tipo de archivo
    if (!in_array($fileExtension, ['xlsx'])) {
        echo json_encode(['status' => 2, 'message' => 'Solo se permiten archivos .xlsx.']);
        exit();
    }

    // Cargar archivo Excel
    $spreadsheet = IOFactory::load($file['tmp_name']);
    $sheet = $spreadsheet->getActiveSheet();
    $highestRow = $sheet->getHighestRow();

    if ($highestRow < 2) {
        echo json_encode(['status' => 4, 'message' => 'El archivo está vacío.']);
        exit();
    }

    // Conectar a la base de datos
    $consulta = new PDOConsultas();
    $consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

    // Crear la tabla errores_timbre si no existe
    $createTableSQL = "
        CREATE TABLE IF NOT EXISTS errores_timbre (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sp VARCHAR(50),
            nombre VARCHAR(255),
            rfc VARCHAR(20),
            curp VARCHAR(20),
            cp VARCHAR(10),
            cve_ads VARCHAR(50),
            detalle TEXT,
            cct VARCHAR(50),
            fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $consulta->executeQuery($createTableSQL);

    // Limpiar la tabla antes de volver a insertar datos
    $consulta->executeQuery("TRUNCATE TABLE errores_timbre");


    // Insertar datos en errores_timbre
    $insertSQL = "INSERT INTO errores_timbre (sp, nombre, rfc, curp, cp, cve_ads, detalle, cct) 
                  VALUES (:sp, :nombre, :rfc, :curp, :cp, :cve_ads, :detalle, :cct)";
    
    for ($row = 2; $row <= $highestRow; $row++) {
        $sp = $sheet->getCell('A' . $row)->getValue();
        $nombre = $sheet->getCell('B' . $row)->getValue();
        $rfc = $sheet->getCell('C' . $row)->getValue();
        $curp = $sheet->getCell('D' . $row)->getValue();
        $cp = $sheet->getCell('E' . $row)->getValue();
        $cve_ads = $sheet->getCell('F' . $row)->getValue();
        $detalle = $sheet->getCell('G' . $row)->getValue();
        $cct = $sheet->getCell('H' . $row)->getValue();

        $consulta->executeQuery($insertSQL, [
            'sp' => $sp,
            'nombre' => $nombre,
            'rfc' => $rfc,
            'curp' => $curp,
            'cp' => $cp,
            'cve_ads' => $cve_ads,
            'detalle' => $detalle,
            'cct' => $cct
        ]);
    }

    echo json_encode(['status' => 1, 'message' => 'Datos importados a errores_timbre correctamente.']);

    // Crear la nueva tabla errores_con_email si no existe
    $createTableWithEmailSQL = "
        CREATE TABLE IF NOT EXISTS errores_con_email (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sp VARCHAR(50),
            nombre VARCHAR(255),
            rfc VARCHAR(20),
            curp VARCHAR(20),
            cp VARCHAR(10),
            cve_ads VARCHAR(50),
            detalle TEXT,
            cct VARCHAR(50),
            email VARCHAR(255) DEFAULT NULL,
            fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $consulta->executeQuery($createTableWithEmailSQL);

    // Limpiar la tabla antes de volver a insertar datos
    $consulta->executeQuery("TRUNCATE TABLE errores_con_email");

    // Insertar datos en errores_con_email
    $insertMatchingSQL = "
        INSERT INTO errores_con_email (sp, nombre, rfc, curp, cp, cve_ads, detalle, cct, email)
        SELECT 
            e.sp, e.nombre, e.rfc, e.curp, e.cp, e.cve_ads, e.detalle, e.cct, COALESCE(g.email, NULL)
        FROM errores_timbre e
        LEFT JOIN g2guser g ON e.sp = g.clavesp
    ";
    $consulta->executeQuery($insertMatchingSQL);

    echo json_encode(['status' => 1, 'message' => 'Datos importados a errores_con_email correctamente.']);

    // Insertar nuevos registros en dt_sp_erroneos si no existen
    $insertNewRecordsSQL = "
    INSERT IGNORE INTO dt_sp_erroneos (
            clave_sp, nombre, rfc, curp, codigo_post, ley_adscripcion, error, centro_trabajo, email, estatus
        )
        SELECT 
            ee.sp, 
            ee.nombre, 
            ee.rfc, 
            ee.curp, 
            ee.cp, 
            ee.cve_ads, 
            ee.detalle, 
            ee.cct, 
            ee.email, 
            ''
        FROM errores_con_email ee
        WHERE NOT EXISTS (
            SELECT 1 FROM dt_sp_erroneos de WHERE de.clave_sp = ee.sp
        )
    ";
    $consulta->executeQuery($insertNewRecordsSQL);


    echo json_encode(['status' => 1, 'message' => 'Nuevos registros insertados en dt_sp_erroneos.']);

    // Actualizar estatus a "vacio" en registros que existen en ambas tablas
    $updateEstatusSQL = "
        UPDATE dt_sp_erroneos de
        JOIN errores_con_email ee ON de.clave_sp = ee.sp
        SET de.estatus = ''
    ";
    $consulta->executeQuery($updateEstatusSQL);
    echo json_encode(['status' => 1, 'message' => 'Estatus actualizado en dt_sp_erroneos.']);

    if (!headers_sent()) {
        ob_end_clean();
        echo json_encode(['status' => 1, 'message' => 'Datos importados y comparados correctamente.']);
        exit();
    }

} catch (Exception $e) {
    echo json_encode(['status' => 2, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
