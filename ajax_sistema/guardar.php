<?php
require_once '../configuracion_sistema/configuracion.php';
require_once '../librerias/PDOConsultas.php';
$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
//Array ( [tabla] => sb_usuario [clave] => 1 [llave] => cve_usuario [campo] => user_image_file ) 
$nombre_archivo = explode('.', $_FILES["archivos"]["name"][0]);
$nombre_archivo = $nombre_archivo[0];
$conteo = count($_FILES["archivos"]["name"]);
$ubicacionTemporal = $_FILES["archivos"]["tmp_name"][0];
$nombreArchivo = $_FILES["archivos"]["name"][0];
$extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
// Renombrar archivo
$nuevoNombre = sprintf("%s_%d.%s", uniqid(), 0, $extension);
$nuevoNombre =$_POST['curp'];
$query_construido = "UPDATE " . $_POST['tabla'] . " SET  " . $_POST['campo'] . "='imagenes_sistema/perfiles/" . $nuevoNombre. "_" .$nombre_archivo  .".".$extension. "' WHERE " . $_POST['llave'] . "= " . $_POST['clave'];
$consulta->executeQuery($query_construido);
// Mover del temporal al directorio actual
move_uploaded_file($ubicacionTemporal, "C:/wamp64/www/plantilla/imagenes_sistema/perfiles/" . $nuevoNombre."_".$nombre_archivo  .".".$extension);

// Responder al cliente
echo json_encode(true);
