<?php
if (isset($_POST['login'])) {
    $errMSG ="¡Error! usuario o contraseña incorrectas";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congreso 2019</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="../css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="../css/iofrm-2.css">
    <style>
        body {
            overflow: hidden;
        }
    </style>
</head>

<body>
    <div class="form-body">
        <div class="website-logo">
            <a href="index.html">
                <div class="logo">
                    <img class="logo-size" src="images/logo-light.svg" alt="">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="../images/graphic2.svg" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Sistema de Administración de Congresos</h3>
                        <p>Administrador</p>
                        <div class="page-links">
                            <a href="index.php" class="active">Login</a>
                        </div>
                        <?php if (isset($errMSG)) {
                        ?>
                            <div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong> </div>
                        <?php
                        }?>
                        <form role="form" action="index.php" method="post">
                            <input class="form-control" type="text" name="username" placeholder="Correo Institucional" required>
                            <input class="form-control" type="password" name="password" placeholder="Contraseña" required>
                            <div class="form-button">
                                <button id="submit" type="submit" name="login" class="ibtn">Acceder</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>