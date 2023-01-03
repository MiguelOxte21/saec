<?php
error_reporting(~E_NOTICE);
session_start();
$id_instructor = $_SESSION["id_instructor"];
if (!isset($_SESSION["id_instructor"]) || $_SESSION["id_instructor"] == null) {
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
require_once '../Conexion.php';

// CONOCER EL ID DEL INSTRUCTOR
$consultaIns0 = $DB_con->prepare('SELECT * FROM instructores WHERE id_user = :id_user');
$consultaIns0->execute(array(':id_user' => $_SESSION["id_instructor"]));
$datos = $consultaIns0->fetch(PDO::FETCH_ASSOC);
extract($datos);

// CONSULTA PARA SABER EL TALLER, CONCURSO Y CONFERENCIA DEL INSTRUCTOR

$consulta1 = $DB_con->prepare("SELECT * FROM talleres WHERE id_instructor = :id_instructor");
$consulta1->execute(array(':id_instructor' => $datos['id_instructor']));
while ($rowTaller = $consulta1->fetch(PDO::FETCH_OBJ)) {
    $imagenTaller = $rowTaller->imagen_taller;
    $nomTaller = $rowTaller->nombre_taller;
}

$consulta2 = $DB_con->prepare("SELECT * FROM concursos WHERE id_instructor = :id_instructor");
$consulta2->execute(array(':id_instructor' => $datos['id_instructor']));
while ($rowCon = $consulta2->fetch(PDO::FETCH_OBJ)) {
    $imgCon = $rowCon->imagen_concurso;
    $nomCon = $rowCon->nombre_concurso;
    $modalidad = $rowCon->modalidad;
}

$consulta3 = $DB_con->prepare("SELECT * FROM conferencias WHERE id_instructor = :id_instructor");
$consulta3->execute(array(':id_instructor' => $datos['id_instructor']));
while ($rowConf = $consulta3->fetch(PDO::FETCH_OBJ)) {
    $imgConf = $rowConf->imagen_conferencia;
    $nomConf = $rowConf->nombre_conferencia;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sistema de Administración de Congresos</title>

    <link href="../../plugins/admin/css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../plugins/admin/assets\img\favicon.png">

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>

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
    <link rel="shortcut icon" href="favicon.png">



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
                            <div class="dropdown-user-details-email">Ingenieria en Sistemas Computacionales</div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="perfil.php">
                        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                        Modificar Perfil
                    </a>
                    <a class="dropdown-item" href="../logout.php">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Salir
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include('nav.php'); ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="page-header pb-1 page-header-dark bg-gradient-primary-to-secondary">
                    <div class="container-fluid">
                        <div class="page-header-content">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather=""></i></div>
                                <span>Alumnos <p>Selecciona una opcion para ver la lista de los alumnos inscritos</p></span>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="container-fluid mt-n10">
                    <div class="container-fluid mt-4">
                        <div id="solid">
                            <section class="standard-list courses-2 section-padding-large">
                                <div class="container">
                                    <div class="courses-content">
                                        <div class="row">
                                            <?php if (isset($imagenTaller)) { ?>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <article class="item">
                                                        <div class="item-thumb">
                                                            <a>
                                                                <img src="../../images/talleres/<?php echo $imagenTaller; ?>" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="info">
                                                            <h3 class="title">
                                                                <p>Taller:</p>
                                                                <a class="text-center"><?php echo $nomTaller; ?></a>
                                                            </h3>
                                                            <div class="row w-100 align-items-center info">
                                                                <div class="col text-center">
                                                                    <form action="lista.php" method="post">
                                                                        <button class="btn btn-outline-dark" name="lista_taller"> Selecionar </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                            <?php }
                                            if (isset($imgCon)) { ?>

                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <article class="item">
                                                        <div class="item-thumb">
                                                            <a>
                                                                <img src="../../images/concursos/<?php echo $imgCon; ?>" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="info">
                                                            <h3 class="title">
                                                                <p>Concurso:</p>
                                                                <a class="text-center"><?php echo $nomCon; ?></a>
                                                            </h3>
                                                            <div class="row w-100 align-items-center info">
                                                                <div class="col text-center">
                                                                    <form action="lista.php" method="post">
                                                                        <?php
                                                                        if ($modalidad == 1) {
                                                                            echo '<button class="btn btn-outline-dark" name="lista_concurso"> Selecionar </button>';
                                                                        } elseif ($modalidad == 2) {
                                                                            echo '<button class="btn btn-outline-dark" name="lista_concurso_grupal"> Selecionar </button>';
                                                                        }
                                                                        ?>

                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                            <?php }
                                            if (isset($imgConf)) { ?>

                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <article class="item">
                                                        <div class="item-thumb">
                                                            <a>
                                                                <img src="../../images/conferencia/<?php echo $imgConf; ?>" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="info">
                                                            <h3 class="title">
                                                                <p>Conferencia:</p>
                                                                <a class="text-center"><?php echo $nomConf; ?></a>
                                                            </h3>
                                                            <div class="row w-100 align-items-center info">
                                                                <div class="col text-center">
                                                                    <form action="lista.php" method="post">
                                                                        <button class="btn btn-outline-dark" name="lista_conferencia"> Selecionar </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </section>
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
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="../../plugins/admin/js\scripts.js"></script>
    <script src="../../plugins/admin/assets\demo\datatables-demo.js"></script>

    <script src="../../plugins/admin/js\sb-customizer.js"></script>
</body>

</html>