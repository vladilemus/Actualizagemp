<?php
//SECCION DE LA CREACION DE LOS ARCHIVOS
session_start();
require '../configuracion_sistema/configuracion.php';
require '../librerias/PDOConsultas.php';

$tabla = $_GET['seleccionados'];
$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0],$CFG_TIPO[0]);

$datos = $consulta->executeQuery("SELECT column_name,data_type 
from information_schema.columns 
where table_name = '".$_GET['seleccionados']."' 
AND table_catalog='$CFG_DBASE[0]'");


$campos = "";

foreach ($datos as $key => &$val) {

    if ($datos[0]['data_type'] == 'PRI') {
        $clave = $datos[0]['column_name'];
    }
    switch ($val['data_type']) {
        case 'integer':
            $tipoformulario = 'number';
            $tipopostgres= 'int';
            break;
        case 'character varying':
            $tipoformulario = 'text';
            $tipopostgres= 'varchar';
            break;
        case 'bigint':
            $tipoformulario = 'number';
            $tipopostgres= 'int';
            break;
        default:
            $tipoformulario = 'text';
            $tipopostgres= 'varchar';
            break;
    }
    $campos .= "
                \$field[]=array('" . $val['column_name'] . "','" . $val['column_name'] . "','VISTA','$tipoformulario','OBLIGATORIO','" . $tipopostgres. "', '', array(0, 12),'100','30');";
}

$contenido = '';

$contenido = "<?php
\$str_check = FALSE;
include_once(\"sb_ii_check.php\");
if (\$str_check) {
    \$IdPrin =\$__SESSION->getValueSession('cveperfil');
    \$mod=\$__SESSION->getValueSession('mod');
    \$consulta = new PDOConsultas();
    \$consulta->connect(\$CFG_HOST[0], \$CFG_USER[0], \$CFG_DBPWD[0], \$CFG_DBASE[0],\$CFG_TIPO[0]);
    \$modulo_acceso = \$consulta->executeQuery(\"SELECT *
                                                        FROM
                                                        sb_perfil_modulo, sb_modulo
                                                        Where sb_perfil_modulo.cve_perfil =\".\$IdPrin.\"
                                                        and sb_perfil_modulo.cve_modulo =\".\$mod.\"
                                                        and sb_perfil_modulo.cve_modulo = sb_modulo.cve_modulo
                                                        and sb_modulo.status_modulo <>0\");


    \$str_valmodulo = \"MOD_NOVALIDO\";
    if (\$consulta->totalRows > 0) {
        //CAMBIA EL TEXTO DEL BOTON
        \$boton_texto=\"NUEVO REGISTRO\";
        \$campo = array();
        \$entidad = 'AQUI VA EL NOMBRE';
        \$id_prin = '$clave';
        \$strWhere = '';   
        \$a_order = array();
        \$impresora = FALSE; 
        \$tamanio_tabla=\"100%\";
        \$intlimit=10;

        //SECCION DE LOS CAMPOS DE BUSQUEDA
        /******************DESCOMENTAR ESTA SECCION SI NECESITAN CAMPOS DE BUSQUEDA**************************/
        ////\$a_search_campo = array('des_sexo');
        ////\$a_search_etiqueta = array('DESCRIPCION');
        ////\$a_search_tipo = array('text');

        //SECCION DE LOS NIVELES DE ACCESO
        /******************DESCOMENTAR ESTA SECCION SI NECESITAN LOS ARCHIVOS PHP**************************/
        //\$niveles_acceso=array('i_sb_perfil.php');
        //\$niveles_acceso_etiqueta=array('PERFILES');

        \$tabla='" . $tabla . "';
        \$campos_join  = '';
        \$tabla_join = '';
        /******************SECCIOM DE LOS SEPARADORES*****************************************/
        \$separadores=array('SEPARADOR 1','SEPARADOR 2','SEPARADOR 3');
        /**************************************************************************/
        /******************JOINS (EJEMPLO)*****************************************/
        //\$tabla = 'cat_sexo a';
        //\$tabla_join = ' LEFT JOIN cat_estatus b on a.cve_estado=b.cve_estado';
        //\$campos_join = 'a.cve_sexo,a.des_sexo,b.des_estado,a.cve_estado';
        /***************************************************************************/
        /************************SECCION DE LOS BOTONES************************************************************************************/
        //\$streditar = TRUE;
        //\$streliminar = TRUE;
        //\$strnuevo = TRUE;
        //\$str_javascript='<script src=\"metodos_javascript\js_sb_persona.js\"></script>';
        /**********************************************************************************************************************************/
        /******************SECCION DE LOS SELECTS(EJEMPLO)***********************************/
        //\$consulta2 = new PDOConsultas();
        //\$consulta2->connect(\$CFG_HOST[0], \$CFG_USER[0], \$CFG_DBPWD[0], \$CFG_DBASE[0]);
        //\$select= \$consulta2->executeQuery(\"SELECT cve_estado,des_estado FROM cat_estatus\");
        //foreach (\$select as \$keyselect => &\$valselect) {
            //\$vector[]=array(\$valselect['cve_estado'],\$valselect['des_estado']);
            //}
        /************************************************************************** */
        /******************SELECTS(EJEMPLO)***********************************************/
        //\$field[] = array('cve_estado', 'cve_estado', 'VISTA', 'select', 'OBLIGATORIO', 'int',\$vector);
        /*************************************************************************************************/

        /***************************************SECCION DE LOS SELECTS EN CASCADA (EJEMPLO)****************************************************
         \$select_cascada[] = array(
            \"llave1\" => ('cve_estado'), \"llave2\" => ('cve_estado'),\"origen\" => ('cve_estado_origen'),\"destino\" => ('cve_municipio_origen'),\"datos\" => ('des_municipio'), \"tablas\" => array('cat_estado', 'cat_municipio'),\"condicion\" => (''), \"archivo\" => ('../' . \$NOMBRE_CARPETA_PRINCIPAL . '/getElementos/get_elementos.php')
        );

        **************************************************************************************************************************************/

        /*POSICION DE LOS DATOS EN EL ARRAY FIELD*/
        //0.- CLAVE PRINCIPAL
        //1.- //1.- NOMBRE DE LA ETIQUETA DE LAS CABECERAS DEL CAMPO AMOSTRAR
        //2.- VISIBILIDAD DEL CAMPO
        //3.- TIPO DE DATO PARA EL FORMULARIO
        //4.- CAMPO OBLIGATORIO O NO OBLIGATORIO (TENER EN CUENTA EL TIPO DE LLAVE DEL CAMPO PRINCIPAL YA QUE EN SU MAYORIA ES AUTOINCREMENTABLE EN ESE CASE SE DEBE DE ESCONDER)
        //5.- TIPO DE DATO EN BASE DE DATOS
        //6.- VECTOR DE DATOS QUE CONTIENE UN PAR DE ARRAYS PARA LA CONSTRUCCION DINAMICA DE LOS SELECTS
        //7.- VECTOR DE LOS PESOS PARA LA CONSTRUCCION DE LOS SEPARADORES Y LA DISTRIBUCION DE LOS CAMPOS, (ARRAY DEFINIDO EN 12 POSICIONES)
        //8.- SECCION DEL TAMAÑO DE LOS CAMPOS DEPENDIENDO EL TAMAÑO DE LA TABLA

        switch (\$_POST['opc']) {
            case 0:
                //CASO DE PRIMERA VISTA, OPC 0 DE MANERAINTERNA, PARA EL FORMATO DE LA TABLA
                $campos
                break;
            case 2:
                /******************SELECTS(EJEMPLO)***********************************************/
                //\$field[] = array('cve_estado', 'cve_estado', 'VISTA', 'select', 'OBLIGATORIO', 'int',\$vector,array(0, 12),'100','30');
                /*************************************************************************************************/
                $campos
                break;
            case 3:
                /******************SELECTS(EJEMPLO)***********************************************/
                //\$field[] = array('cve_estado', 'cve_estado', 'VISTA', 'select', 'OBLIGATORIO', 'int',\$vector,array(0, 12),'100','30');
                /*************************************************************************************************/
                $campos
                break;

            default:
                    echo \"ERROR EN LOS CASE  VERIFIQUE LOS POST\";
                break;                   
        }

        \$strwentidad = \"entidad.php\";
        \$entidad_agrega = \"inserta.php\";
        \$entidad_elimina = \"actualiza.php\";
    }
} else {
    include_once(\"../configuracion_sistema/configuracion.php\");
    include_once(\"sb_ii_refresh.php\");
}";


$archivo = fopen("../includes/i_" . $tabla . ".php", "w");
fwrite($archivo, $contenido);
fclose($archivo);

/////SECCION DE LOS ARCHIVOS JAVASCRIPT
$codigo_javascript = '';
foreach ($datos as $key => &$val) {
    //////////////////SECCION DE INYECCION DE PATRONES
    $codigo_javascript .= 'var ' . $val['COLUMN_NAME'] . ' = document.getElementById("' . $val['COLUMN_NAME'] . '");    
' . $val['COLUMN_NAME'] . '.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });';
}

$archivo_js = fopen("../metodos_javascript/js_" . $tabla . ".js", "w");

fwrite($archivo_js, $codigo_javascript);
fclose($archivo_js);



$formulario = '';
$formulario =
    "<?php
    session_start();
include_once(\"../configuracion_sistema/configuracion.php\");
if (\$__SESSION->getValueSession('nomusuario') == \"\") {
    include_once(\"../includes/sb_refresh.php\");
} else {
    include_once '../librerias/PDOConsultas.php';
    \$consulta = new PDOConsultas();
    \$consulta->connect(\$CFG_HOST[0], \$CFG_USER[0], \$CFG_DBPWD[0], \$CFG_DBASE[0],\$CFG_TIPO[0]);
?>
<div class=\"col-md-12\">
    <div class=\"card mb-12\">
        <div class=\"card-body\">
            <div class=\"card-title mb-3\">" . $tabla . "</div>
            <form>";

foreach ($datos as $key => &$val) {
    switch ($val['DATA_TYPE']) {
        case 'int':
            $val['DATA_TYPE'] = 'number';
            break;
        case 'varchar':
            $val['DATA_TYPE'] = 'text';
            break;
        case 'date':
            $val['DATA_TYPE'] = 'date';
            break;
        default:
            $val['DATA_TYPE'] = 'text';
            break;
    }
    $formulario .= "
                    <div class=\"row\">
                        <div class=\"col-md-12 form-group mb-3\">
                        <label for=\"" . $val['COLUMN_NAME'] . "\">" . $val['COLUMN_NAME'] . "</label>
                        <input class=\"form-control form-control-rounded\" id=\"" . $val['COLUMN_NAME'] . "\" type=\"" . $val['DATA_TYPE'] . "\" placeholder=\"" . $val['COLUMN_NAME'] . "\"/>
                        </div>
                    </div>";
}
$formulario .= "
                <div class=\"col-md-12\">
                    <button class=\"btn btn-primary\">ENVIAR</button>
                </div>
      </form>
        </div>
    </div>
</div>
<?php
}
?>
";
// echo $formulario;
$archivo = fopen("../formulario_sistema/formulario_" . $tabla . ".php", "w");
fwrite($archivo, $formulario);
fclose($archivo);
