<?php
require_once '../configuracion_sistema/configuracion.php';
require_once '../librerias/PDOConsultas.php';

$clave_sp = $_POST['ClaveSp'];

$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

// Consultar dt_sp_erroneos
$consulta->columns = array("a.nombre", "a.clave_sp", "a.rfc", "a.curp", "a.ley_adscripcion", "b.ADescripcion", "a.estatus");
$consulta->where("clave_sp", "$clave_sp");
$consulta->joinTables("cat_adscripcion as b", "a.ley_adscripcion = b.AClave", "INNER JOIN");
$erroneo = $consulta->select("dt_sp_erroneos as a");

$ley = substr($erroneo[0]['ley_adscripcion'],0,3);


// Versificación
if (is_array($erroneo) && count($erroneo) > 0) {

    // Consultar todos los cheques del servidor público (puede tener más de uno)
    $consulta->where("clave_sp", "$clave_sp");
    $cheques = $consulta->select("cat_cheques17"); // Esta función debería devolver un array con todos los cheques

    $condicion = $cheques[0]['condision'];
    
    if ($condicion === "PENDIENTE"){
        $consulta->where("clave", "$ley");
        $unidad = $consulta->select("cat_adscripciones");
    
        // Combinar ambos resultados en un solo array
        $result = [
            'unidad' => $unidad,
            'status' => 2,  // Datos encontrados
            'erroneo' => $erroneo,
            'cheque' => $cheques  // Aquí debería estar enviando todos los cheques
        ];
        
        echo json_encode($result); 
    } else if($condicion === 'ENTREGADO')  {
        echo json_encode(['status' => 4]);
    } else if($condicion === 'CANSELADO'){
        echo json_encode(['status' => 5]);
    } else {
        echo json_encode(['status' => 3]);
    }
} else {
    ///lo bsucamos en el primer corte 
    $consulta->columns = array("a.nombre", "a.clave_sp", "a.rfc", "a.curp", "a.ley_adscripcion", "b.ADescripcion", "a.estatus");
    $consulta->where("clave_sp", "$clave_sp");
    $consulta->joinTables("cat_adscripcion as b", "a.ley_adscripcion = b.AClave", "INNER JOIN");
    $erroneo = $consulta->select("dt_sp_erroneosprimercorte as a");

    $leyII = substr($erroneo[0]['ley_adscripcion'],0,3);

    if (is_array($erroneo) && count($erroneo) > 0){
        

    // Consultar todos los cheques del servidor público (puede tener más de uno)
    $consulta->where("clave_sp", "$clave_sp");
    $cheques = $consulta->select("cat_cheques17"); // Esta función debería devolver un array con todos los cheques

    $condicion = $cheques[0]['condision'];
    
    if ($condicion === "PENDIENTE"){
        $consulta->where("clave", "$leyII");
        $unidad = $consulta->select("cat_adscripciones");
    
        // Combinar ambos resultados en un solo array
        $result = [
            'unidad' => $unidad,
            'status' => 2,  // Datos encontrados
            'erroneo' => $erroneo,
            'cheque' => $cheques  // Aquí debería estar enviando todos los cheques
        ];
        
        echo json_encode($result); 
    } else if($condicion === 'ENTREGADO')  {
        echo json_encode(['status' => 4]);
    } else if($condicion === 'CANSELADO'){
        echo json_encode(['status' => 5]);
    } else {
        echo json_encode(['status' => 3]);
    }

    }else {
        echo json_encode(['status' => 1]);// No hay datos en el array dt_sp_erroneos
    }
    
}
