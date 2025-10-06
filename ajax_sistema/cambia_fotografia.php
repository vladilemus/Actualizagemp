<?php

session_start();

require_once '../configuracion_sistema/configuracion.php';
require_once '../librerias/PDOConsultas.php';

$events = array();
$consulta = new PDOConsultas();
GLOBAL  $CFG_USER, $CFG_TIPO,$CFG_DBPWD,$CFG_HOST,$CFG_DBASE,$str_ruta_inicial;
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

$cveorganismo=$_POST['cveorganismo'];
$ruta=$str_ruta_inicial."imagenes_sistema/perfiles/";

    ////////ESTOS SON LOS DATOS QUE SE POSTEAN PARA INGRESAR A LAS TABLAS CORRESPONDIENTES/////////
    if (isset($_FILES) && count($_FILES) > 0) {
        //SI EL VECTOR ORIGINAL CONTIENE DATOS DE LAS FOTOGRAFIAS
        $files = $_FILES;
        $str_ruta_include = $ruta;
        //////ESTO LO PUSE PARA ASIGNAR LAS VALORES DE LAS VARIABLES DE LOS FILES, SE TENDRAN QUE VALIDAR PREVIAMENTE POR JAVASCRIPT
        $campos_file = "";
        $valores_file = "";
        foreach ($files as $keyfile => &$valfile) {
            $campos_file .= $keyfile;
            $nombre_archivo = explode('.', $files[$keyfile]["name"]);
            $nombre_archivo = $nombre_archivo[0];
            $ubicacionTemporal = $files[$keyfile]["tmp_name"];
            $extension = pathinfo($files[$keyfile]["full_path"], PATHINFO_EXTENSION);
            $valores_file =  $ruta . "_" . $nombre_archivo . "." . $extension;
            $ruta_previa_destino = $ruta;
            if (!mkdir($ruta_previa_destino, 0777, true)) {
            }
            move_uploaded_file($ubicacionTemporal, $ruta_previa_destino  . $__SESSION->getValueSession('nomusuario')."_". $nombre_archivo  . "." . $extension);
        }
    }

    $valor="imagenes_sistema/perfiles/".$__SESSION->getValueSession('nomusuario')."_". $nombre_archivo  . "." . $extension;
    $query_actualizacion="UPDATE sb_usuario SET file_user_image_file='$valor' WHERE cve_organismo=".$cveorganismo;
    $consulta->executeQuery($query_actualizacion);

    echo "EXITO";

