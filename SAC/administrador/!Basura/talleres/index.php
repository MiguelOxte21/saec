<?php
// Archivo de conexion con la base de datos
require_once '../../Conexion.php';
// Condicional para validar el borrado de la imagen
if (isset($_GET['delete_id'])) {
    // Selecciona imagen a borrar
    $Carreras_select = $DB_con->prepare('SELECT admin_carreras.id_AdminCarrera, admin_carreras.nombre, admin_carreras.id_user, admin_carreras.id_imagen, logos.*, users.* FROM ((logos INNER JOIN admin_carreras ON admin_carreras.id_imagen = logos.id_imagen) INNER JOIN users ON users.id_user = admin_carreras.id_user) WHERE id_AdminCarrera =:uid');
    $Carreras_select->execute(array(':uid' => $_GET['delete_id']));
    $imgRow = $Carreras_select->fetch(PDO::FETCH_ASSOC);
    // Ruta de la imagen
    unlink("../../../images/logos/" . $imgRow['imagen']);

    echo $id_user = $imgRow['id_user'];
    echo $id_imagen = $imgRow['id_imagen'];
    echo $id_AdminCarrera = $imgRow['id_AdminCarrera'];

    // Consulta para eliminar el registro de la base de datos
    $Carreras_delete2 = $DB_con->prepare('DELETE FROM admin_carreras WHERE id_AdminCarrera =:uid');
    $Carreras_delete2->bindParam(':uid', $id_AdminCarrera);
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
                                <div class="dropdown-user-details-email">Ingenieria en Sistemas Computacionales</div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../perfil.php"><div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                            Modificar Perfil</a>
                            <a class="dropdown-item" href="../../logout.php"><div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                            Salir</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
            <nav class="sidenav shadow-right sidenav-light">
                    <div class="sidenav-menu">
                        <div class="nav accordion" id="accordionSidenav">
                            <div class="sidenav-menu-heading">Administrar</div>
                            <a class="nav-link" href="../index.php"><div class="nav-link-icon"><i data-feather="home"></i></div>Inicio</a>

                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards"><div class="nav-link-icon"><i data-feather="folder"></i></div>Congreso<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>

                            <div class="collapse" id="collapseDashboards" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="index.php">Talleres</a>
                                    <a class="nav-link" href="index.php">Concursos</a>
                                    <a class="nav-link" href="index.php">Conferencias</a>
                                </nav>
                            </div>
                            
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"><div class="nav-link-icon"><i data-feather="folder"></i></div>Personal<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                            <div class="collapse" id="collapseLayouts" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                                    <a class="nav-link" href="../instructores.php">Instructores</a>
                                    <a class="nav-link" href="../alumnos.php">Alumnos</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsOtros" aria-expanded="false" aria-controls="collapseLayoutsOtros"><div class="nav-link-icon"><i data-feather="folder"></i></div>Otros<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                            <div class="collapse" id="collapseLayoutsOtros" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                                    <a class="nav-link" href="../logo.php">Logo</a>
                                    <a class="nav-link" href="../avisos.php">Avisos</a>
                                </nav>
                            </div>

                            <div class="sidenav-menu-heading">Perfil</div>
                            <a class="nav-link" href="../perfil.php"><div class="nav-link-icon"><i data-feather="user"></i></div>
                                Perfil</a>
                                <a class="nav-link" href="../../logout.php"><div class="nav-link-icon"><i data-feather="log-out"></i></div>
                                Salir</a>
                        </div>
                    </div>
                    <div class="sidenav-footer">
                        <div class="sidenav-footer-content">
                            <div class="sidenav-footer-subtitle">Logeado como:</div>
                            <div class="sidenav-footer-title">Administrador</div>
                        </div>
                    </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="page-header pb-1 page-header-dark bg-gradient-primary-to-secondary">
                    <div class="container-fluid">
                        <div class="page-header-content">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather=""></i></div>
                                <span>Talleres</span>
                            </h1>
                            
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
                                                        <a class="text-center">Usos de las resde locales para empresas</a>
                                                    </h3>
                                                </div>
                                                <div class="info">
                                                    <hr>
                                                    <a href="editarCarrera.php?edit_id=<?php echo $row->id_AdminCarrera; ?>">
                                                        <button>Editar</button>
                                                    </a>

                                                    <button Onclick="confirmarRegistro<?php echo $row->id_AdminCarrera; ?>();">Eliminar</button>

                                                    <script type="text/javascript">
                                                        function confirmarRegistro<?php echo $row->id_AdminCarrera; ?>() {
                                                            if (window.confirm("¿Seguro que desea eliminar esta carrera?\nEsto eliminar todo lo relacionacionado con esta carrera, incluyendo las cuentas de los instructores y alumnos") == true) {
                                                                window.location = "?delete_id=<?php echo $row->id_AdminCarrera; ?>";
                                                            }
                                                        }
                                                    </script>

                                                    <button>Ver Lista</button>
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