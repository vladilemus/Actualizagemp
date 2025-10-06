<?php
//header('Content-Type: text/html; charset=UTF-8');
require_once('../librerias/PHPfpdf/fpdf.php');
include_once('../configuracion_sistema/configuracion.php');
require_once('../librerias/PDOConsultas.php');
global $CFG_HOST, $CFG_USER, $CFG_DBPWD, $CFG_DBASE,$CFG_TIPO;

$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0],$CFG_TIPO[0]);
////init1 es el valor obtenido de la tabla
/////init2 es el campo principal
/////init 3 es la tabla
$valor=base64_decode($_GET['init1']);
$campo=base64_decode($_GET['init2']);
$tabla=base64_decode($_GET['init3']);

$query_datos_factura='SELECT 
                        f.nom_usuario, a.cve_entrada, a.cve_usaurio, a.cve_proveedor, 
                        a.folio_entrada, a.factura, a.fecha_entrada, 
                        a.sub_total, a.iva, a.importe, a.observaciones,
                        b.cantidad,b.importe,c.num_producto,c.des_producto,
                        d.des_tipo_unidad,e.num_partida,e.des_partida
                    FROM entradas a
                        LEFT JOIN det_entradas b ON a.cve_entrada=b.cve_entrada
                        LEFT JOIN cat_productos c ON c.cve_producto=b.cve_producto
                        LEFT JOIN cat_tipo_unidad d ON c.cve_tipo_unidad=d.cve_tipo_unidad
                        LEFT JOIN cat_partidas e ON e.cve_partida=c.cve_partida
                        LEFT JOIN sb_usuario f ON a.cve_usaurio=f.cve_usuario
                        WHERE a.cve_entrada='.$valor;
$datos_factura=$consulta->executeQuery($query_datos_factura);
$usuario=$datos_factura[0]['nom_usuario'];
$folio=$datos_factura[0]['folio_entrada'];
$factura=$datos_factura[0]['factura'];
$fecha=$datos_factura[0]['fecha_entrada'];
$observaciones=$datos_factura[0]['observaciones'];

class PDF extends FPDF
{
    // Cabecera, Footer y otras funciones como antes...
// Cabecera de página
    function Header()
    {
        // Ruta a la imagen de fondo
        $imgFile = '../imagenes_sistema/fondo.png';
        // Obtener las dimensiones de la página
        $w = $this->GetPageWidth();
        $h = $this->GetPageHeight();
        // Colocar la imagen de fondo
        $this->Image($imgFile, 0, 0, $w, $h);

        // Colocar la imagen de fondo
        $this->Image($imgFile, 0, 0, $w, $h);
        // Logo izquierdo
        $this->Image('../imagenes_sistema/escudo_armas_colibri.png', 10, 8, 55);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Mover a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 10, 'OFICIALIA MAYOR', 0, 0, 'C');
        // Logo derecho
        $this->Ln(20);
    }

// Pie de página
    function Footer()
    {

    }
    // Cuerpo del documento adaptado a la estructura de $datos_factura
    function Body($datos_factura)
    {
        // Asumimos que todos los registros tienen el mismo usuario, folio, factura, fecha y observaciones
        $this->SetFont('Arial', '', 12);
        $this->Ln(10); // Espacio adicional después del encabezado
        $this->Cell(40, 10, "Usuario: " . $datos_factura[0]['nom_usuario']);
        $this->Ln(6); // Salto de línea
        $this->Cell(40, 10, "Folio: " . $datos_factura[0]['folio_entrada']);
        $this->Ln(6); // Salto de línea
        $this->Cell(40, 10, "Factura: " . $datos_factura[0]['factura']);
        $this->Ln(6); // Salto de línea
        $this->Cell(40, 10, "Fecha: " . $datos_factura[0]['fecha_entrada']);
        $this->Ln(10); // Espacio antes de la tabla
    }

    // Tabla de datos adaptada a la estructura de $datos_factura
    function Tabla($datos_factura)
    {
        $this->SetFont('Arial', 'B', 10);
        // Cabecera de la tabla
        $this->Cell(30, 10, 'Clave', 1);
        $this->Cell(80, 10, 'Descripcion', 1);
        $this->Cell(40, 10, 'Tipo de Unidad', 1);
        $this->Cell(40, 10, 'Numero Partida', 1);
        $this->Ln();
        // Restaurar fuente para datos de la tabla
        $this->SetFont('Arial', '', 10);
        foreach ($datos_factura as $fila) {
            $this->Cell(30, 10, $fila['num_producto'], 1);
            $this->Cell(80, 10, $fila['des_producto'], 1);
            $this->Cell(40, 10, $fila['des_tipo_unidad'], 1);
            $this->Cell(40, 10, $fila['num_partida'], 1);
            $this->Ln();
        }
    }

    // Observaciones al final de la tabla adaptadas a la estructura de $datos_factura
    function Observaciones($datos_factura)
    {
        $this->Ln(10); // Espacio después de la tabla
        $this->SetFont('Arial', 'I', 10);
        $this->MultiCell(0, 10, "Observaciones: " . $datos_factura[0]['observaciones']);
    }
}

// Creación del objeto PDF y generación del documento
$pdf = new PDF();
$pdf->AddPage();
$pdf->Body($datos_factura);
$pdf->Tabla($datos_factura);
$pdf->Observaciones($datos_factura);
$pdf->Output();

?>