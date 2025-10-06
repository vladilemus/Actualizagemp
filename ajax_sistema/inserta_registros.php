<?php
session_start();
require_once '../configuracion_sistema/configuracion.php';
require_once '../librerias/PDOConsultas.php';
include_once 'funciones_adicionales.php';

$events = array();
$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

if (isset($_FILES) && count($_FILES) > 0) {
    $files = $_FILES;
    $str_ruta_include = $_POST['ruta'];
    //////ESTO LO PUSE PARA ASIGNAR LAS VALORES DE LAS VARIABLES DE LOS FILES, SE TENDRAN QUE VALIDAR PREVIAMENTE POR JAVASCRIPT
    $campos_file = "";
    $valores_file = "";
    foreach ($files as $keyfile => &$valfile) {
        $campos_file .= "," . $keyfile;
        $nombre_archivo = explode('.', $files[$keyfile]["name"]);
        $nombre_archivo = $nombre_archivo[0];
        $ubicacionTemporal = $files[$keyfile]["tmp_name"];
        $extension = pathinfo($files[$keyfile]["full_path"], PATHINFO_EXTENSION);
        $valores_file .= ",'" . $_POST['ruta'] . $nombre_archivo . "." . $extension . "'";
        $ruta_previa_destino = $str_ruta_inicial . $str_ruta_include;

        if (!mkdir($ruta_previa_destino , 0777, true)) {

        }

        move_uploaded_file($ubicacionTemporal, $ruta_previa_destino . $nuevoNombre . $nombre_archivo  . "." . $extension);
    }
    $field = $_POST;
    $puntero = 1;
    $query = "INSERT INTO " . $_POST['tabla'] . " (";
    $query_valores = "(";
    foreach ($field as $key => &$val) {
        if (0 == (count($field) - $puntero)) {
            $query .= $key . $campos_file . ") VALUES ";
            $query_valores .= "'" . $val . "' " . $valores_file . ")";
        } else {
            //el tres es para evitar el indice donde apuntan los datos principales de la tabla
            if ($puntero > 3) {
                if (0 == (count($field) - $puntero)) {
                } else {
                    $query .= $key . ", ";
                    $query_valores .= "'" . $val . "', ";
                }
            }
        }
        $puntero++;
    }
} else {

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

    $field = $_POST;
    $puntero = 1;
    $query = "INSERT INTO " . $_POST['tabla'] . " (";
    $query_valores = "(";
    foreach ($field as $key => &$val) {
        if (0 == (count($field) - $puntero)) {
            $query .= $key . ") VALUES ";
            $query_valores .= "'" . $val . "')";
        } else {
            //el tres es para evitar el indice donde apuntan los datos principales de la tabla
            if ($puntero > 3) {
                if (0 == (count($field) - $puntero)) {
                } else {
                    $query .= $key . ", ";
                    $query_valores .= "'" . $val . "', ";
                }
            }
        }
        $puntero++;
    }
}

if ($_POST['tabla'] == 'sb_perfil_usergroup') {
    $query_antes_insertar = "SELECT COUNT(*) as totales
                            FROM sb_perfil_usergroup
                            WHERE 
                            cve_usergroup=" . $_POST['cve_usergroup'] . " 
                            AND cve_organismo=" . $_POST['cve_organismo'];
    $valores_antes = $consulta->executeQuery($query_antes_insertar);
    if ($valores_antes[0]['totales'] > 0) {
        echo "EL REGISTRO YA EXISTE";
        die();
    }

    $query_antes_insertar = "SELECT COUNT(dominante) AS totales
    FROM sb_perfil_usergroup
    WHERE 
    cve_organismo=" . $_POST['cve_organismo'] . " 
    AND dominante='ACTIVO'";
    $valores_antes = $consulta->executeQuery($query_antes_insertar);
    if ($valores_antes[0]['totales'] >= 1 && $_POST['dominante'] == 'ACTIVO') {
        echo "SOLO PUEDE HABER UN GRUPO DOMINANTE";
        die();
    }
}


$query_final = $query . $query_valores;
$consulta->executeQuery($query_final);
if ($consulta->lastInsertId != 'null') {
    if (isset($consulta->error)) {
        $array_error = $consulta->error;
        $error_cadena = substr($array_error[0], 1, 14);
        if ($error_cadena == "QLSTATE[23000]") {
            echo  "EL REGISTRO YA EXISTE";
        } else {
            echo $consulta->error;
        }
    } else {
        echo  "EXITO";
    }
} else {
    echo $consulta->error;
}
