<?php
session_start();
$idAlumno = $_SESSION["id_alumno"];
if (!isset($_SESSION["id_alumno"]) || $_SESSION["id_alumno"] == null) {
	print "<script>window.location='index.php';</script>";
}

include('../SAC/Conexion.php');
?>
<div class="desc display-flex">
	<div class="comments-students"> <a class="comments"><i class="fas fa-user"></i><?php echo $contador['cont']; ?> alumnos de <b><?php echo $row->cupo_taller; ?></b></a>
	</div>
	<?php if ($contador['cont'] >= $row->cupo_taller) {
		echo '<span class="price notfree">Completado</span>';
	} else {
		echo '<span class="price free">Disponible</span>';
	} ?>


</div>