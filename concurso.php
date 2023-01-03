<?php
session_start();
$idcarr = $_SESSION["id_adminCarrera"];
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

$id_concursoGet = $_GET['i'];
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
                "concurso": <?php echo $_GET['i']; ?>
            };
            $.ajax({
                data: parametros,
                url: 'php/disponibilidadConcurso.php',
                type: 'post',
                success: function(response) {
                    $("#leyenda").html(response);
                }
            });
        }
        setInterval(leyenda, 1000);
    </script>
    <script type="text/javascript">
        function confirmation() {
            if (confirm("¿Deseas Inscribirte a este concurso?")) {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

                    // INFORMACION DE LOS CONCURSOS
                    $consultaConcurso = $DB_con->prepare("SELECT instructores.*, concursos.* FROM concursos INNER JOIN instructores ON concursos.id_instructor = instructores.id_instructor WHERE id_adminCarrera  =:uid AND status_instructor = :uid2 AND id_concurso = :uid3");
                    $consultaConcurso->execute(array(':uid' => $rowAlumno["id_adminCarrera"], ':uid2' => 1, ':uid3' => $id_concursoGet));

                    while ($row = $consultaConcurso->fetch(PDO::FETCH_OBJ)) {

                        // CONTADOR DE ALUMNOS INSCRITOS A ESTE CONCURSO
                        $consulta2 = $DB_con->prepare('SELECT COUNT(*) AS cont FROM alumnos WHERE id_concurso =:uid');
                        $consulta2->execute(array(':uid' => $row->id_concurso));
                        $contador = $consulta2->fetch(PDO::FETCH_ASSOC);
                        extract($contador);
                        $maxAlumno = $row->max_alumnos_grupal;
                        $modalidad = $row->modalidad;
                        $cupo_concurso = $row->cupo_concurso;
                    ?>

                        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 single-course-content">
                            <div class="single-title">
                                <h1><?php echo $row->nombre_concurso; ?> </h1>
                                <div id="leyenda">
                                </div>
                            </div>
                            <div class="single-course-info">
                                <figure class="single-course-images">
                                    <img src="images/concursos/<?php echo $row->imagen_concurso; ?>" alt="">
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
                                                    <a><?php echo $row->lugar_concurso; ?></a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php if ($row->modalidad == 1) { ?>
                                        <script>
                                            function btnInscripcion() {
                                                var parametros = {
                                                    "concurso": <?php echo $_GET['i']; ?>,
                                                    "a": <?php echo $_SESSION["id_alumno"]; ?>
                                                };
                                                $.ajax({
                                                    data: parametros,
                                                    url: 'php/btnInscripcionConcurso.php',
                                                    type: 'post',
                                                    success: function(response) {
                                                        $("#btnInscripcion").html(response);
                                                    }
                                                });
                                            }
                                            setInterval(btnInscripcion, 1000);
                                        </script>
                                    <?php
                                    } elseif ($row->modalidad == 2) { ?>
                                        <script>
                                            function btnInscripcion() {
                                                var parametros = {
                                                    "concurso": <?php echo $_GET['i']; ?>,
                                                    "a": <?php echo $_SESSION["id_alumno"]; ?>
                                                };
                                                $.ajax({
                                                    data: parametros,
                                                    url: 'php/btnInscripcionConcurso_grupal.php',
                                                    type: 'post',
                                                    success: function(response) {
                                                        $("#btnInscripcion").html(response);
                                                    }
                                                });
                                            }
                                            setInterval(btnInscripcion, 1000);
                                        </script>
                                    <?php } else {
                                    } ?>

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
                                        <a class="nav-link" id="curriculum-tab" data-toggle="tab" href="#alumnos" role="tab" aria-controls="curriculum" aria-selected="false">
                                            <?php
                                            if ($modalidad == 2) {
                                                echo '<i class="fas fa-users"></i>Equipos</a>';
                                            } else {
                                                echo '<i class="fas fa-user"></i>Alumnos</a>';
                                            }
                                            ?>

                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                        <div class="course-overview">
                                            <div class="course-desc">
                                                <p class="course-desc-content">
                                                    <?php echo $row->descripcion_concurso;
                                                    $cupoConcurso =  $row->cupo_concurso ?>
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                <?php
                            }
                                ?>

                                <br>
                                <br>
                                <?php
                                if ($modalidad == 2) { ?>
                                    <script>
                                        function listaDeAlumnos() {
                                            var parametros = {
                                                "concurso": <?php echo $_GET['i']; ?>,
                                                "cupo": <?php echo $cupoConcurso; ?>
                                            };
                                            $.ajax({
                                                data: parametros,
                                                url: 'php/listaAlumnosConcurso.php', 
                                                type: 'post', 
                                                success: function(response) { 
                                                    $("#lista").html(response);
                                                }
                                            });
                                        }
                                        setInterval(listaDeAlumnos, 1000);
                                    </script>
                                <?php  } elseif ($modalidad == 1) {  ?>
                                    <script>
                                        function listaDeAlumnos() {
                                            var parametros = {
                                                "concurso": <?php echo $_GET['i']; ?>,
                                                "cupo": <?php echo $cupoConcurso; ?>
                                            };
                                            $.ajax({
                                                data: parametros, 
                                                url: 'php/listaAlumnosConcurso_individual.php', 
                                                type: 'post', 
                                                success: function(response) { 
                                                    $("#lista").html(response);
                                                }
                                            });
                                        }
                                        setInterval(listaDeAlumnos, 1000);
                                    </script>
                                <?php } else {
                                } ?>

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
                                // INFORMACION DE LOS CONCURSOS SIGUIENTES
                                $concultaConcursoSiguiente = $DB_con->prepare("SELECT instructores.*, concursos.* FROM concursos INNER JOIN instructores ON concursos.id_instructor = instructores.id_instructor WHERE id_adminCarrera  =:uid AND status_instructor = :uid2 AND id_concurso < :uid3 ORDER BY id_concurso DESC LIMIT 1");
                                $concultaConcursoSiguiente->execute(array(':uid' => $rowAlumno["id_adminCarrera"], ':uid2' => 1, ':uid3' => $id_concursoGet));
                                while ($rowT = $concultaConcursoSiguiente->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                    <div class="listar-prevpost">
                                        <a href='concurso.php?i=<?php echo $rowT->id_concurso; ?>'>
                                            <i class="fa fa-angle-left"></i><span>Concurso Anterior</span>
                                            <h4 class="course-tab-title"><?php echo $rowT->nombre_concurso; ?></h4>
                                        </a>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                // INFORMACION DE LOS CONCURSOS SIGUIENTES
                                $concultaConcursoSiguiente2 = $DB_con->prepare("SELECT instructores.*, concursos.* FROM concursos INNER JOIN instructores ON concursos.id_instructor = instructores.id_instructor WHERE id_adminCarrera  =:uid AND status_instructor = :uid2 AND id_concurso > :uid3 ORDER BY id_concurso ASC LIMIT 1");
                                $concultaConcursoSiguiente2->execute(array(':uid' => $rowAlumno["id_adminCarrera"], ':uid2' => 1, ':uid3' => $id_concursoGet));
                                while ($rowT = $concultaConcursoSiguiente2->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                    <div class="listar-nextpost">
                                        <a href='concurso.php?i=<?php echo $rowT->id_concurso; ?>'>
                                            <span>Siguiente Concurso</span><i class="fa fa-angle-right"></i>
                                            <h4 class="course-tab-title"><?php echo $rowT->nombre_concurso; ?></h4>
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
                    <p class="copyright">Sistema de Administración de Eventos y Congresos <span></span></p>

                </div>
            </div>
        </div>
    </footer>

    <!-- Back to top -->
    <div id="back-to-top">
        <i class="fa fa-angle-up"></i>
    </div>

    <?php
    if ($modalidad == 2) {
    ?>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Inscribir equipo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="inscripcion.php">
                            <div class="form-group">
                                <input type="hidden" name="maxAlum" value="<?php echo $maxAlumno; ?>" required>
                                <input type="hidden" name="concurso" value="<?php echo $id_concursoGet; ?>" required>

                                <label for="recipient-name" class="col-form-label">Nombre del equipo</label>
                                <input type="text" name="nomEquipo" class="form-control" id="recipient-name" required>

                                <label for="recipient-name" class="col-form-label">Jefe de equipo</label>
                                <select name="alumno1" class="form-control" id="recipient-name">
                                    <option value="<?php echo $rowAlumno["id_alumno"]; ?>"><?php echo $rowAlumno["nombre_alumno"];
                                                                                            echo ' ';
                                                                                            echo $rowAlumno["apellido_alumno"];
                                                                                            echo ' (';
                                                                                            echo $rowAlumno["matricula"];
                                                                                            echo ')'; ?></option>
                                </select>

                                <?php for ($i = 1; $i < $maxAlumno; $i++) { ?>
                                    <label for="recipient-name" class="col-form-label">Integrante #<?php echo $i + 1; ?></label>
                                    <select name="alumno<?php echo $i + 1; ?>" class="form-control" id="recipient-name">
                                        <option value="0">Sin integrantes </option>
                                        <?php
                                        // MOSTRANDO A TODOS LOS ALUMNO QUE YA PAGARON Y QUE PERTENEZCAN A LA CARRERA
                                        $consultaAlumnos = $DB_con->prepare("SELECT * FROM alumnos WHERE id_adminCarrera  =:uid AND status_alumno = :uid2");
                                        $consultaAlumnos->execute(array(':uid' => $rowAlumno["id_adminCarrera"], ':uid2' => 1));
                                        while ($rowAlumnos = $consultaAlumnos->fetch(PDO::FETCH_OBJ)) {
                                            if ($rowAlumnos->id_concurso == null and $rowAlumnos->id_equipo == null and $rowAlumnos->id_alumno != $rowAlumno["id_alumno"]) {
                                        ?>
                                                <option value="<?php echo $rowAlumnos->id_alumno; ?>">
                                                    <?php echo $rowAlumnos->nombre_alumno;
                                                    echo ' ';
                                                    echo $rowAlumnos->apellido_alumno;
                                                    echo ' (';
                                                    echo $rowAlumnos->matricula;
                                                    echo ')'; ?>
                                                </option>
                                            <?php
                                            } ?>
                                        <?php } ?>
                                    </select>
                                <?php  } ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button name="concursoEquipos" type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

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