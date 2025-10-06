<?php

$str_check = FALSE;
include_once("sb_ii_check.php");
if ($str_check) {
    $field[] = array('cve_perfil', 'perfil_modulo', '0', 0);

    $field[] = array('cve_modulo', 'perfil_modulo', '1', "");
    $field[] = array('key_modulo', 'perfil_modulo', '1', "");
    $allf = array();
    $allv = array();
    foreach ($field as $afield) {
        $allf[] = $afield[0];
        $allv[] = $afield[3];
    }
    $IdPrin = '';
    $tabla = 'sb_perfil_modulo,sb_modulo';
    $strWhere = "Where sb_perfil_modulo.cve_perfil=" . $__SESSION->getValueSession('cveperfil');
    $strWhere.=" and sb_perfil_modulo.cve_modulo=" . $__SESSION->getValueSession('mod');
    $strWhere.=" and sb_perfil_modulo.cve_modulo=sb_modulo.cve_modulo";
    $strWhere.=" and sb_modulo.sta_modulo<>0";
    $classval = new Entidad($allf, $allv);
    $classval->Consultar($allf, $IdPrin, $tabla, $strWhere);
    $str_valmodulo = "MOD_NOVALIDO";
    if ($classval->NumReg > 0) {
        $str_valmodulo = "MOD_VALIDO";
        $a_key = explode(',', $classval->key_modulo);


        $per_val = array();
        $per_des = array();
        $classconsul = new Entidad(array('cve_perfil', 'des_perfil'), array(0, ''));
        $classconsul->ListaEntidades(array('cve_perfil'), 'sb_perfil', '');
        for ($i = 0; $i < $classconsul->NumReg; $i++) {
            $classconsul->VerDatosEntidad($i, array('cve_perfil', 'des_perfil'));
            $per_val[] = $classconsul->cve_perfil;
            $per_des[] = $classconsul->des_perfil;
        }



        $field = array();
        $allf = array();
        $allv = array();
        /* $field[]=array('0 - nombre','1 - etiqueta','2 - tipo de impresion(0: no imprimible, 1: imprimible, 2:dato de hiden principal)',
          '3 - tipo de objeto','4 - modificable(0: no mofificable, 1:modificable, 2: mofificable solo para nuevo registro)',
          '5 - valores alternos','6 - tipo de dato','7 - Valor inicial','8 - width de columna en brow', '9 - width de columna en view'
          '10 - longitud maxima en caja de texto', '11 - cadena de validaci&oacute;n', 12 - requiered); */
        $entidad = 'PERFIL MODULO';
        $strSelf = "sb_perfil_modulo.php";
        $id_prin = 'cve_modulo';
        $strWhere = "Where ";
        $a_order = array();

        $tablas_c = 'sb_perfil_modulo';
        $a_order[] = $id_prin;


        /**/
        $m_keyFields = array('cve_usuario');
        $m_Table = 'sb_usuario';
        $m_Fields = array('nom_usuario', 'des_usuario');
        $m_keyTypeFields = array('num'); //num,text
        $m_TypeFields = array('text', 'text'); //num,text
        $a_keyValNiv = array();
        /**/
        $boolkeyValNiv = TRUE;
        $a_mdLabel = array('Modulo');
        $m_keyFields = array('cve_modulo');
        $m_Table = 'sb_modulo';
        $m_Fields = array('des_modulo', 'url_include');
        $m_keyTypeFields = array('num'); //int,text
        $m_TypeFields = array('text', 'text'); //num,text
        $a_keyValNiv = array();
        /* SI EXISTEN IT SE CREA CONDICION */
        if (isset($_GET['it0'])) {
            foreach ($m_keyFields as $cont => $item) {
                $a_keyValNiv[] = $_GET['it' . $cont];
                if ($strWhere != "Where ")
                    $strWhere.=" and ";
                if ($m_keyTypeFields[$cont] == 'num') {
                    $strWhere.=$item . "=" . $_GET['it' . $cont];
                } else {
                    $strWhere.=$item . "='" . $_GET['it' . $cont] . "'";
                }
            }
            /* asignar el arreglo de valores en el nivel que corresponde */
            foreach ($__SESSION->getValueSession('niveles') as $cont => $item) {
                //echo $item."|".$strSelf."|".$cont;
                if ($item == $strSelf) {
                    $__SESSION->setValueItemSession('mdKeyFields', $cont, $m_keyFields);
                    $__SESSION->setValueItemSession('mdKeyTFields', $cont, $m_keyTypeFields);
                    $__SESSION->setValueItemSession('mdFields', $cont, $m_Fields);
                    $__SESSION->setValueItemSession('mdTFields', $cont, $m_TypeFields);
                    $__SESSION->setValueItemSession('mdValFields', $cont, $a_keyValNiv);
                    $__SESSION->setValueItemSession('mdTable', $cont, $m_Table);
                    $__SESSION->setValueItemSession('keyValNiv', $cont, $a_keyValNiv);
                    $__SESSION->setValueSession('intSelfNivel', $cont);
                    break;
                }
            }
        } else {
            foreach ($__SESSION->getValueSession('niveles') as $cont => $item) {
                if ($item == $strSelf) {
                    $__SESSION->setValueSession('intSelfNivel', $cont);
                    $atmp_keyValNiv = $__SESSION->getValueSession('keyValNiv');
                    if (isset($atmp_keyValNiv[$cont])) {
                        foreach ($m_keyFields as $contVal => $itemVal) {
                            if ($strWhere != "Where ")
                                $strWhere.=" and ";
                            if ($m_keyTypeFields[$contVal] == 'num') {
                                $strWhere.=$itemVal . "=" . $atmp_keyValNiv[$cont][$contVal];
                            } else {
                                $strWhere.=$itemVal . "='" . $atmp_keyValNiv[$cont][$contVal] . "'";
                            }
                        }
                    }
                    break;
                }
            }
        }
//echo $cont."<pre>";	
//	print_r($__SESSION->getAll());
//	echo "</pre>";	
//	die();
        if ($strWhere == "Where ")
            $strWhere = "";
        //$strWhere.=" prioridad.estado <> FALSE";
        //$items0='perfil.*';
        $tabla = 'sb_perfil_modulo';
        $intlimit = 1000;
        $a_separs = array();
        $a_separs[] = array(1, 'datos generales', 6, $CFG_BGC[10]);
        $field[] = array('cve_modulo', 'Modulo', '2', 'label', '0', '', 'int', 0, 50, 20, 0, '', 1, 1, 5);
        $field[] = array('cve_perfil', 'Perfil', '1', 'select', '2', array($per_val, $per_des), 'int', 0, 400, 20, 2, '', 1, 1, array(1, 1, 6));
        $field[] = array('key_modulo', 'Cadena Llave', '1', 'text', '1', '', 'char', "0,0,0,0,0", 300, 30, 60, '', 1, 1, array(1, 1, 6));
        $setdel = '';
        
        $strDistintic = 'SELECT count(*) as count_r FROM ' . $tabla . ' ' . $strWhere;

        $keyFields = array('cve_modulo', 'cve_perfil');
        $keyTypeFields = array('num', 'num'); //int,text
        $array_noprint_ent = array('null');
//        $keyFieldsUnique = array('cve_modulo', 'cve_perfil');
//        $keyTypeFieldsUnique = array('num', 'num'); //int,text

        $rwitem = 'null';
        $suma_width = 0;
        $strwentidad = "md_entidad5.php";
        $ent_add = "addentidad0002.php";
        $ent_upd = "updentidad0002.php";

        $boolNoEditable = FALSE;
        $boolNoUpdate = TRUE;
        $boolNoDelete = FALSE;
        //$_SESSION['niveles']=array('i_wp_usuario.php');
        //$intNivel=0;


        $suma_width = 0;
        $numcols = 0;
        foreach ($field as $afield) {
            if ($afield[2] == '1') {
                $suma_width+=$afield[8];
                $numcols+=1;
            }
        }
        $awidths = array('300', '150', '650');
        //	$str_ent=$PHP_SELF."?ent=i_indicador&id=";
        //	if (isset($_GET['opccal']) && $_GET['opccal']==1)
        //		$str_ent=$PHP_SELF."?opccal=".$_GET['opccal']."&ent=i_proyecto&id=";
        //	}
    }
} else {
    include_once("../config/cfg.php");
    include_once("../lib/lib_function.php");
    include_once("sb_ii_refresh.php");
}
?>