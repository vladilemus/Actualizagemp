<?php
session_start();
include_once("../configuracion_sistema/configuracion.php");
include_once("../librerias/PDOConsultas.php");
global $NOMBRE_CARPETA_PRINCIPAL;
////[str_caso] => 1 [tipo] => ./reportes_sistema/vista_reporteadora.php
$datos_query = new PDOConsultas();
$datos_query->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
//CREAMOS EL OBJETO DE LAS CONSULTAS
$campos = "";
$tabla = " ";
$tabla_join = "";
$strWhere = "";
$cadena_busqueda = "";
$query_principal = "";

$cveusuarioase = $__SESSION->getValueSession('cveusuario');

switch ($_GET['str_caso']) {
// $campos es igual a SELECT
// $tabla_join es igual a from 
// $strware es igual a un ware 
    case 1:

        $campos = "a.clave_sp AS \"CLAVE DE SERVIDOR\",
                    a.rfc AS \"RFC\",
                    a.nombre AS \"NOMBRE\",
					a.curp as \"CURP\",
					a.codigo_post as \"CODIGO POSTAL\",
                    a.fecha_captura as \"FECHA DE CAPTURA\",
                    b.ley_adscripcion as \"ADSCRIPCIÓN\",
                    a.estatus AS \"ESTATUS\",
					a.comentarios AS \"COMENTARIOS\"";
        $tabla = "det_peticiones a";
        $tabla_join = "left join dt_sp_erroneos b ON (a.clave_sp = b.clave_sp)";
        $strWhere = "WHERE a.estatus='ACTUALIZADO'";

        break;
    case 2:
        $campos = "a.clave_sp AS \"CLAVE DE SERVIDOR\",
                    a.rfc AS \"RFC\",
                    a.nombre AS \"NOMBRE\",
					a.curp as \"CURP\",
					a.codigo_post as \"CODIGO POSTAL\",
                    a.fecha_captura as \"FECHA DE CAPTURA\",
                    b.ley_adscripcion as \"ADSCRIPCIÓN\",
                    a.estatus AS \"ESTATUS\",
					a.comentarios AS \"COMENTARIOS\"";
        $tabla = "det_peticiones a";
        $tabla_join = "left join dt_sp_erroneos b ON (a.clave_sp = b.clave_sp)";
        $strWhere = "WHERE a.estatus='PENDIENTE'";
        break;
    case 3:
        $campos = "a.clave_sp AS \"CLAVE DE SERVIDOR\",
        a.rfc AS \"RFC\",
        a.nombre AS \"NOMBRE\",
		a.curp as \"CURP\",
		a.codigo_post as \"CODIGO POSTAL\",
        a.fecha_captura as \"FECHA DE CAPTURA\",
        b.ley_adscripcion as \"ADSCRIPCIÓN\",
        a.estatus AS \"ESTATUS\",
		a.comentarios AS \"COMENTARIOS\"";
        $tabla = "det_peticiones a";
        $tabla_join = "left join dt_sp_erroneos b ON (a.clave_sp = b.clave_sp)";
        $strWhere = "WHERE a.estatus='RECHAZADO'";
        break;
    case 4:
		$campos = "
        c.clave AS \"CLAVE\",
        c.ley_ads AS \"ADSCRIPCIÓN\",
        REP.cantidad AS \"CANTIDAD\"
        ";
        $tabla = "(
            SELECT
                SUBSTRING(d.ley_adscripcion, 1, 3) AS clave,
                count(*) AS cantidad
            FROM
                dt_sp_erroneos d
            WHERE
                d.clave_sp IN (
                    SELECT p.clave_sp
                    FROM det_peticiones p
                    WHERE p.estatus = 'ACTUALIZADO'
                )
            GROUP BY
                SUBSTRING(d.ley_adscripcion, 1, 3)
        ) AS REP";
        
        $tabla_join = "LEFT JOIN cat_adscripciones c ON REP.clave = c.clave";
        

        break;
        case 5:
            $campos = "
            c.clave AS \"CLAVE\",
            c.ley_ads AS \"ADSCRIPCIÓN\",
            REP.cantidad AS \"CANTIDAD\"
            ";
            $tabla = "(
                SELECT
                    SUBSTRING(d.ley_adscripcion, 1, 3) AS clave,
                    count(*) AS cantidad
                FROM
                    dt_sp_erroneos d
                WHERE
                    d.clave_sp IN (
                        SELECT p.clave_sp
                        FROM det_peticiones p
                        WHERE p.estatus = 'PENDIENTE'
                    )
                GROUP BY
                    SUBSTRING(d.ley_adscripcion, 1, 3)
            ) AS REP";
            
            $tabla_join = "LEFT JOIN cat_adscripciones c ON REP.clave = c.clave";
            
    
            break;
            case 6:
                $campos = "
                c.clave AS \"CLAVE\",
                c.ley_ads AS \"ADSCRIPCIÓN\",
                REP.cantidad AS \"CANTIDAD\"
                ";
                $tabla = "(
                    SELECT
                        SUBSTRING(d.ley_adscripcion, 1, 3) AS clave,
                        count(*) AS cantidad
                    FROM
                        dt_sp_erroneos d
                    WHERE
                        d.clave_sp IN (
                            SELECT p.clave_sp
                            FROM det_peticiones p
                            WHERE p.estatus = 'RECHAZADO'
                        )
                    GROUP BY
                        SUBSTRING(d.ley_adscripcion, 1, 3)
                ) AS REP";
                
                $tabla_join = "LEFT JOIN cat_adscripciones c ON REP.clave = c.clave";
                
        
                break;
				case 7:
                    $campos = "a.*";
                    $tabla = "det_correo a";
                    $strWhere = "WHERE a.clave_sp NOT IN (SELECT clave_sp FROM det_peticiones)";
                break;
				case 8:
                    $campos = "
                        a.clave_sp AS \"CLAVE\",
                        a.Nombre_SP AS \"NOMBRE\",
                        a.Numero_Cheque AS \"NÚMERO CHEQUE\",
                        IF(b.estatus IS NULL, 'NO ENCONTRADO EN EXCEL ORIGINAL', b.estatus) AS \"ESTATUS\",
                        IF(b.comentarios IS NULL, 'NO ENCONTRADO EN EXCEL ORIGINAL', b.comentarios) AS \"COMENTARIOS\"
                    ";

                    $tabla = "cat_cheques a";

                    $tabla_join ="LEFT JOIN det_peticiones b ON a.Clave_SP = b.clave_sp";

                    $strWhere = "WHERE b.estatus='ACTUALIZADO'";

                    break;
                    case 9:
                        $campos = "
                            a.clave_sp AS \"CLAVE\",
                            a.Nombre_SP AS \"NOMBRE\",
                            a.Numero_Cheque AS \"NÚMERO CHEQUE\",
                            IF(b.estatus IS NULL, 'NO ENCONTRADO EN EXCEL ORIGINAL', b.estatus) AS \"ESTATUS\",
                            IF(b.comentarios IS NULL, 'NO ENCONTRADO EN EXCEL ORIGINAL', b.comentarios) AS \"COMENTARIOS\"
                        ";
    
                        $tabla = "cat_cheques a";

                        $tabla_join ="LEFT JOIN det_peticiones b ON a.Clave_SP = b.clave_sp";
    
                        $strWhere = "WHERE b.estatus='RECHAZADO'";
    
                        break;
                    
                            case 10:
                                $campos = "
                                    a.clave_sp AS \"CLAVE\",
                                    a.Nombre_SP AS \"NOMBRE\",
                                    a.Numero_Cheque AS \"NÚMERO CHEQUE\",
                                    IF(b.estatus IS NULL, 'NO ENCONTRADO EN EXCEL ORIGINAL', b.estatus) AS \"ESTATUS\",
                                    IF(b.comentarios IS NULL, 'NO ENCONTRADO EN EXCEL ORIGINAL', b.comentarios) AS \"COMENTARIOS\"
                                ";
            
                                $tabla = "cat_cheques a";

                                $tabla_join ="LEFT JOIN det_peticiones b ON a.Clave_SP = b.clave_sp";
            
                                $strWhere = "WHERE b.estatus='PENDIENTE'";
            
                                break;
    default:
        die("NO SE ENCOTTRO ALGUNA COINCIDENCIA");
}

$query_principal = "SELECT " . $campos . " FROM " . $tabla . " " . $tabla_join . " " . $strWhere . " " . $cadena_busqueda;
$resultado_query = $datos_query->executeQuery($query_principal);
//ECHO($query_principal);
//var_dump($resultado_query);

if (!$resultado_query || count($resultado_query) == 0){
    echo '<h1>NO SE ENCONTRARON RESULTADOS</h1>';
} else {
    
$vector_campos = array_keys($resultado_query[0]);

$JSONDATOS = "{\"data\": " . $datos_query->arrayToJson($resultado_query) . "}";

// https://parzibyte.me/blog
$nombreArchivo = "../app-assets/data/reporte.json";
$archivo = fopen($nombreArchivo, "w");
fwrite($archivo, $JSONDATOS);
fclose($archivo);
}


?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="./app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/themes/semi-dark-layout.css">

    <link rel="stylesheet" type="text/css" href="./app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="">
<!-- Column Search -->
<section id="column-search-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable">
                    <!--LINEA DEL BOTON QUE LO TRANSFORMA A EXCEL-->
                    <a href="../<?=$NOMBRE_CARPETA_PRINCIPAL?>/reportes_sistema/excel/descarga_excel.php"><img src="./imagenes_sistema/excel_reporte.png" width="25px"></a>
                    <table class="dt-column-search table table-responsive">
                        <thead>
                        <tr>
                            <?php
                            foreach ($vector_campos as $encabezado) {
                                echo '<th>' . $encabezado . '</th>';
                            }
                            ?>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <?php
                            foreach ($vector_campos as $encabezado) {
                                echo '<th>' . $encabezado . '</th>';
                            }
                            ?>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ Column Search -->
<!-- END: Content-->
<!-- BEGIN: Page Vendor JS-->
<script nonce="RANDOM_VALUE" src="./app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
<script nonce="RANDOM_VALUE" src="./app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
<script nonce="RANDOM_VALUE" src="./app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
<script nonce="RANDOM_VALUE" src="./app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js"></script>
<script nonce="RANDOM_VALUE" src="./app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Page JS-->
<!--<script src="./tabla_datos/table-datatables-advanced.js"></script>-->
<!-- END: Page JS-->
<script nonce="RANDOM_VALUE">
    /**
     * DataTables Advanced
     */

    'use strict';

    // Advance filter function
    // We pass the column location, the start date, and the end date
    var filterByDate = function (column, startDate, endDate) {
        // Custom filter syntax requires pushing the new filter to the global filter array
        $.fn.dataTableExt.afnFiltering.push(function (oSettings, aData, iDataIndex) {
            var rowDate = normalizeDate(aData[column]),
                start = normalizeDate(startDate),
                end = normalizeDate(endDate);
            // If our date from the row is between the start and end
            if (start <= rowDate && rowDate <= end) {
                return true;
            } else if (rowDate >= start && end === '' && start !== '') {
                return true;
            } else if (rowDate <= end && start === '' && end !== '') {
                return true;
            } else {
                return false;
            }
        });
    };

    // converts date strings to a Date object, then normalized into a YYYYMMMDD format (ex: 20131220). Makes comparing dates easier. ex: 20131220 > 20121220
    var normalizeDate = function (dateString) {
        var date = new Date(dateString);
        var normalized =
            date.getFullYear() + '' + ('0' + (date.getMonth() + 1)).slice(-2) + '' + ('0' + date.getDate()).slice(-2);
        return normalized;
    };
    // Advanced Search Functions Ends

    $(function () {
        var isRtl = $('html').attr('data-textdirection') === 'rtl';

        var dt_ajax_table = $('.datatables-ajax'),
            dt_filter_table = $('.dt-column-search'),
            dt_adv_filter_table = $('.dt-advanced-search'),
            dt_responsive_table = $('.dt-responsive'),
            assetPath = 'app-assets/';

        if ($('body').attr('data-framework') === 'laravel') {
            assetPath = $('body').attr('data-asset-path');
        }

        // Ajax Sourced Server-side
        // --------------------------------------------------------------------

        if (dt_ajax_table.length) {
            var dt_ajax = dt_ajax_table.dataTable({
                processing: true,
                dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                ajax: assetPath + 'data/ajax.php',
                language: {
                    paginate: {
                        // remove previous & next text from pagination
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    }
                }
            });
        }

        // Column Search
        // --------------------------------------------------------------------

        if (dt_filter_table.length) {
            // Setup - add a text input to each footer cell
            $('.dt-column-search thead tr').clone(true).appendTo('.dt-column-search thead');
            $('.dt-column-search thead tr:eq(1) th').each(function (i) {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control form-control-sm"  />');
                $('input', this).on('keyup change', function () {
                    if (dt_filter.column(i).search() !== this.value) {
                        dt_filter.column(i).search(this.value).draw();
                    }
                });
            });

            var dt_filter = dt_filter_table.DataTable({
                ajax: assetPath + 'data/reporte.json',
                columns: [
                    <?php
                    foreach ($vector_campos as $encabezado) {
                        // Si el número actual no es el último, agregamos una coma
                        if ($encabezado !== end($vector_campos)) {
                            echo "{ data:'" . $encabezado . "'},";
                        } else {
                            echo "{ data:'" . $encabezado . "'}";
                        }
                    }
                    ?>
                ],
                dom: '<"d-flex justify-content-between align-items-center mx-0 row">t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                orderCellsTop: true,
                language: {
                    paginate: {
                        // remove previous & next text from pagination
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    }
                }
            });
        }

        // on key up from input field
        $('input.dt-input').on('keyup', function () {
            filterColumn($(this).attr('data-column'), $(this).val());
        });

        // Filter form control to default size for all tables
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm').removeClass('form-control-sm');
    });

</script>
</body>
<!-- END: Body-->
</html>

