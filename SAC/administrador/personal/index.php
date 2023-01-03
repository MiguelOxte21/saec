<?php
session_start();
if (!isset($_SESSION["id_administrador_carrera"]) || $_SESSION["id_administrador_carrera"] == null) {
    print "<script>window.location='../../../index.php';</script>";
}

//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {
    $inactivo = 900; //15min en este caso.
    $vida_session = time() - $_SESSION['tiempo'];
    if ($vida_session > $inactivo) {
        session_unset();
        session_destroy();
        header("Location: ../../../index.php");
        exit();
    } else {  // si no ha caducado la sesion, actualizamos
        $_SESSION['tiempo'] = time();
    }
} else {
    $_SESSION['tiempo'] = time();
}
           header("Location: instructores.php");
