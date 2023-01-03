<?php

require "../conexion.php";

$id_encuesta = $_GET['id_encuesta'];
$query2 = "SELECT * FROM preguntas WHERE id_encuesta = '$id_encuesta'";
$respuesta2 = $con->query($query2);

$query3 = "SELECT encuestas.titulo, encuestas.descripcion, preguntas.id_pregunta, preguntas.id_encuesta, preguntas.id_tipo_pregunta 
		FROM preguntas
		INNER JOIN encuestas
		ON preguntas.id_encuesta = encuestas.id_encuesta
		WHERE preguntas.id_encuesta = '$id_encuesta'";
$respuesta3 = $con->query($query3);
$row3 = $respuesta3->fetch_assoc();
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
    </div>
    <?php include "header.php"; ?>
    <main>
        <section class="heading-page">
            <img src="../../images/bloggrid-heading-bg.jpg" alt="">
            <div class="container">
                <div class="heading-page-content">
                    <div class="au-page-title text-center">
                        <h1><?php echo $row3['titulo'] ?></h1>
                        <h3><?php echo $row3['descripcion'] ?></h3>
                    </div>
                </div>
            </div>



        </section>
        <section class="testimonials background-grey section-padding-small">
            <div class="container">
                <div class="section-title section-title-center ">
               
                    <div class="container text">



                        <form  action="procesar.php" method="Post" autocomplete="off">
                            <input type="hidden" id="id_encuesta" name="id_encuesta" value="<?php echo $id_encuesta ?>" />
                            <div class="row g-3needs-validation" novalidate>
                <div class="col-md-4">
                                        <labeL class="form-label">
                                            <h5>Nombre Completo</h5>
                                        </labeL>
                                        <input name="nombre" type="text" class="form-control" id="validationCustom01" placeholder="Nombre Completo" required>

                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">
                                            <h5>Matricula</h5>
                                        </label>
                                        <input name="apellido" type="number" class="form-control" id="validationCustom02" placeholder="Matricula" required>

                                    </div>


                                    <div class="col-md-4">
                                        <label class="form-label">
                                            <h5>Correo Institucional</h5>
                                        </label>
                                        <input name="correo" type="email" class="form-control" placeholder="Correo institucional" required>

                                    </div>

                                    <div class="col-md-6"><br>
                                        <label class="form-label">
                                            <h5>Semestre/Grupo</h5>
                                        </label>
                                        <select class="form-control" aria-label="Default select example" name="semestre_grupo" required>
                                            <option selected>Elige tu Semestre/Grupo</option>
                                            <?php
                                            $semestre_grupo = $DB_con->prepare("SELECT * FROM semestre_grupo ORDER BY semestre_grupo ASC");
                                            $semestre_grupo->execute();
                                            while ($row = $semestre_grupo->fetch(PDO::FETCH_OBJ)) {
                                                if ($rowAlumnos['semestre_grupo'] == $row->semestre_grupo) {
                                                    echo '<option value="">';
                                                    echo $row->semestre_grupo;
                                                    echo '</option>';
                                                } else {
                                                    echo '<option>';
                                                    echo $row->semestre_grupo;
                                                    echo '</option>';
                                                }
                                            } ?>
                                        </select>
                                        

                                    </div>
                                    <div class="col-md-6"><br>
                                        <label class="form-label">
                                            <h5>Taller</h5>
                                        </label>
                                        <select class="form-control"  aria-label="Default select example" name="talleres" required>
                                            
                                            <?php
                                            $talleres = $DB_con->prepare("SELECT * FROM talleres ORDER BY nombre_taller ASC");
                                            $talleres->execute();
                                            while ($row = $talleres->fetch(PDO::FETCH_OBJ)) {
                                                if ($rowAlumnos['talleres'] == $row->talleres) {
                                                    echo '<option selected>';
                                                    echo $row->nombre_taller;
                                                    echo '</option>';
                                                } else {
                                                    echo '<option>';
                                                    echo $row->nombre_taller;
                                                    echo '</option>';
                                                }
                                            } ?>
                                        </select>

                                    </div>
                </div>
                <br>

                            <?php

                            $i = 1;
                            while (($row2 = $respuesta2->fetch_assoc())) {

                                $id = $row2['id_pregunta'];

                                $query = "SELECT preguntas.id_pregunta, preguntas.titulo, preguntas.id_tipo_pregunta, opciones.id_opcion, opciones.valor
				FROM opciones
				INNER JOIN preguntas
				ON preguntas.id_pregunta = opciones.id_pregunta
                WHERE preguntas.id_pregunta = $id
				ORDER BY opciones.id_pregunta, opciones.id_opcion";

                                $respuesta = $con->query($query);

                            ?>
                                <div class="container col-md-12 ">
                                    <h3><?php echo "$i. " . $row2['titulo'] ?></h3>

                                    <?php
                                    while (($row = $respuesta->fetch_assoc())) {

                                    ?>

                                        <div class="form-check ">
                                            <label><input class="form-check-input" type="radio" id="exampleRadios1" name="<?php echo $row['id_pregunta'] ?>" value="<?php echo $row['id_opcion'] ?>" required> <?php echo $row['valor'] ?></label>
                                            <input type="hidden" name="c" value="" require>

                                        </div>

                                <?php
                                    }
                                    $i++;
                                }
                                ?>

                                </div>
                                </br>
                                
                                <div class="row g-3needs-validation" novalidate>
                                    

                                    <div class="col-md-12"><br>
                                            <label class="form-lable"><h5>Tu Opinion</h5></label>
                                            <textarea name="respuesta" type="text" class="form-control"  placeholder="Escribenos tus opiniones acerca de las experiencias de los talleres, concursos, conferencias y/o servicio brindado en estas actividades." required></textarea>
                                           
                                        </div>
                                </div>


<br>
                                
                                <br>

                                <div>
                                    <input type="hidden" name="id_encuesta" value="<?php echo $id_encuesta ?>">
                                    <input class="btn btn-primary" type="submit" value="Pagina Siguiente">
                                </div>
                        </form>



                    </div>



                    <hr>
                    <!-- Optional JavaScript -->
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
    <script src="../../vendor/bootstrap/js/popper.min.js"></script>
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Other js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEmXgQ65zpsjsEAfNPP9mBAz-5zjnIZBw"></script>
    <script src="../../js/theme-map.js"></script>
    <script src="../../js/jquery.countdown.min.js"></script>
    <script src="../../js/masonry.pkgd.min.js"></script>
    <script src="../../js/imagesloaded.pkgd.js"></script>
    <script src="../../js/isotope-docs.min.js"></script>

    <!-- Vendor JS -->
    <script src="../../vendor/slick/slick.min.js"></script>
    <script src='../../vendor/jquery-ui/jquery-ui.min.js'></script>
    <script src="../../vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="../../vendor/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="../../vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="../../vendor/sweetalert/sweetalert.min.js"></script>
    <script src="../../vendor/fancybox/dist/jquery.fancybox.min.js"></script>
    <script src='../../vendor/fullcalendar/lib/moment.min.js'></script>
    <script src='../../vendor/fullcalendar/fullcalendar.min.js'></script>
    <script src='../../vendor/wow/dist/wow.min.js'></script>

    <!-- REVOLUTION JS FILES -->
    <script src="../../vendor/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="../../vendor/revolution/js/jquery.themepunch.revolution.min.js"></script>

    <!-- Form JS -->
    <script src="../../js/validate-form.js"></script>
    <script src="../../js/config-contact.js"></script>

    <!-- Main JS -->
    <script src="../../js/main/main.js"></script>

    <script type='text/javascript'>
        document.oncontextmenu = function() {
            return false
        }
    </script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>