<?php
session_start();
$id_instructor = $_SESSION["id_instructor"];
if (!isset($_SESSION["id_instructor"]) || $_SESSION["id_instructor"] == null) {
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

require_once '../../Conexion.php';

// Datos del instructor
$consulta = $DB_con->prepare('SELECT * FROM instructores  WHERE id_user =:uid');
$consulta->execute(array(':uid' => $_SESSION["id_instructor"]));
$datosInstructor = $consulta->fetch(PDO::FETCH_ASSOC);
extract($datosInstructor);

// Saber si el instructor tiene registrado ua conferencia 
$consulta2 = $DB_con->prepare('SELECT COUNT(*) AS cont FROM conferencias WHERE id_instructor =:uid');
$consulta2->execute(array(':uid' => $datosInstructor['id_instructor']));
$contador = $consulta2->fetch(PDO::FETCH_ASSOC);
extract($contador);

// Si el instructor tiene registrado una conferencia, toma los valores de ello para editar
if ($contador['cont'] == 1) {
    $stmt_edit = $DB_con->prepare('SELECT * FROM conferencias  WHERE id_instructor =:uid');
    $stmt_edit->execute(array(':uid' => $datosInstructor['id_instructor']));
    $datosConferencia = $stmt_edit->fetch(PDO::FETCH_ASSOC);
    extract($datosConferencia);
    $imagen = $datosConferencia['imagen_conferencia'];
    $id_conferencia = $datosConferencia['id_conferencia'];
    // los valores los llamos directamente en los inputs
}

// ============================
//      AGREGAR CONFERENCIA
// ============================
if (isset($_POST['btnsave'])) {

    $nombre_conferencia = $_POST['nombre_conferencia'];
    $lugar_conferencia = $_POST['lugar_conferencia'];
    $cupo_conferencia = $_POST['cupo_conferencia'];
    $descripcion_conferencia = $_POST['descripcion_conferencia'];

    $id_instructor = $datosInstructor['id_instructor'];


    $imgFile = $_FILES['user_image']['name'];
    $tmp_dir = $_FILES['user_image']['tmp_name'];
    $imgSize = $_FILES['user_image']['size'];

    if (empty($nombre_conferencia) or empty($lugar_conferencia) or empty($cupo_conferencia) or empty($id_instructor)) {
        $errMSG = "Todos los campos son obligatorios";
    } else if (empty($imgFile)) {
        $errMSG = "Seleccione el archivo de imagen.";
    } else {
        $upload_dir = '../../../images/conferencia/'; // upload directory

        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

        // rename uploading image
        $userpic = rand(1000, 3000000) . "." . $imgExt;

        // allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
            // Check file size '3MB'
            if ($imgSize < 3000000) {
                move_uploaded_file($tmp_dir, $upload_dir . $userpic);
            } else {
                $errMSG = "La imagen es demasiado pesada, Tamaño maximo : 3Mb";
            }
        } else {
            $errMSG = "Solo archivos JPG, JPEG, PNG & GIF son permitidos.";
        }
    }


    // if no error occured, continue ....
    if (!isset($errMSG)) {

        // iniciar transacción
        $DB_con->beginTransaction();

        try {
            // tabla conferencias
            $sql = 'INSERT INTO conferencias (nombre_conferencia,imagen_conferencia,lugar_conferencia,cupo_conferencia,descripcion_conferencia,id_instructor) VALUES (:nombre_conferencia, :upic, :lugar_conferencia, :cupo_conferencia, :descripcion_conferencia, :id_instructor)';
            $result = $DB_con->prepare($sql);
            $result->bindValue(':nombre_conferencia', $nombre_conferencia, PDO::PARAM_STR);
            $result->bindValue(':upic', $userpic, PDO::PARAM_STR);
            $result->bindValue(':lugar_conferencia', $lugar_conferencia, PDO::PARAM_STR);
            $result->bindValue(':cupo_conferencia', $cupo_conferencia, PDO::PARAM_INT);
            $result->bindValue(':descripcion_conferencia', $descripcion_conferencia, PDO::PARAM_STR);
            $result->bindValue(':id_instructor', $id_instructor, PDO::PARAM_INT);
            $result->execute();

            $DB_con->commit();
            // echo 'Datos insertados';
            $successMSG = "Su conferencia ha sido agregado exitasomente, Redireccionando...";
            header("refresh:1;mi_conferencia.php"); // redirects image view page after 5 seconds.
        } catch (PDOException $e) {
            // si ocurre un error hacemos rollback para anular todos los insert
            $DB_con->rollback();
            $e->getMessage();;
            $errMSG = "¡Error al insertar la información!, Porfavor verifique si los datos ingresados sean los correctos o no esten duplicados con la información de otra conferencia";
        }
    }
}

// ============================
//      EDITAR CONFERENCIA
// ============================

if (isset($_POST['btn_save_updates'])) {

    $nombre_conferencia = $_POST['nombre_conferencia'];
    $lugar_conferencia = $_POST['lugar_conferencia'];
    $cupo_conferencia = $_POST['cupo_conferencia'];
    $descripcion_conferencia = $_POST['descripcion_conferencia'];

    $id_instructor = $datosInstructor['id_instructor'];

    $imgFile = $_FILES['user_image']['name'];
    $tmp_dir = $_FILES['user_image']['tmp_name'];
    $imgSize = $_FILES['user_image']['size'];

    if ($imgFile) {
        $upload_dir = '../../../images/conferencia/'; // upload directory	
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        $userpic = rand(1000, 3000000) . "." . $imgExt;
        if (in_array($imgExt, $valid_extensions)) {
            if ($imgSize < 3000000) {
                unlink($upload_dir . $datosConferencia['imagen_conferencia']);
                move_uploaded_file($tmp_dir, $upload_dir . $userpic);
            } else {
                $errMSG = "La imagen es demasiado pesada, Tamaño maximo : 3Mb";
            }
        } else {
            $errMSG = "Solo archivos JPG, JPEG, PNG & GIF .";
        }
    } else {
        // if no image selected the old image remain as it is.
        $userpic = $datosConferencia['imagen_conferencia']; // old image from database
    }


    // if no error occured, continue ....
    if (!isset($errMSG)) {

        // iniciar transacción
        $DB_con->beginTransaction();

        try {
            // tabla conferencias
            $sql = 'UPDATE conferencias 
                SET nombre_conferencia=:nombre_conferencia, 
                imagen_conferencia=:upic, 
                lugar_conferencia=:lugar_conferencia, 
                cupo_conferencia=:cupo_conferencia, 
                descripcion_conferencia=:descripcion_conferencia
                WHERE id_conferencia=:uid';
            $result = $DB_con->prepare($sql);
            $result->bindValue(':nombre_conferencia', $nombre_conferencia, PDO::PARAM_STR);
            $result->bindValue(':upic', $userpic, PDO::PARAM_STR);
            $result->bindValue(':lugar_conferencia', $lugar_conferencia, PDO::PARAM_STR);
            $result->bindValue(':cupo_conferencia', $cupo_conferencia, PDO::PARAM_INT);
            $result->bindValue(':descripcion_conferencia', $descripcion_conferencia, PDO::PARAM_STR);
            $result->bindValue(':uid', $id_conferencia, PDO::PARAM_INT);
            $result->execute();

            $DB_con->commit();
            // echo 'Datos insertados';
            $successMSG = "Su conferencia ha sido editado exitasomente, Redireccionando...";
            header("refresh:1;mi_conferencia.php");
        } catch (PDOException $e) {
            // si ocurre un error hacemos rollback para anular todos los insert
            $DB_con->rollback();
            $e->getMessage();;
            $errMSG = "¡Error al insertar la información!, Porfavor verifique si los datos ingresados sean los correctos o no esten duplicados con la información de otras conferencias";
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
            <?php include('nav.php'); ?>
        </div>

        <!-- fin menu navegacion -->
        <div id="layoutSidenav_content">
            <main>
                <div class="page-header page-header-light bg-white shadow">
                    <div class="container-fluid">
                        <div class="page-header-content py-5">
                            <h1 class="page-header-title">
                                <span>Mi Conferencia</span>
                            </h1>
                            <ol class="breadcrumb mt-4 mb-0">
                                <li class="breadcrumb-item"><a href="mi_conferencia.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Conferencia</li>
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
                // si no tiene registrado ningun Conferencia
                if ($contador['cont'] == 0) { ?>
                    <form method="post" enctype="multipart/form-data" class="listar-formtheme listar-formaddlisting">
                        <div class="container-fluid mt-4">
                            <div id="solid">
                                <div class="card mb-4">
                                    <div class="card-header">Agregar Conferencia</div>
                                    <div class="card-body">
                                        <div class="sbp-">
                                            <div class="sbp-preview-content">
                                                <label for="exampleFormControlInput1">Imagen (3MB Maximo)</label>
                                                <input class="input-group" type="file" name="user_image" accept="image/*" required />
                                                <br>
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Nombre de la conferencia</label>
                                                    <input class="form-control form-control-solid" id="exampleFormControlInput1" type="text" name="nombre_conferencia" placeholder="Titulo" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Lugar</label>
                                                    <input class="form-control form-control-solid" id="exampleFormControlInput1" type="text" name="lugar_conferencia" placeholder="Lugar del conferencia" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Cupo</label>
                                                    <input class="form-control form-control-solid" id="exampleFormControlInput1" type="number" min="1" pattern="^[0-9]+" onpaste="return false;" onDrop="return false;" autocomplete=off name="cupo_conferencia" placeholder="Cupo Maximo de la conferencia" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Descripción</label>
                                                    <textarea placeholder="contenido" id="contenido" name="descripcion_conferencia"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-success   " name="btnsave">Guardar</button>

                        </div>
                    </form>
                <?php } else { ?>
                    <form method="post" enctype="multipart/form-data" class="listar-formtheme listar-formaddlisting">
                        <div class="container-fluid mt-4">
                            <div id="solid">
                                <div class="card mb-4">
                                    <div class="card-header">Editar Conferencia</div>
                                    <div class="card-body">
                                        <div class="sbp-">
                                            <div class="sbp-preview-content">
                                                <label for="exampleFormControlInput1">Imagen (3MB Maximo)</label>
                                                <br>
                                                <img src="../../../images/conferencia/<?php echo $datosConferencia['imagen_conferencia']; ?>" height="" width="30%" /> <br><br>
                                                <input class="input-group" type="file" name="user_image" accept="image/*" />
                                                <br>
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Nombre de la conferencia</label>
                                                    <input class="form-control form-control-solid" id="exampleFormControlInput1" type="text" name="nombre_conferencia" placeholder="Titulo" value="<?php echo $datosConferencia['nombre_conferencia']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Lugar</label>
                                                    <input class="form-control form-control-solid" id="exampleFormControlInput1" type="text" name="lugar_conferencia" placeholder="Lugar de la conferecia" value="<?php echo $datosConferencia['lugar_conferencia']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Cupo</label>
                                                    <input class="form-control form-control-solid" id="exampleFormControlInput1" type="number" min="1" pattern="^[0-9]+" onpaste="return false;" onDrop="return false;" autocomplete=off name="cupo_conferencia" placeholder="Cupo Maximo de la conferencia" value="<?php echo $datosConferencia['cupo_conferencia']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Descripción</label>
                                                    <textarea placeholder="contenido" id="contenido" name="descripcion_conferencia"><?php echo $datosConferencia['descripcion_conferencia']; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary" name="btn_save_updates">Guardar Cambios</button>

                        </div>
                    </form>
                <?php } ?>

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

    <script>
        CKEDITOR.replace('contenido');

        CKEDITOR.on('dialogDefinition', function(e) {
            dialogName = e.data.name;
            dialogDefinition = e.data.definition;
            console.log(dialogDefinition)
            if (dialogName == 'image') {
                dialogDefinition.removeContents('link');
                dialogDefinition.removeContents('advanced');
                var tabContent = dialogDefinition.getContents('info');
                tabContent.remove('txtHSpace');
                tabContent.remove('txtVSpace');
            }
        })
    </script>
</body>

</html>