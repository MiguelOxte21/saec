<?php 	

session_start();

$id_usuario = $_POST['id_usuario'];
echo $id_usuario;
$clave 	= $_POST['clave'];
echo $clave;
include("conexion.php");

$query = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario' AND clave = '$clave'";

	$resultado = $con->query($query);

	
	if ($row = $resultado->fetch_assoc()) {


		if ($row['id_tipo_usuario'] == '1') {
			$_SESSION['id_usuario'] = $row['id_usuario'];
			$_SESSION['u_usuario'] = $row['nombres'];
			header("Location: administrador/index.php");
		}else if  ($row['id_tipo_usuario'] == '2'){
			$_SESSION['id_usuario'] = $row['id_usuario'];
			$_SESSION['u_usuario'] = $row['nombres'];
			header("Location: admin_carrera/index.php");
		}else if  ($row['id_tipo_usuario'] == '4'){
			$_SESSION['id_usuario'] = $row['id_usuario'];
			$_SESSION['u_usuario'] = $row['nombres'];
			header("Location: usuario/index.php");
		}

	} else {
		header("Location: ../../../../congreso-master/index.php");
	}

	if (!$query) {
	    printf("Error: %s\n", mysqli_error($conn));
	    exit();
	}
	

 ?>