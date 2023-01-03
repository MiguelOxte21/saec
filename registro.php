<?php
// Se redireccionan si los usuarios se encuentrar inicido seccion
session_start();
if (isset($_SESSION["id_administrador_general"])) {
    print "<script>window.location='SAC/administrador_general/index.php';</script>";
} elseif (isset($_SESSION["id_administrador_carrera"])) {
    print "<script>window.location='SAC/administrador/index.php';</script>";
} elseif (isset($_SESSION["id_instructor"])) {
    print "<script>window.location='SAC/instructor/index.php';</script>";
} elseif (isset($_SESSION["id_alumno"])) {
    print "<script>window.location='inicio.php';</script>";
}

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
    // si en la URL es modificado, lo envia al index
    if ($id == null) {
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

    $nombre_alumno = $_POST['nombres'];
    $apellido_alumno = $_POST['apellidos'];
    $matricula = $_POST['matricula'];

    //grupo_etnico y promedio lenguaje
    $grupo_etnico = $_POST['grupo_etnico'];
    $promediolengua = $_POST['promediolengua'];


    $semestre_grupo = $_POST['semestre_grupo'];
    $id_adminCarrera = $id; //id de la carrera
    $id_rol = 4; //rol alumno
    $status_alumno = 0; //Enviamos como no pagado
    $idrol = 1; //rol alumno
    $est=1;
    $comentarios = null;
    $id_taller = null;
    $id_concurso = null;
    $id_equipo = null;


    // ecriptamos la contraseña
    $password = password_hash($pass, PASSWORD_DEFAULT, array("cost" => 15));


    if (empty($correo_user)) {
        $errMSG = "Todos los campos son obligatorios";
    } else if (empty($pass)) {
        $errMSG = "Todos los campos son obligatorios";
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

            $passw = 123456; //rol alumn23456o

            $sql = 'INSERT INTO tm_usuario(usu_id, usu_nom, usu_apep, usu_correo,rol_id, est) VALUES(:id_user,:nombre_alumno,:apellido_alumno,:correo_user, :idrol, :est)';
            $result = $DB_con->prepare($sql);
            $result->bindValue(':id_user', $lastId, PDO::PARAM_INT);
            $result->bindValue(':nombre_alumno', $nombre_alumno, PDO::PARAM_STR);
            $result->bindValue(':apellido_alumno', $apellido_alumno, PDO::PARAM_STR);
            $result->bindValue(':correo_user', $correo_user, PDO::PARAM_STR);
            
            $result->bindValue(':idrol', $idrol, PDO::PARAM_INT);
            $result->bindValue(':est', $est, PDO::PARAM_INT);
            $result->execute();
            $lastId = $DB_con->lastInsertId();

            // tabla usuarios de la tabla de encustas
            $sql = 'INSERT INTO usuarios(id_usuario, clave, nombres, apellidos, email, matricula, semestre_grupo, id_tipo_usuario) VALUES(:id_user,:password,:nombre_alumno,:apellido_alumno,:correo_user,:matricula ,:semestre_grupo,:id_rol)';
            $result = $DB_con->prepare($sql);
            
            $result->bindValue(':id_user', $lastId, PDO::PARAM_STR);
            $result->bindValue(':password', $password, PDO::PARAM_STR);
            $result->bindValue(':nombre_alumno', $nombre_alumno, PDO::PARAM_STR);
            $result->bindValue(':apellido_alumno', $apellido_alumno, PDO::PARAM_STR);
            $result->bindValue(':correo_user', $correo_user, PDO::PARAM_STR);
            $result->bindValue(':matricula', $matricula, PDO::PARAM_STR);
            $result->bindValue(':semestre_grupo', $semestre_grupo, PDO::PARAM_STR);
            $result->bindValue(':id_rol', $id_rol, PDO::PARAM_INT);
            $result->execute();
            

            // tabla alumnos
            $sql = 'INSERT INTO alumnos(nombre_alumno,apellido_alumno,matricula,semestre_grupo,status_alumno,comentarios,id_user,id_adminCarrera,id_taller,id_concurso,id_equipo,grupo_etnico,promediolengua) VALUES(:nombre_alumno, :apellido_alumno, :matricula, :semestre_grupo, :status_alumno, :comentarios, :id_user, :id_adminCarrera, :id_taller, :id_concurso, :id_equipo, :grupo_etnico, :promediolengua)';
            $result = $DB_con->prepare($sql);
            $result->bindValue(':nombre_alumno', $nombre_alumno, PDO::PARAM_STR);
            $result->bindValue(':apellido_alumno', $apellido_alumno, PDO::PARAM_STR);
            $result->bindValue(':matricula', $matricula, PDO::PARAM_STR);
            $result->bindValue(':semestre_grupo', $semestre_grupo, PDO::PARAM_STR);

            $result->bindValue(':status_alumno', $status_alumno, PDO::PARAM_INT);
            $result->bindValue(':comentarios', $comentarios, PDO::PARAM_STR);
            $result->bindValue(':id_user', $lastId, PDO::PARAM_INT);
            $result->bindValue(':id_adminCarrera', $id_adminCarrera, PDO::PARAM_INT);
            $result->bindValue(':id_taller', $id_taller, PDO::PARAM_INT);
            $result->bindValue(':id_concurso', $id_concurso, PDO::PARAM_INT);
            $result->bindValue(':id_equipo', $id_equipo, PDO::PARAM_INT);
            //base de dato creada para los grupos etnicos y promedio lengua
            $result->bindValue(':grupo_etnico', $grupo_etnico, PDO::PARAM_STR);
            $result->bindValue(':promediolengua', $promediolengua, PDO::PARAM_STR);

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
    <title>Sistema de Administración de Eventos y Congresos</title>
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
                        <h3 class="">Sistema de Administración de Eventos y Congresos</h3>
                        <p class="text-center"><?php echo $carrera; ?></p>
                        <div class="page-links text-center">
                            <a href="index.php" style="text-decoration: none;" title="Vovler al inicio"><i class='fas fa-home'></i></a>
                            <a href="login.php?carrera=<?php echo $id; ?>">Login</a><a href="" class="active">Registrarme</a>
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
                            <input class="form-control" type="number" name="matricula" placeholder="Matrícula" pattern="[0-9]+" min="8" maxlength="8" required>
                            <!-- <input class="form-control" type="file" name="matricula" placeholder="Matricula" accept="image/pdf" required> -->

                            <!--se agrego en el formulario el grupo etnico seleccion -->

                            <select name="grupo_etnico" class="selcls">
                                <?php
                                $grupo_etnico = $DB_con->prepare("SELECT * FROM grupo_etnico ORDER BY id_grupo_etnico ASC");
                                $grupo_etnico->execute();
                                while ($row = $grupo_etnico->fetch(PDO::FETCH_OBJ)) {
                                    if ($rowAlumnos['grupo_etnico'] == $row->grupo_etnico) {
                                        echo '<option selected>';
                                        echo $row->grupo_etnico;
                                        echo '</option>';
                                    } else {
                                        echo '<option>';
                                        echo $row->grupo_etnico;
                                        echo '</option>';
                                    }
                                } ?>
                            </select>
                            <!-- se agrego en el formulario el promedio  seleccion -->
                            <select name="promediolengua" class="selcls">
                                <?php
                                $promediolengua = $DB_con->prepare("SELECT * FROM promediolengua ORDER BY id_promediolengua ASC");
                                $promediolengua->execute();
                                while ($row = $promediolengua->fetch(PDO::FETCH_OBJ)) {
                                    if ($rowAlumnos['promediolengua'] == $row->promediolengua) {
                                        echo '<option selected>';
                                        echo $row->promediolengua;
                                        echo '</option>';
                                    } else {    
                                        echo '<option>';
                                        echo $row->promediolengua;
                                        echo '</option>';
                                    }
                                } ?>
                            </select>


                            <select name="semestre_grupo" class="selcls">
                                <?php
                                $semestre_grupo = $DB_con->prepare("SELECT * FROM semestre_grupo ORDER BY semestre_grupo ASC");
                                $semestre_grupo->execute();
                                while ($row = $semestre_grupo->fetch(PDO::FETCH_OBJ)) {
                                    if ($rowAlumnos['semestre_grupo'] == $row->semestre_grupo) {
                                        echo '<option selected>';
                                        echo $row->semestre_grupo;
                                        echo '</option>';
                                    } else {
                                        echo '<option>';
                                        echo $row->semestre_grupo;
                                        echo '</option>';
                                    }
                                } ?>
                            </select>


                            <input class="form-control" type="email" name="email" placeholder="Correo Institucional" <?php
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
                            <?php
                            if ($estado_registro == 1) { ?>
                                <div class="page-links text-right">
                                    <a href="r_instructor.php?carrera=<?php echo $id; ?>">Registrarme como instructor</a>
                                </div>
                            <?php } ?>


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