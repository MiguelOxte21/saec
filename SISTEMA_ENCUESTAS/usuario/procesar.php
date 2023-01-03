<?php

require('../conexion.php');
require('../../SAC/Conexion.php');
$id_encuesta = $_POST['id_encuesta'];   
$nombre = $_POST['nombre'];
$matricula = $_POST['apellido'];
$correo = $_POST['correo'];
$semestre_grupo= $_POST['semestre_grupo'];
$respuesta= $_POST['respuesta'];
$talleres= $_POST['talleres'];





$sql = 'INSERT INTO respuestas(id_encueta, nombre_completo, matricula, email, nombree_taller, semestre_grupo, respuesta) 
VALUES(:id_encueta, :nombre_completo, :matricula, :email, :nombree_taller, :semestre_grupo, :respuesta)';
            $result = $DB_con->prepare($sql);
            $result->bindValue(':id_encueta', $id_encuesta, PDO::PARAM_INT);
            $result->bindValue(':nombre_completo', $nombre, PDO::PARAM_STR);
            $result->bindValue(':matricula', $matricula, PDO::PARAM_STR);
            $result->bindValue(':email', $correo, PDO::PARAM_STR);
            $result->bindValue(':nombree_taller', $talleres, PDO::PARAM_STR);
            $result->bindValue(':semestre_grupo', $semestre_grupo, PDO::PARAM_STR);
            $result->bindValue(':respuesta', $respuesta, PDO::PARAM_STR);
            $result->execute();
            $lastId = $DB_con->lastInsertId();
            





$query10 = "SELECT * FROM encuestas WHERE id_encuesta = '$id_encuesta'";
$resultado10 = $con->query($query10);
$row10 = $resultado10->fetch_assoc();

$ids = array();
session_start();
if (!isset($_SESSION["id_alumno"]) || $_SESSION["id_alumno"] == null) {
    print "<script>window.location='index.php';</script>";
}
$idcarr = $_SESSION["id_adminCarrera"];
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


include('../../SAC/Conexion.php');

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de Administración de Eventos y Congresos</title>

    <!-- Bootstrap -->
    <link rel='stylesheet' href='../../vendor/jquery-ui/jquery-ui.min.css'>
    <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.min.css">

    <!-- Font Icon -->
    <link rel="stylesheet" href="../../fonts/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="../../fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../fonts/font-awesome-5/css/fontawesome-all.min.css">

    <!-- Revolution slider -->
    <link rel="stylesheet" href="../../vendor/revolution/settings.css">
    <link rel="stylesheet" href="../../vendor/revolution/layers.css">
    <link rel="stylesheet" href="../../vendor/revolution/navigation.css">
    <link rel="stylesheet" href="../../vendor/revolution/settings-source.css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="../../vendor/css-hamburgers/dist/hamburgers.min.css">
    <link rel="stylesheet" href="../../vendor/slick/slick-theme.css">
    <link rel="stylesheet" href="../../vendor/slick/slick.css">
    <link rel="stylesheet" href="../../vendor/fancybox/dist/jquery.fancybox.min.css">
    <link rel='stylesheet' href='../../vendor/fullcalendar/fullcalendar.css' />
    <link rel='stylesheet' href='../../vendor/animate/animate.css' />

    <!-- Main CSS File -->
    <link href="../../css/style.min.css" rel="stylesheet">
    <link rel="../../shortcut icon" href="favicon.png">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <style>
        .listar-nextprevposts {
            width: 100%;
            float: left;
            padding: 30px 0;
            margin: 0 0 30px;
            border-top: 1px solid #e6e6e6;
            border-bottom: 1px solid #e6e6e6;
        }

        .listar-prevpost {
            float: left;
            text-align: left;
        }

        .listar-nextpost {
            float: right;
            text-align: right;
        }

        .listar-prevpost a,
        .listar-nextpost a,
        .listar-prevpost a:hover,
        .listar-nextpost a:hover {
            width: 100%;
            float: left;
            color: #676767;
        }

        .listar-prevpost a span,
        .listar-nextpost a span {
            font-size: 13px;
            line-height: 13px;
        }

        .listar-prevpost a i,
        .listar-nextpost a i {
            font-size: 13px;
            line-height: 13px;
            margin: 0 8px 0 0;
        }

        .listar-nextpost a i {
            margin: 0 0 0 8px;
        }

        .listar-prevpost {
            float: left;
            text-align: left;
        }

        .listar-prevpost a h2,
        .listar-nextpost a h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
            line-height: 20px;
        }
    </style>
</head>

<body>

    <?php include "header.php"; ?>
    <main>
        <section class="heading-page">
            <img src="../../images/bloggrid-heading-bg.jpg" alt="">
            <div class="container">
                <div class="heading-page-content">
                    <div class="au-page-title text-center">
                        <h1>
                            <center>
                                <div style="margin-top: 50px"></div>
                                <?php


                                $id_usuario = $_SESSION['id_alumno'];

                                $query5 = "SELECT * FROM usuarios_encuestas WHERE id_usuario = '$id_usuario' AND id_encuesta = '$id_encuesta'";
                                $resultado5 = $con->query($query5);
                                $tamaño = $resultado5->num_rows;

                                if ($tamaño > 0) {
                                    echo "Ya respondiste la encuesta";
                                    echo "<br/>";
                                } else {

                                    include("../../SAC/Conexion.php");
                                    //INFORMACION DEL ALUMNO 
                                    $datosAlumnos = $DB_con->prepare("SELECT * FROM alumnos WHERE id_user=:id_user");
                                    $datosAlumnos->execute(array(':id_user' => $_SESSION["id_alumno"]));
                                    while ($row = $datosAlumnos->fetch(PDO::FETCH_OBJ)) {
                                        $nomAlumno = $row->nombre_alumno;
                                        $nomAlumno .= ' ';
                                        $nomAlumno .= $row->apellido_alumno;
                                        $matricula = $row->matricula;
                                        $semestre_grupo1 = $row->semestre_grupo;
                                    }

                                    $datosAlumnos = $DB_con->prepare("SELECT * FROM usuarios WHERE id_usuario=:id_usuario");
                                    $datosAlumnos->execute(array(':id_usuario' => $_SESSION["id_alumno"]));
                                    while ($row = $datosAlumnos->fetch(PDO::FETCH_OBJ)) {
                                        $email = $row->email;
                                    }

                                    $query6 = "INSERT INTO usuarios_encuestas (id_usuario, id_encuesta, nombre, apellidos, email, matricula, semestre_grupo ) VALUES ('$id_usuario', '$id_encuesta', '$nomAlumno', '','$email','$matricula', '$semestre_grupo1')";
                                    $resultado6 = $con->query($query6);

                                    if ($row10['estado'] == '0') {
                                        for ($i = 1; $i <= 100; $i++) {

                                            if (isset($_POST[$i])) {
                                                $ids[$i] = $_POST[$i];

                                                $id = $ids[$i];

                                                $query2 = "SELECT id_opcion, id_pregunta, valor FROM opciones WHERE id_opcion = '$ids[$i]'";
                                                $resultado2 = $con->query($query2);

                                                if ($row2 = $resultado2->fetch_assoc()) {
                                                    $id_opcion = $row2['id_opcion'];
                                                    $query3 = "INSERT INTO resultados (id_opcion) 
							VALUES ('$id_opcion')";
                                                    $resultado3 = $con->query($query3);
                                                    if ($resultado3) {
                                                        echo "Respuesta guardada";
                                                        echo "<br/>";
                                                    } else {
                                                        echo "Error al ingresar resultado";
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        echo "<div style='margin-top: 50px;'>ERROR!<br/>La encuesta se encuentra cerrada</div>";
                                    }
                                }

                                ?>

                        </h1>
                    </div>
                </div>
            </div>



        </section>
        <center>
            <br />
            <a class="btn btn-primary" href="index.php">VOLVER</a> <a class="btn btn-primary" href="../../certi/">Obtener reconocimiento</a> 
        </center>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="../js/jquery-3.3.1.slim.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
</body>

</html>