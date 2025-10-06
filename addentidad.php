<?php
//@CHRISTOPHER DELGADILLO RAMIREZ GENERADOR DE FORMULARIOS DE MANERA RECURSIVA
///EN ESTA PARTE NO REQUIERE EL INICIO DE LA SESSION YA QUE SE ENCUENTRA IMPORTADO DESDE LA ENTIDAD PRINCIPAL
///IMPORTACION DE LA CLASE DE LAS CONSULTAS
global $CFG_HOST, $CFG_USER, $CFG_DBPWD, $CFG_DBASE, $CFG_TIPO, $tabla_join, $tabla,$entidad;
$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

//SI LA TABLA CONTIENE UN ALIAS SE EXTRAE EL ALIAS MEDIANTE LA SEPARACION POR ESPACIO
if ($tabla_join != '') {
    //FAVOR DE RESPETAR EL ESPACIO EN LA TABLA
    if (isset($str_union_tabla)) {
    } else {
        $vector_tabla = explode(' ', $tabla);
        $tabla = $vector_tabla[0];
    }
}
/////FIN DE LA TABLA JOIN
?>

<!-- Core CSS -->
<link rel="stylesheet" href="assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<!-- <link href="css_sistema/estilo.css" rel="stylesheet" type="text/css" /> -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"> </h4>
    <div class="row">
        <!-- FormValidation -->
        <div class="col-12">
            <div class="card">
                <?php
                    echo "<form class\"needs-validation\" action=\"return false;\" method=post name=\"formulario_origen\" enctype=\"multipart/form-data\" id=\"formulario_origen\">";
                    ?>
                    <!-- <div class="card-header encabezado" style="position:fixed;margin-top:0px;margin-left:0px; font-family: Arial;width:50%;height:17%;background: rgba(255, 255, 255,1);z-index:999;border-radius:0px;"> -->
                <div class="row">
                    <h4 class="fw-bold py-3 mb-4"></h4>
                    <div class="col-1">
                        <a href="<?= $_SERVER['HTTP_REFERER'] ?>"><img src="imagenes_sistema/atras.png"
                                                                       alt="ATRAS"
                                                                       title="PAGINA ANTERIOR"
                                                                       width='35px'></a>
                    </div>
                    <div class="col-8" style="text-align: left;">
                        <h4 class="card-title"><b><?= $entidad ?></b><small><font color="#F40000">Los datos (*) son obligatorios</font></small></h4>
                    </div>
                    <div class="col-2">
                        <?= "<button class=\"btn btn-primary  type=\"submit\" id=\"btn_envia_datos\">" . $btn_guardar . "</button>";?>
                    </div>
                </div>
                    <!-- <div class="card-body" style="margin-top:12%;margin-left:0px;"> -->
                    <div class="card-body">
                        <?php
                        $str_nuevo = "";
                        $str_nuevo .= "<input type=\"text\" id=\"opc\" name=\"opc\" value=\"2\" hidden=\"true\">";
                        $str_nuevo .= "<input type=\"text\" id=\"tabla\" name=\"tabla\" value=\"" . $tabla . "\" hidden=\"true\">";
                        $str_nuevo .= "<input type=\"text\" id=\"mod\" name=\"mod\" value=\"" . $_SESSION[_CFGSBASE]['mod'] . "\" hidden=\"true\">";
                        if (isset($_GET['pila'])) {
                            $str_nuevo .= "<input type=\"text\" id=\"pila\" name=\"pila\" value=\"" . $_GET['pila'] . "\" hidden=\"true\">";
                        } else {
                            $str_nuevo .= "<input type=\"text\" id=\"pila\" name=\"pila\" value=\"0\" hidden=\"true\">";
                        }
                        if (isset($str_ruta_include) || strlen($str_ruta_include) > 4) {
                            $str_nuevo .= "<input type=\"text\" id=\"ruta\" name=\"ruta\" value=\"" . $str_ruta_include . "\" hidden=\"true\">";
                        } else {
                            $str_nuevo .= "<input type=\"text\" id=\"ruta\" name=\"ruta\" value=\"0\" hidden=\"true\">";
                        }
                        $str_nuevo .= "<input type=\"text\" id=\"carpetageneral\" name=\"carpetageneral\" value=\"" . $NOMBRE_CARPETA_PRINCIPAL . "\" hidden=\"true\">";
                        $str_nuevo .= "<input type=\"text\" id=\"btnAdd\" name=\"btnAdd\" value=\"btnAdd\" hidden=\"true\">";
                        echo $str_nuevo;
                        //SECCION DEL CICLADO DE LOS FORMULARIOS VERSION 1
                        $formulario_cuerpo = "";
                        $cambia_separador = -1;
                        $separador_acumulado = 0;
                        $estructura_formulario = "";
                        $leyenda_obligatoria = "";

                        //print_r($field);

                        foreach ($field as $key => &$val) {

                            /************************************SECCION DE LOS SEPARADORES************************************************/
                            $contenido = '';
                            $estructura_formulario = "";
                            $pinta_separador = "";
                            $coleccion_atributos = '';
                            $leyenda_obligatoria = "";
                            //SECCION DE CAMBIA SEPARADOR DEACUERDO AL ARRAY DE LOS PESOS
                            if ($cambia_separador != $val[7][0]) {
                                $estructura_formulario = "";
                                $cambia_separador = $val[7][0];
                                $separador_acumulado = 0;
                                $separador_acumulado += $val[7][1];
                                $pinta_separador = '<div style="color: #AF9494; background-color: #f1f0fb ; width: 100%;" >' . $separadores[$cambia_separador] . '</div>';
                                $estructura_formulario .= '<div class="row">';
                                $estructura_formulario .= $pinta_separador . '<div class="form-group col-md-' . $val[7][1] . '">';
                            } else {
                                $separador_acumulado += $val[7][1];
                                if ($separador_acumulado < 13) {
                                    $estructura_formulario .= '<div class="form-group col-md-' . $val[7][1] . '">';
                                } else {
                                    $separador_acumulado = 0;
                                    $separador_acumulado += $val[7][1];
                                    $estructura_formulario .= '<div class="row">';
                                    $estructura_formulario .= '<div class="form-group col-md-' . $val[7][1] . '">';
                                }
                            }
                            //IDENTIFICACION DE LA LLAVE PRICIPAL DE LA BASE DE DATOS
                            if ($id_prin == $val[0]) {
                                $campos[] = $val[0];
                            } else {
                                $campos[] = $val[0];
                            }

                            //ESTA SERA LA SECCION DE LOS PESOS
                            // la condicion de si el campo es obligatorio
                            if ($val[5] == 'date') {
                                $fid[] = $val[0];
                            }
                            // if ($val[5] == 'date') {
                            //     $fid[] = $val[0];
                            // }
                            if ($val[2] == "HIDDEN") {
                                $hidden = "hidden=\"true\"";
                                //$required = "";
                            } else {
                                $hidden = "";
                            }
                            if ($val[4] == "OBLIGATORIO") {
                                $required = "required=\"required\"";
                                $leyenda_obligatoria = "<font color=\"#F40000\"> * </font>";
                            } else {
                                $required = "";
                            }
                            if (strlen($val[9]) > 0 && $val[9] != '') {
                                $DATO_PREDEFINIDO = " value='" . $val[9] . "'";
                            } else {
                                $DATO_PREDEFINIDO = '';
                            }
                            if (count($val[10]) > 0) {
                                for ($patributos = 0; $patributos < count($val[10]); $patributos++) {
                                    $coleccion_atributos .= ' ' . $val[10][$patributos][0] . '="' . $val[10][$patributos][1] . '" ';
                                }
                            }
                            //////PARA LA OPCION DE LOS ATRIBUTTOS DEBE DE SER MAYOR A UNO YA QUE ESTA ESPECIFICANDO UN VALOR VACIO
                            switch ($val[3]) {
                                case "select":
                                   // print_r($valselect);die();
                                    //SECCION QUE CACHA SI EL SELECT ES EN CASCADA@si FUNCIONA NO LE MUEVAS
                                    if (isset($select_cascada) && count($select_cascada) > 0) {

                                        if ($val[0] == $select_cascada[0]['destino']) {

                                            $contenidoselect = '';
                                            $punteroselect = 0;
                                            $contenido .= '                               
                                                                            <label for="' . $val[0] . '" ' . $hidden . '><b>' . $val[1] . '</b>' . $leyenda_obligatoria . '<small style="color:#c4c4c4;">' . $val[11] . '</small></label>  
                                                                            <select  class="form-select" id="' . $val[0] . '" ' . $required . '>                                                                                
                                                                            </select>';
                                        } else {
                                            $contenidoselect = '';
                                            $punteroselect = 0;
                                            foreach ($val[6] as $keyselect => &$valselect) {
                                                $contenidoselect .= '<option value="' . $valselect[0] . '">' . $valselect[1] . '</option>';
                                            }
                                            $contenido .= '                                                
                                                                            <label for="' . $val[0] . '" ' . $hidden . '><b>' . $val[1] . '</b>' . $leyenda_obligatoria . '<small style="color:#c4c4c4;">' . $val[11] . '</small></label> 
                                                                            <select   class="form-select" id="' . $val[0] . '" ' . $required . '>
                                                                            ' . $contenidoselect . '
                                                                            </select>';
                                        }
                                    } else {

                                        $contenidoselect = '';
                                        $punteroselect = 0;
                                        foreach ($val[6] as $keyselect => &$valselect) {
                                            $contenidoselect .= '<option value="' . $valselect[0] . '">' . $valselect[1] . '</option>';
                                        }
                                        $contenido .= ' 
                                                        <label class="form-label" for="' . $val[0] . '" ' . $hidden . '><b>' . $val[1] . '</b>' . $leyenda_obligatoria . '<small style="color:#c4c4c4;">' . $val[11] . '</small></label>
                                                        <select class="form-select" id="' . $val[0] . '" ' . $required . '>
                                                            <option value="">-SELECCIONE-</option>
                                                            ' . $contenidoselect . '
                                                        </select>
                                                        <div class="valid-feedback">Looks good!</div>
                                                        <div class="invalid-feedback">Please select your country</div>
                                                        ';
                                    }
                                    break;

                                case "text":
                                    $contenido .= '                           
                                                        <label for="' . $val[0] . '" ' . $hidden . '><b>' . $val[1] . '</b>' . $leyenda_obligatoria . '<small style="color:#c4c4c4;">' . $val[11] . '</small></label>                                        
                                                        <input class="form-control form-control-rounded" id="' . $val[0] . '"  ' . $DATO_PREDEFINIDO . $coleccion_atributos . ' type="' . $val[3] . '" ' . $hidden . ' placeholder="' . $val[1] . '" ' . $required . '/>                           
                                                        ';
                                    break;

                                case "number":
                                    $contenido .= '                           
                                                            <label for="' . $val[0] . '" ' . $hidden . '><b>' . $val[1] . '</b>' . $leyenda_obligatoria . '<small style="color:#c4c4c4;">' . $val[11] . '</small></label> 
                                                            <input class="form-control form-control-rounded" id="' . $val[0] . '" ' . $DATO_PREDEFINIDO . $coleccion_atributos . ' type="' . $val[3] . '" ' . $hidden . ' placeholder="' . $val[1] . '" ' . $required . '/>                           
                                                            ';
                                    break;

                                case "date":
                                    $contenido .= '                           
                                                            <label for="' . $val[0] . '" ' . $hidden . '><b>' . $val[1] . '</b>' . $leyenda_obligatoria . '<small style="color:#c4c4c4;">' . $val[11] . '</small></label> 
                                                            <input  class="form-control flatpickr-basic" id="' . $val[0] . '" ' . $DATO_PREDEFINIDO . $coleccion_atributos . ' type="text" ' . $hidden . ' placeholder="AÑO-MES-DIA" ' . $required . '/>                           
                                                            ';
                                    break;

                                case "checkbox":
                                    $contenido .= ' 
                                                        <div class="demo-inline-spacing">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" ' . $hidden . ' id="' . $val[0] . '" ' . $DATO_PREDEFINIDO . $coleccion_atributos . $required . ' />
                                                                <label for="' . $val[0] . '" ' . $hidden . '><b>' . $val[1] . '</b>' . $leyenda_obligatoria . '<small style="color:#c4c4c4;">' . $val[11] . '</small></label> 
                                                            </div>
                                                        </div>                               
                                                                ';
                                    break;

                                case "radio":
                                    $contenido .= ' 
                                                        <div class="mb-1">
                                                        <label for="' . $val[0] . '" ' . $hidden . '><b>' . $val[1] . '</b>' . $leyenda_obligatoria . '<small style="color:#c4c4c4;">' . $val[11] . '</small></label> ';
                                    for ($pradio = 0; $pradio < count($radio_butons); $pradio++) {
                                        $contenido .= ' 
                                                            <div class="form-check my-50">
                                                                <input type="radio" id="' . $val[0] . '" ' . $DATO_PREDEFINIDO . $coleccion_atributos . $required . ' name="' . $val[1] . '" ' . $hidden . ' class="form-check-input"  />
                                                                <label class="form-check-label" ' . $hidden . ' for="' . $val[0] . '">' . $radio_butons[$pradio] . '</label>
                                                            </div>';
                                        $contenido .= '
                                                            </div>';
                                    }
                                    break;

                                case "textarea":
                                    $contenido .= ' 
                                                            <label for="' . $val[0] . '" ' . $hidden . '><b>' . $val[1] . '</b>' . $leyenda_obligatoria . '<small style="color:#c4c4c4;">' . $val[11] . '</small></label> 
                                                            <textarea class="form-control" id="' . $val[0] . '" ' . $DATO_PREDEFINIDO . $coleccion_atributos . $required . ' rows="2SS" placeholder="' . $val[1] . '"></textarea>                              
                                                                    ';
                                    break;

                                case "file":
                                    $contenido .= ' 
                                                                <label for="' . $val[0] . '" ' . $hidden . '><b>' . $val[1] . '</b>' . $leyenda_obligatoria . '<small style="color:#c4c4c4;">' . $val[11] . '</small></label> 
                                                                <input multiple type="file" class="form-control" ' . $hidden . ' id="' . $val[0] . '" ' . $DATO_PREDEFINIDO . $coleccion_atributos . $required . '>                            
                                                                        ';
                                    break;

                                case "password":
                                    $contenido .= ' 
                                                                        <label for="' . $val[0] . '" ' . $hidden . '><b>' . $val[1] . '</b>' . $leyenda_obligatoria . '<small style="color:#c4c4c4;">' . $val[11] . '</small></label> 
                                                                        <input multiple type="password" class="form-control" id="' . $val[0] . '" ' . $DATO_PREDEFINIDO . $coleccion_atributos . $required . '>                            
                                                                                ';
                                    break;

                                case "multiselect":
                                    $contenido .= ' 
                                    <div class="col-12">
                                        <label class="form-label" for="' . $val[0] . '" ' . $hidden . '><b>' . $val[1] . '</b>' . $leyenda_obligatoria . '<small style="color:#c4c4c4;">' . $val[11] . '</small></label> 
                                        <div class="mb-1">
                                            <select class="select2 form-select" name="' . $val[0] . '" id="' . $val[0] . '" multiple="multiple" ' . $required . '>
                                            <option value="">-SELECCIONE-</option>
                                            ' . $contenidoselect . '
                                            </select>
                                        </div>
                                    </div>                    
                                                                                        ';
                                    break;
                            }
                            if ($separador_acumulado == 12) {
                                $formulario_cuerpo .= $estructura_formulario . $contenido . '</div></div>';
                            } else {
                                $formulario_cuerpo .= $estructura_formulario . $contenido . '<div id="resultadoBusqueda"></div></div>';
                            }
                        }
                        echo $formulario_cuerpo;
                        ?>
                    </div>
                    <?= '</form>' ?>
                </div>
        </div>
    </div>
</div>
<script src="assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
<script src="assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
<script src="assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
<script src="assets/js/form-validation.js"></script>
<?php
if (isset($str_javascript)) {
    echo $str_javascript;
}

?>
<!-- en treoria funciona con los requerimientos de la libreria de la fucnion anterior       -->
<script>
    $(document).ready(function () {

        // function buscar() {

        //     var textoBusqueda = $("input#rfc").val();
        //     if (textoBusqueda != "") {
        //         $.post("buscar.php", {
        //             valorBusqueda: textoBusqueda
        //         }, function(mensaje) {
        //             $("#resultadoBusqueda").html(mensaje);
        //         });
        //     } else {
        //         ("#resultadoBusqueda").html('');
        //     };
        // };

        $("form").submit(function () {
            Swal.fire({
                title: 'DESEA GUARDAR EL REGISTRO?',
                text: "SE ALMACENARA EN LA BASE DE DATOS!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'SI, ADELANTE!',
                cancelButtonText: "CANCELAR"
            }).then((result) => {
                if (result.isConfirmed) {
                    guardaRegistro();
                }
            })
            return false;
        });
        ////////////////////////RELLENA CAMPOS/////////////////////////
        // SECCION DE LOS SELECTS EN CASCADA
        <?php

        if (isset($select_cascada) && count($select_cascada) > 0) {
            for ($pcascada = 0; $pcascada < count($select_cascada); $pcascada++) {
                echo '
                                        $("#' . $select_cascada[$pcascada]['origen'] . '").change(function() {                                       
                                           $.get("' . $select_cascada[$pcascada]['archivo'] . '", "dato=" + $("#' . $select_cascada[$pcascada]['origen'] . '").val()+"&valores=' . $select_cascada[$pcascada]['valores'] . '"+"&tab1=' . $select_cascada[$pcascada]['tablas'][0] . '"+"&tab2=' . $select_cascada[$pcascada]['tablas'][1] . '"+"&llave1=' . $select_cascada[$pcascada]['llave1'] . '"+"&llave2=' . $select_cascada[$pcascada]['llave2'] . '"+"&origen=' . $select_cascada[$pcascada]['origen'] . '"+"&detalle=' . $select_cascada[$pcascada]['datos'] . '"+"&condicion=' . $select_cascada[0]['condicion'] . '", function(data) {
                                                $("#' . $select_cascada[$pcascada]['destino'] . '").html(data);
                                            });
                                        });
                                        ';
            }
        }
        ?>

        function guardaRegistro() {

            const formData = new FormData();
            formData.append("tabla", $('#tabla').val());
            formData.append("ruta", $('#ruta').val());
            <?php
            for ($t = 0; $t < count($campos); $t++) {

                switch (substr($campos[$t], 0, 4)) {
                    case 'file':
                        echo '
                        const $' . $campos[$t] . '= document.querySelector("#' . $campos[$t] . '");
                        const archivos' . $campos[$t] . ' = $' . $campos[$t] . '.files;
                        for (const archivo of archivos' . $campos[$t] . ') {
                            formData.append("' . $campos[$t] . '", archivo);
                        }
                        ';
                        break;
                    case 'pass':
                        echo "                       
                        formData.append(\"" . $campos[$t] . "\", Base64.encode($('#" . $campos[$t] . "').val()));";
                        break;
                    default:
                        echo "
                    formData.append(\"" . $campos[$t] . "\", $('#" . $campos[$t] . "').val());";
                        break;
                }
            }

            ?>
            $.ajax({
                url: "ajax_sistema/inserta_registros.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            }).done(function (res) {
                if (res[''] == "EXITO") {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'REGISTRO GUARDADO CON EXITO',
                        showConfirmButton: false,
                        timer: 1700
                    })
                    setTimeout("redireccionar('" + $('#mod').val() + "','" + $('#carpetageneral').val() + "','" + $('#pila').val() + "')", 1700);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR',
                        text: res
                    })
                }
            });

        }

    });

    function redireccionar(valor, carpeta, pila) {

        if (pila == 0) {
            window.location.replace("../" + carpeta + "/index.php?mod=" + valor);
        } else {
            window.location.replace("../" + carpeta + "/index.php?mod=" + valor + "&pila=" + pila);
        }
    }


    var Base64 = {
        _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
        encode: function (input) {
            var output = "";
            var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
            var i = 0;
            input = Base64._utf8_encode(input);
            while (i < input.length) {

                chr1 = input.charCodeAt(i++);
                chr2 = input.charCodeAt(i++);
                chr3 = input.charCodeAt(i++);

                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                enc4 = chr3 & 63;

                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                } else if (isNaN(chr3)) {
                    enc4 = 64;
                }

                output = output +
                    this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
                    this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
            }
            return output;
        },

        decode: function (input) {
            var output = "";
            var chr1, chr2, chr3;
            var enc1, enc2, enc3, enc4;
            var i = 0;

            input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

            while (i < input.length) {

                enc1 = this._keyStr.indexOf(input.charAt(i++));
                enc2 = this._keyStr.indexOf(input.charAt(i++));
                enc3 = this._keyStr.indexOf(input.charAt(i++));
                enc4 = this._keyStr.indexOf(input.charAt(i++));

                chr1 = (enc1 << 2) | (enc2 >> 4);
                chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                chr3 = ((enc3 & 3) << 6) | enc4;

                output = output + String.fromCharCode(chr1);

                if (enc3 != 64) {
                    output = output + String.fromCharCode(chr2);
                }
                if (enc4 != 64) {
                    output = output + String.fromCharCode(chr3);
                }
            }

            output = Base64._utf8_decode(output);

            return output;
        },

        _utf8_encode: function (string) {
            string = string.replace(/\r\n/g, "\n");
            var utftext = "";

            for (var n = 0; n < string.length; n++) {
                var c = string.charCodeAt(n);
                if (c < 128) {
                    utftext += String.fromCharCode(c);
                } else if ((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                } else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
            }
            return utftext;
        },

        _utf8_decode: function (utftext) {
            var string = "";
            var i = 0;
            var c = c1 = c2 = 0;

            while (i < utftext.length) {

                c = utftext.charCodeAt(i);

                if (c < 128) {
                    string += String.fromCharCode(c);
                    i++;
                } else if ((c > 191) && (c < 224)) {
                    c2 = utftext.charCodeAt(i + 1);
                    string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                    i += 2;
                } else {
                    c2 = utftext.charCodeAt(i + 1);
                    c3 = utftext.charCodeAt(i + 2);
                    string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                    i += 3;
                }
            }
            return string;
        }
    }

</script>
