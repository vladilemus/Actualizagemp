<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing;

$jsonFile = 'C:\wamp64\www\capturagem\admcaptura\app-assets\data\reporte.json';

$spreadsheet = new Spreadsheet();
$worksheet = $spreadsheet->getActiveSheet();

$jsonData = file_get_contents($jsonFile);
$data = json_decode($jsonData, true)['data'];

$keys = array_keys($data[0]);

$columnCount = count($keys);
$rowCount = count($data);

// Establecer los encabezados y el estilo
$headerStyle = [
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '024B06'],
    ],
    'font' => [
        'color' => ['rgb' => 'FFFFFF'],
        'size' => 14,
    ],
];

$worksheet->fromArray($keys, null, 'A1');
$worksheet->getStyle('A1:' . chr(65 + $columnCount - 1) . '1')->applyFromArray($headerStyle);

// Establecer los datos
$dataRows = [];
foreach ($data as $item) {
    $dataRows[] = array_values($item);
}

$worksheet->fromArray($dataRows, null, 'A2');

// Ajustar automáticamente el tamaño de las celdas al texto
$worksheet->getColumnDimension('A')->setAutoSize(true);
$worksheet->getColumnDimension(chr(65 + $columnCount - 1))->setAutoSize(true);
$worksheet->getColumnDimension('B')->setAutoSize(true);
$worksheet->getColumnDimension(chr(65 + $columnCount - 1))->setAutoSize(true);
$worksheet->getColumnDimension('C')->setAutoSize(true);
$worksheet->getColumnDimension(chr(65 + $columnCount - 1))->setAutoSize(true);
$worksheet->getColumnDimension('D')->setAutoSize(true);
$worksheet->getColumnDimension(chr(65 + $columnCount - 1))->setAutoSize(true);
$worksheet->getColumnDimension('E')->setAutoSize(true);
$worksheet->getColumnDimension(chr(65 + $columnCount - 1))->setAutoSize(true);
$worksheet->getColumnDimension('F')->setAutoSize(true);
$worksheet->getColumnDimension(chr(65 + $columnCount - 1))->setAutoSize(true);

// Guardar el archivo
$fileName = "Reporte_excel" . date("Y:m:d") . ".xlsx";
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
$writer->save('php://output');
