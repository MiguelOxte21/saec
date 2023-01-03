<?php
include("SAC/Conexion.php");
if ($_GET['carrera'] == !null) {
    $id_carrera = $_GET['carrera'];
    $Carreras = $DB_con->prepare("SELECT admin_carreras.*, logos.imagen FROM logos INNER JOIN admin_carreras ON admin_carreras.id_imagen = logos.id_imagen WHERE id_adminCarrera = $id_carrera");
    $Carreras->execute();
    while ($row = $Carreras->fetch(PDO::FETCH_OBJ)) {
        $id = $row->id_adminCarrera;
        $carrera =  $row->carrera;
        $img = $row->imagen;
        $estado_registro = $row->estado_registro;
    }
    // si en la URL es modificado o no este activo el registro de los intructores, lo envia al index
    if ($id == null or $estado_registro == 0) {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}

// ============================
//     Registro del usuario
// ============================
if (isset($_POST['btnsave'])) {

    $correo_user = $_POST['email'];
    $pass = $_POST['password'];
    $id_rol = 3; //rol instructor

    $nombre_instructor = $_POST['nombres'];
    $apellido_instructor = $_POST['apellidos'];
    $clave = $_POST['clave'];
    $status_instructor = 0; //Enviamos como inactivo
    $id_adminCarrera = $id; //id de la carrera

    // encriptamos la contraseña
    $password = password_hash($pass, PASSWORD_DEFAULT, array("cost" => 15));


    if (empty($correo_user)) {
        $errMSG = "Acomplete los campos, Por favor";
    } else if (empty($pass)) {
        $errMSG = "Acomplete los campos, Por favor";
    }


    // if no error occured, continue ....
    if (!isset($errMSG)) {

        // iniciar transacción
        $DB_con->beginTransaction();

        try {
            // tabla users
            $sql = 'INSERT INTO users(correo_user,password,id_rol) VALUES(:correo_user, :password, :id_rol)';
            $result = $DB_con->prepare($sql);
            $result->bindValue(':correo_user', $correo_user, PDO::PARAM_STR);
            $result->bindValue(':password', $password, PDO::PARAM_STR);
            $result->bindValue(':id_rol', $id_rol, PDO::PARAM_INT);
            $result->execute();
            $lastId = $DB_con->lastInsertId();

            // tabla instructores
            $sql = 'INSERT INTO instructores(nombre_instructor, apellido_instructor, clave, status_instructor, id_user, id_adminCarrera) VALUES(:nombre_instructor, :apellido_instructor, :clave, :status_instructor, :id_user, :id_adminCarrera)';
            $result = $DB_con->prepare($sql);
            $result->bindValue(':nombre_instructor', $nombre_instructor, PDO::PARAM_STR);
            $result->bindValue(':apellido_instructor', $apellido_instructor, PDO::PARAM_STR);
            $result->bindValue(':clave', $clave, PDO::PARAM_STR);
            $result->bindValue(':status_instructor', $status_instructor, PDO::PARAM_INT);
            $result->bindValue(':id_user', $lastId, PDO::PARAM_INT);
            $result->bindValue(':id_adminCarrera', $id_adminCarrera, PDO::PARAM_INT);

            $result->execute();

            $DB_con->commit();
            // echo 'Datos insertados';
            $successMSG = "Registrado Exitosamente";
            header("refresh:1;login.php?carrera=$id");
        } catch (PDOException $e) {
            // si ocurre un error hacemos rollback para anular todos los insert
            $DB_con->rollback();
            $e->getMessage();;
            $errMSG = "¡Error al procesar la información!, Por favor verifique si los datos ingresados sean los correctos o es posible que ya se encuentre registrado";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Administracion de Congresos</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-theme6.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>



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
        .selcls {
            padding: 9px;
            border: solid 1px #517B97;
            outline: 0;
            /* background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #CAD9E3), to(#FFFFFF));  */
            /* background: -moz-linear-gradient(top, #FFFFFF, #CAD9E3 1px, #FFFFFF 25px); 
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  */
            -moz-box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 8px;
            -webkit-box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 8px;
            margin-bottom: 12px;
            width: 100%;
        }

        .input-group {
            width: 100%;
        }
    </style>

</head>

<body>


    <div class="form-body">

        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="images/logos/<?php echo $img ?>" alt="Logo <?php echo $carrera; ?>">
                </div>
            </div>


            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3 class="">Sistema de Administración de Congresos</h3>
                        <p class="text-center"><?php echo $carrera; ?></p>
                        <div class="page-links text-center">
                            <a href="index.php" title="Volver al inicio"><i class='fas fa-home icon'></i></a>
                            <a href="login.php?carrera=<?php echo $id; ?>">Login</a>
                            <a href="" class="active">Registrarme como instructor</a>
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
                        <form method="post">
                            <input class="form-control" type="text" name="nombres" placeholder="Nombre(s)" pattern="[A-Za-z\s]+" maxlength="40" required>
                            <input class="form-control" type="text" name="apellidos" placeholder="Apellidos" pattern="[A-Za-z\s]+" maxlength="40" required>
                            <input class="form-control" type="text" name="clave" placeholder="Clave" pattern="[0-9a-zA-Z]+" maxlength="15" required>
                            <input class="form-control" type="email" name="email" placeholder="Correo institucional" <?php
                                                                                                                        $correo = $DB_con->prepare("SELECT * FROM correos");
                                                                                                                        $correo->execute();
                                                                                                                        echo 'pattern="[a-z0-9|.]+(';
                                                                                                                        while ($row2 = $correo->fetch(PDO::FETCH_OBJ)) {
                                                                                                                            echo $row2->correo;
                                                                                                                            echo '|';
                                                                                                                        }
                                                                                                                        echo ')"'; ?> maxlength="70" required>

                            <div class="input-group">
                                <input ID="txtPassword" type="Password" Class="form-control" name="password" placeholder="Contraseña" minlength="8" maxlength="16" pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$" required>
                                <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                                <p> <small>La contraseña debe tener entre 8 y 16 caracteres, al menos un dígito y al menos una mayúscula.</small></p>
                            </div>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn" name="btnsave">Registrarme</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    <script type='text/javascript'>
        document.oncontextmenu = function() {
            return false
        }
    </script>
</body>

</html>