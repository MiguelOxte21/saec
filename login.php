<?php
session_start();
include("SAC/Conexion.php");
if ($_GET['carrera'] == !null) {
    $id_carrera = $_GET['carrera'];
    $Carreras = $DB_con->prepare("SELECT admin_carreras.*, logos.imagen FROM logos INNER JOIN admin_carreras ON admin_carreras.id_imagen = logos.id_imagen WHERE id_adminCarrera = $id_carrera");
    $Carreras->execute();
    while ($row = $Carreras->fetch(PDO::FETCH_OBJ)) {
        $id = $row->id_adminCarrera;
        $carrera =  $row->carrera;
        $img = $row->imagen;
    }
    // si en la URL es modificado, lo envia al index
    if ($id == null) {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}
// Tu sesión ha expirado. Por favor inicie sesión de nuevo.

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

    <style>
        #btn-acceso {
            position: right;
        }
    </style>

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
                        <a href="index.php" title="Vovler al inicio"><i class='fas fa-home icon'></i></a>
                            <a href="" class="active">Login</a><a href="registro.php?carrera=<?php echo $id; ?>">Registrarme</a><a href="olvidopass.php">Olvidé contraseña</a>
                        </div>
                        <form role="form" name="login" action="verificar.php" action="SISTEMA_ENCUESTAS/validacion.php" method="post">
                            <input type="hidden" name="c" value="<?php echo $id; ?>" require>
                            <input class="form-control" type="text" name="usuario" placeholder="Correo Institucional" maxlength="" required>

                            <div class="input-group">
                                <input ID="txtPassword" type="Password" Class="form-control" name="password" placeholder="Contraseña" maxlength="" required>
                                <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                            </div>
                            <div class="form-button">
                                <button id="submit" name="login" type="submit" class="ibtn">Acceder</button>
                            
                                
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