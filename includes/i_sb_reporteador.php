<?php
$str_check = FALSE;
include_once("sb_ii_check.php");
if ($str_check) {
    GLOBAL $__SESSION;
    $IdPrin =$__SESSION->getValueSession('cveperfil');
    $mod=$__SESSION->getValueSession('mod');
    $consulta = new PDOConsultas();
    global  $CFG_HOST,$CFG_USER,$CFG_DBPWD,$CFG_TIPO,$CFG_DBASE;
    $consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
    $modulo_acceso = $consulta->executeQuery("SELECT *
                                                        FROM
                                                        sb_perfil_modulo, sb_modulo
                                                        Where sb_perfil_modulo.cve_perfil =".$IdPrin."
                                                        and sb_perfil_modulo.cve_modulo =".$mod."
                                                        and sb_perfil_modulo.cve_modulo = sb_modulo.cve_modulo
                                                        and sb_modulo.status_modulo <>0");
    $str_valmodulo = "MOD_NOVALIDO";
    if ($consulta->totalRows > 0) {
    $entidad = 'REPORTE';
    //elste es para generar el excel
    $stropen = "reportes/nivelrango.php?";
    //este es para generar el pdf
    $stropenPDF = "reportes/pdfnivelrango.php?";
    //este es el que pinta el reporte y sus parametros
    $str_entidad = "entidad_reporteador.php";

    $fileExcel = true;
    $filePDF = true;
    }
} else {
    include_once("../configuracion_sistema/configuracion.php");
    include_once("sb_ii_refresh.php");
}