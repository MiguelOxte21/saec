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

// Archivo de conexion con la base de datos
require_once '../../Conexion.php';
// 
if (isset($_GET['delete_id'])) {
    //
    $stmt_delete = $DB_con->prepare('DELETE FROM productos WHERE id_producto =:pid');
    $stmt_delete->bindParam(':pid', $_GET['delete_id']);
    $stmt_delete->execute();

    header("Location: index.php");
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

    <link href="../../../plugins/admin/css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../../plugins/admin/assets\img\favicon.png">

    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>


    <!-- Main CSS File -->
    <link href="../../../css/style.min.css" rel="stylesheet">
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
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../perfil.php">
                        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                        Modificar Perfil
                    </a><a class="dropdown-item" href="../../logout.php">
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
                                <div class="page-header-icon"><i data-feather="dollar-sign"></i></div>
                                <span>Pagos</span>
                            </h1>
                            <br>
                            <div class="page-header-subtitle"><a href="nuevo_pago.php"><button class="btn btn-secondary">Agregar nuevo pago</button></a></div>
                        </div>
                    </div>
                </div>
                <div id="solid">
                    <section class="standard-list courses-2 section-padding-large">
                        <div class="container">
                            <div class="courses-content">
                                <div class="row">
                                    <?php
                                    $Productos = $DB_con->prepare("SELECT * FROM `productos` ");
                                    // Ejecutamos
                                    $Productos->execute();
                                    // Ahora vamos a indicar el fetch mode cuando llamamos a fetch:
                                    while ($row = $Productos->fetch(PDO::FETCH_OBJ)) { ?>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                            <article class="item">
                                                <div class="item-thumb">
                                                    <a>
                                                        <img class="card-img-top" src="<?php echo $row->imagen; ?>">

                                                    </a>
                                                </div>
                                                <div class="info">
                                                    <h3 class="title">
                                                        <a class="text-center"><?php echo $row->nombre; ?></a>
                                                    </h3>
                                                    <p><?php echo $row->precio; ?></p>
                                                </div>
                                                <div class="info">
                                                    <hr>

                                                    <a href="editarPago.php?edit_id=<?php echo $row->id_producto; ?>">
                                                        <button class="btn btn-primary"><i data-feather="edit"></i>Editar</button>
                                                    </a>

                                                    <button class="btn btn-danger" Onclick="confirmarRegistro<?php echo $row->id_producto; ?>();"><i data-feather="trash-2"></i>Eliminar</button>

                                                    <script type="text/javascript">
                                                        function confirmarRegistro<?php echo $row->id_producto; ?>() {
                                                            if (window.confirm("¿Seguro que desea eliminar este pago?\nEsto eliminará todo lo relacionacionado con este pago.") == true) {
                                                                window.location = "?delete_id=<?php echo $row->id_producto; ?>";
                                                            }
                                                        }
                                                    </script>

                                                    <!-- <button>Ver mas</button> -->
                                                </div>
                                            </article>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </section>
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../../plugins/admin/js\scripts.js"></script>

    <script src="../../../plugins/admin/js\sb-customizer.js"></script>

</html>