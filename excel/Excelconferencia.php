<?php
require 'vendor/autoload.php';
require ' ../../../SAC/Conexion.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$sql= "SELECT 
id_conferencia,	nombre_conferencia,	lugar_conferencia,	descripcion_conferencia,	cupo_conferencia,	id_instructor FROM conferencias";
$resultado = $DB_con1->query($sql);
$excel = new Spreadsheet();
$hojaActiva =$excel->getActiveSheet();
$hojaActiva -> setTitle("Conferencias");
$hojaActiva->getColumnDimension('A')->setWidth(10);
$hojaActiva->setCellValue("A1", "Numero");
$hojaActiva->getColumnDimension('B')->setWidth(10);
$hojaActiva -> setCellValue('B1','ID conferencia');
$hojaActiva->getColumnDimension('C')->setWidth(30);
$hojaActiva -> setCellValue('C1','Nombre de la conferencia');
$hojaActiva->getColumnDimension('D')->setWidth(20);
$hojaActiva -> setCellValue('D1','Lugar de la conferencia');
$hojaActiva->getColumnDimension('E')->setWidth(30);
$hojaActiva -> setCellValue('E1','descripcion_conferencia');
$hojaActiva->getColumnDimension('F')->setWidth(10);
$hojaActiva -> setCellValue('F1','cupo_conferencia');
$hojaActiva->getColumnDimension('G')->setWidth(15);
$hojaActiva -> setCellValue('G1','id_instructor');

$fila = 2;
$num = 1;
while ($row =$resultado->fetch_assoc())
{$hojaActiva->setCellValue("A".$fila, "$num");
    $hojaActiva -> setCellValue('B'.$fila, $row['id_conferencia']);
    $hojaActiva -> setCellValue('C'.$fila,$row['nombre_conferencia']);
    $hojaActiva -> setCellValue('D'.$fila,$row['lugar_conferencia']);
    $hojaActiva -> setCellValue('E'.$fila,$row['descripcion_conferencia']);
    $hojaActiva -> setCellValue('F'.$fila,$row['cupo_conferencia']);
    $hojaActiva -> setCellValue('G'.$fila,$row['id_instructor']);
   
    
    $fila++; $num++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Conferencia.xlsx"');
header('Cache-Control: max-age=0');

$write =IOFactory::createWriter($excel, 'Xlsx');
$write->save('php://output');
exit;