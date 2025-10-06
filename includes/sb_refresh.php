<?php
echo "
	<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">
	<html xmlns=\"http://www.w3.org/1999/xhtml\">
	<head>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />"
 . "<meta http-equiv=\"Window-target\" content=\"_top\">"
 . "<title>" . $CFG_TITLE . " - [ CIERRE DE SESSION ]</title>
	
	";
echo "<body topmargin=\"0\" leftmargin=\"0\" >";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"estilos/estilo.css\" />";
$str_msg_red = 'ERROR ( PAGINA NO DISPONIBLE )';
include_once("includes/sb_msg_red.php");
$str_refresh = "index.php";
echo "<meta http-equiv='refresh' content='2;URL=" . $str_refresh . "'>";
echo "</body>";
