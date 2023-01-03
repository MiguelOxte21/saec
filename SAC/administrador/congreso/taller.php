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
        header("Location: ../../../index.php");
        exit();
    } else {  // si no ha caducado la sesion, actualizamos
        $_SESSION['tiempo'] = time();
    }
} else {
    $_SESSION['tiempo'] = time();
}

include('../../Conexion.php');

if (!isset($_GET['editar'])) {
    print "<script>window.location='index.php';</script>";
}

//DATOS ADMIN (SABER LA CARRERA)
$consulta = $DB_con->prepare('SELECT * FROM admin_carreras WHERE id_user=:id_user');
$consulta->execute(array(':id_user' => $_SESSION["id_administrador_carrera"]));
$datosCarrera = $consulta->fetch(PDO::FETCH_ASSOC);
extract($datosCarrera);

// Datos del taller-instructor
$consulta = $DB_con->prepare('SELECT instructores.*, talleres.* FROM instructores INNER JOIN talleres ON instructores.id_instructor = talleres.id_instructor WHERE talleres.id_taller= :id_taller');
$consulta->execute(array(':id_taller' => $_GET['id']));
$datosTaller = $consulta->fetch(PDO::FETCH_ASSOC);
extract($datosTaller);

if ($datosTaller['id_adminCarrera'] == $datosCarrera['id_adminCarrera']) {
    // El taller es de la carrera, continua con la edicion
} else {
    //si el taller no pertenece a la carrera, lo envia al inicio
    print "<script>window.location='index';</script>";
}

// ============================
//      ACTULIZAR TALLER
// ============================

if (isset($_POST['btn_save_updates'])) {

    $nombre_taller = $_POST['nombre_taller'];
    $lugar_taller = $_POST['lugar_taller'];
    $cupo_taller = $_POST['cupo_taller'];
    $descripcion_taller = $_POST['descripcion_taller'];
    $id_instructor = $_POST['id_instructor'];

    $imgFile = $_FILES['user_image']['name'];
    $tmp_dir = $_FILES['user_image']['tmp_name'];
    $imgSize = $_FILES['user_image']['size'];

    if ($imgFile) {
        $upload_dir = '../../../images/talleres/'; // upload directory	
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        $userpic = rand(1000, 3000000) . "." . $imgExt;
        if (in_array($imgExt, $valid_extensions)) {
            if ($imgSize < 3000000) {
                unlink($upload_dir . $datosTaller['imagen_taller']);
                move_uploaded_file($tmp_dir, $upload_dir . $userpic);
            } else {
                $errMSG = "La imagen es demasiado pesada, Tamaño máximo : 3Mb";
            }
        } else {
            $errMSG = "Solo archivos JPG, JPEG, PNG & GIF .";
        }
    } else {
        // if no image selected the old image remain as it is.
        $userpic = $datosTaller['imagen_taller']; // old image from database
    }


    // if no error occured, continue ....
    if (!isset($errMSG)) {

        // iniciar transacción
        $DB_con->beginTransaction();

        try {
            // tabla talleres
            $sql = 'UPDATE talleres 
                SET nombre_taller=:nombre_taller, 
                imagen_taller=:upic, 
                lugar_taller=:lugar_taller, 
                cupo_taller=:cupo_taller, 
                descripcion_taller=:descripcion_taller,
                id_instructor=:id_instructor
                WHERE id_taller=:uid';
            $result = $DB_con->prepare($sql);
            $result->bindValue(':nombre_taller', $nombre_taller, PDO::PARAM_STR);
            $result->bindValue(':upic', $userpic, PDO::PARAM_STR);
            $result->bindValue(':lugar_taller', $lugar_taller, PDO::PARAM_STR);
            $result->bindValue(':cupo_taller', $cupo_taller, PDO::PARAM_INT);
            $result->bindValue(':descripcion_taller', $descripcion_taller, PDO::PARAM_STR);
            $result->bindValue(':id_instructor', $id_instructor, PDO::PARAM_STR);
            $result->bindValue(':uid', $datosTaller['id_taller'], PDO::PARAM_INT);
            $result->execute();

            $DB_con->commit();
            // echo 'Datos insertados';
            $successMSG = "El taller ha sido editado exitosamente, Redireccionando...";
            header("refresh:1;index.php"); // redirects image view page after 5 seconds.
        } catch (PDOException $e) {
            // si ocurre un error hacemos rollback para anular todos los insert
            $DB_con->rollback();
            $e->getMessage();;
            $errMSG = "¡Error al insertar la información!, Por favor verifique si los datos ingresados sean los correctos o no esten duplicados con la información de otros talleres";
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
    <title>Sistemas de Administración de Eventos y Congresos</title>

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
                <div class="page-header page-header-light bg-white shadow">
                    <div class="container-fluid">
                        <div class="page-header-content py-5">
                            <h1 class="page-header-title">
                                <span>Taller</span>
                            </h1>
                            <ol class="breadcrumb mt-4 mb-0">
                                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Taller</li>
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
                                <div class="card-header">Editar Taller</div>
                                <div class="card-body">
                                    <div class="sbp-">
                                        <div class="sbp-preview-content">
                                            <label for="exampleFormControlInput1">Imagen (3MB Máximo)</label>
                                            <br>
                                            <img src="../../../images/talleres/<?php echo $datosTaller['imagen_taller']; ?>" height="" width="30%" /> <br><br>
                                            <input class="input-group" type="file" name="user_image" accept="image/*" />
                                            <br>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Nombre del Taller</label>
                                                <input class="form-control form-control-solid" id="exampleFormControlInput1" type="text" name="nombre_taller" placeholder="Titulo" value="<?php echo $datosTaller['nombre_taller']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Lugar</label>
                                                <input class="form-control form-control-solid" id="exampleFormControlInput1" type="text" name="lugar_taller" placeholder="Lugar del taller" value="<?php echo $datosTaller['lugar_taller']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Cupo</label>
                                                <input class="form-control form-control-solid" id="exampleFormControlInput1" type="number" min="1" pattern="^[0-9]+" onpaste="return false;" onDrop="return false;" autocomplete=off name="cupo_taller" placeholder="Cupo Maximo del Taller" value="<?php echo $datosTaller['cupo_taller']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                    <label for="my-select">Instructor</label>
                                                    <select id="my-select" class="form-control" name="id_instructor">
                                                    
                                <?php
                                // INSTRUCTOR ACTUAL
                                $instructoresLibres = $DB_con->prepare("SELECT * FROM instructores");
                                $instructoresLibres->execute();
                                while ($row = $instructoresLibres->fetch(PDO::FETCH_OBJ)) {
                                    if ($row->id_instructor == $datosTaller['id_instructor']) {
                                        echo '<option value="'.$row->id_instructor. '" selected>'.$row->nombre_instructor. ' ' .$row->apellido_instructor. '</option>';
                                    }
                                    
                                } 
                                // INSTRUCTORES QUE NO TIENEN TALLER
                                $instructoresLibres = $DB_con->prepare("SELECT * FROM instructores WHERE NOT EXISTS (SELECT * FROM talleres WHERE instructores.id_instructor = talleres.id_instructor)");
                                $instructoresLibres->execute();
                                while ($row = $instructoresLibres->fetch(PDO::FETCH_OBJ)) {
                                        echo '<option value="'.$row->id_instructor. '">'.$row->nombre_instructor. ' ' .$row->apellido_instructor. '</option>';
                                }
                                ?>
                                                    </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Descripción</label>
                                                <textarea placeholder="contenido" id="contenido" name="descripcion_taller"><?php echo $datosTaller['descripcion_taller']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success" name="btn_save_updates">Guardar Cambios</button>
                        <a href="index.php"><input type="button" class ="btn btn-danger" value="Cancelar"></a>
                    </div>
                </form>
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