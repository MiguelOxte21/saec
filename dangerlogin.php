<?php
session_start();
include("SAC/Conexion.php");
if (  empty($_POST["c"])) {
   
 }  else {
    
    $carrera = htmlentities(addslashes($_POST['c']));

// Tu sesión ha expirado. Por favor inicie sesión de nuevo.
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
                    <img src="images/logos/1401424.jpg" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3 class="">Sistema de Administración de Eventos y Congresos</h3>
                        <p class="text-center">Contraseña y/o usuario incorrecto</p>
                        <div class="page-links text-center">
                        <a href="index.php" title="Vovler al inicio"><i class='fas fa-home icon'></i></a>
                            <a href="" class="active">Login</a><a href="registro.php?carrera=<?php echo $id; ?>">Registrarme</a><a href="olvidopass.php">Olvidé contraseña</a>
                       
                        <div class="alert alert-warning Sp-3 mb-2 bg-white">Contraseña y/o usuario incorrecto, Verifica sus datos.
                            <div> </div>
                            <button type="submit" class=" btn btn-primary  text-white"><a href="javascript:history.back()" >Regresar</a></button>


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