<?php
session_start();
if (!isset($_SESSION["id_administrador_carrera"]) || $_SESSION["id_administrador_carrera"] == null) {
    print "<script>window.location='../../../index.php';</script>";
}

//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {
    $inactivo = 900; //15min en este caso.
    $vida_session = time() - $_SESSION['tiempo'];
    if ($vida_session > $inactivo) {
        session_unset();
        session_destroy();
        header("Location: ../../../index");
        exit();
    } else {  // si no ha caducado la sesion, actualizamos
        $_SESSION['tiempo'] = time();
    }
} else {
    $_SESSION['tiempo'] = time();
}

include('../../Conexion.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de Administración de Congresos</title>

    <link href="../../../plugins/admin/css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../../plugins/admin/assets\img\favicon.png">

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>

    <!-- Bootstrap -->
    <link rel='stylesheet' href='../../../vendor/jquery-ui/jquery-ui.min.css'>
    <link rel="stylesheet" href="../../../vendor/bootstrap/css/bootstrap.min.css">

    <!-- Font Icon -->
    <link rel="stylesheet" href="../../../fonts/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="../../../fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../../fonts/font-awesome-5/css/fontawesome-all.min.css">

    <!-- Revolution slider -->
    <link rel="stylesheet" href="../../../vendor/revolution/settings.css">
    <link rel="stylesheet" href="../../../vendor/revolution/layers.css">
    <link rel="stylesheet" href="../../../vendor/revolution/navigation.css">
    <link rel="stylesheet" href="../../../vendor/revolution/settings-source.css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="../../../vendor/css-hamburgers/dist/hamburgers.min.css">
    <link rel="stylesheet" href="../../../vendor/slick/slick-theme.css">
    <link rel="stylesheet" href="../../../vendor/slick/slick.css">
    <link rel="stylesheet" href="../../../vendor/fancybox/dist/jquery.fancybox.min.css">
    <link rel='stylesheet' href='../../../vendor/fullcalendar/fullcalendar.css' />
    <link rel='stylesheet' href='../../../vendor/animate/animate.css' />

    <!-- Main CSS File -->
    <link href="../../../css/style.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">

    <!-- AJAX -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        function leyenda() {
            var parametros = {
                "concurso": <?php echo $datosConcurso['id_concurso']; ?>
            };
            $.ajax({
                data: parametros,
                url: '../../../php/disponibilidadConcurso.php',
                type: 'post',
                success: function(response) {
                    $("#leyenda").html(response);
                }
            });
        }
        setInterval(leyenda, 1000);
    </script>
</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
        <a class="navbar-brand d-none d-sm-block" href="../index.php">SAC</a><button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#"><i data-feather="menu"></i></button>
        <ul class="navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="../../../images/icono_usuario.png"></a>
                <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="../../../images/icono_usuario.png">
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name">Administrador</div>
                            <div class="dropdown-user-details-email">Ingenieria en Sistemas Computacionales</div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../perfil.php">
                        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                        Modificar Perfil
                    </a>
                    <a class="dropdown-item" href="../../logout.php">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Salir
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include('../nav-2.php'); ?>
        </div>
        <div id="layoutSidenav_content">
                <main>
                    <div class="page-header pb-1 page-header-dark bg-gradient-primary-to-secondary">
                        <div class="container-fluid">
                            <div class="page-header-content">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather=""></i></div>
                                    <span>Agregar Concurso</span>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid mt-4">
                        <div id="solid">
                            <section class="standard-list courses-2 section-padding-large">
                                <div class="container">
                                    <div class="courses-content">
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <article class="item">
                                                    <div class="item-thumb">
                                                        <a>
                                                            <img src="../../../images/concurso_individual.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="info">
                                                        <h3 class="title">
                                                            <a class="text-center">Concurso Individual</a>
                                                        </h3>
                                                        <p>Solo se admitara que solo un alumno se inscriba al concurso</p>
                                                        <div class="row w-100 align-items-center info">
                                                            <div class="col text-center">
                                                                <form action="nuevo_concurso.php" method="post">
                                                                    <input type="hidden" name="modalidad" value="1" required>
                                                                    <button class="btn btn-outline-dark"> Selecionar </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <article class="item">
                                                    <div class="item-thumb">
                                                        <a>
                                                            <img src="../../../images/concurso_grupal.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="info">
                                                        <h3 class="title">
                                                            <a class="text-center">Concurso Grupal</a>
                                                        </h3>
                                                        <p>Los alumnos podran formar equipos para trabajar en conjunto</p>
                                                        <div class="row w-100 align-items-center info">
                                                            <div class="col text-center">
                                                                <form action="nuevo_concurso.php" method="post">
                                                                    <input type="hidden" name="modalidad" value="2" required>
                                                                    <button class="btn btn-outline-dark"> Selecionar </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                </main>
            <footer class="footer mt-auto footer-light">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 small">Sistema de Administración de Congresos</div>
                    </div>
                </div>
        </div>
        </footer>
    </div>
    </div>
    <!-- JS -->
    <!-- Jquery and Boostrap library -->
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="../../../vendor/bootstrap/js/popper.min.js"></script>
    <script src="../../../vendor/jquery/jquery.min.js"></script>
    <script src="../../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Other js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEmXgQ65zpsjsEAfNPP9mBAz-5zjnIZBw"></script>
    <script src="../../../js/theme-map.js"></script>
    <script src="../../../js/jquery.countdown.min.js"></script>
    <script src="../../../js/masonry.pkgd.min.js"></script>
    <script src="../../../js/imagesloaded.pkgd.js"></script>
    <script src="../../../js/isotope-docs.min.js"></script>

    <!-- Vendor JS -->
    <script src="../../../vendor/slick/slick.min.js"></script>
    <script src='../../../vendor/jquery-ui/jquery-ui.min.js'></script>
    <script src="../../../vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="../../../vendor/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="../../../vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="../../../vendor/sweetalert/sweetalert.min.js"></script>
    <script src="../../../vendor/fancybox/dist/jquery.fancybox.min.js"></script>
    <script src='../../../vendor/fullcalendar/lib/moment.min.js'></script>
    <script src='../../../vendor/fullcalendar/fullcalendar.min.js'></script>
    <script src='../../../vendor/wow/dist/wow.min.js'></script>

    <!-- REVOLUTION JS FILES -->
    <script src="../../../vendor/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="../../../vendor/revolution/js/jquery.themepunch.revolution.min.js"></script>

    <!-- Form JS -->
    <script src="../../../js/validate-form.js"></script>
    <script src="../../../js/config-contact.js"></script>

    <!-- Main JS -->
    <script src="../../../js/main/main.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="../../../plugins/admin/js\scripts.js"></script>
    <script src="../../../plugins/admin/assets\demo\datatables-demo.js"></script>
    <script src="../../../plugins/admin/js\sb-customizer.js"></script>

    <script type='text/javascript'>
        document.oncontextmenu = function() {
            return false
        }
    </script>

</html>