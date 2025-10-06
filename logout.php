<?php
declare(strict_types=1);
session_start();
include_once('./configuracion_sistema/configuracion.php');

$str_msg_red = "";
$time = 0;

global $__SESSION;

if ($__SESSION->getValueSession('nomusuario') !== "") {
    unset($_SESSION[_CFGSBASE]);
    $str_refresh = "index.php";
    $time = 1;
} else {
    $i_intcolor = 25;
    unset($_SESSION[_CFGSBASE]);
    $str_refresh = "index.php";
    $time = 1;
}
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <title>CERRANDO SESIÓN</title>

        <!-- Styles -->
        <link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css">
        <link rel="stylesheet" href="assets/vendor/fonts/tabler-icons.css">
        <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css">
        <link rel="stylesheet" href="assets/vendor/css/rtl/core.css" class="template-customizer-core-css">
        <link rel="stylesheet" href="assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css">
        <link rel="stylesheet" href="assets/css/demo.css">
        <link rel="stylesheet" href="assets/vendor/libs/node-waves/node-waves.css">
        <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
        <link rel="stylesheet" href="assets/vendor/libs/typeahead-js/typeahead.css">
        <link rel="stylesheet" href="assets/vendor/css/pages/page-misc.css">

        <!-- Helpers -->
        <script src="assets/vendor/js/helpers.js"></script>
        <script src="assets/vendor/js/template-customizer.js"></script>
        <script src="assets/js/config.js"></script>
    </head>

    <body>
    <!-- Content -->

    <!--Under Maintenance -->
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h1 class="mb-1 mx-2">-C E R R A N D O     S E S S I O N-</h1>
            <p class="mb-4 mx-2">GRACIAS POR SU VISITA</p>
            <a href="index.html" class="btn btn-primary mb-4">Back to home</a>
            <div class="mt-4">
                <img src="assets/img/illustrations/page-misc-under-maintenance.png" alt="page-misc-under-maintenance" width="550" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="container-fluid misc-bg-wrapper misc-under-maintenance-bg-wrapper">
        <img src="assets/img/illustrations/bg-shape-image-light.png" alt="page-misc-under-maintenance" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png">
    </div>
    <!-- /Under Maintenance -->

    <!-- / Content -->

    <!-- Core JS -->
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/libs/hammer/hammer.js"></script>
    <script src="assets/vendor/libs/i18n/i18n.js"></script>
    <script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    <script src="assets/js/main.js"></script>
    </body>

    </html>

<?php
echo "<meta http-equiv='refresh' content='" . $time . "; URL=" . $str_refresh . "'>";
