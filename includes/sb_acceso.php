<?php
include_once('./configuracion_sistema/configuracion.php');
include_once './librerias/PDOConsultas.php';

$str_login = 'NOTHING';
$field = array();
$field[] = array('cve_usuario', 'usuario', '1', 0);
$field[] = array('nom_usuario', 'usuario', '0', "");
$field[] = array('passwd', 'usuario', '1', "");
$field[] = array('des_usuario', 'usuario', '1', "");
$field[] = array('cve_estatus', 'usuario', '1', "");
$field[] = array('cve_perfil', 'perfil', '1', 0);
$field[] = array('cve_usergroup', 'usuario', '1', 0);
$field[] = array('des_perfil', 'perfil', '1', "");
$field[] = array('cve_organismo', 'usuario', '1', 0);
$field[] = array('alta', 'alta', '1', 0);
$field[] = array('actualiza', 'actualiza', '1', 0);
$field[] = array('elimina', 'elimina', '1', 0);
$field[] = array('file_user_image_file', 'usuario', '1', 0);
$field[] = array('cve_usergroup', 'grupo', '1', 0);
$field[] = array('des_usergroup', 'grupo', '1', 0);
$field[] = array('des_usergroup', 'grupo', '1', 0);
$field[] = array('cve_15', 'usuario', '1', 0);
$field[] = array('grupo_usuarios', 'perfil', '1', "");

$allf = array();
$allv = array();

foreach ($field as $afield) {
    $allf[] = $afield[0];
    $allv[] = $afield[3];
}

$IdPrin = '';

foreach ($field as $afield)
    if ($afield[2] == '0') {
        $IdPrin = $afield[0];
        break;
    }
if (isset($_POST['txtnomusuario']) && isset($_POST['txtpasswd']) && isset($_POST['hidlogin']) && isset($_POST['hid_login'])) {
    if (!is_null($_POST['txtnomusuario']) && !is_null($_POST['txtpasswd']) && !is_null($_POST['hidlogin'])) {
        if (strlen(trim($_POST['txtnomusuario'])) > 0 && strlen(trim($_POST['txtpasswd'])) > 0 && strlen(trim($_POST['hidlogin'])) > 0) {
            if (true) {
                unset($_SESSION[_CFGSBASE]);
                $IdPrin = base64_decode(substr($_POST['txtnomusuario'], 1, -1));
                $pwd = base64_decode(substr($_POST['txtpasswd'], 1, -1));

                global $CFG_HOST, $CFG_USER, $CFG_DBPWD, $CFG_DBASE, $CFG_TIPO;

//                $consulta = new PDOConsultas();
//                $consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
//                $consulta2 = new PDOConsultas();
//                $consulta2->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

                $consulta = new PDOConsultas();
                $consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);
                $consulta2 = $consulta;

                $prepara_consulta="SELECT 
                                                    u.cve_usuario, 
                                                    u.des_usuario, 
                                                    u.nom_usuario, 
                                                    u.cve_estatus, 
                                                    u.passwd, 
                                                    u.cve_perfil, 
                                                    p.des_perfil, 
                                                    p.alta, 
                                                    p.actualiza, 
                                                    p.elimina, 
                                                    u.cve_organismo, 
                                                    u.file_user_image_file, 
                                                    u.cve_usergroup, 
                                                    g.des_usergroup     
                                                    from sb_usuario u 
                                                    JOIN sb_perfil p ON u.cve_perfil = p.cve_perfil 
                                                    JOIN sb_usergroup g ON u.cve_usergroup=g.cve_usergroup                                         
                                                    Where u.nom_usuario='" . $IdPrin . "' and u.cve_estatus <> 0 and u.passwd ='" . base64_encode($pwd) . "' and p.sta_perfil <> 0 ";

                $datos_acceso = $consulta->executeQuery( $prepara_consulta);
                /////// CON LA FINALIDAD  DE SABER EN QUE GRUPOS DE USUARIOS TIENE ACCESO EL ORGANISMOS
                $query_grupo_usuarios = "SELECT * FROM sb_perfil_usergroup WHERE cve_usuario=" . $datos_acceso[0]['cve_usuario'] . " ORDER BY cve_usergroup ASC";

                $grupo_usuarios = $consulta2->executeQuery($query_grupo_usuarios);

                foreach ($grupo_usuarios as $keygrupo => &$valgrupo) {
                    $grupo_session[] = array($valgrupo['cve_usergroup'], $valgrupo['dominante']);
                }
                $str_gets = "";
                if ($consulta->totalRows > 0) {
                    $str_login = 'SESSION_00';
                } else {
                }
            } else {
                $str_login = 'SIN_DATOS';
            }
        } else {
            $str_login = 'DATOS_INC';
        }
    } else {
        $str_login = 'SIN_DATOS';
    }
} else {
    $str_login = 'SIN_DATOS';
}
