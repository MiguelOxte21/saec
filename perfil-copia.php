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
include("SAC/Conexion.php");
// INFORMACION DEL ALUMNO
if (isset($_SESSION["id_alumno"])) {
    $consultaAlumno = $DB_con->prepare('SELECT users.*, alumnos.* FROM alumnos INNER JOIN users ON alumnos.id_user = users.id_user WHERE alumnos.id_user =:id_user');
    $consultaAlumno->execute(array(':id_user' => $_SESSION["id_alumno"]));
    $rowAlumnos = $consultaAlumno->fetch(PDO::FETCH_ASSOC);
    extract($rowAlumnos);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Administración de Eventos y Congresos</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-theme6.css">

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
    <link rel='stylesheet' href='vendor/fullcalendar/fullcalendar.css'>
    <link rel='stylesheet' href='vendor/animate/animate.css'>

    <!-- Main CSS File -->
    <link href="css/style.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


    <script type="text/javascript">
        function mostrarPassword() {
            var cambio = document.getElementById("txtPassword");
            if (cambio.type == "password") {
                cambio.type = "text";
                $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            } else {
                cambio.type = "password";
                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }

        }

        $(document).ready(function() {
            //CheckBox mostrar contraseña
            $('#ShowPassword').click(function() {
                $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });
        });
    </script>
    <style>
        .selcls {
            padding: 9px;
            border: solid 1px #517B97;
            outline: 0;
            /* background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #CAD9E3), to(#FFFFFF));  */
            /* background: -moz-linear-gradient(top, #FFFFFF, #CAD9E3 1px, #FFFFFF 25px); 
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  */
            -moz-box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 8px;
            -webkit-box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 8px;
            margin-bottom: 12px;
            width: 100%;
        }

        .input-group {
            width: 100%;
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
    <?php
    include "header.php";
    ?>
    <div class="form-body without-side">

        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="images/graphic3.svg" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3 class="text-center">PERFIL</h3>
                        <p class="text-center">Sistema de Administración de Eventos y Congresos</p>
                        <form action="actualizar_perfil.php" method="post">
                            <input class="form-control" type="hidden" name="id_user" value="" required>

                            <input class="form-control" type="text" name="nombres" value="<?php echo $rowAlumnos['nombre_alumno']; ?>" pattern="[A-Za-z\s]+" maxlength="40" required>
                            <input class="form-control" type="text" name="apellidos" value="<?php echo $rowAlumnos['apellido_alumno']; ?>" pattern="[A-Za-z\s]+" maxlength="40" required>
                            <input class="form-control" type="text" name="matricula" value="<?php echo $rowAlumnos['matricula']; ?>" pattern="[0-9]+" maxlength="8" required>

                            <select name="semestre_grupo" class="selcls">
                                <?php
                                $semestre_grupo = $DB_con->prepare("SELECT * FROM semestre_grupo ORDER BY semestre_grupo ASC");
                                $semestre_grupo->execute();
                                while ($row = $semestre_grupo->fetch(PDO::FETCH_OBJ)) {
                                    if ($rowAlumnos['semestre_grupo'] == $row->semestre_grupo) {
                                        echo '<option selected>';
                                        echo $row->semestre_grupo;
                                        echo '</option>';
                                    } else {
                                        echo '<option>';
                                        echo $row->semestre_grupo;
                                        echo '</option>';
                                    }
                                } ?>
                            </select>

                            <input class="form-control" type="email" name="email" value="<?php echo $rowAlumnos['correo_user']; ?>" <?php
                                                                                                                                    $correo = $DB_con->prepare("SELECT * FROM correos");
                                                                                                                                    $correo->execute();
                                                                                                                                    echo 'pattern="[a-z0-9|.]+(';
                                                                                                                                    while ($row2 = $correo->fetch(PDO::FETCH_OBJ)) {
                                                                                                                                        echo $row2->correo;
                                                                                                                                        echo '|';
                                                                                                                                    }
                                                                                                                                    echo ')"'; ?> maxlength="70" required>

                            <div class="input-group">
                                <input ID="txtPassword" type="Password" Class="form-control" name="password" value="" maxlength="15">
                                <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                            </div>
                            <p style="color: red; font-size: 12px;">*No se pueden visualizar las contraseñas encriptadas, sin embargo tu contraseña no sera afectada si deja el campo vacío</p>
                            <div class="form-button center">
                                <button id="submit" type="submit" name="perfil" class="ibtn">OK!</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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