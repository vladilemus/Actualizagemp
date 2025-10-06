<?php
$str_check = FALSE;
include_once("sb_ii_check.php");
if ($str_check) {
    $IdPrin =$__SESSION->getValueSession('cveperfil');
    $mod=$__SESSION->getValueSession('mod');
    $consulta = new PDOConsultas();
    $consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0],$CFG_TIPO[0]);
    $modulo_acceso = $consulta->executeQuery("SELECT *
                                                        FROM
                                                        sb_perfil_modulo, sb_modulo
                                                        Where sb_perfil_modulo.cve_perfil =".$IdPrin."
                                                        and sb_perfil_modulo.cve_modulo =".$mod."
                                                        and sb_perfil_modulo.cve_modulo = sb_modulo.cve_modulo
                                                        and sb_modulo.sta_modulo <>0");
    $str_valmodulo = "MOD_NOVALIDO";
    if ($consulta->totalRows > 0) {
        $proceso="CREAR MODULO";
        $strwentidad = "crud.php";      
    }
} else {
    include_once("../configuracion/configuracion.php");
    include_once("sb_ii_refresh.php");
}

