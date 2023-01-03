<?php
require 'vendor/autoload.php';
require ' ../../../SAC/Conexion.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$sql= "SELECT id_encueta, nombre_completo, apellido, respuesta, email, semestre_grupo, nombree_taller FROM respuestas";
$resultado = $DB_con1->query($sql);
$excel = new Spreadsheet();
$hojaActiva =$excel->getActiveSheet();
$hojaActiva -> setTitle("Comentarios");
$hojaActiva->getColumnDimension('A')->setWidth(10);
$hojaActiva->setCellValue("A1", "Numero");

$hojaActiva->getColumnDimension('B')->setWidth(10);
$hojaActiva -> setCellValue('B1','id_encueta');

$hojaActiva->getColumnDimension('C')->setWidth(30);
$hojaActiva -> setCellValue('C1','Nombre del alumno');

$hojaActiva->getColumnDimension('D')->setWidth(30);
$hojaActiva -> setCellValue('D1','Apellido del alumno');

$hojaActiva->getColumnDimension('E')->setWidth(50);
$hojaActiva -> setCellValue('E1','Respuesta de la encuesta');

$hojaActiva->getColumnDimension('F')->setWidth(30);
$hojaActiva -> setCellValue('F1','correo');

$hojaActiva->getColumnDimension('G')->setWidth(30);
$hojaActiva -> setCellValue('G1','Semestre/Grupo');

$hojaActiva->getColumnDimension('H')->setWidth(30);
$hojaActiva -> setCellValue('H1','taller elejido');
$fila = 2;
$num = 1;
while ($row =$resultado->fetch_assoc())
{
    $hojaActiva->setCellValue("A".$fila, "$num");
    $hojaActiva -> setCellValue('B'.$fila, $row['id_encueta']);
    $hojaActiva -> setCellValue('C'.$fila,$row['nombre_completo']);
    $hojaActiva -> setCellValue('D'.$fila,$row['apellido']);
    $hojaActiva -> setCellValue('E'.$fila,$row['respuesta']);
    $hojaActiva -> setCellValue('F'.$fila,$row['email']);
    $hojaActiva -> setCellValue('G'.$fila,$row['semestre_grupo']);
    $hojaActiva -> setCellValue('H'.$fila,$row['nombree_taller']);
    
     $fila++; $num++;
}


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Comentarios.xlsx"');
header('Cache-Control: max-age=0');

$write =IOFactory::createWriter($excel, 'Xlsx');
$write->save('php://output');
exit;