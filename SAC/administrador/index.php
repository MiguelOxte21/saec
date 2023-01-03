<?php
session_start();
$id_administrador_carrera = $_SESSION["id_administrador_carrera"];
if (!isset($_SESSION["id_administrador_carrera"]) || $_SESSION["id_administrador_carrera"] == null) {
    print "<script>window.location='../../index.php';</script>";
}

//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {
    $inactivo = 900; //15min en este caso.
    $vida_session = time() - $_SESSION['tiempo'];
    if ($vida_session > $inactivo) {
        session_unset();
        session_destroy();
        header("Location: ../../index.php");
        exit();
    } else {  // si no ha caducado la sesion, actualizamos
        $_SESSION['tiempo'] = time();
    }
} else {
    $_SESSION['tiempo'] = time();
}

include('../Conexion.php');

// Datos del administrador de la carrera
$stmt_edit = $DB_con->prepare('SELECT * FROM admin_carreras  WHERE id_user =:uid');
$stmt_edit->execute(array(':uid' => $_SESSION["id_administrador_carrera"]));
$datosAdministradorCarrera = $stmt_edit->fetch(PDO::FETCH_ASSOC);
extract($datosAdministradorCarrera);
$datosAdministradorCarrera['nombre_adminCarrera'];
$datosAdministradorCarrera['carrera'];
$id_adminCarrera = $datosAdministradorCarrera['id_adminCarrera'];

// === CONTADORES ===

// 
$contadorAlumnosP = $DB_con->prepare('SELECT COUNT(*) AS contador FROM alumnos WHERE id_adminCarrera =:uid');
$contadorAlumnosP->execute(array(':uid' => $id_adminCarrera));
$contador1 = $contadorAlumnosP->fetch(PDO::FETCH_ASSOC);
extract($contador1);
echo $contador1['contador'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sistemas de Administración de Eventos y Congresos</title>

    <link href="../../plugins/admin/css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../plugins/admin/assets\img\favicon.png">

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="appIns.js"></script>



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
                            <div class="dropdown-user-details-email"><?php echo $datosAdministradorCarrera['carrera']; ?></div>
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
            <?php include('nav.php') ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid mt-5">
                    <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                        <div class="mr-4 mb-3 mb-sm-0">
                            <h1 class="mb-0"><?php echo $datosAdministradorCarrera['carrera']; ?></h1>
                        </div>

                    </div>
                    <div class="alert alert-primary border-0 mb-4 mt-5 px-md-5">
                        <div class="position-relative">
                            <div class="row align-items-center justify-content-between">
                                <div class="col position-relative">
                                    <h2 class="text-primary">¡Bienvenido de nuevo! <?php echo $datosAdministradorCarrera['nombre_adminCarrera']; ?></h2>
                                    <p class="text-gray-700"> <b> “La educación no cambia al mundo: cambia a las personas que van a cambiar el mundo.”</b>
                                    </p>
                                    <p class="text-right text-gray-700"><i> - Paulo Freire</i><br></p>
                                    <a class="btn btn-teal" href="personal/instructores.php">Administar Instructores<i class="ml-1" data-feather="arrow-right"></i></a>
                                </div>
                                <div class="col d-none d-md-block text-right pt-3"><img class="img-fluid mt-n5" src="../../plugins/admin/assets\img\drawkit\color\drawkit-developer-woman.svg" style="max-width: 25rem;"></div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-blue h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="small font-weight-bold text-blue mb-1">Alumnos Activos</div>
                                            <div class="h5">Null</div>
                                            <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center"><i class="mr-1" data-feather=""></i>
                                                <a href="tours/index.php">Ver Alumnos</a>
                                            </div>
                                        </div>
                                        <div class="ml-2"><i class="fas fa-user-graduate fa-2x text-gray-200"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-purple h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="small font-weight-bold text-purple mb-1">Alumnos en espera</div>
                                            <div class="h5">Null</div>
                                            <div class="text-xs font-weight-bold text-danger d-inline-flex align-items-center"><i class="mr-1" data-feather=""></i><a href="otros/destinos.php">Ver Alumnos</a></div>
                                        </div>
                                        <div class="ml-2"><i class="fas fa-user-slash fa-2x text-gray-200"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-yellow h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="small font-weight-bold text-yellow mb-1">Instructores Activos</div>
                                            <div class="h5">Null</div>
                                            <div class="text-xs font-weight-bold text-danger d-inline-flex align-items-center"><i class="mr-1" data-feather=""></i><a href="otros/categorias.php">Ver Instructores</a></div>
                                        </div>
                                        <div class="ml-2"><i class="fas fas fa-chalkboard-teacher fa-2x text-gray-200"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-green h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="small font-weight-bold text-green mb-1">Instructores en espera</div>
                                            <div class="h5">Null</div>
                                            <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center"><i class="mr-1" data-feather=""></i><a href="tours/comentarios_tour.php">Ver Intructores</a></div>
                                        </div>
                                        <div class="ml-2"><i class="fas fa-user-slash fa-2x text-gray-200"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> -->
                    <div class="card mb-4">
                        <div class="card-header">Lista de instructores en espera</div>
                        <div class="card-body">
                            <div class="datatable table-responsive">
                                <div id="lista-instructores">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="card mb-4">
                        <div class="card-header">Alumnos NO activados</div>
                        <div class="card-body">
                            <div class="datatable table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Matricula</th>
                                            <th>Semestre y Grupo</th>
                                            <th>Status</th>
                                            <th>Acción</th>
                                            <th>Comentario</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php
                                        $Carreras = $DB_con->prepare("SELECT * FROM alumnos WHERE status_alumno=0 AND id_adminCarrera = $id_adminCarrera");
                                        $Carreras->execute();
                                        while ($row = $Carreras->fetch(PDO::FETCH_OBJ)) { ?>
                                            <tr>
                                                <td><?php echo $row->nombre_alumno;
                                                    echo ' ';
                                                    echo $row->apellido_alumno; ?></td>
                                                <td><?php echo $row->matricula; ?></td>
                                                <td><?php echo $row->semestre_grupo; ?></td>
                                                <td>
                                                    <div class="badge badge-danger badge-pill">No Pagado</div>
                                                </td>


                                                <td>
                                                    <select class="form-control" id="exampleFormControlSelect2">
                                                        <option>No Pagado</option>
                                                        <option>Pendiente</option>
                                                        <option>Pagado</option>
                                                    </select>
                                                </td>
                                                <td>

                                                    <input type="text" class="form-control" id="exampleFormControlSelect2">
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> -->

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
    <script src="../../plugins/admin/js\scripts.js"></script>
    <script src="../../plugins/admin/assets\demo\datatables-demo.js"></script>

    <script src="../../plugins/admin/js\sb-customizer.js"></script>
</body>

</html>