<?php
session_start();
require_once '../configuracion_sistema/configuracion.php';
require_once '../librerias/PDOConsultas.php';
$events = array();

$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
//print_r($_POST);die();

if(isset($_POST['tabla'])){
    if($_POST['tabla']=='vista_puestos'){
        $_POST['tabla']='cat_puesto';
    }
    if($_POST['tabla']=='vista_tab_medica'){
        $_POST['tabla']='cat_tabuladormedica';
    }
    if($_POST['tabla']=='vista_tab_educacion'){
        $_POST['tabla']='cat_tabuladoreducacion';
    }
    if($_POST['tabla']=='vista_obra'){
        $_POST['tabla']='cat_contratos';
    }
    if($_POST['tabla']=='vista_honorarios'){
        $_POST['tabla']='cat_contratos';
    }
}

if (isset($_FILES) && count($_FILES) > 0) {
    $files = $_FILES;
    $str_ruta_include = $_POST['ruta'];
    //////ESTO LO PUSE PARA ASIGNAR LAS VALORES DE LAS VARIABLES DE LOS FILES, SE TENDRAN QUE VALIDAR PREVIAMENTE POR JAVASCRIPT
    $campos_file = "";
    $valores_file = "";

    foreach ($files as $keyfile => &$valfile) {
        $campos_file .= "," . $keyfile . "=";
        $nombre_archivo = explode('.', $files[$keyfile]["name"]);
        $nombre_archivo = $nombre_archivo[0];
        $ubicacionTemporal = $files[$keyfile]["tmp_name"];
        $extension = pathinfo($files[$keyfile]["full_path"], PATHINFO_EXTENSION);
        $campos_file .= "'" . $_POST['ruta'] . $nombre_archivo . "." . $extension . "'";
        $ruta_previa_destino = $str_ruta_inicial . $str_ruta_include;
        if (!mkdir($ruta_previa_destino, 0777, true)) {
        }
        move_uploaded_file($ubicacionTemporal, $ruta_previa_destino . $nuevoNombre . $nombre_archivo  . "." . $extension);
    }
    $field = $_POST;
    $puntero = 1;
    $query = "UPDATE " . $_POST['tabla'] . " SET ";
    foreach ($field as $key => &$val) {
        if ($puntero > 2) {
            if ($puntero == 3) {
                $condicion_act = " WHERE " . $key . "=" . "'" . $val . "'";
            } else {
                if (0 == (count($field) - $puntero)) {
                    $query .= $key . "=" . "'" . $val . "'" . $campos_file;
                } else {
                    $query .= $key . "=" . "'" . $val . "',";
                }
            }
        }
        $puntero++;
    }
} else {
    $field = $_POST;
    $puntero = 1;
    $query = "UPDATE " . $_POST['tabla'] . " SET ";
    foreach ($field as $key => &$val) {
        if ($puntero > 2) {
            if ($puntero == 3) {
                $condicion_act = " WHERE " . $key . "=" . "'" . $val . "'";
            } else {
                if (0 == (count($field) - $puntero)) {
                    $query .= $key . "=" . "'" . $val . "'";
                } else {
                    $query .= $key . "=" . "'" . $val . "',";
                }
            }
        }
        $puntero++;
    }
}

$query_final = $query . $condicion_act;

//die($query_final);

$consulta->executeQuery($query_final);
if ($consulta->lastInsertId != 'null') {
    echo  "EXITO";
} else {
    echo  $consulta->error;
}
