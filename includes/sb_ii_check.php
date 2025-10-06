<?php
global $NOMBRE_CARPETA_PRINCIPAL;
if ($_SERVER['PHP_SELF']=="/$NOMBRE_CARPETA_PRINCIPAL/index.php" && isset($__SESSION)){
	if ($__SESSION->getValueSession('nomusuario')<>"" && $__SESSION->getValueSession('passwd')<>"" && $__SESSION->getValueSession('cveperfil')<>"") {
//	if (isset($_SESSION['nomusuario']) && isset($_SESSION['cveperfil']) && isset($_SESSION['passwd'])){
//		if (!empty($_SESSION['nomusuario']) && !empty($_SESSION['cveperfil']) && !empty($_SESSION['passwd'])){
//			if (strlen($_SESSION['nomusuario'])>0 && strlen($_SESSION['cveperfil'])>0 && strlen($_SESSION['passwd'])>0){
				$str_check=TRUE;
//			}
//		}
	}
}

?>