<?php
//  -- TABLA USER -- 
	actualizarEstado($_POST['estado_concurso'], $_POST['nomconcurso'], $_POST['id_user']);
	function actualizarEstado($estado_concurso, $nomconcurso, $id_user)
	{
		$mjs=$nomconcurso;
		include '../conexion.php';
		$sentencia="UPDATE user SET id_user='".$id_user."', estado_concurso='".$estado_concurso."', nomconcurso='".$nomconcurso."' WHERE id_user='".$id_user."' ";
		$conexion->query($sentencia) or die ("Error al actualizar datos".mysqli_error($conexion));

	
	}	
?>

<?php 

echo '			<script type="text/javascript"> ';
echo '				alert("¡Inscripción exitosa!"); ';
echo '			</script> ';
echo '<meta http-equiv="Refresh" content="0;URL=../concursos.php">';

?>