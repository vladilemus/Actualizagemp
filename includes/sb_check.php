<?php

include_once('./configuracion/configuracion.php');
//print_r($_SESSION[_CFGSBASE]);
if (isset($_SESSION[_CFGSBASE]['nomusuario']) && isset($_SESSION[_CFGSBASE]['cveperfil']) && isset($_SESSION[_CFGSBASE]['passwd'])) {
//	if (!empty($_SESSION['nomusuario']) && !empty($_SESSION['cveperfil']) && !empty($_SESSION['passwd'])){
//		if (strlen($_SESSION['nomusuario'])>0 && strlen($_SESSION['cveperfil'])>0 && strlen($_SESSION['passwd'])>0){
    if ($__SESSION->getValueSession('nomusuario') <> "" && $__SESSION->getValueSession('passwd') <> "" && $__SESSION->getValueSession('cveperfil') <> "") {
        $str_check = TRUE;
    } else {
        session_destroy(); // destruyo la sesi�n
        header("Location: index.php"); //env�o al usuario a la pag. de autenticaci�n
    }
} else {
    session_destroy(); // destruyo la sesi�n
    header("Location: index.php"); //env�o al usuario a la pag. de autenticaci�n
}

