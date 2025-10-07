<?php 

//del post sacamos las variables

$periodo = $_POST['periodo'] ?? '';
$anio    = $_POST['anio'] ?? '';
$adsc    = $_POST['adsc'] ?? '';
$clsp    = $_POST['clsp'] ?? '';

//funcion encargada de obtenrer el rango de fechas par adecidir el perido 
function rangoPorPeriodo($periodo, $anio) {
    // convertir a entero
    $p = intval($periodo);

    // mes: redondear hacia arriba (cada 2 periodos = 1 mes)
    $mes = ceil($p / 2);

    // determinar si es primera o segunda quincena
    $esPrimera = ($p % 2) != 0;

    // obtener días inicial y final
    $diaInicio = $esPrimera ? 1 : 16;
    $diaFin = $esPrimera ? 15 : cal_days_in_month(CAL_GREGORIAN, $mes, $anio);

    // formatear fechas
    $inicio = sprintf("%04d-%02d-%02d", $anio, $mes, $diaInicio);
    $fin    = sprintf("%04d-%02d-%02d", $anio, $mes, $diaFin);

    return [$inicio, $fin];
}

// --- Calcular el rango de fechas ---
list($inicio, $fin) = rangoPorPeriodo($periodo, $anio);

//switch que mandara segun las variables 
switch (true) {
    case ($periodo && $anio && !$adsc && !$clsp):
        // Solo periodo + año
        include 'DescarConstanciasZip/DescargaConstanciaPorPeriodo.php';
        break;

    case ($periodo && $anio && $adsc && !$clsp):
        // Periodo + año + adscripcion
        include 'DescarConstanciasZip/DescargaConstanciaPorPeriodoAdscripcion.php';
        break;

    case ($clsp):
        // Solo clave de servidor público
        include 'DescarConstanciasZip/DescargaConstanciaPorClsp.php';
        break;

    default:
        die(json_encode(['status'=>'error','msg'=>'Filtros inválidos']));
}