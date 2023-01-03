<?php

actualizarContador($_POST['id_taller'], $_POST['contador'], $_POST['estado_taller'], $_POST['nomTaller'], $_POST['id_user']);
function actualizarContador($id_taller, $contador, $estado_taller, $nomTaller, $id_user)
{
	include '../conexion.php';
	$sql_banner_top=mysqli_query($conexion,"select * from talleres where id_taller='$id_taller' limit 0,1");
	while($rw_banner_top=mysqli_fetch_array($sql_banner_top)){
		$contadorSuma =  $rw_banner_top['contador'];
		$cupoMax =  $rw_banner_top['cupo'];

		if ($contadorSuma >= $cupoMax) {
			
		 $_SESSION['safo'] = 1;
		
		}else {
			$_SESSION['safo'] = 0;
            
         
        $sentencia="UPDATE user SET id_user='".$id_user."', estado_taller='".$estado_taller."', nomTaller='".$nomTaller."' WHERE id_user='".$id_user."' ";
		$conexion->query($sentencia) or die ("Error al actualizar datos".mysqli_error($conexion));    
            
		$contadorSuma = $contadorSuma+1;
		$sentencia2="UPDATE talleres SET contador='".$contadorSuma."' WHERE id_taller='".$id_taller."' ";
		$conexion->query($sentencia2) or die ("Error al actualizar datos".mysqli_error($conexion));

		$mjs=$nomTaller;
			// include '../conexion.php';
		
		}

	}

}

?>


<!-- MENSAJE -->
<?php 
if ($_SESSION['safo'] == 0) {
		
	echo '			<script type="text/javascript"> ';
echo '				alert("¡Inscripción exitosa!"); ';
echo '			</script> ';
echo '<meta http-equiv="Refresh" content="0;URL=../talleres.php">';

}else {
	echo '			<script type="text/javascript"> ';
	echo '				alert("Taller Lleno"); ';
	echo '			</script> ';
	echo '<meta http-equiv="Refresh" content="0;URL=../talleres.php">';
}



?>