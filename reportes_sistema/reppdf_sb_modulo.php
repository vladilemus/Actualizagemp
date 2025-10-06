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
    $this->Image('../imagenes_sistema/desiciones.jpg',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,utf8_decode('FICHA DE INFORMACIÓN'),0,0,'C');
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
////init1 es el valor obtenido de la tabla
/////init2 es el campo principal
/////init 3 es la tabla
$valor=base64_decode($_GET['init1']);
$campo=base64_decode($_GET['init2']);
$tabla=base64_decode($_GET['init3']);
$consulta = new PDOConsultas();
$consulta->connect($CFG_HOST[0], $CFG_USER[0], $CFG_DBPWD[0], $CFG_DBASE[0],$CFG_TIPO[0]);
// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
    $pdf->Cell(0,10,utf8_decode('Imprimiendo línea número').$i,0,1);
$pdf->Output();
?>