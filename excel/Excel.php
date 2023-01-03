<?php
require 'vendor/autoload.php';
require ' ../../../SAC/Conexion.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$sql= "SELECT id_alumno, nombre_alumno, apellido_alumno, matricula, semestre_grupo, status_alumno,
comentarios, id_taller, id_concurso, id_equipo, grupo_etnico, promediolengua FROM alumnos";
$resultado = $DB_con1->query($sql);

$excel = new Spreadsheet();
$hojaActiva =$excel->getActiveSheet();
$hojaActiva -> setTitle("alumnos");

$hojaActiva->getColumnDimension('A')->setWidth(10);
$hojaActiva->setCellValue("A1", "Numero");
$hojaActiva->getColumnDimension('B')->setWidth(10);
$hojaActiva -> setCellValue('B1','id_alumno');
$hojaActiva->getColumnDimension('C')->setWidth(30);
$hojaActiva -> setCellValue('C1','Nombre del alumno');
$hojaActiva->getColumnDimension('D')->setWidth(30);
$hojaActiva -> setCellValue('D1','Apellido del alumno');
$hojaActiva->getColumnDimension('E')->setWidth(20);
$hojaActiva -> setCellValue('E1','Matricula');
$hojaActiva->getColumnDimension('F')->setWidth(10);
$hojaActiva -> setCellValue('F1','Semestre/grupo');
$hojaActiva->getColumnDimension('G')->setWidth(10);
$hojaActiva -> setCellValue('G1','status del alumno');
$hojaActiva->getColumnDimension('H')->setWidth(30);
$hojaActiva -> setCellValue('H1','Comentarios');
$hojaActiva->getColumnDimension('I')->setWidth(5);
$hojaActiva -> setCellValue('I1','Id_taller');
$hojaActiva->getColumnDimension('J')->setWidth(8);
$hojaActiva -> setCellValue('J1','Id_concurso');
$hojaActiva->getColumnDimension('K')->setWidth(8);
$hojaActiva -> setCellValue('K1','id_equipo');
$hojaActiva->getColumnDimension('L')->setWidth(30);
$hojaActiva -> setCellValue('L1','Grupo_etnico');
$hojaActiva->getColumnDimension('M')->setWidth(30);
$hojaActiva -> setCellValue('M1','Promedio lengua hablada');



$fila = 2;
$num = 1;
while ($row =$resultado->fetch_assoc())
{
    $hojaActiva->setCellValue("A".$fila, "$num");
    $hojaActiva -> setCellValue('B'.$fila, $row['id_alumno']);
    $hojaActiva -> setCellValue('C'.$fila,$row['nombre_alumno']);
    $hojaActiva -> setCellValue('D'.$fila,$row['apellido_alumno']);
    $hojaActiva -> setCellValue('E'.$fila,$row['matricula']);
    $hojaActiva -> setCellValue('F'.$fila,$row['semestre_grupo']);
    $hojaActiva -> setCellValue('G'.$fila,$row['status_alumno']);
    $hojaActiva -> setCellValue('H'.$fila,$row['comentarios']);
    $hojaActiva -> setCellValue('I'.$fila,$row['id_taller']);
    $hojaActiva -> setCellValue('J'.$fila,$row['id_concurso']);
    $hojaActiva -> setCellValue('K'.$fila,$row['id_equipo']);
    $hojaActiva -> setCellValue('L'.$fila,$row['grupo_etnico']);
    $hojaActiva -> setCellValue('M'.$fila,$row['promediolengua']);
     $fila++; $num++;
}


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="alumnos.xlsx"');
header('Cache-Control: max-age=0');

$write =IOFactory::createWriter($excel, 'Xlsx');
$write->save('php://output');
exit;