<?php
session_start();
if (!isset($_SESSION["id_alumno"]) || $_SESSION["id_alumno"] == null) {
    print "<script>window.location='index.php';</script>";
}
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {
    $inactivo = 900; //15min en este caso.
    $vida_session = time() - $_SESSION['tiempo'];
    if ($vida_session > $inactivo) {
        session_unset();
        session_destroy();
        header("Location: login.php?carrera=$idcarr");
        exit();
    } else {  // si no ha caducado la sesion, actualizamos
        $_SESSION['tiempo'] = time();
    }
} else {
    $_SESSION['tiempo'] = time();
}
include("SAC/Conexion.php");
//INFORMACION DEL ALUMNO 
$datosAlumnos = $DB_con->prepare("SELECT * FROM alumnos WHERE id_user=$_SESSION[id_alumno]");
$datosAlumnos->execute();
while ($row = $datosAlumnos->fetch(PDO::FETCH_OBJ)) {
    $nomAlumno = $row->nombre_alumno;
    $nomAlumno .= ' ';
    $nomAlumno .= $row->apellido_alumno;

    $id_taller = $row->id_taller;
    $id_concurso = $row->id_concurso;
    $id_equipo = $row->id_equipo;
    $id_alumno = $row->id_alumno;

    $_SESSION["id_adminCarrera"] = $row->id_adminCarrera;
    $id_adminCarrera = $_SESSION["id_adminCarrera"];
    $status = $row->status_alumno;
}
// NOMBRE DE LA CARRERA 
$carreraIns = $DB_con->prepare('SELECT * FROM admin_carreras WHERE id_adminCarrera =:id_adminCarrera');
$carreraIns->execute(array(':id_adminCarrera' => $id_adminCarrera));
$carreraAlumno = $carreraIns->fetch(PDO::FETCH_ASSOC);
extract($carreraAlumno);

$carrera = $carreraAlumno['carrera'];
$_SESSION['imgLogo'] = $carreraAlumno['id_imagen'];
$estado_conferencia = 0;

// Informacion del taller del alumno
if (isset($id_taller)) {
    $infoTaller = $DB_con->prepare('SELECT * FROM talleres WHERE id_taller =:id_taller');
    $infoTaller->execute(array(':id_taller' => $id_taller));
    $rowTaller = $infoTaller->fetch(PDO::FETCH_ASSOC);
    extract($rowTaller);
}

// Informacion del Concurso del alumno
if (isset($id_concurso)) {
    $infoConcurso = $DB_con->prepare('SELECT * FROM concursos WHERE id_concurso =:id_concurso');
    $infoConcurso->execute(array(':id_concurso' => $id_concurso));
    $rowConcurso = $infoConcurso->fetch(PDO::FETCH_ASSOC);
    extract($rowConcurso);
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de Administración de Eventos y Congresos</title>

    <!-- Bootstrap -->
    <link rel='stylesheet' href='vendor/jquery-ui/jquery-ui.min.css'>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome-5/css/fontawesome-all.min.css">

    <!-- Revolution slider -->
    <link rel="stylesheet" href="vendor/revolution/settings.css">
    <link rel="stylesheet" href="vendor/revolution/layers.css">
    <link rel="stylesheet" href="vendor/revolution/navigation.css">
    <link rel="stylesheet" href="vendor/revolution/settings-source.css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/css-hamburgers/dist/hamburgers.min.css">
    <link rel="stylesheet" href="vendor/slick/slick-theme.css">
    <link rel="stylesheet" href="vendor/slick/slick.css">
    <link rel="stylesheet" href="vendor/fancybox/dist/jquery.fancybox.min.css">
    <link rel='stylesheet' href='vendor/fullcalendar/fullcalendar.css' />
    <link rel='stylesheet' href='vendor/animate/animate.css' />

    <!-- Main CSS File -->
    <link href="css/style.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">
</head>

<body>

  
</body>

</html>