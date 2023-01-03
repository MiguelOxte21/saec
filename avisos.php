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
    <div class="images-preloader">
        <div id="preloader_1 spinner1" class="spinner1 rectangle-bounce">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
    <?php
    include "header.php";
    ?>
    <main>
        <section class="testimonials background-grey section-padding-large">
            <div class="container">
                <div class="section-title section-title-center">
                    <h2>Avisos</h2>
                </div>
                <div class="testimonials-content">
                    <div class="row">

                        <?php
                        $avisos = $DB_con->prepare("SELECT * FROM avisos WHERE id_adminCarrera =:id_adminCarrera");
                        $avisos->execute(array(':id_adminCarrera' => $_SESSION["id_adminCarrera"]));
                        while ($row = $avisos->fetch(PDO::FETCH_OBJ)) {
                        ?>

                            <article class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 item">
                                <div class="info">
                                    <div class="meta"> <span class="date"><i class="far fa-calendar"></i><?php echo $row->fecha; ?>
                                        </span> </div>
                                    <p class="desc"><?php echo $row->descripcion; ?></p>
                                </div>
                            </article>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <p class="copyright">Sistema de Administración de Eventos y Congresos<span></span></p>

                </div>
            </div>
        </div>
    </footer>

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


    <!-- Form JS -->

    <!-- Main JS -->

    <script src="js/main/main.js"></script>
    <script type='text/javascript'>
        document.oncontextmenu = function() {
            return false
        }
    </script>
</body>

</html>