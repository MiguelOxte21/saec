<?php
session_start();
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

error_reporting(~E_NOTICE);
require_once '../../Conexion.php';

// DATOS DEL ADMIN
$consultaIns = $DB_con->prepare('SELECT admin_carreras.*, users.* FROM admin_carreras INNER JOIN users ON admin_carreras.id_user = users.id_user WHERE admin_carreras.id_user = :id_user');
$consultaIns->execute(array(':id_user' => $_SESSION["id_administrador_carrera"]));
$datos = $consultaIns->fetch(PDO::FETCH_ASSOC);
extract($datos);


if (isset($_POST['btnsave'])) {
    setlocale(LC_TIME, "es_MX");
    $descripcion = $_POST['descripcion'];
    $fecha = date("F j, Y");
    $id_adminCarrera = $datos['id_adminCarrera'];
    $DB_con->beginTransaction();
    try {
        $sql = 'INSERT INTO avisos (descripcion, fecha, id_adminCarrera) VALUES (:descripcion, :fecha, :id_adminCarrera);';
        $result = $DB_con->prepare($sql);
        $result->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
        $result->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $result->bindValue(':id_adminCarrera', $id_adminCarrera, PDO::PARAM_INT);
        $result->execute();

        $DB_con->commit();
    } catch (PDOException $e) {
        // si ocurre un error hacemos rollback para anular todos los insert
        $DB_con->rollback();
        $e->getMessage();;
        $errMSG = "¡Error al insertar la información!, Porfavor verifique si los datos ingresados sean los correctos o no esten duplicados";
    }
}

if (isset($_POST['btn_save_updates'])) {
    $descripcion = $_POST['descripcion'];
    $id_aviso = $_POST['id_aviso'];

    $stmt = $DB_con->prepare('UPDATE avisos SET descripcion=:descripcion WHERE id_aviso=:id_aviso AND id_adminCarrera =:id_adminCarrera');
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':id_aviso', $id_aviso);
    $stmt->bindParam(':id_adminCarrera', $datos['id_adminCarrera']);
    if ($stmt->execute()) {
        header("Location: avisos.php");
    } else {
        $errMSG = "Los datos no fueron actualizados";
    }
}
if (isset($_GET['delete_id'])) {
    $stmt_delete = $DB_con->prepare('DELETE FROM avisos WHERE id_aviso =:uid AND id_adminCarrera =:id_adminCarrera');
    $stmt_delete->bindParam(':uid', $_GET['delete_id']);
    $stmt_delete->bindParam(':id_adminCarrera', $datos['id_adminCarrera']);
    $stmt_delete->execute();
    header("Location: avisos.php");
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
    <title>Sistemas de Administración de Eventos y Congresos</title>

    <link href="../../../plugins/admin/css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../../plugins/admin/assets\img\favicon.png">

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://www.jose-aguilar.com/scripts/jquery/jquery.js"></script>
    <script>
        $(document).ready(function() {

            var max_chars = 900;

            $('#max').html(max_chars);

            $('#comment').keyup(function() {
                var chars = $(this).val().length;
                var diff = max_chars - chars;
                $('#contador').html(diff);
            });
        });
    </script>

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
                            <div class="dropdown-user-details-email">Ingeniería en Sistemas Computacionales</div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../perfil.php">
                        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                        Modificar Perfil
                    </a>
                    <a class="dropdown-item" href="../../logout.php">
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
                <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                    <div class="container-fluid">
                        <div class="page-header-content">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i></i></div>
                                <span>Avisos</span>
                            </h1>
                            <!-- <p style="color: white;">Los avisos se mostrar al intante de publicarlo</p> -->

                        </div>
                    </div>
                </div>
                <div class="container-fluid mt-n10">
                    <div class="card mb-4">
                        <div class="card-header">Mostrando los avisos pblicados</div>
                        <div class="card-body">
                            <div class="datatable table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Aviso</th>
                                            <th>Fecha</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php
                                        $Avisos = $DB_con->prepare("SELECT * FROM avisos WHERE id_adminCarrera =:id_adminCarrera");
                                        $Avisos->execute(array(':id_adminCarrera' => $datos['id_adminCarrera']));
                                        while ($row = $Avisos->fetch(PDO::FETCH_OBJ)) { ?>
                                            <tr>
                                                <td><?php echo $row->id_aviso; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->fecha; ?></td>

                                                <td>
                                                    <a href="?edit_id=<?php echo $row->id_aviso; ?>"><button class="btn btn-datatable btn-icon btn-transparent-dark mr-2"><i data-feather="edit"></i></button></a>

                                                    <button class="btn btn-datatable btn-icon btn-transparent-dark" Onclick="confirmarRegistro<?php echo $row->id_aviso; ?>();"><i data-feather="trash-2"></i></button>
                                                </td>
                                            </tr>
                                            <script type="text/javascript">
                                                function confirmarRegistro<?php echo $row->id_aviso; ?>() {
                                                    if (window.confirm("¿Seguro que desea eliminar este aviso?") == true) {
                                                        window.location = "avisos.php?delete_id=<?php echo $row->id_aviso; ?>";
                                                    }
                                                }
                                            </script>
                                        <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (empty($_GET['edit_id'])) {
                    ?>
                        <div id="solid">
                            <div class="card mb-4">
                                <div class="card-header">Agregar un nuevo aviso</div>
                                <div class="card-body">
                                    <div class="sbp-">
                                        <div class="sbp-preview-content">
                                            <?php
                                            if (isset($errMSG)) {
                                            ?>
                                                <div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong> </div>
                                            <?php
                                            } else if (isset($successMSG)) {
                                            ?>
                                                <div class="alert alert-success"> <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG;
                                                                                                                                            } ?></strong> </div>


                                                <form method="post" class="listar-formtheme listar-formaddlisting">

                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label> Caracteres restantes: <span id="contador"></span></label>
                                                            <textarea class="form-control form-control-solid" id="comment" name="descripcion" cols="30" rows="10" maxlength="900"></textarea>
                                                        </div>
                                                        <button class="btn btn-success " name="btnsave">Guardar</button>

                                                    </div>
                                                </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>


                        <div id="solid">
                            <div class="card mb-4">
                                <div class="card-header">Editar Aviso</div>
                                <div class="card-body">
                                    <div class="sbp-">
                                        <div class="sbp-preview-content">
                                            <?php
                                            if (isset($errMSG)) {
                                            ?>
                                                <div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong> </div>
                                            <?php
                                            } else if (isset($successMSG)) {
                                            ?>
                                                <div class="alert alert-success"> <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG;
                                                                                                                                            } ?></strong> </div>

                                                <?php
                                                $Avisos = $DB_con->prepare("SELECT * FROM avisos WHERE id_aviso = :id AND id_adminCarrera=:id_adminCarrera");
                                                $Avisos->execute(array(':id' => $_GET['edit_id'], ':id_adminCarrera' => $datos['id_adminCarrera']));
                                                while ($row = $Avisos->fetch(PDO::FETCH_OBJ)) { ?>
                                                    <form method="post" class="listar-formtheme listar-formaddlisting">
                                                        <div class="form-group">
                                                            <div class="form-group"><label for="exampleFormControlInput1">Aviso</label>
                                                                <input type="hidden" name="id_aviso" value="<?php echo $row->id_aviso; ?>">
                                                                <label> Caracteres restantes: <span id="contador"></span></label>
                                                            <textarea class="form-control form-control-solid" id="comment" name="descripcion" cols="30" rows="10" maxlength="900"><?php echo $row->descripcion; ?></textarea>
                                                            </div>
                                                            <button class="btn btn-info" name="btn_save_updates">Actualizar</button>
                                                            <a href="avisos.php"><input  class="btn btn-danger" type="button" value="Cancelar"></a>
                                                        </div>
                                                    </form>
                                                <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

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