<?php

include_once("configuracion_sistema/configuracion.php");
include_once 'librerias/PDOConsultas.php';

$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

//consulta
$sql = ("SELECT  cve_peticion, rfc, nombre,codigo_post FROM det_peticiones WHERE estatus = 'ACTUALIZADO'");
$result= $consulta->executeQuery($sql);


    if (!empty($result)) {
        // Nombre del archivo
        $filename = "resultados.txt";
        
        // Crear el archivo y escribir los resultados
        $file = fopen($filename, "w");

        // Número consecutivo
        $contador = 1;

        foreach ($result as $row) {
            // Formatear la línea según el formato deseado
            $linea = $contador . "|" . $row["rfc"] . "|" . $row["nombre"] . "|" . $row["codigo_post"] . "\n";

            // Escribir la línea en el archivo
            fwrite($file, $linea);

            // Incrementar el contador
            $contador++;
        }

        // Cerrar el archivo
        fclose($file);

        // Enviar el archivo para descarga
            header('Content-Description: File Transfer');
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="'.basename($filename).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filename));
            readfile($filename);
        exit;
    } else {
        echo "No se encontraron resultados.";
    }


?>
