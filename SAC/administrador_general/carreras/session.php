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

// Archivo de conexion con la base de datos
require_once '../../Conexion.php';

if (isset($_GET['id_carrera_admin'])) {
    // BUSCAR ID DEL ADMINISTRADOR DE CARRERAS
    $Carreras_select = $DB_con->prepare('SELECT admin_carreras.*, users.* FROM admin_carreras INNER JOIN users ON admin_carreras.id_user = users.id_user WHERE admin_carreras.id_adminCarrera = :id_adminCarrera');
    $Carreras_select->execute(array(':id_adminCarrera' => $_GET['id_carrera_admin']));
    $infoUser = $Carreras_select->fetch(PDO::FETCH_ASSOC);
    // echo $infoUser['nombre_adminCarrera'];

    session_start();
    $_SESSION["id_administrador_carrera"] = $infoUser['id_user'];
    print "<script>window.location='../../../SAC/administrador/congreso/index.php';</script>";

    // Ruta de la imagen
    // unlink("../../../images/logos/" . $info['imagen']);

}
// ENVIAR AL ADMINISTRADOR DE CARRERAS
