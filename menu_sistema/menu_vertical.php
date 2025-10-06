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
    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto">
                    <a class="navbar-brand" href="#">
                        <span class="brand-logo" style="width: 100%;">
                            <img src="imagenes_sistema/escudo_estado_mexico.png" width="100%">
                        </span>
                    </a>
                </li>
                <li class="nav-item nav-toggle" id="oculta_menus"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="content-header row">&nbsp;</div>
        <div class="content-header row">&nbsp;</div>
        <div class="shadow-bottom"></div>
        <!-- END: Main Menu-->
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="active nav-item"><a class="d-flex align-items-center" href="../plantilla/index.php?mod=9999"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Home">INICIO</span></a>
                </li>

            <?php

            $perfil = $__SESSION->getValueSession('cveperfil');
            $consulta = new PDOConsultas();
            $consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
            $DATOS_MENU = $consulta->executeQuery("SELECT 
                                                    *
                                                    FROM 
                                                    sb_perfil_modulo 
                                                    INNER JOIN  sb_modulo ON 
                                                            sb_modulo.status_modulo=1 AND sb_perfil_modulo.cve_perfil=$perfil
                                                    AND sb_perfil_modulo.cve_modulo=sb_modulo.cve_modulo
                                                    AND sb_modulo.status_modulo<>0
                                                    ORDER BY grupo_modulo, posicion_modulo, nivel_modulo");

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
                                    if ($NUMERO_CICLO == 0) {
                                        // <li class=" nav-item has-sub open" id="menu_principal">
                                        // <li class=" nav-item has-sub" id="menu_principal">
                                        $CABECERA_PADRE = '                
                                        <li class=" nav-item has-sub open" id="menu_principal">
                                        <a class="d-flex align-items-center" href="' . (($VAL_MENU['url_include'] == 'null') ? '#' : ('index.php?mod=' . $VAL_MENU['cve_modulo'])) . '">
                                        ' . $VAL_MENU['icono'] . '
                                        <span class="menu-title text-truncate" data-i18n="Menu Levels">' . $VAL_MENU['descripcion_modulo'] . '</span>
                                        </a>
                                        <ul class="menu-content">';
                                    } else {
                                        $CABECERA_PADRE = '                
                                        <li class=" nav-item" id="menu_principal">
                                        <a class="d-flex align-items-center" href="' . (($VAL_MENU['url_include'] == 'null') ? '#' : ('index.php?mod=' . $VAL_MENU['cve_modulo'])) . '">
                                        ' . $VAL_MENU['icono'] . '
                                        <span class="menu-title text-truncate" data-i18n="Menu Levels">' . $VAL_MENU['descripcion_modulo'] . '</span>
                                        </a>
                                        <ul class="menu-content">';
                                    }

                                    break;

                                case 2:
                                    $CABECERA_PADRE = '                
                                    <li>
                                    <a class="d-flex align-items-center" href="' . (($VAL_MENU['url_include'] == 'null') ? '#' : ('index.php?mod=' . $VAL_MENU['cve_modulo'])) . '">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="Second Level">' . $VAL_MENU['descripcion_modulo'] . '</span>
                                    </a>
                                    <ul class="menu-content">';
                                    break;

                                default:
                                    break;
                            }
                            $CADENA_MENU .= $CABECERA_PADRE;
                            break;

                        case 'HIJO':
                            switch ($VAL_MENU['nivel_hijo']) {
                                case 1:
                                    $CABECERA_HIJO = '                
                                    <li id="menu_secundario">
                                    <a class="d-flex align-items-center" href="' . (($VAL_MENU['url_include'] == 'null') ? '#' : ('index.php?mod=' . $VAL_MENU['cve_modulo'])) . '">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="Second Level">' . $VAL_MENU['descripcion_modulo'] . '</span>
                                    </a>
                                    </li>';
                                    break;

                                case 2:
                                    $CABECERA_HIJO = '
                                    <li>
                                    <a class="d-flex align-items-center" href="' . (($VAL_MENU['url_include'] == 'null') ? '#' : ('index.php?mod=' . $VAL_MENU['cve_modulo'])) . '">
                                    <span class="menu-item text-truncate" data-i18n="Third Level">' . $VAL_MENU['descripcion_modulo'] . '</span>
                                    </a>
                                    </li>';
                                    $BANDERA_CIERRE_PADRE2 = 1;
                                    break;

                                default:
                                    break;
                            }
                            $CADENA_MENU .= $CABECERA_HIJO;
                            break;
                    }
                    if ($KEY_MENU === array_key_last($DATOS_MENU)) {
                        if ($BANDERA_CIERRE_PADRE2 == 1) {
                            $CIERRE_PADRE = '</ul></li></ul></li>';
                        } else {
                            $CIERRE_PADRE = '</ul></li>';
                        }
                    }
                    $NUMERO_CICLO++;
                }
                echo $CADENA_MENU;
                echo '           
                 </ul>
        </div>
    </div>';
            }
        } else {
            echo "ERROR EN LA CONSTRUCCION DEL MENU";
            include_once '../includes/sb_refresh.php';
        }
