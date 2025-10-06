<?php
// @ISC.CHRISTOPHER DELGADILLO RAMIREZ
// CONTENIDO DE LOS ESTILOS Y LOS SCRIPTS DE LA PANTALLA PRINCIPAL
// FAVOR DE ANOTAR TUS CAMBIOS Y MODIFICACIONES GRACIAS
?>
<meta charset="utf-8" />
<meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
/>

<title>::ACTUALIZAGEM::</title>

<meta name="description" content="" />

<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="imagenes_sistema/escudo_estado_mexico.png">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
/>

<!-- Icons -->
<link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css" />
<link rel="stylesheet" href="assets/vendor/fonts/tabler-icons.css" />
<link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" />

<!-- Core CSS -->
<link rel="stylesheet" href="assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="assets/css/demo.css" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="assets/vendor/libs/node-waves/node-waves.css" />
<link rel="stylesheet" href="assets/vendor/libs/typeahead-js/typeahead.css" />
<!-- Vendor -->
<link rel="stylesheet" href="assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

<!-- Page CSS -->
<!-- Page -->
<link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />
<!-- Helpers -->
<script src="assets/vendor/js/helpers.js"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
<script src="assets/vendor/js/template-customizer.js"></script>
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="assets/js/config.js"></script>
<script src="js_sistema/misvalidaciones.js" type="text/javascript"></script>
<style>
    .authentication-wrapper.authentication-basic.container-p-y {
        position: relative;
    }

    .authentication-wrapper.authentication-basic.container-p-y::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-image: url('imagenes_sistema/portada.png');
        background-size: 100% 99%; /* 50% del ancho y 50% de la altura del contenedor */
        background-position: center;
        opacity: 1; /* Ajusta la opacidad según tus necesidades */
        z-index: -1; /* Coloca el pseudo-elemento detrás del contenido */
    }

</style>


