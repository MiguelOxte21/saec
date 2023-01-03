<?php
//  -- TABLA USER -- 
	actualizarEstado($_POST['estado_conferencia'], $_POST['nomconferencia'], $_POST['id_user']);
	function actualizarEstado($estado_conferencia, $nomconferencia, $id_user)
	{
		$mjs=$nomconferencia;
		include '../conexion.php';
		$sentencia="UPDATE user SET id_user='".$id_user."', estado_conferencia='".$estado_conferencia."', nomconferencia='".$nomconferencia."' WHERE id_user='".$id_user."' ";
		$conexion->query($sentencia) or die ("Error al actualizar datos".mysqli_error($conexion));

	}	
	
	
?>

<?php
// -- TABLA CONCURSOS -- 
	actualizarContador($_POST['id_conferencia'], $_POST['contador']);
	function actualizarContador($id_conferencia, $contador)
	{
		include '../conexion.php';
		$sentencia2="UPDATE conferencias SET id_conferencia='".$id_conferencia."', contador='".$contador."' WHERE id_conferencia='".$id_conferencia."' ";
		$conexion->query($sentencia2) or die ("Error al actualizar datos".mysqli_error($conexion));
	}	
?>

<?php
// -- TABLA ALUMNOS_CONFERENCIAS -- 
	subirDatos($_POST['id_conferencia'], $_POST['id_user'], $_POST['nombreUser'], $_POST['apellidoUser'], $_POST['nomconferencia'], $_POST['semestre_grupo']);
	function subirDatos($id_conferencia, $id_user, $nombreUser, $apellidoUser, $nomconferencia, $semestre_grupo)
	{
	
include '../conexion.php';
$error=0;

$insertar = "INSERT INTO alumnos_conferencias (id_alumno, nomAlumno, apellidoAlumno, grado_grupo, id_conferencia, nomConferencia) VALUES ('$id_user','$nombreUser','$apellidoUser','$semestre_grupo','$id_conferencia','$nomconferencia')";

$resultado = mysqli_query($conexion, $insertar);
if(!$resultado){
	$error=1;
}

?>
<?php 
if ($error ==0) {
?>

	<script type="text/javascript">
		alert("¡Inscripción exitosa!");
		window.location.href='../conferencias';
	</script>

<?php
	}else{
?>

	<script type="text/javascript">
		alert("OPPS!! A ocurrido un error");
		window.location.href='../conferencias';
	</script>

<?php
	}
	}	
?>
<?php 

// 	echo '			<script type="text/javascript"> ';
// 	echo '				alert("¡Felicidades! Te haz inscrito a esta conferencia"); ';
// 	echo '			</script> ';
// echo '<meta http-equiv="Refresh" content="0;URL=../conferencias.php">';

?>