<?php
error_reporting(~E_NOTICE);
session_start();
if (!isset($_SESSION["id_administrador_general"]) || $_SESSION["id_administrador_general"] == null) {
    print "<script>window.location='../../index.php';</script>";
}


//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {
    $inactivo = 900; //15min en este caso.
    $vida_session = time() - $_SESSION['tiempo'];
    if ($vida_session > $inactivo) {
        session_unset();
        session_destroy();
        header("Location: ../../index");
        exit();
    } else {  // si no ha caducado la sesion, actualizamos
        $_SESSION['tiempo'] = time();
    }
} else {
    $_SESSION['tiempo'] = time();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sistema de Administración de Congresos</title>
    
    <link href="../../plugins/admin/css\styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../plugins/admin/assets\img\favicon.png">
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
        <a class="navbar-brand d-none d-sm-block" href="index.php">SAC</a><button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#"><i data-feather="menu"></i></button>
        <ul class="navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="../../images/icono_usuario.png"></a>
                <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="../../images/icono_usuario.png">
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name">Administrador</div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="perfil.php">
                        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                        Modificar Perfil
                    </a><a class="dropdown-item" href="../logout.php">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Salir
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php echo include('nav.php');?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid mt-5">
                    <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                        <div class="mr-4 mb-3 mb-sm-0">
                            <h1 class="mb-0">Administrador General</h1>
                        </div>
                    </div>
                    <div class="alert alert-primary border-0 mb-4 mt-5 px-md-5">
                        <div class="position-relative">
                            <div class="row align-items-center justify-content-between">
                                <div class="col position-relative">
                                    <h2 class="text-primary">¡Bienvenido de nuevo! Administrador</h2>
                                    <p class="text-gray-700"> <b> “La enseñanza es más que impartir conocimiento, es inspirar el cambio. El aprendizaje es más que absorber hechos, es adquirir entendimiento.”</b>
                                    </p>
                                    <p class="text-right text-gray-700"><i> - William Arthur Ward</i><br></p>
                                    <a class="btn btn-teal" href="carreras/index.php">Agregar una carrera<i class="ml-1" data-feather="arrow-right"></i></a>
                                      </div>
                                <div class="col d-none d-md-block text-right pt-3"><img class="img-fluid mt-n5" src="../../plugins/admin/assets\img\drawkit\color\drawkit-content-man-alt.svg" style="max-width: 25rem;"></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </main>
            <footer class="footer mt-auto footer-light">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 small">Sistema de Administración de Congresos</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../plugins/admin/js\scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../../plugins/admin/assets\demo\chart-area-demo.js"></script>
    <script src="../../plugins/admin/assets\demo\chart-bar-demo.js"></script>

    <script src="../../plugins/admin/js\sb-customizer.js"></script>
</body>

</html>