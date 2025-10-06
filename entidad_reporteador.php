<?php
global $__SESSION;
if ($__SESSION->getValueSession('nomusuario') == "") {
    include_once("configuracion_sistema/configuracion.php");
} else {
    include_once("configuracion_sistema/configuracion.php");
    include_once("librerias/PDOConsultas.php");
    $vars_post = '';
?>

            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<section style="height: 80px;"></section>
            <section class="bs-validation">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="report" id="report" value="">

                                <?php if($__SESSION->getValueSession('cveperfil') == 2 || $__SESSION->getValueSession('cveperfil') == 1): ?>
                                    <div class="col-md-4 mb-1">
                                        <select class="form-control" title="SELECCIONE" id="reporte" name="reporte">
                                            <option value="">-SELECCIONE UN REPORTE-</option>
                                            <option value="./reportes_sistema/vista_reporteadora.php?str_caso=1">ACTUALIZADOS</option>
                                            <option value="./reportes_sistema/vista_reporteadora.php?str_caso=2">PENDIENTES</option>
                                            <option value="./reportes_sistema/vista_reporteadora.php?str_caso=3">RECHAZADOS</option>
                                            <option value="./reportes_sistema/vista_reporteadora.php?str_caso=4">CONTEO ACTUALIZADOS POR UNIDAD</option>
                                            <option value="./reportes_sistema/vista_reporteadora.php?str_caso=5">CONTEO PENDIENTES POR UNIDAD</option>
                                            <option value="./reportes_sistema/vista_reporteadora.php?str_caso=6">CONTEO RECHAZADOS POR UNIDAD</option>
											<option value="./reportes_sistema/vista_reporteadora.php?str_caso=7">PROCESO INCONCLUSO</option>
											<option value="./reportes_sistema/vista_reporteadora.php?str_caso=8">CHEQUES ACTUALIZADOS</option>
                                            <option value="./reportes_sistema/vista_reporteadora.php?str_caso=9">CHEQUES RECHAZADOS</option>
                                            <option value="./reportes_sistema/vista_reporteadora.php?str_caso=10">CHEQUES PENDIENTES</option>
                                        </select>
                                    </div>                                    
                                <?php endif; ?>
                                <div class="col-md-4 mb-1">
                                    <div class="d-flex">
                                        <div class="ml-4">
                                            <?php if (isset($fileExcel) && $fileExcel): ?>
                                                <input type='button' style="background-color: #943c4f; border-color:#943c4f;" class='btn-primary' id='excel' name='submit' value='Generar Reporte' onclick="sendRep2()">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SESSION DE LOS DATOS DE LA SELECCION DEL REPORTE -->
                            <div class="row">
                                <?php echo "<div id=\"miiframe\" name=\"miiframe\" style=\"border: 1px solid #E0E4D1; z-index: 10; overflow: scroll; height: 630px;\"></div>"; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

<script nonce="RANDOM_VALUE" LANGUAGE="JavaScript">
    $(document).ready(function() {
    $("#reporte").change(function() {
        var repo = $("#reporte").val();
        $("#report").val(repo);
    });

    function validateSelection() {
        if ($("#reporte").val() == '') {
            Swal.fire({
                icon: 'error',
                title: '¡DEBE SELECCIONAR UNA OPCIÓN!',
            });
            return false;
        }
        return true;
    }

    $("#excel").click(function() {
        if (validateSelection()) {
            var rep = $("#report").val();
            sendRep2(rep);
        }
    });
});

function sendRep2(report) {
    var cadena1 = report;
    openInIframe5(cadena1);
}


function openInIframe5(cadena1) {
    $("#miiframe").css("overflow", "scroll");
    load_response('miiframe', cadena1);
}

function load_response(target, cadena1) {
    var myConnection = new XHConn();
    if (!myConnection)
        alert("XMLHTTP no esta disponible");
    var peticion = function(oXML) {
        $("#" + target).html(oXML.responseText);
    };
    var pars = cadena1.split('?');
    myConnection.connect(pars[0], "GET", pars[1], peticion);
}
</script>
<?php
}
?>