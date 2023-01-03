<?php
include('../SAC/Conexion.php');
session_start();
// $_SESSION["id_alumno"];

if (isset($_GET['paymentToken']) && isset($_GET['paymentID'])) {

    $idu = $_SESSION["id_alumno"];

    $comentarios = 'El alumno pago por paypal la cantidad de $250';
    $upAlumno = $DB_con->prepare('UPDATE alumnos SET status_alumno =:status_alumno, comentarios =:comentarios WHERE id_user =:idu');
    $upAlumno->bindParam(':status_alumno', 1);
    $upAlumno->bindParam(':comentarios', $comentarios);
    $upAlumno->bindParam(':idu', $idu);
    $upAlumno->execute();
}

header("Location: ../inicio");

