<?php
//SECCION DE LA CREACION DE LOS ARCHIVOS
session_start();
require '../configuracion_sistema/configuracion.php';
require '../librerias/PDOConsultas.php';
global $CFG_HOST, $CFG_USER, $CFG_DBPWD, $CFG_DBASE, $CFG_TIPO;
$tabla = $_GET['seleccionados'];
$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0], $CFG_TIPO[0]);

$prepara_query="SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH,COLUMN_KEY
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = '$tabla'";

$datos = $consulta->executeQuery($prepara_query);
//die($prepara_query);
$campos = "";
//print_r($datos);die();
foreach ($datos as $key => &$val) {
    if ($datos[0]['COLUMN_KEY'] == 'PRI') {
       $clave = $datos[0]['COLUMN_NAME'];
    }

    switch ($val['DATA_TYPE']) {
        case 'int':
            $tipoformulario = 'number';
            break;
        case 'float':
            $tipoformulario = 'number';
            break;
        case 'smallint':
            $tipoformulario = 'number';
            break;
        case 'varchar':
            $tipoformulario = 'text';
            break;
        case 'char':
            $tipoformulario = 'text';
            break;
        case 'date':
            $tipoformulario = 'date';
            break;
        default:
            $tipoformulario = 'text';
            break;
    }
    $campos .= "
                \$field[]=array('" . $val['COLUMN_NAME'] . "','" . $val['COLUMN_NAME'] . "','VISTA','$tipoformulario','OBLIGATORIO','" . $val['DATA_TYPE'] . "', '', array(0, 12),'30','',array(),'','');";
}

$contenido = '';

$contenido = "<?php
\$str_check = FALSE;
include_once(\"sb_ii_check.php\");
if (\$str_check) {
    global \$CFG_HOST, \$CFG_USER, \$CFG_DBPWD, \$CFG_DBASE,\$CFG_TIPO,\$__SESSION;
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

        /////DESCOMENTAR EN CASO DE USAR EL PRIMER SUBNIVEL
        //\$array_auxiliar = explode(',', \$_GET['pila']);
        //\$str_clave = base64_decode(\$array_auxiliar[0]);
        //\$str_llave = base64_decode(\$array_auxiliar[1]);
        //\$str_Include = base64_decode(\$array_auxiliar[2]);
        //\$str_mod = base64_decode(\$array_auxiliar[3]);
        //\$str_nivelpadre = base64_decode(\$array_auxiliar[4]);

        //CAMBIA EL TEXTO DEL BOTON
        \$boton_texto=\"NUEVO REGISTRO\";
        \$campo = array();
        \$entidad = 'NOMBRE DEL MÓDULO';
        \$btn_guardar='GUARDAR';
        \$id_prin = '$clave';
        \$strWhere = '';   
        \$a_order = '';
        /************************SECCION DE LOS BOTONES*****************************************************************************************/
        \$strnuevo = (\$__SESSION->getValueSession('alta')) ? TRUE : FALSE;
        \$streditar = (\$__SESSION->getValueSession('actualiza')) ? TRUE : FALSE;
        \$streliminar = (\$__SESSION->getValueSession('elimina')) ? TRUE : FALSE;
        
        //\$strnuevo = TRUE;
        //\$streditar = TRUE;
        //\$streliminar =TRUE;
        
        //\$str_impresora = TRUE; 
        //\$str_impresora_destino='fichas_reporte_sistema/rep_" . $tabla . ".php?';
        //\$str_title_impresora=\"titulo al sobreponer el cursor\";
        /************************FIN  DE LA SECCION DE LOS BOTONES*******************************************************************************/

        \$tamanio_tabla=\"100%\";
        \$intlimit=5;

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
        //\$str_union_tabla = ' ';
        //\$tabla = 'cat_sexo a';
        //\$tabla_join = ' LEFT JOIN cat_estatus b on a.cve_estatus=b.cve_estatus';
        //\$campos_join = 'a.cve_sexo,a.des_sexo,b.des_estatus,a.cve_estatus';
        /***************************************************************************/
        /************************SECCION DE LOS BOTONES************************************************************************************/
        //\$streditar = TRUE;
        //\$streliminar = TRUE;
        //\$strnuevo = TRUE;
        //\$str_javascript='<script src=\"metodos_javascript/js_" . $tabla . ".js\"></script>';
        //EN CASO DE UTILIZAR PRCESOS EM TIEMPO INTERMEDIO
        //\$str_javascript_entidad = '<script src=\"metodos_javascript/js_inicio.js\"></script>';
        /************************RUTA EN DONDE SE COLOCARAN LOS ARCHIVOS A SUBIR**********************************************************/
  
        //\$str_ruta_include= \"imagenes_sistema/perfiles2/\";
        /**********************************************************************************************************************************/
        /******************SECCION DE LOS SELECTS(EJEMPLO)***********************************/
        //\$consulta2 = new PDOConsultas();
        //\$consulta2->connect(\$CFG_HOST[0], \$CFG_USER[0], \$CFG_DBPWD[0], \$CFG_DBASE[0]);
        //\$select= \$consulta2->executeQuery(\"SELECT cve_estatus,des_estatus FROM cat_estatus\");
        //foreach (\$select as \$keyselect => &\$valselect) {
        //    \$vector[]=array(\$valselect['cve_estatus'],\$valselect['des_estatus']);
        //    }
        /************************************************************************** */
        /******************SELECTS(EJEMPLO)***********************************************/
        //\$field[] = array('cve_estado', 'cve_estado', 'VISTA', 'select', 'OBLIGATORIO', 'int',\$vector);
        /*************************************************************************************************/

        /***************************************SECCION DE LOS SELECTS EN CASCADA (EJEMPLO)****************************************************
        \$select_cascada[] = array(
            \"llave1\" => ('cve_estado'), \"llave2\" => ('cve_estado'), \"origen\" => ('cve_estado_origen'), \"destino\" => ('cve_municipio_origen'), \"valores\" => ('cve_municipio'), \"datos\" => ('des_municipio'), \"tablas\" => array('cat_estado', 'cat_municipio'), \"condicion\" => (''), \"update\" => ('WHERE cve_municipio_origen'), \"archivo\" => ('../' . \$NOMBRE_CARPETA_PRINCIPAL . '/getElementos/get_elementos.php')
        );


        **************************************************************************************************************************************/
        //@ISC.CHRISTOPHER DELGADILLO

        /*********************POSICION DE LOS DATOS EN EL ARRAY FIELD****************************/
        /*********************POSICION DE LOS DATOS EN EL ARRAY FIELD****************************/
        //0.- CLAVE PRINCIPAL DE LA BASE DE DATOS
        //1.- NOMBRE DE LA ETIQUETA DE LAS CABECERAS DEL CAMPO AMOSTRAR 
        //2.- VISIBILIDAD DEL CAMPO
        //3.- TIPO DE DATO PARA EL FORMULARIO
        //4.- CAMPO OBLIGATORIO O NO OBLIGATORIO (TENER EN CUENTA EL TIPO DE LLAVE DEL CAMPO PRINCIPAL YA QUE EN SU MAYORIA ES AUTOINCREMENTABLE EN ESE CASE SE DEBE DE ESCONDER)
        //5.- TIPO DE DATO EN BASE DE DATOS
        //6.- VECTOR DE DATOS QUE CONTIENE UN PAR DE ARRAYS PARA LA CONSTRUCCION DINAMICA DE LOS SELECTS
        //7.- VECTOR DE LOS PESOS PARA LA CONSTRUCCION DE LOS SEPARADORES Y LA DISTRIBUCION DE LOS CAMPOS, (ARRAY DEFINIDO EN 12 POSICIONES)
        //8.- TAMAÑO DEL CAMPO EN LA PANTALLA 0
        //9.- LLENADO DE CAMPO PREDEFINIDO PANTALLA 2 y 3, AGREGA EL VALOR VALUE    
        //10.- AREA DE ATRIBUTOS DEL INPUT
        //11.-ETIQUETA PEQUEÑA PARA ESPECIFICACIONES
        //12.-MODALS


        /******************************************************SECCION DE MODALS*****************************************************/
        //\$str_modal = 'modal_sistema/formulario_sb_modulo.php?';
        /******************************************************FIN DE LOS MODALS*****************************************************/

            switch (\$_POST['opc']) {
                case 0:
                    //CASO DE PRIMERA VISTA, OPC 0 DE MANERA INTERNA, PARA EL FORMATO DE LA TABLA, RECUERDA TRAAER TU LLAVE PRIMARIA
                    $campos
                    break;
                case 2:
                    /******************SELECTS(EJEMPLO)***********************************************/
                    //\$field[] = array('cve_estado', 'cve_estado', 'VISTA', 'select', 'OBLIGATORIO', 'int',\$vector,array(0, 12),'30','','');
                    /*************************************************************************************************/
                    $campos
                    break;
                case 3:
                    /******************SELECTS(EJEMPLO)***********************************************/
                    //\$field[] = array('cve_estado', 'cve_estado', 'VISTA', 'select', 'OBLIGATORIO', 'int',\$vector,array(0, 12),'30','','');
                    /*************************************************************************************************/
                    $campos
                    break;
    
                default:
                        echo \"ERROR EN LOS CASE  VERIFIQUE LOS POST\";
                    break;                   
                }

        //SE PUEDEN AGREGAR ENTIDADES INDEPENDIENTES
        \$str_entidad = \"entidad.php\";
        \$str_addentidad = \"addentidad.php\";
        \$str_updentidad = \"updentidad.php\";
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
$codigo_javascript .= '
//////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////@ISC CHRISTOPHER DELGADILLO RAMIREZ ALV PRRS';
$codigo_javascript .= '
////ARCHIVO DE CONFIGURACION DE JAVASCREIPT JQUERY
//////////////////////////////////////////////////////////////////////////////////////////////////////';
$codigo_javascript .= '
////////////////////////////////////SECCION DE LAS VALIDACIONES DE LOS CAMPOS VIA JAVASCRIPT////////////////////////////////////////////////
';
foreach ($datos as $key => &$val) {
    $codigo_javascript .= '
    var ' . $val['COLUMN_NAME'] . ' = document.getElementById("' . $val['COLUMN_NAME'] . '");    
' . $val['COLUMN_NAME'] . '.addEventListener ("input", function (event) { 
    (this.value = this.value.toUpperCase());
    });
    
    ';
}
$codigo_javascript .= '
/////////////////////////////////////////////////FIN DE LAS VALIDACIONES////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////SECCCION DEL EVENTO ONCLICK////////////////////////////////////////////////////////////////';
$codigo_javascript .= '
$(document).ready(function() {';

foreach ($datos as $key => &$val) {
    $codigo_javascript .= '    
        $("#' . $val['COLUMN_NAME'] . '").hide();';
}

foreach ($datos as $key => &$val) {
    $codigo_javascript .= '    
        $("#' . $val['COLUMN_NAME'] . '").show();';
}

foreach ($datos as $key => &$val) {
    $codigo_javascript .= '    
    $("#' . $val['COLUMN_NAME'] . '").click(function(){

    });';
}

$codigo_javascript .= '
/////////////////////////////////////////////////FIN DE LOS EVENTOS////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////FUNCIONES KEYUP/////////////////////////////////////////////////////////////////////////////////////////
';
foreach ($datos as $key => &$val) {
    $codigo_javascript .= '    
    $("#' . $val['COLUMN_NAME'] . '").keyup(function () {

    });';
}

$codigo_javascript .= '
/////////////////////////////////////////////////FIN DE LOS EVENTOS KEY UP////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
';

$codigo_javascript .= '
/////////////////////////////////////////////////FIN DE LOS keypress////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////FUNCIONES keypress/////////////////////////////////////////////////////////////////////////////////////////
';
foreach ($datos as $key => &$val) {
    $codigo_javascript .= '    
    $("#' . $val['COLUMN_NAME'] . '").keypress(function(){

    });';
}

$codigo_javascript .= '
/////////////////////////////////////////////////FIN DE LOS EVENTOS keypress////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
';


$codigo_javascript .= '
/////////////////////////////////////////////////FUNCIONES ON PROP///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////FUNCIONES PROP/////////////////////////////////////////////////////////////////////////////////////////
';
foreach ($datos as $key => &$val) {
    $codigo_javascript .= '    
    if ($("#' . $val['COLUMN_NAME'] . '").prop(\'checked\')) {
    } else {
    }';
}

$codigo_javascript .= '
/////////////////////////////////////////////////FIN DE LOS EVENTOS PROP////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
';


$codigo_javascript .= '
});';
$codigo_javascript .= '
//////////////////////////////////////////////////////CIERRE DOCUMENT READY////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////';

$codigo_javascript .= '
function validar_numeros(elem) {
    var text = document.getElementById(elem);
    text.addEventListener("keypress", _check);
    function _check(e) {
        var textV = "which" in e ? e.which : e.keyCode,
                char = String.fromCharCode(textV),
                regex = /[0-9]/ig;
        if (!regex.test(char))
            e.preventDefault();
        return false;
    }
}
function validar_letras(elem) {
    var text = document.getElementById(elem);
    text.addEventListener("keypress", _check);
    function _check(e) {
        var textV = "which" in e ? e.which : e.keyCode,
                char = String.fromCharCode(textV),
                regex = /^[a-zA-ZáéíóúñÁÉÍÓÚÑ0-9\s]+$/g;
        if (!regex.test(char))
            e.preventDefault();
        return false;
    }
}';

$archivo_js = fopen("../metodos_javascript/js_" . $tabla . ".js", "w");
fwrite($archivo_js, $codigo_javascript);
fclose($archivo_js);

/******************************************************************************************************************/
/*********************************CREACION DE LAS FICHAS DE REPORTES**************************************************/
$ficha_reporte = "<?php
header('Content-Type: text/html; charset=UTF-8');
require_once('../librerias/PHPfpdf/fpdf.php');
include_once('../configuracion_sistema/configuracion.php');
require_once('../librerias/PDOConsultas.php');
class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    \$this->Image('../imagenes_sistema/desiciones.jpg',10,8,33);
    // Arial bold 15
    \$this->SetFont('Arial','B',15);
    // Movernos a la derecha
    \$this->Cell(80);
    // Título
    \$this->Cell(30,10,utf8_decode('FICHA DE INFORMACIÓN'),0,0,'C');
    // Salto de línea
    \$this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    \$this->SetY(-15);
    // Arial italic 8
    \$this->SetFont('Arial','I',8);
    // Número de página
    \$this->Cell(0,10,'Page '.\$this->PageNo().'/{nb}',0,0,'C');
}
}
////init1 es el valor obtenido de la tabla
/////init2 es el campo principal
/////init 3 es la tabla
\$valor=base64_decode(\$_GET['init1']);
\$campo=base64_decode(\$_GET['init2']);
\$tabla=base64_decode(\$_GET['init3']);
\$consulta = new PDOConsultas();
\$consulta->connect(\$CFG_HOST[0], \$CFG_USER[0], \$CFG_DBPWD[0], \$CFG_DBASE[0],\$CFG_TIPO[0]);
// Creación del objeto de la clase heredada
\$pdf = new PDF();
\$pdf->AliasNbPages();
\$pdf->AddPage();
\$pdf->SetFont('Times','',12);
for(\$i=1;\$i<=40;\$i++)
    \$pdf->Cell(0,10,utf8_decode('Imprimiendo línea número').\$i,0,1);
\$pdf->Output();
?>";
$archivo = fopen("../fichas_reporte_sistema/rep_" . $tabla . ".php", "w");
fwrite($archivo, $ficha_reporte);
fclose($archivo);
/******************************************************************************************************************/
/*********************************FIN DE LAS FICHAS DE REPORTES**************************************************/

$formulario = "
<?php
header('Content-Type: text/html; charset=UTF-8');
require_once('../librerias/PHPfpdf/fpdf.php');
include_once('../configuracion_sistema/configuracion.php');
require_once('../librerias/PDOConsultas.php');
class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    \$this->Image('../imagenes_sistema/desiciones.jpg',10,8,33);
    // Arial bold 15
    \$this->SetFont('Arial','B',15);
    // Movernos a la derecha
    \$this->Cell(80);
    // Título
    \$this->Cell(30,10,utf8_decode('FICHA DE INFORMACIÓN'),0,0,'C');
    \$this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    \$this->SetY(-15);
    // Arial italic 8
    \$this->SetFont('Arial','I',8);
    // Número de página
    \$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada
\$pdf = new PDF();
\$pdf->AliasNbPages();
\$pdf->AddPage();
\$pdf->SetFont('Times','',12);
for(\$i=1;\$i<=40;\$i++)
\$pdf->Cell(0,10,utf8_decode('Imprimiendo línea número').\$i,0,1);
\$pdf->Output();
?>
";
$formulario =
    "<?php
    session_start();
include_once(\"../configuracion_sistema/configuracion.php\");
if (\$__SESSION->getValueSession('nomusuario') == \"\") {
    include_once(\"../includes/sb_refresh.php\");
} else {
    include_once '../librerias/PDOConsultas.php';
    \$consulta = new PDOConsultas();
    \$consulta->connect(\$CFG_HOST[0], \$CFG_USER[0], \$CFG_DBPWD[0], \$CFG_DBASE[0],,\$CFG_TIPO[0]);
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
die("PARARxxx");