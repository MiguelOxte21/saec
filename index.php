<?php
// Se redireccionan si los usuarios se encuentrar inicido seccion
session_start();
if (isset($_SESSION["id_administrador_general"])) {
    print "<script>window.location='SAC/administrador_general/index.php';</script>";
} elseif (isset($_SESSION["id_administrador_carrera"])) {
    print "<script>window.location='SAC/administrador/index.php';</script>";
} elseif (isset($_SESSION["id_instructor"])) {
    print "<script>window.location='SAC/instructor/index.php';</script>";
} elseif (isset($_SESSION["id_alumno"])) {
    print "<script>window.location='inicio.php';</script>";
}
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
    <link rel='stylesheet' href='vendor/fullcalendar/fullcalendar.css'>
    <link rel='stylesheet' href='vendor/animate/animate.css'>

    <!-- Main CSS File -->
    <link href="css/style.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">
</head>

<body>
    <!-- page load-->
    <div class="images-preloader">
        <div id="preloader_1 spinner1" class="spinner1 rectangle-bounce">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>



    <main>
        <!-- Heading Page -->
        <section class="heading-page">
            <img src="images/bloggrid-heading-bg.jpg" alt="">
            <div class="container">
                <div class="heading-page-content">
                    <div class="au-page-title text-center">
                        <h1>Sistema de Administración de Congresos</h1>
                    </div>

                </div>
            </div>
        </section>

        <!-- standard list -->
        <section class="standard-list courses-2 section-padding-large">
            <div class="container">
                <div class="courses-content">
                    <div class="row">
                        <?php
                        include('SAC/Conexion.php');
                        $Carreras = $DB_con->prepare("SELECT admin_carreras.*, logos.imagen FROM logos INNER JOIN admin_carreras ON admin_carreras.id_imagen = logos.id_imagen");
                        $Carreras->execute();
                        while ($row = $Carreras->fetch(PDO::FETCH_OBJ)) { ?>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                <article class="item">
                                    <div class="item-thumb">
                                        <a href="login.php?carrera=<?php echo $row->id_adminCarrera; ?>">
                                            <img src="images/logos/<?php echo $row->imagen; ?>" alt="Logo <?php echo $row->carrera; ?>">
                                        </a>
                                    </div>
                                    <div class="info">
                                        <h3 class="title">
                                            <a href="login.php?carrera=<?php echo $row->id_adminCarrera; ?>" class="text-center"><?php echo $row->carrera; ?></a>
                                        </h3>
                                    </div>
                                </article>
                            </div>
                        <?php  } ?>
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
                    <p class="copyright">Sistema de Administración de Eventos y Congresos<span></span></p>

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