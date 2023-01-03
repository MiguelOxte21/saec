<?php

	require ('FPDF/fpdf.php');

	class PDF extends FPDF
	{
		function Header()
		{
			$this->Image('../imagenes/tec.png',5, 5, 20 );

			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			$this->Cell(120,10, 'Reporte de encuesta',0,0,'C');
			$this->Ln(20);
		}

		
		
		function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			$this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C' );
		}		
	}
	//Agregamos la libreria FPDF
	require('../conexion.php');

	$query = "SELECT * FROM usuarios_encuestas";
	$resultado = $con->query($query);



	$pdf = new PDF();
	
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',12);

	
	$pdf->Cell(30,6,utf8_decode('Matricula'),1,0,'C',1);
	$pdf->Cell(70,6,utf8_decode('Nombre del alumno'),1,0,'C',1);
	$pdf->Cell(70,6,utf8_decode('correo'),1,0,'C',1);	
	$pdf->Cell(20,6,utf8_decode('Grupo'),1,1,'C',1);
	$pdf->SetFont('Arial','',10);
	

	

	while($row = $resultado->fetch_assoc())
	{
		$pdf->Cell( 30,6,utf8_decode($row['matricula']),1,0,'C');
		$pdf->Cell(70,6,utf8_decode($row['nombre']),1,0,'C');
		$pdf->Cell(70,6,utf8_decode($row['email']),1,0,'C');
		$pdf->Cell(20,6,utf8_decode ($row['semestre_grupo']),1,1,'C');
	}
	
	$pdf->Output();

 ?>