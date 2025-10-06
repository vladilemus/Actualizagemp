<?php

require_once '../configuracion_sistema/configuracion.php';
require_once '../librerias/PDOConsultas.php';

$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

$clavesp = $_POST['clave_sp'];
$estatus = $_POST['estatusCheque'];



if($estatus == "true"){
    $entregado = $consulta->executeQuery("UPDATE cat_cheques17
                                            SET
                                                condision='ENTREGADO'
                                            WHERE clave_SP = '$clavesp'");

    echo json_encode(['status' => 1]);
} elseif($estatus == "false") {
    $entregado = $consulta->executeQuery("UPDATE cat_cheques17
                                            SET
                                                condision='CANSELADO'
                                            WHERE clave_SP = '$clavesp'");
    echo json_encode(['status' => 2]);
} else {
    echo json_encode(['status' => 3]);
}