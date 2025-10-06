<?php
session_start();
global $CFG_HOST, $CFG_USER, $CFG_DBPWD, $CFG_DBASE,$CFG_TIPO,$__SESSION;
$tabla='';
if ($__SESSION->getValueSession('nomusuario') == "") {
    include_once("includes/sb_refresh.php");
} else {
    require_once('configuracion_sistema/configuracion.php');
    require_once('librerias/PDOConsultas.php');
    $tabla='';
    $consulta = new PDOConsultas();
    $consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0],$CFG_TIPO[0]);
    $query_tablas="SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA= '$CFG_DBASE[0]' ORDER BY TABLE_NAME ASC";
    $datos = $consulta->executeQuery($query_tablas);

    foreach ($datos as $key => &$val) {
        $tabla .= '<div class="col-sm-3">
                         <div "form-check form-check-inline">
                            <input class="form-check-input" id="' . $val['TABLE_NAME'] . '" type="checkbox" />
                            <label class="form-check-label" for="gridCheck1">
                               ' . $val['TABLE_NAME'] . '
                            </label>
                        </div>
                    </div>';
    }
?>
    <!-- Basic Checkbox start -->
    <section id="basic-checkbox">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><br><br><br><br><br>
                        <h4 class="card-title">SUGERENCIA DE MODULOS</h4>
                    </div>
                    <div class="card-body">
                        <div class="demo-inline-spacing">
                            <input class="form-control" id="seleccionados" type="hidden" name="data[seleccionados]" value="" placeholder="seleccionados" />
                            <?php
                            echo "" . $tabla;
                            ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div id="miiframe" name="miiframe" style="z-index:10;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $('input[type=checkbox]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#seleccionados').val("");
                    $('#seleccionados').val($('#seleccionados').val() + $(this).prop("id"));
                    sendRep2("formulario_sistema/formularios.php?");
                } else {

                }
            });
        });
    </script>
    <SCRIPT LANGUAGE="JavaScript">
        function sendRep2(valor) {
            var d = null;
            var cadena1 = '',
                xname = '',
                i, args = sendRep2.arguments;
            var cadena2 = '';
            var cadena = '';
            var chk = true;
            var chkStr = "chk";
            var chkCnt = 0;
            document.obj_retVal = false;
            cadena1 = args[0] + cadena;
            cadena1 += '&seleccionados=' + $('#seleccionados').val();
            openInIframe5(cadena1);
        }

        function openInIframe5(cadena1) {
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
    </SCRIPT>
<?php
}
