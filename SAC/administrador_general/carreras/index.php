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
        header("Location: ../../../../administrador_general/index");
        exit();
    } else {  // si no ha caducado la sesion, actualizamos
        $_SESSION['tiempo'] = time();
    }
} else {
    $_SESSION['tiempo'] = time();
}

// Archivo de conexion con la base de datos
require_once '../../Conexion.php';
// Condicional para validar el borrado de la imagen
if (isset($_GET['delete_id'])) {
    // Selecciona imagen a borrar
    $Carreras_select = $DB_con->prepare('SELECT admin_carreras.*, logos.*, users.* FROM ((logos INNER JOIN admin_carreras ON admin_carreras.id_imagen = logos.id_imagen) INNER JOIN users ON users.id_user = admin_carreras.id_user) WHERE id_adminCarrera =:uid');
    $Carreras_select->execute(array(':uid' => $_GET['delete_id']));
    $imgRow = $Carreras_select->fetch(PDO::FETCH_ASSOC);
    // Ruta de la imagen
    unlink("../../../images/logos/" . $imgRow['imagen']);

    echo $id_user = $imgRow['id_user'];
    echo $id_imagen = $imgRow['id_imagen'];
    echo $id_adminCarrera = $imgRow['id_adminCarrera'];

    // Consulta para eliminar el registro de la base de datos
    $Carreras_delete2 = $DB_con->prepare('DELETE FROM admin_carreras WHERE id_adminCarrera =:uid');
    $Carreras_delete2->bindParam(':uid', $id_adminCarrera);
    $Carreras_delete2->execute();

    $Carreras_delete3 = $DB_con->prepare('DELETE FROM users WHERE id_user =:uid');
    $Carreras_delete3->bindParam(':uid', $id_user);
    $Carreras_delete3->execute();

    $Carreras_delete = $DB_con->prepare('DELETE FROM logos WHERE id_imagen =:uid');
    $Carreras_delete->bindParam(':uid', $id_imagen);
    $Carreras_delete->execute();

    // falta eliminar las cuentas de los instructores y alumnos

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
                                <div class="page-header-icon"><i data-feather=""></i></div>
                                <span>Carreras</span>
                            </h1>
                            <br>
                            <div class="page-header-subtitle"><a href="nueva_carrera.php"><button class="btn btn-secondary">Agregar nueva carrera</button></a></div>
                        </div>
                    </div>
                </div>
                <div id="solid">
                    <section class="standard-list courses-2 section-padding-large">
                        <div class="container">
                            <div class="courses-content">
                                <div class="row">
                                    <?php
                                    $Carreras = $DB_con->prepare("SELECT admin_carreras.*, logos.imagen FROM logos INNER JOIN admin_carreras ON admin_carreras.id_imagen = logos.id_imagen");
                                    // Ejecutamos
                                    $Carreras->execute();
                                    // Ahora vamos a indicar el fetch mode cuando llamamos a fetch:
                                    while ($row = $Carreras->fetch(PDO::FETCH_OBJ)) { ?>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                            <article class="item">
                                                <div class="item-thumb">
                                                    <a>
                                                        <img src="../../../images/logos/<?php echo $row->imagen; ?>" alt="">
                                                    </a>
                                                </div>
                                                <div class="info">
                                                    <h3 class="title">
                                                        <a class="text-center"><?php echo $row->carrera; ?></a>
                                                    </h3>
                                                    <p><?php echo $row->nombre_adminCarrera; ?></p>
                                                </div>
                                                <div class="info">
                                                    <hr>
                                                    <a href="session.php?id_carrera_admin=<?php echo $row->id_adminCarrera; ?>" target="_blank">
                                                        <button class="btn btn-primary btn-sm  mb1 bg-blue">Administrar</button>
                                                    </a>
                                                    
                                                    <a href="editarCarrera.php?edit_id=<?php echo $row->id_adminCarrera; ?>">
                                                        <button class="btn btn-warning btn-sm mb1 black bg-yellow">Editar</button>
                                                    </a>

                                                    <button class="btn btn-danger btn-sm mb1 bg-red " Onclick="confirmarRegistro<?php echo $row->id_adminCarrera; ?>();">Eliminar</button>

                                                    <script type="text/javascript">
                                                        function confirmarRegistro<?php echo $row->id_adminCarrera; ?>() {
                                                            if (window.confirm("¿Seguro que desea eliminar esta carrera?\nEsto eliminar todo lo relacionacionado con esta carrera, incluyendo las cuentas de los instructores y alumnos") == true) {
                                                                window.location = "?delete_id=<?php echo $row->id_adminCarrera; ?>";
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