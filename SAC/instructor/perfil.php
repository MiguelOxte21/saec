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
        header("Location: ../../index.php");
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

if (isset($_POST['datos'])) {
    $_POST['nombre'];
    $_POST['apellidos'];
    $_POST['clave'];

    $DB_con->beginTransaction();

    try {
        $sentencia = $DB_con->prepare("UPDATE instructores SET nombre_instructor = ?, apellido_instructor = ?, clave = ? WHERE id_user = ?;");
        $resultado = $sentencia->execute([$_POST['nombre'], $_POST['apellidos'], $_POST['clave'], $_SESSION["id_instructor"]]);

        $DB_con->commit();
        // echo 'Datos insertados';
        header("Location: perfil.php");
    } catch (PDOException $e) {
        // si ocurre un error hacemos rollback para anular todos los insert
        $DB_con->rollback();
        $e->getMessage();;
        $errMSG = 'Error';
    }
}

if (isset($_POST['usuario'])) {
    $_POST['correo'];

    $DB_con->beginTransaction();

    try {
        $sentencia = $DB_con->prepare("UPDATE users SET correo_user = ? WHERE id_user = ?;");
        $resultado = $sentencia->execute([$_POST['correo'], $_SESSION["id_instructor"]]);

        $DB_con->commit();
        // echo 'Datos insertados';
        header("Location: perfil.php");
    } catch (PDOException $e) {
        // si ocurre un error hacemos rollback para anular todos los insert
        $DB_con->rollback();
        $e->getMessage();;
        $errMSG = 'Error';
    }
}

if (isset($_POST['contra'])) {
    $_POST['pass1'];
    $_POST['pass2'];
    $nombre = htmlentities(addslashes($_POST['nombre']));
    $clave = htmlentities(addslashes($_POST['pass-old']));

    if ($_POST['pass1'] == $_POST['pass2']) {
        // ecriptamos la contraseña
        $password = password_hash($_POST['pass2'], PASSWORD_DEFAULT, array("cost" => 15));

        $sql = "SELECT * FROM users WHERE correo_user = :nombre";
        $resultado = $DB_con->prepare($sql);
        $resultado->execute(array(":nombre" => $nombre));

        // Verificamos el Password
        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {

            if (password_verify($clave, $registro['password'])) {
                $id_user = $registro['id_user'];

                $DB_con->beginTransaction();

                try {
                    $sentencia = $DB_con->prepare("UPDATE users SET password = ? WHERE id_user = ?;");
                    $resultado = $sentencia->execute([$password, $_SESSION["id_instructor"]]);

                    $DB_con->commit();
                    // echo 'Datos insertados';
                    header("Location: perfil.php");
                    print "<script>alert('Contraseña Actulizada');</script>";
                } catch (PDOException $e) {
                    // si ocurre un error hacemos rollback para anular todos los insert
                    $DB_con->rollback();
                    $e->getMessage();;
                    $errMSG = 'Error';
                }
            } else {
                print "<script>alert('Su contraseña con coinciden');</script>";
                $errMSG = 'Error';
            }
        }
    } else {
        print "<script>alert('¡Error! las contraseñas NO coinciden');</script>";
        $errMSG = 'Error';
    }
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
    <title>Sistema de Administración de Congresos</title>

    <link href="../../plugins/admin/css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../plugins/admin/assets\img\favicon.png">

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.0.0.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>

    <script>
        $(document).ready(function() {
            //variables
            var pass1 = $('[name=pass1]');
            var pass2 = $('[name=pass2]');
            var confirmacion = "Las contraseñas coinciden";
            var longitud = "La contraseña debe estar formada entre 8-16 carácteres (ambos inclusive)";
            var negacion = "No coinciden las contraseñas";
            var vacio = "La contraseña no puede estar vacía";
            //oculto por defecto el elemento span
            var span = $('<span></span>').insertAfter(pass2);
            span.hide();
            //función que comprueba las dos contraseñas
            function coincidePassword() {
                var valor1 = pass1.val();
                var valor2 = pass2.val();
                //muestro el span
                span.show().removeClass();
                //condiciones dentro de la función
                if (valor1 != valor2) {
                    span.text(negacion).addClass('negacion');
                }
                if (valor1.length == 0 || valor1 == "") {
                    span.text(vacio).addClass('negacion');
                }
                if (valor1.length < 6 || valor1.length > 10) {
                    span.text(longitud).addClass('negacion');
                }
                if (valor1.length != 0 && valor1 == valor2) {
                    span.text(confirmacion).removeClass("negacion").addClass('confirmacion');
                }
            }
            //ejecuto la función al soltar la tecla
            pass2.keyup(function() {
                coincidePassword();
            });
        });
    </script>
    <script type="text/javascript">
        function mostrarPassword() {
            var cambio = document.getElementById("txtPassword");
            if (cambio.type == "password") {
                cambio.type = "text";
                $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            } else {
                cambio.type = "password";
                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }

        }

        $(document).ready(function() {
            //CheckBox mostrar contraseña
            $('#ShowPassword').click(function() {
                $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });
        });
    </script>
    <style>
        .confirmacion {
            color: green;
        }

        .negacion {
            color: red;
        }
    </style>

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
                            <?php
                            if (isset($errMSG)) {
                            ?>
                                <div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> <strong>Datos NO actulizados, por favor verifique que la informacion sea la correcta.</strong> </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="container-fluid mt-n10">
                    <div class="card mb-4">
                        <div class="card-header">Datos publicos</div>
                        <div class="card-body">
                            <form action="perfil.php" method="post">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Nombre(s)</label>
                                    <input type="text" class="form-control" id="exampleFormControlSelect1" name="nombre" value="<?php echo $datos['nombre_instructor']; ?>" pattern="[A-Za-z\s]+" maxlength="40" required>
                                    <label for="exampleFormControlSelect1">Apellidos</label>
                                    <input type="text" class="form-control" id="exampleFormControlSelect1" name="apellidos" value="<?php echo $datos['apellido_instructor']; ?>" pattern="[A-Za-z\s]+" maxlength="40" required>
                                    <label for="exampleFormControlSelect1">Clave</label>
                                    <input type="text" class="form-control" id="exampleFormControlSelect1" name="clave" value="<?php echo $datos['clave']; ?> " maxlength="20" required>
                                </div>
                                <button class="btn btn-primary" name="datos">Actualizar</button>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">Usuario</div>
                        <div class="card-body">
                            <form action="perfil.php" method="post">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Correo institucional</label>
                                    <input class="form-control" type="email" name="correo" placeholder="Correo Institucional" <?php
                                                                                                                                $correo = $DB_con->prepare("SELECT * FROM correos");
                                                                                                                                $correo->execute();
                                                                                                                                echo 'pattern="[a-z0-9|.]+(';
                                                                                                                                while ($row2 = $correo->fetch(PDO::FETCH_OBJ)) {
                                                                                                                                    echo $row2->correo;
                                                                                                                                    echo '|';
                                                                                                                                }
                                                                                                                                echo ')"'; ?> maxlength="70" value="<?php echo $datos['correo_user']; ?>" required>
                                </div>
                                <button class="btn btn-primary" name="usuario">Actualizar</button>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">Contraseña</div>
                        <div class="card-body">
                            <form action="perfil.php" method="post">
                                <div class="form-group">
                                    <input type="hidden" name="nombre" value="<?php echo $datos['correo_user']; ?>" required>
                                    <label for="exampleFormControlSelect1">Contraseña Antigua</label>
                                    <div class="input-group">
                                        <input ID="txtPassword" type="Password" Class="form-control" name="pass-old" maxlength="15" required>
                                        <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                                    </div>

                                    <label for="exampleFormControlSelect1">Nueva Contraseña</label>
                                    <input class="form-control" type="password" name="pass1" autofocus="autofocus" minlength="8" maxlength="16" pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$" required>
                                    <label for="exampleFormControlSelect1">confirmar nueva Contraseña</label>
                                    <input type="password" class="form-control" name="pass2" minlength="8" maxlength="16" pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$" required>
                                    <p> <small>Su nueva contraseña debe tener entre 8 y 16 caracteres, al menos un dígito y al menos una mayúscula.</small></p>
                                </div>
                                <input type="submit" class="btn btn-primary" name="contra" value="Actualizar" />
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