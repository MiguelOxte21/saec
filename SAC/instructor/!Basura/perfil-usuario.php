<?php
error_reporting(~E_NOTICE);
session_start();
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

// DATOS DEL INSTRUCTOR
$consultaIns = $DB_con->prepare('SELECT instructores.*, users.* FROM instructores INNER JOIN users ON instructores.id_user = users.id_user WHERE instructores.id_user = :id_user');
$consultaIns->execute(array(':id_user' => $_SESSION["id_instructor"]));
$datos = $consultaIns->fetch(PDO::FETCH_ASSOC);
extract($datos);

// if (isset($_POST['btnsave'])) {
//     $correo = $_POST['correo'];
//     $DB_con->beginTransaction();
//     try {
//         // tabla logos
//         $sql = 'INSERT INTO correos (correo) VALUES (:correo);';
//         $result = $DB_con->prepare($sql);
//         $result->bindValue(':correo', $correo, PDO::PARAM_STR);
//         $result->execute();

//         $DB_con->commit();
//     } catch (PDOException $e) {
//         // si ocurre un error hacemos rollback para anular todos los insert
//         $DB_con->rollback();
//         echo $e->getMessage();;
//         $errMSG = "¡Error al insertar la información!, Porfavor verifique si los datos ingresados sean los correctos o no esten duplicados";
//     }
// }

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
                <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                    <div class="container-fluid">
                        <div class="page-header-content">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i></i></div>
                                <span>Perfil</span>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="container-fluid mt-n10">
                    <div class="card mb-4">
                        <div class="card-header">Modificar perfil</div>
                        <div class="card-body">
                            <form action="">
                                <div class="form-group">
                                    
                                    <label for="exampleFormControlSelect1">Nombre(s)</label>
                                    <input type="text" class="form-control" id="exampleFormControlSelect1" value="<?php echo $datos['nombre_instructor'];?>">
                                    <label for="exampleFormControlSelect1">Apellidos</label>
                                    <input type="text" class="form-control" id="exampleFormControlSelect1" value="<?php echo $datos['apellido_instructor'];?>">
                                    <label for="exampleFormControlSelect1">Clave</label>
                                    <input type="text" class="form-control" id="exampleFormControlSelect1" value="<?php echo $datos['clave'];?>">
                                    <label for="exampleFormControlSelect1">Correo</label>
                                    <input type="email" class="form-control" id="exampleFormControlSelect1" value="<?php echo $datos['correo_user'];?>">
                                    <label for="exampleFormControlSelect1">Contraseña Antigua</label>
                                    <input type="text" class="form-control" id="exampleFormControlSelect1" value="<?php echo $datos['password'];?>">
                                    <label for="exampleFormControlSelect1">Nueva Contraseña</label>
                                    <input type="text" class="form-control" id="exampleFormControlSelect1" value="<?php echo $datos['password'];?>">
                                </div>
                                <input type="button" value="Guardar">
                            </form>
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