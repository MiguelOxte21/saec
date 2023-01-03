<?php
error_reporting(~E_NOTICE);
session_start();
if (!isset($_SESSION["id_administrador_general"]) || $_SESSION["id_administrador_general"] == null) {
    print "<script>window.location='../../index.php';</script>";
}


//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {
    $inactivo = 900; //15min en este caso.
    $vida_session = time() - $_SESSION['tiempo'];
    if ($vida_session > $inactivo) {
        session_unset();
        session_destroy();
        header("Location: ../../index");
        exit();
    } else {  // si no ha caducado la sesion, actualizamos
        $_SESSION['tiempo'] = time();
    }
} else {
    $_SESSION['tiempo'] = time();
}
require_once '../Conexion.php';

if (isset($_GET['delete_id'])) {
	// Selecciona imagen a borrar
	$stmt_select = $DB_con->prepare('SELECT imagen FROM estados WHERE id_estados =:uid');
	$stmt_select->execute(array(':uid' => $_GET['delete_id']));
	$imgRow = $stmt_select->fetch(PDO::FETCH_ASSOC);
	// Ruta de la imagen
	unlink("../../images/destinos/" . $imgRow['imagen']);

	// Consulta para eliminar el registro de la base de datos
	$stmt_delete = $DB_con->prepare('DELETE FROM estados WHERE id_estados =:uid');
	$stmt_delete->bindParam(':uid', $_GET['delete_id']);
	$stmt_delete->execute();
    
	// borra comentarios del paquete
	// $stmt_delete2 = $DB_con->prepare('DELETE FROM comentario WHERE post_id =:uid');
	// $stmt_delete2->bindParam(':uid', $_GET['delete_id']);
	// $stmt_delete2->execute();
    
	// Redireccioa al inicio
	header("Location: destinos.php");
}
?>