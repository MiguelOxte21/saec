<?php
error_reporting(~E_NOTICE);
require_once '../Conexion.php';

if (isset($_POST['btnsave'])) {
    $correo = $_POST['correo'];
    $DB_con->beginTransaction();
    try {
        // tabla logos
        $sql = 'INSERT INTO correos (correo) VALUES (:correo);';
        $result = $DB_con->prepare($sql);
        $result->bindValue(':correo', $correo, PDO::PARAM_STR);
        $result->execute();

        $DB_con->commit();
    } catch (PDOException $e) {
        // si ocurre un error hacemos rollback para anular todos los insert
        $DB_con->rollback();
        echo $e->getMessage();;
        $errMSG = "¡Error al insertar la información!, Porfavor verifique si los datos ingresados sean los correctos o no esten duplicados";
    }
}

if (isset($_POST['btn_save_updates'])) {
    $correo = $_POST['correo'];
    $id_correo = $_POST['id_correo'];

    $stmt = $DB_con->prepare('UPDATE correos SET correo=:correo WHERE id_correo=:id_correo');
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':id_correo', $id_correo);
    if ($stmt->execute()) {
?>
        <script>
            alert('Informacion editado correctamente');
            window.location.href = 'correos.php';
        </script>
<?php
    } else {
        $errMSG = "Los datos no fueron actualizados";
    }
}
if (isset($_GET['delete_id'])) {
    $stmt_delete = $DB_con->prepare('DELETE FROM correos WHERE id_correo =:uid');
    $stmt_delete->bindParam(':uid', $_GET['delete_id']);
    $stmt_delete->execute();
    header("Location: correos.php");
}

$id = $_GET['edit_id'];
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
                        <a class="dropdown-item" href="perfil.php"><div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                            Modificar Perfil</a>
                            <a class="dropdown-item" href="../logout.php"><div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
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
                            <a class="nav-link" href="index.php"><div class="nav-link-icon"><i data-feather="home"></i></div>Inicio</a>

                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards"><div class="nav-link-icon"><i data-feather="folder"></i></div>Congreso<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>

                            <div class="collapse" id="collapseDashboards" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="talleres/index.php">Talleres</a>
                                    <a class="nav-link" href="talleres/index.php">Concursos</a>
                                    <a class="nav-link" href="talleres/index.php">Conferencias</a>
                                </nav>
                            </div>
                            
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"><div class="nav-link-icon"><i data-feather="folder"></i></div>Personal<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                            <div class="collapse" id="collapseLayouts" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                                    <a class="nav-link" href="instructores.php">Instructores</a>
                                    <a class="nav-link" href="alumnos.php">Alumnos</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsOtros" aria-expanded="false" aria-controls="collapseLayoutsOtros"><div class="nav-link-icon"><i data-feather="folder"></i></div>Otros<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                            <div class="collapse" id="collapseLayoutsOtros" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                                    <a class="nav-link" href="logo.php">Logo</a>
                                    <a class="nav-link" href="avisos.php">Avisos</a>
                                </nav>
                            </div>

                            <div class="sidenav-menu-heading">Perfil</div>
                            <a class="nav-link" href="perfil.php"><div class="nav-link-icon"><i data-feather="user"></i></div>
                                Perfil</a>
                                <a class="nav-link" href="../logout.php"><div class="nav-link-icon"><i data-feather="log-out"></i></div>
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
                <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                    <div class="container-fluid">
                        <div class="page-header-content">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i></i></div>
                                <span>Alumnos</span>
                            </h1>
                            <!-- <p style="color: white;">En esta sección usted podra agregar los correos que seran aceptados al momento de que se registren los alumnos e instructores</p> -->

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
                                            <th>Matricula</th>
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
                                            <th>Matricula</th>
                                            <th>Correo</th>
                                            <th>Semestre</th>
                                            <th>Status</th>
                                            <th>Comentarios</th>
                                            <th>Acciones</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                            <tr>
                                                <td>Jesus Alberto Medina Dzib</td>
                                                <td>16070022</td>
                                                <td>jesus.medina@itsva.edu.mx</td>
                                                <td>7° A</td>
                                                <td><div class="badge badge-danger badge-pill">No Pagado</div></td>
                                                <td><input type="text" class="form-control" id="exampleFormControlSelect2"></td>
                                                <td>
                                                <select class="form-control" id="exampleFormControlSelect2">
                                                    <option>No Pagado</option>
                                                    <option>Pendiente</option>
                                                    <option>Pagado</option>
                                                </select>
                                                   
                                                </td>
                                                <td>
                                               
                                                    <button class="btn btn-datatable btn-icon btn-transparent-dark" Onclick="confirmarRegistro00000000000000();"><i data-feather="trash-2"></i></button>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>Karina Chiguil Euan</td>
                                                <td>16070014</td>
                                                <td>karina@itsva.edu.mx</td>
                                                <td>8° A</td>
                                                <td><div class="badge badge-danger badge-pill">No Pagado</div></td>
                                                <td><input type="text" class="form-control" id="exampleFormControlSelect2"></td>
                                                <td>
                                                <select class="form-control" id="exampleFormControlSelect2">
                                                    <option>No Pagado</option>
                                                    <option>Pendiente</option>
                                                    <option>Pagado</option>
                                                </select>
                                                   
                                                </td>
                                                <td>
                                               
                                                    <button class="btn btn-datatable btn-icon btn-transparent-dark" Onclick="confirmarRegistro00000000000000();"><i data-feather="trash-2"></i></button>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Geonavi Pech</td>
                                                <td>18070022</td>
                                                <td>geo@itsva.edu.mx</td>
                                                <td>6° B</td>
                                                <td><div class="badge badge-success badge-pill">Pagado</div></td>
                                                <td><input type="text" class="form-control" id="exampleFormControlSelect2"></td>
                                                <td>
                                                <select class="form-control" id="exampleFormControlSelect2">
                                                    <option>No Pagado</option>
                                                    <option>Pendiente</option>
                                                    <option>Pagado</option>
                                                </select>
                                                   
                                                </td>
                                                <td>
                                               
                                                    <button class="btn btn-datatable btn-icon btn-transparent-dark" Onclick="confirmarRegistro00000000000000();"><i data-feather="trash-2"></i></button>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Rogelio Chanche Canche</td>
                                                <td>12070002</td>
                                                <td>r@itsva.edu.mx</td>
                                                <td>4° B</td>
                                                <td><div class="badge badge-warning badge-pill">Pendiente</div></td>
                                                <td><input type="text" class="form-control" id="exampleFormControlSelect2"></td>
                                                <td>
                                                <select class="form-control" id="exampleFormControlSelect2">
                                                    <option>No Pagado</option>
                                                    <option>Pendiente</option>
                                                    <option>Pagado</option>
                                                </select>
                                                   
                                                </td>
                                                <td>
                                               
                                                    <button class="btn btn-datatable btn-icon btn-transparent-dark" Onclick="confirmarRegistro00000000000000();"><i data-feather="trash-2"></i></button>
                                                </td>
                                            </tr>
                                            <script type="text/javascript">
                                                function confirmarRegistro00000000000000() {
                                                    if (window.confirm("¿Seguro que desea eliminar a este alumno?") == true) {
                                                        window.location = "correos.php?delete_id=00000000000000";
                                                    }
                                                }
                                            </script>
                                    </tbody>
                                </table>
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