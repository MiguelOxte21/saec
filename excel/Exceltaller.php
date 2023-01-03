<?php
require 'vendor/autoload.php';
require ' ../../../SAC/Conexion.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$sql= "SELECT id_taller, nombre_taller, lugar_taller, cupo_taller, descripcion_taller, id_instructor FROM talleres";
$resultado = $DB_con1->query($sql);

$excel = new Spreadsheet();
$hojaActiva =$excel->getActiveSheet();
$hojaActiva -> setTitle("Talleres");

$hojaActiva->getColumnDimension('A')->setWidth(10);
$hojaActiva->setCellValue("A1", "Numero");

$hojaActiva->getColumnDimension('B')->setWidth(10);
$hojaActiva -> setCellValue('B1','ID taller');

$hojaActiva->getColumnDimension('C')->setWidth(30);
$hojaActiva -> setCellValue('C1','Nombre del taller');

$hojaActiva->getColumnDimension('D')->setWidth(20);
$hojaActiva -> setCellValue('D1','Lugar del taller');

$hojaActiva->getColumnDimension('E')->setWidth(10);
$hojaActiva -> setCellValue('E1','Cupo del taller');

$hojaActiva->getColumnDimension('F')->setWidth(30);
$hojaActiva -> setCellValue('F1','Descripción del taller');

$hojaActiva->getColumnDimension('G')->setWidth(10);
$hojaActiva -> setCellValue('G1','ID instructor');


$fila = 2;
$num = 1;
while ($row =$resultado->fetch_assoc())
{$hojaActiva->setCellValue("A".$fila, "$num");

    $hojaActiva -> setCellValue('B'.$fila, $row['id_taller']);
    $hojaActiva -> setCellValue('C'.$fila,$row['nombre_taller']);
    $hojaActiva -> setCellValue('D'.$fila,$row['lugar_taller']);
    $hojaActiva -> setCellValue('E'.$fila,$row['cupo_taller']);
    $hojaActiva -> setCellValue('F'.$fila,$row['descripcion_taller']);
    $hojaActiva -> setCellValue('G'.$fila,$row['id_instructor']);
    
    $fila++; $num++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Talleres.xlsx"');
header('Cache-Control: max-age=0');

$write =IOFactory::createWriter($excel, 'Xlsx');
$write->save('php://output');
exit;