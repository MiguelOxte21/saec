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

//DATOS ADMIN (SABER LA CARRERA)
$consulta = $DB_con->prepare('SELECT * FROM admin_carreras WHERE id_user=:id_user');
$consulta->execute(array(':id_user' => $_SESSION["id_administrador_carrera"]));
$datosCarrera = $consulta->fetch(PDO::FETCH_ASSOC);
extract($datosCarrera);

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

    <link href="../../../plugins/admin/css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../../plugins/admin/assets\img\favicon.png">

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="app.js"></script>
</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
        <a class="navbar-brand d-none d-sm-block" href="index.php">SAEC</a><button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#"><i data-feather="menu"></i></button>
        <ul class="navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="../../../images/icono_usuario.png"></a>
                <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="../../../images/icono_usuario.png">
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name">Administrador</div>
                            <div class="dropdown-user-details-email">Ingeniería en Sistemas Computacionales</div>
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
            <nav class="sidenav shadow-right sidenav-light">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">
                        <div class="sidenav-menu-heading">Administrar</div>
                        <a class="nav-link" href="index.php">
                            <div class="nav-link-icon"><i data-feather="home"></i></div>Inicio
                        </a>

                        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                            <div class="nav-link-icon"><i data-feather="folder"></i></div>Congreso<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>

                        <div class="collapse" id="collapseDashboards" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                <a class="nav-link" href="talleres/index.php">Talleres</a>
                                <a class="nav-link" href="talleres/index.php">Concursos</a>
                                <a class="nav-link" href="talleres/index.php">Conferencias</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="nav-link-icon"><i data-feather="folder"></i></div>Personal<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                                <a class="nav-link" href="instructores.php">Instructores</a>
                                <a class="nav-link" href="alumnos.php">Alumnos</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsOtros" aria-expanded="false" aria-controls="collapseLayoutsOtros">
                            <div class="nav-link-icon"><i data-feather="folder"></i></div>Otros<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsOtros" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                                <a class="nav-link" href="logo.php">Logo</a>
                                <a class="nav-link" href="avisos.php">Avisos</a>
                            </nav>
                        </div>

                        <div class="sidenav-menu-heading">Perfil</div>
                        <a class="nav-link" href="perfil.php">
                            <div class="nav-link-icon"><i data-feather="user"></i></div>
                            Perfil
                        </a>
                        <a class="nav-link" href="../logout.php">
                            <div class="nav-link-icon"><i data-feather="log-out"></i></div>
                            Salir
                        </a>
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
                <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                    <div class="container-fluid">
                        <div class="page-header-content">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i></i></div>
                                <span>Alumnos</span>
                            </h1>
                            <p style="color: white;">Las modificaciones se guardan automaticante.</p>
                        </div>
                    </div>
                </div>
                <div class="container-fluid mt-n10">
                    <div class="card mb-4">
                        <div class="card-header">Mostrando todos los alumnos inscritos</div>
                        <div class="card-body">
                            <div class="datatable table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Matrícula</th>
                                            <th>Correo</th>
                                            <th>Semestre</th>
                                            <th>Status</th>
                                            <th>Comentarios</th>
                                            <th>Acciones</th>
                                            <th>Eliminar</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Matrícula</th>
                                            <th>Correo</th>
                                            <th>Semestre</th>
                                            <th>Status</th>
                                            <th>Comentarios</th>
                                            <th>Acciones</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        // INFORMACION DE LOS CONCURSOS
                                        $Alumnos = $DB_con->prepare("SELECT alumnos.*, users.* FROM alumnos INNER JOIN users ON alumnos.id_user = users.id_user WHERE alumnos.id_adminCarrera =:uid ORDER BY nombre_alumno ASC");
                                        $Alumnos->execute(array(':uid' => $datosCarrera["id_adminCarrera"]));
                                        while ($row = $Alumnos->fetch(PDO::FETCH_OBJ)) { ?>
                                            <tr>
                                                <td><?php echo $row->nombre_alumno  . ' ' . $row->apellido_alumno; ?></td>
                                                <td><?php echo $row->matricula; ?></td>
                                                <td><?php echo $row->correo_user; ?></td>
                                                <td><?php echo $row->semestre_grupo; ?></td>
                                                <td>
                                                    <div class="badge badge-danger badge-pill">No Pagado</div>
                                                </td>
                                                <td id="comentario_alumno" data-id_alumno="<?php echo $row->id_alumno;?>" contenteditable><?php echo $row->comentarios;?>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="status_alumno" data-id_alumno="<?php echo $row->id_alumno;?>">
                                                        <option data-status="0">No Pagado</option>
                                                        <option data-status="1">Pendiente</option>
                                                        <option data-status="2">Pagado</option>
                                                    </select>
                                                </td>
                                                <td>

                                                    <button class="btn btn-datatable btn-icon btn-transparent-dark" Onclick="boorar();"><i data-feather="trash-2"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </main>
            <footer class="footer mt-auto footer-light">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 small">Sistemas de Administración de Eventos y Congresos</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="../../../plugins/admin/js\scripts.js"></script>
    <script src="../../../plugins/admin/assets\demo\datatables-demo.js"></script>

    <script src="../../../plugins/admin/js\sb-customizer.js"></script>
</body>

</html>