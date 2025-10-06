<?php
session_start();
include_once("../configuracion_sistema/configuracion.php");
include_once("../librerias/PDOConsultas.php");

$datos_organismo = new PDOConsultas();
$datos_organismo->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
         $campos = "cve_organismo, 
        abreviatura, 
        apellido_paterno, 
        apellido_materno,
        nombre,
        des_sexo,
        fecha_captura,
        des_profesion, 
        cve_plaza,
        num_empleado,
        issemym,
        rfc,
        puesto_funcional,
        codigo,
        cve_nivel,
        cve_rango,
        des_tipo_mando,
        des_tipoplaza,
        hora,
        des_sindicato,
        unidad_administrativa,
        cve_15_adscripcion,
        descripcion_organismo,
        fecha_inicio,
        fecha_fin,
        telefono,
        extension,
        des_estado_origen,
        des_municipio_origen,
        des_estado as des_estado_actual,
        des_municipio as des_municipio_actual,
        IF(cve_hijos=1,'SI','NO APLICA') AS cve_hijos,
        ine,
        curp";
        $tabla = " ";
        $tabla_join = " (
            SELECT 
            a.cve_organismo,c.abreviatura, m.des_tipoplaza, a.num_empleado, a.cve_plaza,b.apellido_paterno, b.apellido_materno,b.nombre,b.file_fotografia, c.des_organismo AS des_organismo_organismo, 
            c.cve_15 AS cve_15_organismo,d.descripcion_organismo,a.hora,a.codigo,a.cve_nivel,a.cve_rango,e.puesto_funcional,
            f.des_tipo_mando,c.des_organismo,g.unidad_administrativa,g.cve_15 AS cve_15_adscripcion,a.fecha_captura,
            a.fecha_inicio,a.fecha_fin,b.telefono,b.extension,hh.des_estado as des_estado_origen,
            ii.des_municipio AS des_municipio_origen,h.des_estado,i.des_municipio,b.domicilio_actulizado,
            b.rfc,b.ine,b.cve_hijos,b.issemym,l.des_sindicato,b.curp,j.des_sexo,k.des_profesion
            FROM 
            dt_plaza a
            LEFT JOIN sb_persona b ON (a.cve_persona=b.cve_persona )
            LEFT JOIN cat_organismo_aux c ON (a.cve_organismo=c.cve_organismo)
            LEFT JOIN cat_tipo_organismo d ON (a.cve_tipo_organismo=d.cve_tipo_organismo)
            LEFT JOIN cat_puesto e ON (a.cve_puesto=e.cve_puesto)
            LEFT JOIN cat_tipo_mando f ON (a.cve_tipo_mando=f.cve_tipo_mando)
            LEFT JOIN cat_adscripciones g ON (a.cve_ads=g.cve_ads AND a.cve_organismo=g.cve_organismo)
            LEFT JOIN cat_estado h ON (b.cve_estado_actual=h.cve_estado)
            LEFT JOIN cat_municipio i ON (b.cve_municipio_actual=i.cve_municipio  
                        AND i.cve_estado=h.cve_estado AND b.cve_estado_actual=h.cve_estado)
            LEFT JOIN cat_estado hh ON (b.cve_estado_origen=hh.cve_estado)
            LEFT JOIN cat_municipio ii ON (b.cve_municipio_origen=ii.cve_municipio  
                        AND ii.cve_estado=hh.cve_estado AND b.cve_estado_origen=hh.cve_estado)			
            LEFT JOIN cat_sexo j ON b.cve_sexo=j.cve_sexo
            LEFT JOIN cat_profesion k ON b.cve_profesion=k.cve_profesion
            LEFT JOIN cat_sidicato l ON a.cve_sindicato=l.cve_sindicato
            LEFT JOIN cat_tipoplaza m ON a.cve_tipoplaza=m.cve_tipoplaza
            WHERE a.cve_tipoplaza=1 AND a.cve_tipo_organismo=1
            UNION 
            SELECT 
            a.cve_organismo,c.abreviatura, m.des_tipoplaza,a.num_empleado,a.cve_plaza,b.apellido_paterno, b.apellido_materno,b.nombre,b.file_fotografia, c.des_organismo AS des_organismo2,
            c.cve_15,d.descripcion_organismo,a.hora,a.codigo,a.cve_nivel,a.cve_rango,ee.categoria,f.des_tipo_mando,
            c.des_organismo,g.unidad_administrativa,g.cve_15,a.fecha_captura,a.fecha_inicio,a.fecha_fin,
            b.telefono,b.extension,hh.des_estado,ii.des_municipio,h.des_estado,i.des_municipio,b.domicilio_actulizado,
            b.rfc,b.ine,b.cve_hijos,b.issemym,l.des_sindicato,b.curp,j.des_sexo,k.des_profesion
            FROM 
            dt_plaza a
            LEFT JOIN sb_persona b ON (a.cve_persona=b.cve_persona )
            LEFT JOIN cat_organismo_aux c ON (a.cve_organismo=c.cve_organismo)
            LEFT JOIN cat_tipo_organismo d ON (a.cve_tipo_organismo=d.cve_tipo_organismo)
            LEFT JOIN cat_contratos ee ON (a.cve_puesto=ee.cve_contrato)
            LEFT JOIN cat_tipo_mando f ON (a.cve_tipo_mando=f.cve_tipo_mando)
            LEFT JOIN cat_adscripciones g ON (a.cve_ads=g.cve_ads AND a.cve_organismo=g.cve_organismo)
            LEFT JOIN cat_estado h ON (b.cve_estado_actual=h.cve_estado)
            LEFT JOIN cat_municipio i ON (b.cve_municipio_actual=i.cve_municipio  
                        AND i.cve_estado=h.cve_estado AND b.cve_estado_actual=h.cve_estado)
            LEFT JOIN cat_estado hh ON (b.cve_estado_origen=hh.cve_estado)
            LEFT JOIN cat_municipio ii ON (b.cve_municipio_origen=ii.cve_municipio  
                        AND ii.cve_estado=hh.cve_estado AND b.cve_estado_origen=hh.cve_estado)			
            LEFT JOIN cat_sexo j ON b.cve_sexo=j.cve_sexo
            LEFT JOIN cat_profesion k ON b.cve_profesion=k.cve_profesion
            LEFT JOIN cat_sidicato l ON a.cve_sindicato=l.cve_sindicato
            LEFT JOIN cat_tipoplaza m ON a.cve_tipoplaza=m.cve_tipoplaza
            WHERE (a.cve_tipoplaza=2 OR a.cve_tipoplaza=3) 
            UNION
            SELECT 
            a.cve_organismo,c.abreviatura, m.des_tipoplaza,a.num_empleado,a.cve_plaza,b.apellido_paterno, b.apellido_materno,b.nombre,b.file_fotografia, c.des_organismo AS des_organismo_organismo, 
            c.cve_15 AS cve_15_organismo,d.descripcion_organismo,a.hora,a.codigo,a.cve_nivel,a.cve_rango,e.puesto_funcional,
            f.des_tipo_mando,c.des_organismo,g.unidad_administrativa,g.cve_15 AS cve_15_adscripcion,a.fecha_captura,
            a.fecha_inicio,a.fecha_fin,b.telefono,b.extension,hh.des_estado as des_estado_origen,
            ii.des_municipio AS des_municipio_origen,h.des_estado,i.des_municipio,b.domicilio_actulizado,
            b.rfc,b.ine,b.cve_hijos,b.issemym,l.des_sindicato,b.curp,j.des_sexo,k.des_profesion
            FROM 
            dt_plaza a
            LEFT JOIN sb_persona b ON (a.cve_persona=b.cve_persona )
            LEFT JOIN cat_organismo_aux c ON (a.cve_organismo=c.cve_organismo)
            LEFT JOIN cat_tipo_organismo d ON (a.cve_tipo_organismo=d.cve_tipo_organismo)
            LEFT JOIN cat_tabuladoreducacion e ON (a.cve_puesto=e.cve_tabuladoreducacion)
            LEFT JOIN cat_tipo_mando f ON (a.cve_tipo_mando=f.cve_tipo_mando)
            LEFT JOIN cat_adscripciones g ON (a.cve_ads=g.cve_ads AND a.cve_organismo=g.cve_organismo)
            LEFT JOIN cat_estado h ON (b.cve_estado_actual=h.cve_estado)
            LEFT JOIN cat_municipio i ON (b.cve_municipio_actual=i.cve_municipio  
                        AND i.cve_estado=h.cve_estado AND b.cve_estado_actual=h.cve_estado)
            LEFT JOIN cat_estado hh ON (b.cve_estado_origen=hh.cve_estado)
            LEFT JOIN cat_municipio ii ON (b.cve_municipio_origen=ii.cve_municipio  
                        AND ii.cve_estado=hh.cve_estado AND b.cve_estado_origen=hh.cve_estado)			
            LEFT JOIN cat_sexo j ON b.cve_sexo=j.cve_sexo
            LEFT JOIN cat_profesion k ON b.cve_profesion=k.cve_profesion
            LEFT JOIN cat_sidicato l ON a.cve_sindicato=l.cve_sindicato
            LEFT JOIN cat_tipoplaza m ON a.cve_tipoplaza=m.cve_tipoplaza
            WHERE a.cve_tipoplaza=1 AND a.cve_tipo_organismo=3
            UNION 
            SELECT 
            a.cve_organismo,c.abreviatura, m.des_tipoplaza,a.num_empleado,a.cve_plaza,b.apellido_paterno, b.apellido_materno,b.nombre,b.file_fotografia, c.des_organismo AS des_organismo_organismo, 
            c.cve_15 AS cve_15_organismo,d.descripcion_organismo,a.hora,a.codigo,a.cve_nivel,a.cve_rango,
            e.puesto_funcional,f.des_tipo_mando,c.des_organismo,g.unidad_administrativa,g.cve_15 AS cve_15_adscripcion,
            a.fecha_captura,a.fecha_inicio,a.fecha_fin,b.telefono,b.extension,hh.des_estado as des_estado_origen,
            ii.des_municipio AS des_municipio_origen,h.des_estado,i.des_municipio,b.domicilio_actulizado,b.rfc,b.ine,b.cve_hijos,
            b.issemym,l.des_sindicato,b.curp,j.des_sexo,k.des_profesion
            FROM 
            dt_plaza a
            LEFT JOIN sb_persona b ON (a.cve_persona=b.cve_persona )
            LEFT JOIN cat_organismo_aux c ON (a.cve_organismo=c.cve_organismo)
            LEFT JOIN cat_tipo_organismo d ON (a.cve_tipo_organismo=d.cve_tipo_organismo)
            LEFT JOIN cat_tabuladormedica e ON (a.cve_puesto=e.cve_tabuladormedica)
            LEFT JOIN cat_tipo_mando f ON (a.cve_tipo_mando=f.cve_tipo_mando)
            LEFT JOIN cat_adscripciones g ON (a.cve_ads=g.cve_ads AND a.cve_organismo=g.cve_organismo)
            LEFT JOIN cat_estado h ON (b.cve_estado_actual=h.cve_estado)
            LEFT JOIN cat_municipio i ON (b.cve_municipio_actual=i.cve_municipio  
                        AND i.cve_estado=h.cve_estado AND b.cve_estado_actual=h.cve_estado)
            LEFT JOIN cat_estado hh ON (b.cve_estado_origen=hh.cve_estado)
            LEFT JOIN cat_municipio ii ON (b.cve_municipio_origen=ii.cve_municipio  
                        AND ii.cve_estado=hh.cve_estado AND b.cve_estado_origen=hh.cve_estado)			
            LEFT JOIN cat_sexo j ON b.cve_sexo=j.cve_sexo
            LEFT JOIN cat_profesion k ON b.cve_profesion=k.cve_profesion
            LEFT JOIN cat_sidicato l ON a.cve_sindicato=l.cve_sindicato
            LEFT JOIN cat_tipoplaza m ON a.cve_tipoplaza=m.cve_tipoplaza
            WHERE a.cve_tipoplaza=1 AND a.cve_tipo_organismo=2) AS CONCENTRADO_PLAZAS ";
        $strWhere = "";
        $cadena_busqueda = "";

   $query_principal = "SELECT " . $campos . " FROM " . $tabla . " " . $tabla_join . " " . $strWhere . " " . $cadena_busqueda;
echo $query_principal;
die("fdsa");
$res_datos_organismo =$datos_organismo->executeQuery($query_principal);

$vector_campos = array_keys($res_datos_organismo[0]);

//print_r($vector_campos);

$JSONDATOS="{\"data\": ".$datos_organismo->arrayToJson($res_datos_organismo)."}";

// https://parzibyte.me/blog
$nombreArchivo = "../app-assets/data/reporte.json";
$archivo = fopen($nombreArchivo, "w");
fwrite($archivo, $JSONDATOS);
fclose($archivo);

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
                    <a href="C:\wamp64\www\plantilla\reportes_sistema\excel\index.php" target="_blank"><img src="./imagenes_sistema/excel_reporte.png" width="25px"></a>
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
<script src="./app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
<script src="./app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
<script src="./app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
<script src="./app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js"></script>
<script src="./app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Page JS-->
<!--<script src="./tabla_datos/table-datatables-advanced.js"></script>-->
<!-- END: Page JS-->
<script>
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
