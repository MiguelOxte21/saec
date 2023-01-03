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
    <!--page load
    <div class="images-preloader">
        <div id="preloader_1 spinner1" class="spinner1 rectangle-bounce">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>

    </div>-->
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

        <!-- standard list -->
        <section class="standard-list courses-2 section-padding-large">
            <div class="container">
                <?php if ($mensaje != "") { ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $mensaje; ?>
                        <a href="mostrarCarrito.php" class="badge badge-success">Por favor, Seleccione aquí para continuar.</a>
                    </div>
                <?php } ?>
                <div class="row">
                    <?php
                    $sentencia = $DB_con->prepare("SELECT * FROM productos");
                    $sentencia->execute();
                    $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                    // print_r($listaProductos);
                    ?>
                    <?php foreach ($listaProductos as $producto) { ?>
                        <div class="col-3">
                            <div class="card">
                                <img class="card-img-top" src="<?php echo $producto['imagen']; ?>" data-toggle="popover" data-trigger="hover" data-content="<?php echo $producto['descripcion']; ?>" title="<?php echo $producto['nombre']; ?>" alt="">
                                <div class="card-body">
                                    <span><?php echo $producto['nombre']; ?></span>
                                    <h5 class="card-title">$<?php echo $producto['precio']; ?></h5>

                                    <form action="" method="POST">
                                        <input type="hidden" name="id_producto" id="id_producto" value="<?php echo openssl_encrypt($producto['id_producto'], COD, KEY); ?>">
                                        <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['nombre'], COD, KEY); ?>">
                                        <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['precio'], COD, KEY); ?>">
                                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1, COD, KEY); ?>">
                                        <button class="btn btn-primary" value="Agregar" name="btnAccion" type="submit">Seleccionar</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
        </section>
    </main>





    <?php include 'templates/pie.php'; ?>