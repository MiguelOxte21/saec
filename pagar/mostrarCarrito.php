<?php
//include 'global/config.php';
//include '../SAC/Conexion.php';
//include 'carrito.php';
//include 'templates/cabecera.php';
//header("Location: pagar.php");
?>
<?php
session_start();
if (!isset($_SESSION["id_alumno"]) || $_SESSION["id_alumno"] == null) {
    print "<script>window.location='../index.php';</script>";
}
$idcarr = $_SESSION["id_adminCarrera"];

//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {
    $inactivo = 900; //15min en este caso.
    $vida_session = time() - $_SESSION['tiempo'];
    if ($vida_session > $inactivo) {
        session_unset();
        session_destroy();
        header("Location: ../login.php?carrera=$idcarr");
        exit();
    } else {  // si no ha caducado la sesion, actualizamos
        $_SESSION['tiempo'] = time();
    }
} else {
    $_SESSION['tiempo'] = time();
}
include 'global/config.php';
include("../SAC/Conexion.php");
include 'carrito.php';
//include 'templates/cabecera.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de Administración de Eventos y Congresos</title>

    <!-- Bootstrap -->
    <link rel='stylesheet' href='../vendor/jquery-ui/jquery-ui.min.css'>
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">

    <!-- Font Icon -->
    <link rel="stylesheet" href="../fonts/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="../fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../fonts/font-awesome-5/css/fontawesome-all.min.css">

    <!-- Revolution slider -->
    <link rel="stylesheet" href="../vendor/revolution/settings.css">
    <link rel="stylesheet" href="../vendor/revolution/layers.css">
    <link rel="stylesheet" href="../vendor/revolution/navigation.css">
    <link rel="stylesheet" href="../vendor/revolution/settings-source.css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="../vendor/css-hamburgers/dist/hamburgers.min.css">
    <link rel="stylesheet" href="../vendor/slick/slick-theme.css">
    <link rel="stylesheet" href="../vendor/slick/slick.css">
    <link rel="stylesheet" href="../vendor/fancybox/dist/jquery.fancybox.min.css">
    <link rel='stylesheet' href='../vendor/fullcalendar/fullcalendar.css'>
    <link rel='stylesheet' href='../vendor/animate/animate.css'>

    <!-- Main CSS File -->
    <link href="../css/style.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">

    <!-- AJAX -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>



</head>

<body>
    <?php include 'templates/cabecera.php'; ?>
    <main>
        <!-- Heading Page -->
        <section class="heading-page">
            <img src="../images/bloggrid-heading-bg.jpg" alt="">
            <div class="container">
                <div class="heading-page-content">
                    <div class="au-page-title text-center">
                        <h1>Pagos</h1>
                    </div>

                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <br>
                <h3>Lista Carrito</h3>
                <?php if (!empty($_SESSION['CARRITO'])) { ?>
                    <table class="table table-light table-bordered">
                        <tbody>
                            <tr>
                                <th width="40%">Descripción.</th>
                                <th width="15%" class="text-center">Cantidad</th>
                                <th width="20%" class="text-center">Precio</th>
                                <th width="20%" class="text-center">Total</th>
                                <th width="5%">--</th>
                            </tr>
                            <?php
                            $total = 0;
                            foreach ($_SESSION['CARRITO'] as $indice => $producto) { ?>
                                <tr>
                                    <td width="40%"><?php echo $producto['NOMBRE']; ?></td>
                                    <td width="20%" class="text-center"><?php echo $producto['CANTIDAD']; ?></td>
                                    <td width="20%" class="text-center">$<?php echo $producto['PRECIO']; ?></td>
                                    <td width="20%" class="text-center">$<?php echo number_format($producto['PRECIO'] * $producto['CANTIDAD'], 2); ?></td>
                                    <!-- 
                                    <td width="5%">
                                        <form action="" method="post">
                                            <input type="hidden" name="id_producto" id="id_producto" value="<?php echo openssl_encrypt($producto['id_producto'], COD, KEY); ?>">
                                            <button class="btn btn-danger" value="Eliminar" name="btnAccion" type="submit">Eliminar</button>
                                        </form>

                                    </td>
                                    -->
                                </tr>
                            <?php
                                $total = $total + $producto['PRECIO'] * $producto['CANTIDAD'];
                            } ?>

                            <tr>
                                <td colspan="3" align="right">
                                    <h3>Total: </h3>
                                </td>
                                <td align="right">
                                    <h3>$<?php echo number_format($total, 2); ?> </h3>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <form action="pagar.php" method="post">
                                        <div class="alert alert-success" role="alert">
                                            <div class="form-group">
                                                <label for="my-input">Correo de contacto: </label>
                                                <input id="email" name="email" class="form-control" type="email" placeholder="Por favor escribe tu correo institucional." required>
                                            </div>
                                            <small id="emailhelp" class="form-text text-muted">El correo se usará para llevar un registro.</small>
                                        </div>
                                        <button class="btn btn-primary btn-lg btn-block" type="submit" value="proceder" name="btnAccion">Proceda a su pago. >></button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="alert alert-success" role="alert">
                        No hay productos en el carrito.
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>


    <?php include 'templates/pie.php'; ?>