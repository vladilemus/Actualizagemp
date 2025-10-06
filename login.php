<?php
declare(strict_types=1);
session_start();
include_once('./configuracion_sistema/configuracion.php');

global $__SESSION;

if ($__SESSION->getValueSession('nomusuario') !== "") {
    header("Location: index.php");
    exit();
}
global $NOMBRE_CABECERA,$NOMBRE_SUBCABECERA;
$intlogin=0;
?>
<!DOCTYPE html>

<html
        lang="en"
        class="light-style customizer-hide"
        dir="ltr"
        data-theme="theme-default"
        data-assets-path="assets/"
        data-template="horizontal-menu-template"
>
<head>
    <?php include_once 'cabecera_sistema/cabecera_login.php'; ?>
    <link rel="shortcut icon" type="image/x-icon" href="imagenes_sistema/escudo_estado_mexico.png">
</head>

<body>
<!-- Content -->


    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Login -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4 mt-2">
                        <a href="..//index.php" class="app-brand-link gap-2">

                        <img src="imagenes_sistema/escudo_estado_mexico.png" width="100%" height="35">

                            <span class="app-brand-text demo text-body fw-bold ms-1"></span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-1 pt-2"><center>ADMINISTRADOR DE CAPTURA Y ACTUALIZACIÓN CFDI</center></h4>
                    <p class="mb-4"></p>

                    <form id="formAuthentication" class="mb-3" id="loginform" method="POST" action="index.php">
                        <input type="hidden" name="hidlogin" value="<?php echo $intlogin; ?>">
                        <input type="hidden" name="hid_login" value="<?php echo session_id(); ?>">
                        <div class="mb-3">
                            <label for="usuario" class="form-label" style="text-align: center;">USUARIO</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="txtnomusuario"
                                    name="txtnomusuario"
                                    placeholder="Usuario"
                                    autofocus
                            />
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">CONTRASEÑA</label>
                                <a href="#">
                                    <small>Olvidaste t&uacute; Contraseña?</small>
                                </a>
                            </div>
                            <div class="input-group input-group-merge">
                                <input
                                        type="password"
                                        id="txtpasswd"
                                        class="form-control"
                                        name="txtpasswd"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password"
                                />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        <div class="mb-3" style="text-align: center;">
                            <!-- Tu contenido centrado aquí -->
                            <p><h3><?=date('Y')?></h3></p>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100"  id="btningresa">ACCEDER AL SISTEMA</button>
                        </div>
                    </form>

                    <p class="text-center">
                        <span>Nuevo en la plataforma?</span>
                            <span>Acude con el Administrador de Sistema</span>
                    </p>

<!--                    <div class="divider my-4">-->
<!--                        <div class="divider-text">or</div>-->
<!--                    </div>-->
<!---->
<!--                    <div class="d-flex justify-content-center">-->
<!--                        <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">-->
<!--                            <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>-->
<!--                        </a>-->
<!---->
<!--                        <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">-->
<!--                            <i class="tf-icons fa-brands fa-google fs-5"></i>-->
<!--                        </a>-->
<!---->
<!--                        <a href="javascript:;" class="btn btn-icon btn-label-twitter">-->
<!--                            <i class="tf-icons fa-brands fa-twitter fs-5"></i>-->
<!--                        </a>-->
<!--                    </div>-->
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
<?php include_once 'pie_sistema/pie_login.php'; ?>
<script src="librerias/excepciones/excepxiones.js" type="text/javascript"></script>
</body>
</html>
