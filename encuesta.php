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

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".toast").toast("show");
        });
    </script>
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
        <section class="featured section-padding-large">
            <div class="container">
                <section class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">Encuesta de salida.</h1>
                        <p class="text-center">Sistema de Administración de Eventos y Congresos</p>
                    </div>
                </section>
                <!-- <hr><br /> -->
                <!-- <section class="row">
                    <section class="col-md-12">
                        <h3>Datos basicos</h3>
                        <p></p>
                    </section>
                </section>
                <section class="row">
                    <section class="col-md-12">
                        <section class="row">
                            <div class="col-md-4">
                                <label for="tipoAtencion">Tipo de Atención: *</label>
                                <select class="form-control" id="tipoAtencion">
                                    <option value="ce">Consulta Externa</option>
                                    <option value="farm">Farmacia</option>
                                    <option value="fisi">Fisioterapia</option>
                                    <option value="fo">Fo</option>
                                    <option value="hosp">Hospitalizació</option>
                                    <option value="odon">Odontologia</option>
                                    <option value="pyp">Promoción y Prevención</option>
                                    <option value="rx">Rayos X</option>
                                    <option value="urge">Urgencias</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fechaActual">Fecha Actual: *</label>
                                    <input type="date" class="form-control" id="fechaActual" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fechaActencion">Fecha Atención: *</label>
                                    <input type="date" class="form-control" id="fechaAtencion" required>
                                </div>
                            </div>
                        </section>
                        <section class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nombreCompleto">Nombre Compelto: *</label>
                                    <input type="text" class="form-control" id="nombreCompleto" maxlength="128" placeholder="Nombre Compelto" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <label for="edadEncuestado">Edad: *</label>
                                    <input type="number" class="form-control" id="edadEncuestado" placeholder="Edad" maxlength="3" required />
                                </div>
                            </div>
                        </section>
                        <section class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="idIdentificacion">Identificación: *</label>
                                    <input type="number" id="idIdentificacion" class="form-control" placeholder="Numero de Identificación" maxlength="15" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="telefono">Telefono: *</label>
                                <input type="text" class="form-control" id="telefono" placeholder="Numero Telefonico" maxlength="12" required />
                            </div>
                            <div class="col-md-4">
                                <label for="epsPaciente">EPS: *</label>
                                <input type="text" class="form-control" id="epsPaciente" placeholder "EPS del Paciente" required />
                            </div>
                        </section>
                    </section>
                </section> -->
                <hr />

                <!--  Servicios  -->
                <section class="row">
                    <div class="col-md-12">
                        <h3>Taller, Concurso y conferencia.</h3>
                        <p></p>
                    </div>
                </section>
                <!--  PREGUNTA 1  -->
                <section class="row">
                    <div class="col-md-6">
                        <p>1- ¿Los talleres presentados fueron interesantes para ti?</p>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="pregunta1a" value="SI"> Si
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntab" value="NO"> No
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntac" value="NA"> N/A
                        </label>
                    </div>
                </section>
                <!--  PREGUNTA 2  -->
                <section class="row">
                    <div class="col-md-6">
                        <p>2- ¿Las Conferencias presentadas fueron interesantes para ti? </p>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="pregunta1a" value="SI"> Si
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntab" value="NO"> No
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntac" value="NA"> N/A
                        </label>
                    </div>
                </section>
                <!--  PREGUNTA 3  -->
                <section class="row">
                    <div class="col-md-6">
                        <p>3- ¿Sientes que Los concursos realizados son importantes en tu desarrollo? </p>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="pregunta1a" value="SI"> Si
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntab" value="NO"> No
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntac" value="NA"> N/A
                        </label>
                    </div>
                </section>
                <!--  PREGUNTA 4  -->
                <section class="row">
                    <div class="col-md-12">
                        <p>¿Tienes algun Concurso, Conferencia o Taller para sugerir?¿Cual?</p>
                        <p></p>
                    </div>
                </section>
                <section class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="comment">Sugerencias:</label>
                            <textarea class="form-control" rows="2" id="comentarios"></textarea>
                        </div>
                    </div>
                </section>
                <hr>
                <!--  Durante la Atención  -->
                <section class="row">
                    <div class="col-md-12">
                        <h3>Docentes.</h3>
                        <p></p>
                    </div>
                </section>
                <!--  PREGUNTA 5  -->
                <section class="row">
                    <div class="col-md-6">
                        <p>5- ¿Como Calificarias al instructor que impartio el taller?</p>
                    </div>
                    <div class="col-md-4">
                                <select class="form-control" id="pregunta13">
                                    <option value="5">Muy Buena</option>
                                    <option value="4">Buena</option>
                                    <option value="3">Regular</option>
                                    <option value="2">Mala</option>
                                    <option value="1">Muy Mala</option>
                                    <option value="0">No Responde</option>
                                </select>
                            </div>
                </section>
                <!--  PREGUNTA 6  -->
                <section class="row">
                    <div class="col-md-6">
                        <p>6- ¿Como Calificarias al instructor que impartio la conferencia?</p>
                    </div>
                    <div class="col-md-4">
                                <select class="form-control" id="pregunta13">
                                    <option value="5">Muy Buena</option>
                                    <option value="4">Buena</option>
                                    <option value="3">Regular</option>
                                    <option value="2">Mala</option>
                                    <option value="1">Muy Mala</option>
                                    <option value="0">No Responde</option>
                                </select>
                            </div>
                </section>
                <!--  PREGUNTA 7  -->
                <section class="row">
                    <div class="col-md-6">
                        <p>7- ¿Como Calificarias al instructor que coordino el Concurso?</p>
                    </div>
                    <div class="col-md-4">
                                <select class="form-control" id="pregunta13">
                                    <option value="5">Muy Buena</option>
                                    <option value="4">Buena</option>
                                    <option value="3">Regular</option>
                                    <option value="2">Mala</option>
                                    <option value="1">Muy Mala</option>
                                    <option value="0">No Responde</option>
                                </select>
                            </div>
                </section>
               <!--  PREGUNTA 8  -->
               <!--   <section class="row">
                    <div class="col-md-6">
                        <p>8- ¿lorem ipsum dolor sit amet consectetur incididunt ut labore et ? </p>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="pregunta1a" value="SI"> Si
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntab" value="NO"> No
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntac" value="NA"> N/A
                        </label>
                    </div>
                </section>-->
                <!--  PREGUNTA 9  -->
                <!--  <section class="row">
                    <div class="col-md-6">
                        <p>9- ¿lorem ipsum dolor sit amet consectetur incididunt ut labore et ?</p>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="pregunta1a" value="SI"> Si
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntab" value="NO"> No
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntac" value="NA"> N/A
                        </label>
                    </div>
                </section>-->
                <br />
                <hr />
                <!--  Durante la Atención  -->
                <section class="row">
                    <div class="col-md-12">
                        <h3>Administrativos.</h3>
                        <p></p>
                    </div>
                </section>
                <!--  PREGUNTA 10  -->
                <section class="row">
                    <div class="col-md-6">
                        <p>8- ¿Los administrativos te brindaron la ayuda necesaria ?</p>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="pregunta1a" value="SI"> Si
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntab" value="NO"> No
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntac" value="NA"> N/A
                        </label>
                    </div>
                </section>
                <!--  PREGUNTA 11  -->
                <section class="row">
                    <div class="col-md-6">
                        <p>9- ¿Te fue util la informacion que brindaron los administrativo a lo largo del congreso ?</p>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="pregunta1a" value="SI"> Si
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntab" value="NO"> No
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntac" value="NA"> N/A
                        </label>
                    </div>
                </section>
                <!--  PREGUNTA 12  -->
                <!-- <section class="row">
                    <div class="col-md-6">
                        <p>10- ¿lorem ipsum dolor sit amet consectetur incididunt ut labore et ?</p>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="pregunta1a" value="SI"> Si
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntab" value="NO"> No
                        </label>
                    </div>
                    <div class="col-md-2">
                        <label class="radio">
                            <input type="radio" name="pregunta1" id="preguntac" value="NA"> N/A
                        </label>
                    </div>
                </section> -->





                <br />
                <hr />
                <!--  Satisfacción General  -->
                <section class="row">
                    <div class="col-md-12">
                        <h3>Satisfacción General.</h3>
                        <p></p>
                    </div>
                </section>
                <!--  PREGUNTA 13  -->
                <section class="row">
                    <div class="col-md-12">
                        <section class="row">
                            <div class="col-md-8">
                                <p>11- ¿Como fue la experiencia en el congreso?</p>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" id="pregunta13">
                                    <option value="5">Muy Buena</option>
                                    <option value="4">Buena</option>
                                    <option value="3">Regular</option>
                                    <option value="2">Mala</option>
                                    <option value="1">Muy Mala</option>
                                    <option value="0">No Responde</option>
                                </select>
                            </div>
                        </section>
                    </div>
                </section><br />
                <!--  PREGUNTA 14  -->
                <section class="row">
                    <div class="col-md-12">
                        <section class="row">
                            <div class="col-md-8">
                                <p>12- ¿Como fue la experiencia usando el sistema Web?</p>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" id="pregunta14">
                                    <option value="5">Muy Buena</option>
                                    <option value="4">Buena</option>
                                    <option value="3">Regular</option>
                                    <option value="2">Mala</option>
                                    <option value="1">Muy Mala</option>
                                    <option value="0">No Responde</option>
                                </select>
                            </div>
                        </section>
                    </div>
                </section><br />
                <hr />

                <!--  Comentarios  -->
                <section class="row">
                    <div class="col-md-12">
                        <h3>Comentarios.</h3>
                        <p></p>
                    </div>
                </section>
                <section class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="comment">Comentarios:</label>
                            <textarea class="form-control" rows="6" id="comentarios"></textarea>
                        </div>
                    </div>
                </section>
                <section class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-info" id="saveForm" onclick="saveForm">Guardar Encuesta</button>
                        <button type="button" class="btn btn-danger" id="clearForm">Limpiar formulario</button>
                    </div>
                </section>
            </div>

        </section>


    </main>

    <!-- Footer page -->
    <footer class="footer">
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <p class="copyright">Sistema de Administración de Congresos<span></span></p>

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
    <script src="js/main/main.js"></script>
    <script type='text/javascript'>
        document.oncontextmenu = function() {
            return false
        }
    </script>
</body>

</html>