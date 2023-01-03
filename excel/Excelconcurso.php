<?php
require 'vendor/autoload.php';
require ' ../../../SAC/Conexion.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$sql= "SELECT id_concurso, nombre_concurso, lugar_concurso, descripcion_concurso, cupo_concurso, modalidad, max_alumnos_grupal, id_instructor FROM concursos";
$resultado = $DB_con1->query($sql);
$excel = new Spreadsheet();
$hojaActiva =$excel->getActiveSheet();
$hojaActiva -> setTitle("Concusos");
$hojaActiva->getColumnDimension('A')->setWidth(10);
$hojaActiva->setCellValue("A1", "Numero");
$hojaActiva->getColumnDimension('B')->setWidth(10);
$hojaActiva -> setCellValue('B1','ID Concurso');
$hojaActiva->getColumnDimension('C')->setWidth(30);
$hojaActiva -> setCellValue('C1','Nombre del concurso');
$hojaActiva->getColumnDimension('D')->setWidth(20);
$hojaActiva -> setCellValue('D1','Lugar del concurso');
$hojaActiva->getColumnDimension('E')->setWidth(10);
$hojaActiva -> setCellValue('E1','Cupo del concurso');
$hojaActiva->getColumnDimension('F')->setWidth(20);
$hojaActiva -> setCellValue('F1','Modalidad (1=individual, 2=grupo)');
$hojaActiva->getColumnDimension('G')->setWidth(15);
$hojaActiva -> setCellValue('G1','Grupo de equipo');
$hojaActiva->getColumnDimension('H')->setWidth(15);
$hojaActiva -> setCellValue('H1','Id_instructor');
$fila = 2;
$num = 1;
while ($row =$resultado->fetch_assoc())
{ $hojaActiva->setCellValue("A".$fila, "$num");
    $hojaActiva -> setCellValue('B'.$fila, $row['id_concurso']);
    $hojaActiva -> setCellValue('C'.$fila,$row['nombre_concurso']);
    $hojaActiva -> setCellValue('D'.$fila,$row['lugar_concurso']);
    $hojaActiva -> setCellValue('E'.$fila,$row['descripcion_concurso']);
    $hojaActiva -> setCellValue('F'.$fila,$row['modalidad']);
    $hojaActiva -> setCellValue('G'.$fila,$row['max_alumnos_grupal']);
    $hojaActiva -> setCellValue('H'.$fila,$row['id_instructor']);
    
    $fila++; $num++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Concuesos.xlsx"');
header('Cache-Control: max-age=0');

$write =IOFactory::createWriter($excel, 'Xlsx');
$write->save('php://output');
exit;