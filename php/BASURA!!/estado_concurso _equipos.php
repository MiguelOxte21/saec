
<?php

require '../conexion.php';
$nomEquipo = $_POST['nomEquipo'];
$id_integrante = $_POST['id_integrante'];
$id_concurso = $_POST['id_concurso'];

$vueltas = $_POST['max_alumnos_grupal'];

$cadena = "INSERT INTO equipos_concurso (nomEquipo, id_integrante, id_concurso) VALUES ";

for ($i = 0; $i < count($id_integrante); $i++) {
	 $cadena.="('".$nomEquipo."', '".$id_integrante[$i]."', '".$id_concurso."'),";
}

echo '<br>';
$cadena_final = substr($cadena, 0, -1);
echo $cadena_final.= ";";

		$conexion->query($cadena_final) or die ("Error al subir los datos".mysqli_error($conexion));

?>
<script type="text/javascript">
	alert("¡Equipos registrado exitosamente!");
	window.location.href='../concurso.php?id_concurso=<?php echo $id_concurso?>';
</script>
