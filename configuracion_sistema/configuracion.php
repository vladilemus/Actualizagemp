<?php

/**
 * @author CHRISTOPHER
 *
* CAMBIAR LOS PARAMETROS DE LA BASE DE DATOS
 * $CFG_HOST = array('127.0.0.1');
 * $CFG_USER = array('prototipo');
 * $CFG_DBPWD = array('prototipo');
 * $CFG_DBASE = array('prototipo');
 * $CFG_TIPO = array('mysql');
 * EL const _CFGSBASE = "SISTEMA_PROTOTIPO"; Y EL
 * $NOMBRE_CARPETA_PRINCIPAL = "prototipo";
SON PARAMETROS MUY IMPORTANTES
 *
 * EL PARAMETRO $str_ruta_inicial = "C:/wamp64/www/prototipo/"; SERA LA RUTA PRINCIPAL
 */

error_reporting(0);
// DESCOMENTAR SI SE QUIEREN VER LOS ERRORES DEL SISTEMA
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
include_once("session.php");

global $CFG_HOST;
global $CFG_USER;
global $CFG_DBPWD;
global $CFG_DBASE;
global $CFG_TIPO;
global $menu_sistema;

$CFG_HOST = array('127.0.0.1:3307');
$CFG_USER = array('root');
$CFG_DBPWD = array('');
$CFG_DBASE = array('dbservidores');
$CFG_TIPO = array('mysql');

//$CFG_HOST = array("127.0.0.1");
//$CFG_USER = array("root");
//$CFG_DBPWD = array("");
//$CFG_DBASE = array("dbglinkdgp");
//$CFG_TIPO = array("mysql");


const _CFGSBASE = "SISTEMA_ ADMCAPTURA";
$NOMBRE_SISTEMA = "ADMCFDI";
$NOMBRE_CARPETA_PRINCIPAL = "admcaptura";
$NOMBRE_CABECERA = "PORTAL DE ADMINISTRADOR";
$NOMBRE_SUBCABECERA = "AÑO :: ".date('Y');
$NOMBRE_TITLE = "SISTEMA CORRECCIÓN";
$__SESSION = new Session(_CFGSBASE);


$menu_sistema = "menu_horizontal.php";
//$menu_sistema = "menu_vertical.php";

$str_ruta_inicial = "C:/wamp64/www/admcaptura/";


