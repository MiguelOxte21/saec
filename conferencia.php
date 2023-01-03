<?php
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

$id_conferenciaGet = $_GET['i'];
include('SAC/Conexion.php');
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

    <!-- AJAX -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        function leyenda() {
            var parametros = {
                "conferencia": <?php echo $_GET['i']; ?>
            };
            $.ajax({
                data: parametros,
                url: 'php/disponibilidadConferencia.php',
                type: 'post',
                success: function(response) {
                    $("#leyenda").html(response);
                }
            });
        }
        setInterval(leyenda, 1000);
    </script>
    <script>
        function btnInscripcion() {
            var parametros = {
                "conferencia": <?php echo $_GET['i']; ?>,
                "a": <?php echo $_SESSION["id_alumno"]; ?>
            };
            $.ajax({
                data: parametros,
                url: 'php/btnInscripcionConferencia.php',
                type: 'post',
                success: function(response) {
                    $("#btnInscripcion").html(response);
                }
            });
        }
        setInterval(btnInscripcion, 1000);
    </script>
    <script type="text/javascript">
        function confirmation() {
            if (confirm("¿Deseas asistir a esta conferencia?")) {
                return true;
            } else {
                return false;
            }
        }
    </script>
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
    <!-- page load-->
    <div class="images-preloader">
        <div id="preloader_1 spinner1" class="spinner1 rectangle-bounce">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
    <?php include "header.php"; ?>
    <main>
        <section class="single-course section-padding-large">
            <div class="container">
                <div class="row">
                    <?php
                    // DATOS DEL ALUMNO (solo para saber a que carrera pertenece)
                    $Alumno = $DB_con->prepare('SELECT * FROM alumnos  WHERE id_user =:uid');
                    $Alumno->execute(array(':uid' => $_SESSION["id_alumno"]));
                    $rowAlumno = $Alumno->fetch(PDO::FETCH_ASSOC);
                    extract($rowAlumno);

                    // INFORMACION DE La conferencia
                    $conferencia = $DB_con->prepare("SELECT instructores.*, conferencias.* FROM conferencias INNER JOIN instructores ON conferencias.id_instructor = instructores.id_instructor WHERE id_adminCarrera  =:uid AND status_instructor = :uid2 AND id_conferencia = :uid3");
                    $conferencia->execute(array(':uid' => $rowAlumno["id_adminCarrera"], ':uid2' => 1, ':uid3' => $id_conferenciaGet));

                    while ($row = $conferencia->fetch(PDO::FETCH_OBJ)) {

                        // CONTADOR DE ALUMNOS INSCRITOS A La conferencia
                        $consulta2 = $DB_con->prepare('SELECT COUNT(*) AS cont FROM alumnos_conferencias WHERE id_conferencia =:uid');
                        $consulta2->execute(array(':uid' => $row->id_conferencia));
                        $contador = $consulta2->fetch(PDO::FETCH_ASSOC);
                        extract($contador);
                    ?>

                        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 single-course-content">
                            <div class="single-title">
                                <h1><?php echo $row->nombre_conferencia; ?> </h1>
                                <div id="leyenda">
                                </div>
                            </div>
                            <div class="single-course-info">
                                <figure class="single-course-images">
                                    <img src="images/conferencia/<?php echo $row->imagen_conferencia; ?>" alt="">
                                </figure>
                                <div class="course-teacher-cat display-flex">
                                    <div class="teacher-cat">
                                        <ul class="display-flex">
                                            <li class="display-flex">

                                                <div class="teacher-cat-item">
                                                    <span>Instructor:</span>
                                                    <a><?php echo $row->nombre_instructor;
                                                        echo ' ';
                                                        echo $row->apellido_instructor; ?></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="teacher-cat-item">
                                                    <span>Área</span>
                                                    <a><?php echo $row->lugar_conferencia; ?></a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div id="btnInscripcion">
                                    </div>

                                </div>

                            </div>
                            <div class="single-course-tab">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true"><i class="fas fa-book"></i>Información</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="curriculum-tab" data-toggle="tab" href="#alumnos" role="tab" aria-controls="curriculum" aria-selected="false"><i class="fas fa-user"></i>Alumnos</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                        <div class="course-overview">
                                            <div class="course-desc">
                                                <!-- <h4 class="course-tab-title">Información del conferencia</h4> -->
                                                <p class="course-desc-content">
                                                    <?php echo $row->descripcion_conferencia;
                                                    $cupoconferencia =  $row->cupo_conferencia ?>
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                <?php
                            }
                                ?>

                                <br>
                                <br>
                                <script>
                                    function listaDeAlumnos() {
                                        var parametros = {
                                            "conferencia": <?php echo $_GET['i']; ?>,
                                            "cupo": <?php echo $cupoconferencia; ?>
                                        };
                                        $.ajax({
                                            data: parametros,
                                            url: 'php/listaAlumnosConferencia.php',
                                            type: 'post', 
                                            success: function(response) {
                                                $("#lista").html(response);
                                            }
                                        });
                                    }
                                    setInterval(listaDeAlumnos, 1000);
                                </script>
                                <div class="tab-pane fade" id="alumnos" role="tabpanel" aria-labelledby="curriculum-tab">
                                    <ul id="curriculum-content" class="curriculum-content">
                                        <li class="card active">
                                            <div id="lista">
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="listar-nextprevposts">

                                <?php
                                // INFORMACION DE LOS conferencias SIGUIENTES
                                $masconferencias = $DB_con->prepare("SELECT instructores.*, conferencias.* FROM conferencias INNER JOIN instructores ON conferencias.id_instructor = instructores.id_instructor WHERE id_adminCarrera  =:uid AND status_instructor = :uid2 AND id_conferencia < :uid3 ORDER BY id_conferencia DESC LIMIT 1");
                                $masconferencias->execute(array(':uid' => $rowAlumno["id_adminCarrera"], ':uid2' => 1, ':uid3' => $id_conferenciaGet));
                                while ($rowT = $masconferencias ->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                    <div class="listar-prevpost">
                                        <a href='conferencia.php?i=<?php echo $rowT->id_conferencia; ?>'>
                                            <i class="fa fa-angle-left"></i><span>Conferencia Anterior</span>
                                            <h4 class="course-tab-title"><?php echo $rowT->nombre_conferencia; ?></h4>
                                        </a>
                                    </div>
                                <?php
                                }
                                ?>

                                <?php
                                // INFORMACION DE LOS conferencia SIGUIENTES
                                $masconferencia2 = $DB_con->prepare("SELECT instructores.*, conferencias.* FROM conferencias INNER JOIN instructores ON conferencias.id_instructor = instructores.id_instructor WHERE id_adminCarrera  =:uid AND status_instructor = :uid2 AND id_conferencia > :uid3 ORDER BY id_conferencia ASC LIMIT 1");
                                $masconferencia2->execute(array(':uid' => $rowAlumno["id_adminCarrera"], ':uid2' => 1, ':uid3' => $id_conferenciaGet));
                                while ($rowT = $masconferencia2 ->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                    <div class="listar-nextpost">
                                        <a href='conferencia.php?i=<?php echo $rowT->id_conferencia; ?>'>
                                            <span>Siguiente Conferencia</span><i class="fa fa-angle-right"></i>
                                            <h4 class="course-tab-title"><?php echo $rowT->nombre_conferencia; ?></h4>
                                        </a>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                </div>

        </section>
    </main>

    <!-- Footer page -->
    <footer class="footer">
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <p class="copyright">Sistema de Administración de Eventos y Congresoss <span></span></p>

                </div>
            </div>
        </div>
    </footer>


    <!-- Back to top -->
    <div id="back-to-top">
        <i class="fa fa-angle-up"></i>
    </div>

    <!-- JS -->

    <!-- Jquery and Boostrap library -->
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="vendor/bootstrap/js/popper.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Other js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEmXgQ65zpsjsEAfNPP9mBAz-5zjnIZBw"></script>
    <script src="js/theme-map.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/imagesloaded.pkgd.js"></script>
    <script src="js/isotope-docs.min.js"></script>

    <!-- Vendor JS -->
    <script src="vendor/slick/slick.min.js"></script>
    <script src='vendor/jquery-ui/jquery-ui.min.js'></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="vendor/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="vendor/sweetalert/sweetalert.min.js"></script>
    <script src="vendor/fancybox/dist/jquery.fancybox.min.js"></script>
    <script src='vendor/fullcalendar/lib/moment.min.js'></script>
    <script src='vendor/fullcalendar/fullcalendar.min.js'></script>
    <script src='vendor/wow/dist/wow.min.js'></script>

    <!-- REVOLUTION JS FILES -->
    <script src="vendor/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="vendor/revolution/js/jquery.themepunch.revolution.min.js"></script>

    <!-- Form JS -->
    <script src="js/validate-form.js"></script>
    <script src="js/config-contact.js"></script>

    <!-- Main JS -->
    <script src="js/main/main.js"></script>

    <script type='text/javascript'>
        document.oncontextmenu = function() {
            return false
        }
    </script>
</body>

</html>