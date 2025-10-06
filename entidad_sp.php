<?php
include_once("configuracion_sistema/configuracion.php");
global $__SESSION, $CFG_HOST, $CFG_USER, $CFG_DBPWD, $CFG_TIPO, $CFG_DBASE, $modulo;

if ($__SESSION->getValueSession('nomusuario') == "") {
    include_once("includes/sb_refresh.php");
} else {
    //CREACION DEL OBJETO DE LAS CONSULTAS
    global $serveraux,$a_search_tipo,$tabla,$tabla_join,$tablas_c,$campos_join,$a_order,$niveles_acceso_etiqueta,$id_prin,$a_search_etiqueta,$str_impresora_destino,$NOMBRE_CARPETA_PRINCIPAL,$str_title_impresora,$str_modal,$streliminar,$strWhere,$boton_texto,$str_impresora,$streditar;

    $IdPrin = $__SESSION->getValueSession('cveperfil');
    $consulta = new PDOConsultas();
    $consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
    $modulo_acceso = $consulta->executeQuery("SELECT *
                                                    FROM
                                                    sb_perfil_modulo, sb_modulo
                                                    Where sb_perfil_modulo.cve_perfil =$IdPrin
                                                    and sb_perfil_modulo.cve_modulo =$modulo
                                                    and sb_perfil_modulo.cve_modulo = sb_modulo.cve_modulo
                                                    and sb_modulo.status_modulo <>0");
    $nombre_modulo_padre = $modulo_acceso[0]['descripcion_modulo'];
    /*************************************************************************************************************************************************************/
    /*OBTENCION DE LA PILA PARA EL REDIRECCIONAMIENTO DE LAS PANTALLAS DE LOS SUBNIVELES*/
    /*************************************************************************************************************************************************************/

    /*************************************************************************************************************************************************************/
    /*FIN DE LA SECCION DE LAS PILAS*/
    /*************************************************************************************************************************************************************/
    /*******************************************************************************************************************/
    /*SECCION DE EL PAGINADO*/
    /*******************************************************************************************************************/

    if (isset($a_search_campo)) {
        //SECCION DE LA CREACION DEL FORMULARRIO DE BUSQUEDA/
        if (isset($_POST[base64_encode('vector_busqueda')]) && strlen($_POST[base64_encode('buscar_campo')]) > 0) {
            $cadena_auxiliar = explode("@@", $_POST[base64_encode('vector_busqueda')]);
            $nombre_campo = base64_decode($cadena_auxiliar[0]);
            $tipo_dato_campo = base64_decode($cadena_auxiliar[1]);

            //PROGRAMAR CONDICINES DE BUSQUEDA inica contiene termina
            if ($tipo_dato_campo == 'text' || $tipo_dato_campo == 'varchar') {
                switch ($tipo_dato_campo) {
                    case 'text':
                        $filtro = $nombre_campo . " like '%" . $_POST[base64_encode('buscar_campo')] . "%'";
                        break;
                    case 'char':
                        $filtro = $nombre_campo . " like '%" . $_POST[base64_encode('buscar_campo')] . "%'";
                        break;
                    case 'varchar':
                        $filtro = $nombre_campo . " like '%" . $_POST[base64_encode('buscar_campo')] . "%'";
                        break;
                    case 'int':
                        $filtro = $nombre_campo . "=" . $_POST[base64_encode('buscar_campo')];
                        break;
                    default:
                        break;
                }
            }

            if (strlen($strWhere) <= 0) {
                $cadena_busqueda = " Where " . $filtro;
                $campo_post_busqueda = $cadena_busqueda;
            } else {
                $cadena_busqueda = " AND " . $filtro;
                $campo_post_busqueda = $cadena_busqueda;
            }
        }
        //echo $cadena_busqueda;
        for ($pbusqueda = 0; $pbusqueda < count($a_search_campo); $pbusqueda++) {
            $opciones_busqueda .= '<option value="' . base64_encode($a_search_campo[$pbusqueda]) . '@@' . base64_encode($a_search_tipo[$pbusqueda]) . '">' . $a_search_etiqueta[$pbusqueda] . '</option>';
        }
        $select_busqueda="";
        $select_busqueda .= '<div class="row">';
        $select_busqueda .= '
                            <div class="col-md-6 form-group mb-3">                        
                                <select class="form-control" name="' . base64_encode('vector_busqueda') . '" id="' . base64_encode('vector_busqueda') . '">
                                ' . $opciones_busqueda . '
                                </select>
                                </div>
                            <div class="col-md-4 form-group mb-3">
                                <input class="form-control" id="' . base64_encode('buscar_campo') . '" placeholder="BUSCAR" name="' . base64_encode('buscar_campo') . '" />
                             </div>
                            <div class="col-md-2 form-group mb-3">
                                <button class="btn btn-primary">BUSCAR</button>
                            </div>';
        $select_busqueda .= '</div>';
        $strbusqueda = "";
        $strbusqueda = "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "?mod=" . $_GET['mod'] . "\">";
        $strbusqueda .= "<input type=\"text\" id=\"op\" name=\"op\" value=\"1\" hidden=\"true\">";
        $strbusqueda .= "<input type=\"text\" id=\"mod\" name=\"mod\" value=\"" . $_GET['mod'] . "\" hidden=\"true\">";
        $strbusqueda .= "<input type=\"text\" id=\"opc\" name=\"opc\" value=\"0\" hidden=\"true\">";
        $strbusqueda .= $select_busqueda;
        $strbusqueda .= "</form>";
    }

    /***************************************/
    //FIN DE MICROFORMULARIO DE BUSQUEDA/

    /***************************************/
    //SECCION DE EL PAGINADO/
    /***************************************/
    $consulta_paginado = new PDOConsultas();
    $consulta_paginado->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]); //connect to database
    //DETECTA SI HEMOS CAMBIADO DE PAGINA Y PONE EL NUMERO DE LA PAGINA EN LA QUE ESTAMOS
    if (isset($_GET['intpag'])) {

        $intpag = $_GET['intpag'];
        //    echo $intpag;
    }
    //echo json_encode($_GET);
    //  echo json_encode($_POST);
    // echo $cadena_busqueda;

    if (isset($_GET['busquedag'])) {
        $cadena_busqueda = $_GET['busquedag'];
    }

    if (strpos($strWhere, ' WHERE')) {
        $query_pag = " select count(*) AS TOTAL FROM " . $tabla . " " . $tabla_join . " " . $cadena_busqueda;
    } else {
        $query_pag = " select count(*) AS TOTAL FROM " . $tabla . " " . $tabla_join . " " . $strWhere . " " . $cadena_busqueda;
    }


    //  echo $query_pag;
    //SACA EL TOTAL DE REGISTROS Y LO DIVIDE EN TRE EL LIMITE DE REGISTRO QUE PODEMOS MOSTRAR POR PAGINA
    $total_datos = $consulta_paginado->executeQuery($query_pag);
    $reg_found = $total_datos[0]['TOTAL'];

// Configuración de la cantidad de registros por página
    $registros_pagina = isset($intlimit) ? $intlimit : 15;
    $intlimit = $registros_pagina;

// Cálculo del número total de páginas
    $decdiv = ceil($reg_found / $intlimit);

// Configuración de la página actual y cálculo del offset
    $intpag = isset($intpag) && $intpag > 0 && $intpag <= $decdiv ? $intpag : 1;
    $intOffset = ($intlimit * $intpag) - $intlimit;
    $strlimit = " LIMIT $intlimit OFFSET $intOffset";

//    echo "-----".$strlimit;
//
//    die();

// Configuración de la paginación visual
    $paginas = $intlimit;
    $inipag = max(1, $intpag - ($paginas / 2));
    $finpag = min($decdiv, $intpag + ($paginas / 2));


    // echo $decdiv;
    $paginado = '<nav aria-label="..."><ul class="pagination">';
    for ($i = round($inipag); $i <= $finpag; $i++) {
        if ($i > $finpag) {
            $titulo1 .= '<li class="page-item"><a class="page-link" href="#" tabindex="-1">FIN</a></li>';
        } else {
            if ($_GET['pila'] == '') {
                $aux_pila = "";
                if($i==1){
                    $titulo1.="<li class=\"page-item\"><span class=\"page-link\" href=\"index.php" . $serveraux . "?" . 'mod=' . $_GET['mod'] . $aux_pila . "&intpag=" . $i . "&busquedag=" . $cadena_busqueda . " \">ANTERIOR</a></span></li>";
                }
                $titulo1 .= "<li class=\"page-item \"><a class=\"page-link\" href=\"index.php" . $serveraux . "?" . 'mod=' . $_GET['mod'] . $aux_pila . "&intpag=" . $i . "&busquedag=" . $cadena_busqueda . " \" >" . $i . '</a></li>';

                if($i == $finpag){
                    $titulo1.="<li class=\"page-item\"><a class=\"page-link\" href=\"#\">SIGUIENTE</a></li>";
                }

            } else {
                global $sub_1;
                $aux_pila = $sub_1;
                $titulo1 .= "<li class=\"page-item \"><a class=\"page-link\" href=\"index.php" . $serveraux . $aux_pila . "&intpag=" . $i . "&busquedag=" . $cadena_busqueda . "\" >" . $i . '</a></li>';
            }
        }
    }
    $paginado .=$titulo1. '</ul></nav>';

    /*******************************************************************************************************************/
    /*FIN DE MICROFORMULARIO DE BUSQUEDA*/
    /*******************************************************************************************************************
     * /*******************************************************************************************************************/
    /*INICIO DE LA CREACION DE LOS CAMPOS PRINCIPALES*/
    /*******************************************************************************************************************/
    //SE ESTABLECE LOS ARRAYS DE LOS CAMPOS DE LOS FIELDS
    $array_cabecera = array();
    $nombres_cabecera = array();
    $tamanio_celda = array();
    $query_principal = "SELECT ";
    $campos = "";
    global $field;
    /*****************************************SE ESTABLECE LOS ARRAYS DE LOS CAMPOS DE LOS FIELDS***********************/
    //DESTRIPA LOS FIELD Y LOS AGRUPA A LOS CAMPOS EN SUS RESPECTIVAS POSICIONES
    foreach ($field as $key => &$val) {
//        print_r($field);die();
        if ($key != count($field) - 1) {
            $campos .= $val[0] . ',';
            $array_cabecera[] = $val[0];
            $nombres_cabecera[] = $val[1];
            $tamanio_celda[] = $val[8];
            $vector_imagen[] = $val[3];
            $vector_modal[] = $val[12];
        } else {
            $campos .= $val[0];
            $array_cabecera[] = $val[0];
            $nombres_cabecera[] = $val[1];
            $tamanio_celda[] = $val[8];
            $vector_imagen[] = $val[3];
            $vector_modal[] = $val[12];
        }
    }
    //SI DETECTA DATOS EN LAS TABLAS DE LOS CAMPOS DE JOIN  SE REEMPLAZAN LOS CAMPOS
    if ($campos_join != '') {
        $campos = $campos_join;
    }


    //SE SE DETECTA DATOS EN EL LA VARIABLE DE  CONDICION SE REEMPLAZA
    if (strpos($strWhere, ' Where')) {
        $query_principal .= $campos . " FROM " . $tabla . " " . $tabla_join . " " . $cadena_busqueda . " " . $a_order;
    } else {
        if (isset($str_union_tabla)) {
            $query_principal .= $campos . " FROM " . $str_union_tabla . " " . $tabla_join . " " . $strWhere . " " . $cadena_busqueda . $a_order;
        } else {
            $query_principal .= $campos . " FROM " . $tabla . " " . $tabla_join . " " . $strWhere . " " . $cadena_busqueda . $a_order;
        }
    }

    
    echo $query_principal;
    //die();
    $resultado = $consulta->executeQuery($query_principal . $strlimit);
    global $entidad, $strnuevo;
    ?>
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Bootstrap Table with Header - Light -->
        <?php
        if (isset($_GET['pila'])) {
            $sub_1 = "?mod=" . $_GET['mod'] . "&pila=" . $_GET['pila'];
            echo '<a href="' . $_SERVER['PHP_SELF'] . '?mod=' . $_GET['mod'] . '"><img src="imagenes_sistema/atras.png" alt="ATRÁS" title="PAGINA ANTERIOR" width="38px"> </a>';
        } else {
            $sub_1 = "";
        }
        ?>
        <div class="card">
            <!-- Card Modal -->
            <div class="modal fade" id="addNewCCModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div id="miiframe" name="miiframe"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Card Modal -->
            <div class="row">
                <div class="col-4">
                    <h3 class="card-title mb-3" id="informacion_modulo">
                        <h4><?= $entidad ?></h4><small>&nbsp;&nbsp;&nbsp;<?= "REGISTROS ENCONTRADOS::" . $reg_found ?></small>

                        </h3>
                </div>
                <div class="col-6">
                    </br>
                    <?= $strbusqueda ?>

                </div>
                <div class="col-2">
                    </br>
                    <?php
                    if ($strnuevo) {
                        $strnuevo = "";
                        $strnuevo = "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . $sub_1 . "\" style=\"position: relative; left: 0;\">";
                        $strnuevo .= "<input type=\"text\" id=\"op\" name=\"op\" value=\"1\" hidden=\"true\">";
                        $strnuevo .= "<input type=\"text\" id=\"mod\" name=\"mod\" value=\"" . $_GET['mod'] . "\" hidden=\"true\">";
                        $strnuevo .= "<input type=\"text\" id=\"opc\" name=\"opc\" value=\"2\" hidden=\"true\">";
                        $strnuevo .= "<input type=\"text\" id=\"btnAdd\" name=\"btnAdd\" value=\"btnAdd\" hidden=\"true\">";
                        $strnuevo .= "<button class=\"btn btn-primary btn4\" id=\"btn_nuevo_registro\" type=\"submit\"><span class=\"ul-btn__icon\"><i class=\"i-Gear-2\"></i></span><span class=\"ul-btn__text\">" . $boton_texto . "</span></button>";
                        $strnuevo .= "</form>";
                        echo $strnuevo;
                    } else {
                        echo "";
                    }
                    ?>
                </div>
            </div>


            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead class="table-light">
                        <tr>
                            <th>PROCESOS</th>
                            <?php
                            for ($i = 1; $i < count($array_cabecera); $i++) {
                                echo "<th><b>" . str_replace('CVE', ' ', str_replace('_', ' ', strtoupper($nombres_cabecera[$i]))) . "</b></th>";
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        <?php
                        if ($tabla_join != '') {
                            if (isset($str_union_tabla)) {
                            } else {
                                $vector_tabla = explode(' ', $tabla);
                                $tabla = $vector_tabla[0];
                            }
                        }
                        foreach ($resultado as $key => &$val) {
                            /****************************SECCION DE LOS NIVELES DE ACCESO*************************************************************/
                            if (isset($niveles_acceso) && count($niveles_acceso) > 0) {
                                // (valor, llave, tabla, archivo, carpeta)

                                for ($puntero_nivel = 0; $puntero_nivel < count($niveles_acceso); $puntero_nivel++) {
                                    $nivel_enlaces .= "<a class=\"dropdown-item\" href='javascript:;' onclick=\"detalle('" . $val[$id_prin] . "','" . $id_prin . "','" . $tabla . "','" . $niveles_acceso[$puntero_nivel] . "','" . $NOMBRE_CARPETA_PRINCIPAL . "','" . $_GET['mod'] . "','" . $nombre_modulo_padre . "');\">
                                                    <i class=\"ti ti-pencil me-1\"></i> " . $niveles_acceso_etiqueta[$puntero_nivel] . "</a>";
                                }

                                $niveles = '<div class="col-lg-1"><div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                            ' . $nivel_enlaces . '
                                            </div>
                                        </div>';
                                $nivel_enlaces = "";
                            } else {
                                $niveles = "";
                            }

                            /*************************************************************************************************************************/
                            /***********************************************AVTIVACION DEL ICONO DE LA IMPRESORA*****************************************/
                            if ($str_impresora) {
                                $strimpresora = "
                                        <a type=\"button\" class=\"btn btn-icon btn-flat-warning\" target=\"_blank\" onclick=\"window.open(this.href, 'mywin',
                                        'left=20,top=20,width=1000,height=800,toolbar=1,resizable=0'); return false;\" title=\"$str_title_impresora\" href=\"../" . $NOMBRE_CARPETA_PRINCIPAL . "/" . $str_impresora_destino . "init1=" . base64_encode($val[$id_prin]) . "&init2=" . base64_encode($id_prin) . "&init3=" . base64_encode($tabla) . "'\">
                                        <i class=\"ti ti-printer\"></i>
                                        </a>";
                            } else {
                                $strimpresora = "";
                            }
                            $stractualiza = "";
                            echo '<tr>';
                            if ($streditar) {
                                $stractualiza .= '<div class="col-lg-1">';
                                $stractualiza .= "<form method=\"post\" id=\"formactualiza\" action=\"" . $_SERVER['PHP_SELF'] . $sub_1 . "\" >";
                                $stractualiza .= "<input type=\"text\" id=\"id_prin\" name=\"id_prin\" value=\"$val[$id_prin] \" hidden=\"true\">";
                                $stractualiza .= "<input type=\"text\" id=\"op\" name=\"op\" value=\"3\" hidden=\"true\">";
                                $stractualiza .= "<input type=\"text\" id=\"mod\" name=\"mod\" value=\"" . $_GET['mod'] . "\" hidden=\"true\">";
                                $stractualiza .= "<input type=\"text\" id=\"opc\" name=\"opc\" value=\"3\" hidden=\"true\">";
                                $stractualiza .= "<button class=\"btn btn-icon btn-flat-primary\" id=\"btn_actualiza_registro\" title =\"ACTUALIZAR REGISTRO\" name=\"button\"><i class=\"ti ti-pencil me-1\"></i></button>";
                                $stractualiza .= "</form>";
                                $stractualiza .= '</div>';
                            } else {
                                $stractualiza = "";
                            }

                            if ($streliminar) {
                                $strelimina = '
                                        <div class="col-lg-1">
                                                <button type="button" id="btn_elimina_registro" class="btn btn-icon btn-flat-success" title ="ELIMINAR REGISTRO" href=\'javascript:;\' onclick="elimina(\'' . $val[$id_prin] . '\',\'' . $id_prin . '\',\'' . $tabla . '\');">
                                                <i class="ti ti-trash me-1" ></i>
                                                </button>
                                        </div>';
                            } else {
                                $streimina = "";
                            }


                            echo '<td>
                                                <div class="row" >
                                                            ' . $stractualiza . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                            ' . $strelimina . '
                                                            <div class="col-lg-1"> &nbsp; &nbsp; 
                                                            ' . $strimpresora.  '
                                                            </div> 
                                                            
                                                             
                                                                 &nbsp; &nbsp;    &nbsp; &nbsp;    &nbsp; &nbsp;  '. $niveles.'                                                                                  
                                                         
                                                            
                                                </div>                               
                                    </td>';
                            for ($i = 1; $i < count($array_cabecera); $i++) {
                                if ($vector_imagen[$i] == 'IMAGEN' || $vector_imagen[$i] == 'FILE') {
                                    switch ($vector_imagen[$i]) {
                                        case 'IMAGEN':
                                            echo '<td style="width:' . $tamanio_celda[$i] . 'px;"><img class="round" src="' . $val[$array_cabecera[$i]] . '" alt="Perfil" width="62"></td>';
                                            break;
                                        case 'FILE':
                                            echo '<td style="width:' . $tamanio_celda[$i] . 'px;">
                                                    <a href="' . $val[$array_cabecera[$i]] . '" target="_blank" onclick="window.open(this.href, \'mywin\',
                                                    \'left=20,top=20,width=1000,height=800,toolbar=1,resizable=0\'); return false;">
                                                    <img src="imagenes_sistema/Icono_pdf.png"   title="ayuda "   height="50" width="50" />
                                                    </a>
                                                    </td>';
                                            break;
                                        default:
                                            break;
                                    }
                                } else {
                                    if ($vector_modal[$i] != '') {
                                        echo '<td style="width:' . $tamanio_celda[$i] . 'px;">' . $val[$array_cabecera[$i]] . '   
                                                     <button class="btn btn-icon btn-flat-primary" title ="ABRIR MODAL"  name="button"><i class="ti ti-ad-2" style="color: #E74C01FF;"  onclick="ejecuta_modal(\'' . $val[$id_prin] . '\',\'' . $id_prin . '\',\'' . $tabla . '\',\'' . $str_modal . '\');"></i></button>                                        
                                                   </td>';
                                    } else {
                                        echo '<td style="width:' . $tamanio_celda[$i] . 'px;">' . $val[$array_cabecera[$i]] . '</td>';
                                    }
                                }
                            }
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                    <?= $paginado ?>
                </div>
            </div>
        </div>
        <!-- Bootstrap Table with Header - Light -->
    </div>
    <!--/ Content -->

    <?php
    if (isset($str_javascript_entidad)) {
        echo $str_javascript_entidad;
    }
    ?>
    <!------------------------------------------------------------------------------------------------------------------------------------------------->
    <!-------------------------------------------- CREACION DEL FORMULARIO GENERAL -------------------------------------------------------------------->
    <!------------------------------------------------------------------------------------------------------------------------------------------------->
    <script>
        function detalle(valor, llave, tabla, archivo, carpeta, mod, padre) {
            let sbniv = [Base64.encode(valor), Base64.encode(llave), Base64.encode(archivo), Base64.encode(mod), Base64.encode(padre)];
            let sbniv2 = Base64.encode(tabla);
            window.location.href = "../" + carpeta + "/index.php?mod=" + mod + "&pila=" + sbniv + "&tabs=" + sbniv2;
        }

        function elimina(valor, llave, tabla) {
            Swal.fire({
                title: 'DESEAS ELIMINAR ESTE REGISTRO?',
                text: "Este proceso es irreversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, de acuerdo'
            }).then((result) => {
                if (result.isConfirmed) {
                    ejecuta_elimina(valor, llave, tabla);
                }
            })
        }


        function ejecuta_elimina(valor, llave, tabla) {
            $.ajax({
                url: 'ajax_sistema/elimina.php',
                data: 'elemento=' + valor + '&llave=' + llave + '&tabla=' + tabla,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    $('#content2').fadeIn(1000).html(data);
                    $.each(data, function (index, element) {
                        if (element.bandera === 'EXITO') {
                            Swal.fire(
                                'ELIMINADO!',
                                'EL REGISTRO FUE ELIMINADO DE MANERA CORRECTA.',
                                'success'
                            ),
                                window.location.reload();
                        } else {
                            return false;
                        }
                    });
                },
                error: function (e) {
                    return false;
                }
            });
        }

        function ejecuta_modal(valor, llave, tabla, archivo) {
            // esta es la seccion para el nuevo modal
            let rep = archivo;
            $('#addNewCCModal').modal('show');
            sendRep2(rep);
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
    <SCRIPT LANGUAGE="JavaScript">
        var d = null;

        function sendRep2() {
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
            cadena1 += '&tipo=7';
            openInIframe5(cadena1);
        }

        function openInIframe5(cadena1) {
            // $("#miiframe").css("overflow", "scroll");
            load_response('miiframe', cadena1);
        }

        function load_response(target, cadena1) {
            ///NI LE MUEVAN
            var myConnection = new XHConn();
            if (!myConnection)
                alert("XMLHTTP no esta disponible");
            var peticion = function (oXML) {
                $("#" + target).html(oXML.responseText);
            };
            var pars = cadena1.split('?');
            myConnection.connect(pars[0], "GET", pars[1], peticion);
        }
    </SCRIPT>
    <?php
}
?>