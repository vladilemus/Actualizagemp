<?php
if (strlen(session_id()) == 0) {
    session_start();
    include_once("configuracion_sistema/configuracion.php");
    global $NOMBRE_CARPETA_PRINCIPAL;
}
$str_check = FALSE;
include_once("configuracion_sistema/configuracion.php");
include_once("includes/sb_check.php");
ini_set("display_errors", 1);
if ($str_check) {
?>
<!DOCTYPE html>
<html
        lang="en"
        class="light-style layout-menu-fixed"
        dir="ltr"
        data-theme="theme-default"
        data-assets-path="assets/"
        data-template="horizontal-menu-template-no-customizer">
<head>
    <meta charset="utf-8" />
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>::ADMCAPTURA::</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="imagenes_sistema/escudo_estado_mexico.png">

    <link href="app-assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">
    <script src="js_sistema/jquery.min.js"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="assets/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />
    <link href="assets/sweet/sweetalert2.css" rel="stylesheet" type="text/css"/>
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="assets/vendor/libs/swiper/swiper.css" />
    <link rel="stylesheet" href="assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="assets/vendor/css/pages/cards-advance.css" />
    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>


</head>

<body>
<?php
$field = array();
$modulo = 0;
$dmenu = false;
$pag_centro = "presentacion.php";
$strInclude = '';


if (isset($_GET['mod'])) {
    $modulo = $_GET['mod'];
    $__SESSION->setValueSession('opc', '0');
    $__SESSION->setValueSession('msg', '0');
    $__SESSION->setValueSession('pag', '1');
    $__SESSION->setValueSession('mod', $modulo);
    if ($__SESSION->getValueSession('niv') <> "") {
        $__SESSION->unsetSession('niv');
    }
    if ($__SESSION->getValueSession('valSearch') <> "") {
        $__SESSION->unsetSession('valSearch');
        $__SESSION->unsetSession('itemSearch');
    }
} else {
    if ($__SESSION->getValueSession('mod') <> "") {
        $modulo = $__SESSION->getValueSession('mod');
    } else {
        $perfil = $__SESSION->getValueSession('cveperfil');
        $modulo = $__SESSION->getValueSession('mod');
    }
}
/*******************************SECCION DE LAS POSICIONES Y DE LAS LLAVES PRINCIPALES*******************************************************************/
if ($modulo > 0) {

    $IdPrin = $__SESSION->getValueSession('cveperfil');
//    print_r($_SESSION);
//    die();
    $consulta = new PDOConsultas();
    $consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
    $modulo_acceso = $consulta->executeQuery("SELECT *
                                                                FROM
                                                                sb_perfil_modulo, sb_modulo
                                                                Where sb_perfil_modulo.cve_perfil =$IdPrin
                                                                and sb_perfil_modulo.cve_modulo =$modulo
                                                                and sb_perfil_modulo.cve_modulo = sb_modulo.cve_modulo
                                                                and sb_modulo.status_modulo <>0");
    if ($consulta->totalRows > 0) {
        $strInclude = $modulo_acceso[0]['url_include'];
    }
}
/********************************************************************************************************************************************************/

if (strlen($strInclude) > 0) {

    if (isset($_GET['pila'])) {

        $array_auxiliar = explode(',', $_GET['pila']);
        $CONSULTA_NIVELES = new PDOConsultas();
        $CONSULTA_NIVELES->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
        $REDIRECCIONA_ARCHIVO = $CONSULTA_NIVELES->executeQuery("SELECT 
                    cve_modulo, descripcion_modulo, status_modulo, 
                    url_modulo, grupo_modulo, posicion_modulo, nivel_modulo, 
                    url_include, tipo_nivel, nivel_padre, nivel_hijo, icono
                    FROM sb_modulo
                    WHERE
                    cve_modulo=" . $modulo);

        if ($CONSULTA_NIVELES->totalRows > 0) {
            $strInclude = base64_decode($array_auxiliar[2]);
            $modulo = $REDIRECCIONA_ARCHIVO[0]['cve_modulo'];
            $array_niveles[] = array(
                "clave" => (base64_decode($array_auxiliar[0])),
                "llave" => (base64_decode($array_auxiliar[1])),
                "modulo" => ($REDIRECCIONA_ARCHIVO[0]['descripcion_modulo']),
                "anterior" => $_SERVER['HTTP_REFERER'],
                "mod" => (base64_decode($array_auxiliar[3])),
                "nivelpadre" => (base64_decode($array_auxiliar[4]))
            );

            $__SESSION->setValueSession('niveles', $array_niveles);
        } else {
            echo "ERRROR AL OBTENER EL CODIGO DE INCLUDE";
        }
    } else {
        $__SESSION->unsetSession('niveles');
        // header('Location: index.php?mod='. $modulo );
    }

    include_once('includes/' . $strInclude);

    $pag_centro = $str_entidad;
    $str_back = "";
    $footer = true;

    if (isset($_POST['opc'])) {
        if ($_POST['opc'] == 2) {
            $__SESSION->setValueSession('opc', 2);
        }
        if ($_POST['opc'] == 3) {
            $__SESSION->setValueSession('opc', 3);
        }
    }
    if ($__SESSION->getValueSession('opc') <> "") {
        switch ($__SESSION->getValueSession('opc')) {
            case 2:
                $pag_centro = $str_addentidad;
                break;
            case 3:
                $pag_centro = $str_updentidad;
                break;
        }
    }
}/* termina conf modulo a visualizar */

?>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
    <div class="layout-container">
        <!-- Navbar -->

        <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
            <div class="container-xxl">
                <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
                    <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">

                </span>
                        <span class="app-brand-text demo menu-text fw-light"><b>ADMCAPTURA </b></span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                        <i class="ti ti-x ti-sm align-middle"></i>
                    </a>
                </div>

                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="ti ti-menu-2 ti-sm"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img src="imagenes_sistema/escudo_estado_mexico.png"  alt class="h-auto rounded-circle" />
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="pages-account-settings-account.html">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar avatar-online">
                                                    <img src="imagenes_sistema/escudo_estado_mexico.png" alt class="h-auto rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-medium d-block"><?=$__SESSION->getValueSession('nomusuario')?></span>
                                                <small class="text-muted"><?=$__SESSION->getValueSession('desperfil')?></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../<?= $NOMBRE_CARPETA_PRINCIPAL ?>/logout.php">
                                        <i class="ti ti-logout me-2 ti-sm"></i>
                                        <span class="align-middle">-CERRAR SESSION-</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Menu -->
                <aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
                    <div class="container-xxl d-flex h-100">
                        <ul class="menu-inner">
                            <?php
                            require_once 'menu_sistema/'.$menu_sistema;
                            ?>
                        </ul>
                    </div>
                </aside>
<!--                <span>               -->
<!--                    --><?php
//                    echo "</br>";
//                    echo "</br>";
//                    echo "</br>";
//                    echo "</br>";
//                    print_r($_SESSION);
//                    ?>
<!--                </span>-->
                <!-- / Menu -->
                <!-- Content -->
                        <?php
                        //print_r($_SESSION);
                        include $pag_centro;
                        ?>
                <!--/ Content -->

                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl">
                        <div
                                class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                            <div>
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                ,Unidad De Informática De La Dirección General de Personal ❤ Derechos Reservados <a href="#" target="_blank" class="fw-medium"></a>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!--/ Content wrapper -->
        </div>

        <!--/ Layout container -->
    </div>
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="assets/vendor/libs/jquery/jquery.js"></script>
<script src="assets/vendor/libs/popper/popper.js"></script>
<script src="assets/vendor/js/bootstrap.js"></script>
<script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="assets/vendor/libs/node-waves/node-waves.js"></script>

<script src="assets/vendor/libs/hammer/hammer.js"></script>
<script src="assets/vendor/libs/i18n/i18n.js"></script>
<script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>

<script src="assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="assets/vendor/libs/swiper/swiper.js"></script>
<script src="assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="assets/sweet/sweetalert2.js" type="text/javascript"></script>
<script src="js_sistema/XHConn.js" type="text/javascript"></script>
<!-- Main JS -->
<script src="assets/js/main.js"></script>

<!-- Page JS -->
<script src="assets/js/dashboards-analytics.js"></script>
</body>
</html>
    <?php
} else {
    include_once("includes/sb_refresh.php");
}
?>