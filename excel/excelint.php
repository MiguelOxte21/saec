<?php
require 'vendor/autoload.php';
require ' ../../../SAC/Conexion.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$sql= "SELECT 
id_instructor,	
nombre_instructor,	
apellido_instructor,	
status_instructor,	
id_user	FROM instructores";
$resultado = $DB_con1->query($sql);
$excel = new Spreadsheet();
$hojaActiva =$excel->getActiveSheet();
$hojaActiva -> setTitle("Instructores");
$hojaActiva->getColumnDimension('A')->setWidth(10);
$hojaActiva->setCellValue("A1", "Numero");
$hojaActiva->getColumnDimension('B')->setWidth(10);
$hojaActiva -> setCellValue('B1','id_instructor');
$hojaActiva->getColumnDimension('C')->setWidth(30);
$hojaActiva -> setCellValue('C1','nombre_instructor');
$hojaActiva->getColumnDimension('D')->setWidth(20);
$hojaActiva -> setCellValue('D1','apellido_instructor');
$hojaActiva->getColumnDimension('E')->setWidth(30);
$hojaActiva -> setCellValue('E1','status_instructor');
$hojaActiva->getColumnDimension('F')->setWidth(10);
$hojaActiva -> setCellValue('F1','id_user');
$fila = 2;
$num = 1;
while ($row =$resultado->fetch_assoc())
{$hojaActiva->setCellValue("A".$fila, "$num");
    $hojaActiva -> setCellValue('B'.$fila, $row['id_instructor']);
    $hojaActiva -> setCellValue('C'.$fila,$row['nombre_instructor']);
    $hojaActiva -> setCellValue('D'.$fila,$row['apellido_instructor']);
    $hojaActiva -> setCellValue('E'.$fila,$row['status_instructor']);
    $hojaActiva -> setCellValue('F'.$fila,$row['id_user']);
   
    
    $fila++; $num++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="instructores.xlsx"');
header('Cache-Control: max-age=0');

$write =IOFactory::createWriter($excel, 'Xlsx');
$write->save('php://output');
exit;