<?php
/*
@AUTOR:ISC.CHRISTOPHER DELGADILLO RAMIREZ
CONTENIDO DE LOS ESTILOS Y LOS SCRIPTS DE LA PANTALLA PRINCIPAL
FAVOR DE ANOTAR TUS CAMBIOS Y MODIFICACIONES GRACIAS
 */
if (strlen(session_id()) == 0) {
    session_start();
}
global $__SESSION;
include_once('./configuracion_sistema/configuracion.php');
if ($__SESSION->getValueSession('nomusuario') <> "" && $__SESSION->getValueSession('passwd') <> "" && $__SESSION->getValueSession('cveperfil') <> "") {
    global $CFG_HOST, $CFG_USER, $CFG_DBPWD, $CFG_DBASE, $CFG_TIPO;

    ?>

    <!-- BOTON DE INICIO -->
    <li class="menu-item active">
        <a href="../admcaptura/index.php?mod=9999" class="menu-link">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="INICIO">INICIO</div>
        </a>
    </li>
    <?php

    $perfil = $__SESSION->getValueSession('cveperfil');
    $grupo_usr = $__SESSION->getValueSession('cve_usergroup');
    $consulta = new PDOConsultas();
    $consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

    $query_menu = "SELECT 
                                                    *
                                                    FROM 
                                                    sb_perfil_modulo 
                                                    INNER JOIN  sb_modulo ON 
                                                            sb_modulo.status_modulo=1 AND sb_perfil_modulo.cve_perfil=$perfil
                                                    AND sb_perfil_modulo.cve_modulo=sb_modulo.cve_modulo
                                                    AND sb_modulo.status_modulo<>0
                                                    ORDER BY grupo_modulo, posicion_modulo, nivel_modulo";

    $DATOS_MENU = $consulta->executeQuery($query_menu);

    $CABECERA_PADRE = "";
    $contador=0;
    if ($consulta->totalRows > 0) {
        $PIVOTE_CAMBIO_GRUPO = 0;
        $PIVOTE_CAMBIO_NIVEL = 1;
        $BANDERA_CIERRE_PADRE2 = 0;
        $CADENA_MENU = '';
        $CIERRE_PADRE = "";
        $NUMERO_CICLO = 0;
        foreach ($DATOS_MENU as $KEY_MENU => &$VAL_MENU) {
            if ($PIVOTE_CAMBIO_GRUPO != $VAL_MENU['grupo_modulo']) {
                if ($PIVOTE_CAMBIO_GRUPO == 0) {
                    $PIVOTE_CAMBIO_GRUPO = $VAL_MENU['grupo_modulo'];
                } else {
                    $CIERRE_PADRE = '</ul></li>';
                    $CADENA_MENU .= $CIERRE_PADRE;
                    $PIVOTE_CAMBIO_GRUPO = $VAL_MENU['grupo_modulo'];
                }
            }

            if ($PIVOTE_CAMBIO_NIVEL != $VAL_MENU['nivel_padre']) {
                if ($PIVOTE_CAMBIO_NIVEL == 1) {
                    $PIVOTE_CAMBIO_NIVEL = $VAL_MENU['nivel_padre'];
                } else {
                    $BANDERA_CIERRE_PADRE2 = 0;
                    $CIERRE_PADRE = '</ul></li>';
                    $CADENA_MENU .= $CIERRE_PADRE;
                    $PIVOTE_CAMBIO_NIVEL = $VAL_MENU['nivel_padre'];
                }
            }


            switch ($VAL_MENU['tipo_nivel']) {
                case 'PADRE':
                    switch ($VAL_MENU['nivel_padre']) {
                        case 1:
                            $CABECERA_PADRE = '
                                                <li class="menu-item">
                                                    <a href="' . (($VAL_MENU['url_include'] == 'null') ? '#' : ('index.php?mod=' . $VAL_MENU['cve_modulo'])) . '" class="menu-link menu-toggle">
                                                        <i class="menu-icon tf-icons ti ti-layout-sidebar"></i>
                                                        <div data-i18n="' . $VAL_MENU['descripcion_modulo'] . '">' . $VAL_MENU['descripcion_modulo'] . '</div>
                                                    </a>
                                                    <ul class="menu-sub">  
                                                    ';

                            break;
                        default:
                            break;
                    }
                    $CADENA_MENU .= $CABECERA_PADRE;
                    break;

                case 'HIJO':
                    $contador++;
                    switch ($VAL_MENU['nivel_hijo']) {
                        case 1:
                            $CABECERA_HIJO = '              
                                                        <li class="menu-item">
                                                            <a href="' . (($VAL_MENU['url_include'] == 'null') ? '#' : ('index.php?mod=' . $VAL_MENU['cve_modulo'])) . '" class="menu-link">
                                                                <i class="menu-icon tf-icons ti ti-menu-2"></i>
                                                                <div data-i18n="' . $VAL_MENU['descripcion_modulo'] . '">' . $VAL_MENU['descripcion_modulo'] . '</div>
                                                            </a>
                                                        </li>';
                            break;
                        default:
                            break;
                    }
                    $CADENA_MENU .= $CABECERA_HIJO;
                    break;
            }
            if ($KEY_MENU === array_key_last($DATOS_MENU)) {
                if ($BANDERA_CIERRE_PADRE2 == 1) {
                    $CIERRE_PADRE = '</ul></li>';
                } else {
                    $CIERRE_PADRE = '</ul></li>';
                }
            }
            $NUMERO_CICLO++;
        }
        echo $CADENA_MENU;
    }
} else {
    echo "ERROR EN LA CONSTRUCCION DEL MENU";
    include_once '../includes/sb_refresh.php';
}