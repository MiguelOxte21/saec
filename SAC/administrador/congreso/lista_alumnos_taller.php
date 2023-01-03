<?php
error_reporting(~E_NOTICE);
session_start();
if (!isset($_SESSION["id_administrador_carrera"]) || $_SESSION["id_administrador_carrera"] == null) {
    print "<script>window.location='../../../index.php';</script>";
}

require_once '../../Conexion.php';

// ID DEL INSTRUCTOR
// $consultaIns0 = $DB_con->prepare('SELECT * FROM instructores WHERE id_user = :id_user');
// $consultaIns0->execute(array(':id_user' => $_SESSION["id_instructor"]));
// $datos = $consultaIns0->fetch(PDO::FETCH_ASSOC);
// extract($datos);

//TALLER DEL INSTRUCTOR
// if (isset($_POST['lista_taller'])) {
//     $consultaIns = $DB_con->prepare('SELECT * FROM talleres WHERE id_taller = :id_taller');
//     $consultaIns->execute(array(':id_taller' => $_POST['lista_taller']));
//     $datos2 = $consultaIns->fetch(PDO::FETCH_ASSOC);
//     extract($datos2);
// }
?>

<script src="../../../plugins/admin/assets\demo\datatables-demo.js"></script>
