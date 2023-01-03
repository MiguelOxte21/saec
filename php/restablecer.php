<?php
include('../SAC/Conexion.php');
$email = $_POST['email'];

$bytes = random_bytes(5);
$token = bin2hex($bytes);

include('mail_reset.php');

if ($enviado) {
    $DB_con1->query("insert into passwords(email, token, codigo)
values('$email','$token','$codigo')") or die($DB_con1->error);
    //echo '<p>verifica tu correo para restablecer tu contraseña </p>';
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset</title>
    <!-- <title>Sistema de Administración de Eventos y Congresos</title> -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="../css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="../css/iofrm-theme6.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <style>
        #btn-acceso {
            position: right;
        }
    </style>


</head>


<body>

    <div class="form-body">

        <div class="row ">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="images/logos/1204182.jpg" alt="logos">
                </div>

            </div>

            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3 class="">Sistema de Administración de Eventos y Congresos</h3>


                        <h4><font color="white">Verifica tu correo para restablecer tu contraseña </font></h4>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>

    <script type='text/javascript'>
        document.oncontextmenu = function() {
            return false
        }
    </script>
</body>

</html>