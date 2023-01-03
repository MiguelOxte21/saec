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

error_reporting(~E_NOTICE); // avoid notice
require_once '../../Conexion.php';
if (isset($_POST['btnsave'])) {

    $nombre_pago = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_POST['imagen'];

    if (empty($nombre_pago)) {
        $errMSG = "Ingrese el nombre del pago";
    } else if (empty($precio)) {
        $errMSG = "Ingrese el precio";
    } else if (empty($imagen)) {
        $errMSG = "Ingrese la URL del pago.";
    }


    // if no error occured, continue ....
    if (!isset($errMSG)) {

        // iniciar transacción
        $DB_con->beginTransaction();

        try {
            // tabla productos
            $sql = 'INSERT INTO `productos` (`id_producto`,`nombre`, `precio`, `descripcion`, `imagen`) VALUES (NULL, :nombre, :precio, :descripcion, :imagen);';
            $result = $DB_con->prepare($sql);
            $result->bindValue(':nombre', $nombre_pago, PDO::PARAM_STR);
            $result->bindValue(':precio', $precio, PDO::PARAM_STR);
            $result->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
            $result->bindValue(':imagen', $imagen, PDO::PARAM_STR);
            $result->execute();

            $DB_con->commit();
            // echo 'Datos insertados';
            $successMSG = "Nuevo pago agregado y publicado exitasomente";
            header("refresh:3;index.php"); // redirects image view page after 5 seconds.
        } catch (PDOException $e) {
            // si ocurre un error hacemos rollback para anular todos los insert
            $DB_con->rollback();
            echo $e->getMessage();;
            $errMSG = "¡Error al insertar la información!, Porfavor verifique si los datos ingresados sean los correctos o no esten duplicados";
        }
    }
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
    <title>Sistemas de Administración de Congresos</title>

    <link href="../../../plugins/admin/css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../../plugins/admin/assets\img\favicon.png">

    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>

    <script src="../../../plugins/ckeditor/ckeditor.js"></script>

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

        <!-- fin menu navegacion -->
        <div id="layoutSidenav_content">
            <main>
                <div class="page-header page-header-light bg-white shadow">
                    <div class="container-fluid">
                        <div class="page-header-content py-5">
                            <h1 class="page-header-title">
                                <span>Nuevo Pago</span>
                            </h1>
                            <ol class="breadcrumb mt-4 mb-0">
                                <li class="breadcrumb-item"><a href="index.php">Pagos</a></li>
                                <li class="breadcrumb-item active">Nuevo Pago</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <?php
                if (isset($errMSG)) {
                ?>
                    <div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong> </div>
                <?php
                } else if (isset($successMSG)) {
                ?>
                    <div class="alert alert-success"> <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong> </div>
                <?php
                }
                ?>

                <form method="post" enctype="multipart/form-data" class="listar-formtheme listar-formaddlisting">
                    <div class="container-fluid mt-4">
                        <div id="solid">
                            <div class="card mb-4">
                                <div class="card-header">Información del pago.</div>
                                <div class="card-body">
                                    <div class="sbp-">
                                        <div class="sbp-preview-content">
                                            <br>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Nombre</label>
                                                <input class="form-control form-control-solid" id="exampleFormControlInput1" type="text" name="nombre" placeholder="Nombre del pago." required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Precio</label>
                                                <input class="form-control form-control-solid" id="exampleFormControlInput1" type="text" name="precio" placeholder="Agregar precio del nuevo pago." required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Descripción</label>
                                                <input class="form-control form-control-solid" id="exampleFormControlInput1" type="text" name="descripcion" placeholder="Agregar nueva descripción del pago." required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">URL de la imagen del pago.</label>
                                                <input class="form-control form-control-solid" id="exampleFormControlInput1" type="text" name="imagen" placeholder="Agregar la URL de la imagen del pago." required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary" name="btnsave"><i data-feather="save"></i>Guardar</button>

                    </div>
                </form>
            </main>

            <footer class="footer mt-auto footer-light">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 small">Sistemas de Administración de Congresos</div>

                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../../plugins/admin/js\scripts.js"></script>
    <script src="../../../plugins/admin/js\sb-customizer.js"></script>
</body>

</html>