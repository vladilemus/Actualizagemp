<?php
include_once("configuracion_sistema/configuracion.php");
include_once 'librerias/PDOConsultas.php';

$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

$date=date('Y-m-d');


try {
    if (!file_exists('archivos_sat')) {
        mkdir('archivos_sat', 0777, true);
    }
    
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $fileName = basename($file['name']);
        $targetDir = 'archivos_sat/';
        $targetFilePath = $targetDir . $fileName;

        // Verifica si es un archivo .txt
        if (pathinfo($targetFilePath, PATHINFO_EXTENSION) == 'txt') {
            // Mueve el archivo a la carpeta archivos_sat
            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                // Guardar la información en la base de datos
                $stmt =("INSERT INTO datos_sat (nombre_archivo, ruta, fecha) VALUES ('$fileName', '$targetFilePath','$date') ");
                $result= $consulta->executeQuery($stmt);

                // Leer el archivo .txt y procesar los datos
                $lines = file($targetFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                if ($lines) {
                    // Contar el número de líneas
                    $totalLines = count($lines);
                
                    // Usar un bucle for para iterar por cada línea
                    for ($i = 0; $i < $totalLines; $i++) {
                        $line = $lines[$i];
                
                        // Dividir la línea en partes usando el separador '|'
                        $partes = explode('|', $line);
                
                        // Verificar que se obtuvieron al menos 5 elementos
                        if (count($partes) >= 5) {
                            list($consecutivo, $rfc, $nombre, $codigo_postal, $leyenda) = $partes;
                
                            // Verificar si la leyenda contiene "RFC válido, y susceptible de recibir facturas"
                            if (strpos($leyenda, 'RFC válido, y susceptible de recibir facturas') !== false) {
                                // Consulta para actualizar el estatus en la base de datos
                                $sql = "UPDATE det_peticiones SET estatus = 'ACTUALIZADO' WHERE rfc = :rfc";
                                $consulta->executeQuery($sql, ['rfc' => $rfc]);
                            }
                        }
                    }
                } else {
                    //echo "El archivo está vacío o no se pudo leer correctamente.";
                }
                echo json_encode(['status' => 1]);
            } else {
                //echo "Hubo un error al subir el archivo.";
            }
        } else {
            //echo "Solo se permiten archivos .txt.";
        }
    } else {
        //echo "No se ha subido ningún archivo.";
        echo json_encode(['status' => 2]);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
