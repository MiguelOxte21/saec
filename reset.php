<?php
if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
} else {
    header("location:./login.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset</title>
    <!-- <title>Sistema de Administración de Eventos y Congresos</title> -->
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


</head>


<body>
    <div class="form-body">

        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="images/logos/1401424.jpg" alt="logos">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3 class="">Sistema de Administración de Eventos y Congresos</h3>
                        <p class="text-center"></p>
                        <div class="page-links text-center">
                            <a href="index.php" title="Vovler al inicio"><i class='fas fa-home icon'></i></a>
                            <!--<a href="" class="active">Login</a><a href="registro.php?carrera=<?php echo $id; ?>">Registrarme</a>-->
                        </div>
                        <form rol="form" action="./php/verificartoken.php" method="POST">
                            <!--<form class="col-3" action="./php/verificartoken.php" method="POST"> -->

                            <h3>Escriba el código</h3>
                            <div class="mb-3">

                                <input type="hidden" name="c" value="" require>
                                <!-- <label for="c" class="form-label">codigo</label> -->
                                <input type="number" class="form-control" id="c" name="codigo" placeholder="Código enviado en su correo" maxlength="" required>

                                <input type="hidden" class="form-control" id="c" name="email" value="<?php echo $email; ?>">
                                <input type="hidden" class="form-control" id="c" name="token" value="<?php echo $token; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Restablecer</button>
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