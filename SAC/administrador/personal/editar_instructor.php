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

// datos del admin 
$consulta = $DB_con->prepare('SELECT * FROM admin_carreras WHERE id_user=:id_user');
$consulta->execute(array(':id_user' => $_SESSION["id_administrador_carrera"]));
$datosCarrera = $consulta->fetch(PDO::FETCH_ASSOC);
extract($datosCarrera);

// datos del instructor
$consulta = $DB_con->prepare('SELECT users.*, instructores.* FROM users INNER JOIN instructores ON users.id_user = instructores.id_user WHERE instructores.id_instructor = :id_instructor');
$consulta->execute(array(':id_instructor' => $_GET['id']));
$datosInstructor = $consulta->fetch(PDO::FETCH_ASSOC);
extract($datosInstructor);

// COMPROBAR QUE EL INSTRUCTOR ES EL MISMO QUE EL ADMINISTRADOR
if ($datosCarrera['id_adminCarrera'] <> $datosInstructor['id_adminCarrera']) {
    header("location:instructores.php");    
}

if (isset($_POST['btnedit'])) {
    echo $nombre_instructor = $_POST['nombres'];
    echo $apellido_instructor = $_POST['apellidos'];

    echo $correo_user = $_POST['email'];
    echo $pass = $_POST['password'];
    echo $id_user = $_POST['id_user'];

    // encriptamos la contraseña
    $password = password_hash($pass, PASSWORD_DEFAULT, array("cost" => 15));

    if (empty($correo_user)) {
        $errMSG = "Acomplete los campos, Por favor";
    } 

    // if no error occured, continue ....
    if (!isset($errMSG)) {

        // iniciar transacción
        $DB_con->beginTransaction();

        if (isset($_POST['password']) && $_POST['password'] <> null) {
            try {
                // tabla users - con pass
                $sql = 'UPDATE users SET correo_user=:correo_user,password=:password WHERE id_user = :id_user';
                $result = $DB_con->prepare($sql);
                $result->bindValue(':correo_user', $correo_user, PDO::PARAM_STR);
                $result->bindValue(':password', $password, PDO::PARAM_STR);
                $result->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                $result->execute();
    
                // tabla instructores
                $sql = 'UPDATE instructores SET nombre_instructor=:nombre_instructor,apellido_instructor=:apellido_instructor WHERE id_user = :id_user';
                $result = $DB_con->prepare($sql);
                $result->bindValue(':nombre_instructor', $nombre_instructor, PDO::PARAM_STR);
                $result->bindValue(':apellido_instructor', $apellido_instructor, PDO::PARAM_STR);
                $result->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    
                $result->execute();
    
                $DB_con->commit();
                // echo 'Datos insertados';
                $successMSG = "Registrado Exitosamente asdasd";
                header("refresh:1;instructores.php");
            } catch (PDOException $e) {
                // si ocurre un error hacemos rollback para anular todos los insert
                $DB_con->rollback();
                $e->getMessage();;
                $errMSG = "¡Error al procesar la información!, Por favor verifique si los datos ingresados sean los correctos o es posible que ya se encuentre registrado" .$e;
            }
        }else {
            try {
                // tabla users - sin pass
                $sql = 'UPDATE users SET correo_user=:correo_user WHERE id_user = :id_user';
                $result = $DB_con->prepare($sql);
                $result->bindValue(':correo_user', $correo_user, PDO::PARAM_STR);
                $result->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                $result->execute();
    
                // tabla instructores
                $sql = 'UPDATE instructores SET nombre_instructor=:nombre_instructor,apellido_instructor=:apellido_instructor WHERE id_user = :id_user';
                $result = $DB_con->prepare($sql);
                $result->bindValue(':nombre_instructor', $nombre_instructor, PDO::PARAM_STR);
                $result->bindValue(':apellido_instructor', $apellido_instructor, PDO::PARAM_STR);
                $result->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    
                $result->execute();
    
                $DB_con->commit();
                // echo 'Datos insertados';
                $successMSG = "Registrado Exitosamente";
                header("refresh:1;instructores.php");
            } catch (PDOException $e) {
                // si ocurre un error hacemos rollback para anular todos los insert
                $DB_con->rollback();
                $e->getMessage();;
                $errMSG = "¡Error al procesar la información!, Por favor verifique si los datos ingresados sean los correctos o es posible que ya se encuentre registrado" .$e;
            }
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
                            <div class="dropdown-user-details-email">Ingenieria en Sistemas Computacionales</div>
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
                                <span>Actulizar Instructor</span>
                            </h1>
                            <ol class="breadcrumb mt-4 mb-0">
                                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="instructores.php">Instructores</a></li>
                                <li class="breadcrumb-item active">Actulizar Instructor</li>
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
                                <div class="card-header">Actulizar Instructor</div>
                                <div class="card-body">
                                    <div class="sbp-">
                                        <div class="sbp-preview-content">
                                            <input type="hidden" name="id_user" value="<?php echo $datosInstructor['id_user']; ?>">
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Nombre</label>
                                                <input class="form-control form-control-solid" id="exampleFormControlInput1" type="text" name="nombres" placeholder="Nombre del instructor" maxlength="40" value="<?php echo $datosInstructor['nombre_instructor']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Apellidos</label>
                                                <input class="form-control form-control-solid" id="exampleFormControlInput1" type="text" name="apellidos" placeholder="Apellidos del instructor" maxlength="40" value="<?php echo $datosInstructor['apellido_instructor']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Correo institucional</label>
                                                <input class="form-control form-control-solid" type="email" name="email" value="<?php echo $datosInstructor['correo_user']; ?>" placeholder="Correo Institucional" <?php
                                                                                                                                                                                                                    $correo = $DB_con->prepare("SELECT * FROM correos");
                                                                                                                                                                                                                    $correo->execute();
                                                                                                                                                                                                                    echo 'pattern="[a-z0-9|.]+(';
                                                                                                                                                                                                                    while ($row2 = $correo->fetch(PDO::FETCH_OBJ)) {
                                                                                                                                                                                                                        echo $row2->correo;
                                                                                                                                                                                                                        echo '|';
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                    echo ')"'; ?> maxlength="70" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Resetear Contraseña</label>
                                                <input ID="txtPassword" type="text" class="form-control form-control-solid" name="password" placeholder="Nueva Contraseña" minlength="8" maxlength="16" pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$">
                                                <p> <small>La contraseña debe tener entre 8 y 16 caracteres, al menos un dígito y al menos una mayúscula.</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="" name="btnedit">Guardar Cambios</button>
                        <a href="index.php"><input type="button" value="Cancelar"></a>
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