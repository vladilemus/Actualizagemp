<?php
/*
 * @CHRISTOPPHER DELGADILLO
 * SE REALIZARON LAS SIGUIENTES MODIFICACIONES
 */
print_r($__SESSION);die("----------------------------->");
if (strlen(session_id()) == 0) {
    session_start();
}
include_once('./configuracion/configuracion.php');
if ($__SESSION->getValueSession('nomusuario') <> "" && $__SESSION->getValueSession('passwd') <> "" && $__SESSION->getValueSession('cveperfil') <> "") {
print_r($__SESSION);die();
    $perfil = $__SESSION->getValueSession('cveperfil');

    $consulta = new PDOConsultas();
   $consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0],$CFG_TIPO[0]);
    $datos_acceso = $consulta->executeQuery("SELECT 
                                                        *
                                                        FROM 
                                                        sb_perfil_modulo 
                                                        INNER JOIN  sb_modulo ON 
                                                                sb_modulo.display=1 AND sb_perfil_modulo.cve_perfil=$perfil
                                                        AND sb_perfil_modulo.cve_modulo=sb_modulo.cve_modulo
                                                        AND sb_modulo.sta_modulo<>0
                                                        ORDER BY grp_modulo, pos_modulo, niv_modulo");

    if ($consulta->totalRows > 0) {
        ?>

        <?php

        $group = -1;
        $p = "";
        $padre = false;
        $bandera_ul = false;
        for ($i = 0; $i < count($datos_acceso); $i++) {



            if ($datos_acceso[$i]['grp_modulo'] != $group) {

                $group = $datos_acceso[$i]['grp_modulo'];
                if ($i == 0) {
                    
                } else {

                    echo '</ul>';
                }
            }
            if ($datos_acceso[$i]['url_modulo'] != 'null') {
                //ESTE ES PARA EL HIJO
                if ($datos_acceso[$i]['niv_modulo'] == 3) {
                    echo '<li class="item-name"><a href="' . (($datos_acceso[$i]['url_include'] == 'null') ? '#' : ('index.php?mod=' . $datos_acceso[$i]['cve_modulo'])) . '"><i class="' . $datos_acceso[$i]['icono'] . ' mr-2 text-muted"></i><span class="text-muted">' . substr($datos_acceso[$i]['des_modulo'], 0, 23) . '</span></a></li>';
                } else {
                    if ($datos_acceso[$i - 1]['niv_modulo'] == 3) {
                        echo '</ul>';
                        echo '<li class="item-name"><a href="' . (($datos_acceso[$i]['url_include'] == 'null') ? '#' : ('index.php?mod=' . $datos_acceso[$i]['cve_modulo'])) . '"><i class="' . $datos_acceso[$i]['icono'] . ' mr-2 text-muted"></i><span class="text-muted">' . substr($datos_acceso[$i]['des_modulo'], 0, 23) . '</span></a></li>';
                    } else {
                        echo '<li class="item-name"><a href="' . (($datos_acceso[$i]['url_include'] == 'null') ? '#' : ('index.php?mod=' . $datos_acceso[$i]['cve_modulo'])) . '"><i class="' . $datos_acceso[$i]['icono'] . ' mr-2 text-muted"></i><span class="text-muted">' . substr($datos_acceso[$i]['des_modulo'], 0, 23) . '</span></a></li>';
                    }
                }
            } else {
                //ESTE ES PA RA LAS ETIQUETAS PADRES

                if ($datos_acceso[$i]['niv_modulo'] == 2) {
                    echo ' <li class="item-name"><a class="has-arrow cursor-pointer"><i class="' . $datos_acceso[$i]['icono'] . ' text-20 mr-2 text-muted"></i><span class="item-name text-15 text-muted">' . substr($datos_acceso[$i]['des_modulo'], 0, 23) . '&nbsp;</span></a> ';
                    echo '<ul class="mm-collapse">';
                } else {
                    echo '<li class="Ul_li--hover"><a class="has-arrow" href="#"><i class="' . $datos_acceso[$i]['icono'] . ' text-20 mr-2 text-muted"></i><span class="item-name text-15 text-muted">' . substr($datos_acceso[$i]['des_modulo'], 0, 23) . '&nbsp;</span></a>';
                    echo '<ul class="mm-collapse">';
                }
            }
//            if ($datos_acceso[$i]['niv_modulo'] == 3 && $datos_acceso[$i+1]['url_modulo'] == 'null') {
//                echo '</ul>';
//            }
            if ($i == count($datos_acceso) - 1) {
                echo '</ul></li>';
            }
        }
        ?>
        <?php

    }
} else {
    include_once '../includes/sb_refresh.php';
}
    