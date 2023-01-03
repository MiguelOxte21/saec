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
//INFORMACION DEL ALUMNO 
$datosAlumnos = $DB_con->prepare("SELECT * FROM alumnos WHERE id_user=:id_user");
$datosAlumnos->execute(array(':id_user' => $_SESSION["id_alumno"]));
while ($row = $datosAlumnos->fetch(PDO::FETCH_OBJ)) {
    $id_alumno = $row->id_alumno;
}
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
                <?php

                $Login = curl_init(LINKAPI . "/v1/oauth2/token");
                curl_setopt($Login, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($Login, CURLOPT_USERPWD, CLIENTID . ":" . SECRET);
                curl_setopt($Login, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
                $Rspuesta = curl_exec($Login);
                $objRespuesta = json_decode($Rspuesta);
                $AccessToken = $objRespuesta->access_token;


                $venta = curl_init(LINKAPI . "/v1/payments/payment/" . $_GET['paymentID']);
                curl_setopt($venta, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $AccessToken));
                curl_setopt($venta, CURLOPT_RETURNTRANSFER, TRUE);
                $RespuestaVenta = curl_exec($venta);

                $objDatosTransaccion = json_decode($RespuestaVenta);

                $state = $objDatosTransaccion->state;
                $email = $objDatosTransaccion->payer->payer_info->email;

                $total = $objDatosTransaccion->transactions[0]->amount->total;
                $currency = $objDatosTransaccion->transactions[0]->amount->currency;
                $custom = $objDatosTransaccion->transactions[0]->custom;


                $clave = explode("#", $custom);

                $SID = $clave[0];
                $claveVenta = openssl_decrypt($clave[1], COD, KEY);

                curl_close($venta);
                curl_close($Login);


                if ($state == "approved") {
                    $mensajePaypal = "<h3>Su pago se realizó con éxito, queda en espera de activación.</h3>";
                    $sentencia = $DB_con->prepare("UPDATE `ventas` SET `paypal_datos` = :paypal_datos, `status` = 'aprobado' WHERE `ventas`.`id_venta` = :id_venta;");
                    $sentencia->bindParam(":id_venta", $claveVenta);
                    $sentencia->bindParam(":paypal_datos", $RespuestaVenta);
                    $sentencia->execute();

                    $sentencia = $DB_con->prepare("UPDATE `ventas` SET status='completo' WHERE clave_transaccion=:clave_transaccion AND total=:total AND id_venta=:id_venta");
                    $sentencia->bindParam(":clave_transaccion", $SID);
                    $sentencia->bindParam(":total", $total);
                    $sentencia->bindParam(":id_venta", $claveVenta);
                    $sentencia->execute();

                    $idu = $_SESSION["id_alumno"];

                    $total = 0;

                    foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                        $total = $total + $producto['PRECIO'] * $producto['CANTIDAD'];
                    }
                    $tol = number_format($total, 2);

                    $comentarios = 'El alumno pago por paypal la cantidad de $' . $tol;
                    $upAlumno = $DB_con->prepare('UPDATE alumnos SET comentarios =:comentarios WHERE id_user =:idu');
                    $upAlumno->bindParam(':comentarios', $comentarios);
                    $upAlumno->bindParam(':idu', $idu);
                    $upAlumno->execute();

                    $completado = $sentencia->rowCount();
                    session_destroy();
                } else {
                    $mensajePaypal = "<h3>Hay un problema con el pago de paypal</h3>";
                }

                ?>
                <div class="jumbotron">
                    <h1 class="display-4">¡ Listo !</h1>
                    <hr class="my-4">
                    <p class="lead"><?php echo $mensajePaypal; ?></p>
                    <p>
                        <?php
                        if ($completado >= 1) {

                            $sentencia = $DB_con->prepare("SELECT * FROM transacciones, productos WHERE transacciones.id_producto=productos.id_producto AND transacciones.id_venta=:id_transaccion");
                            $sentencia->bindParam(":id_transaccion", $claveVenta);
                            $sentencia->execute();
                            $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                            //print_r($listaProductos);
                        }
                        ?>
                    <div class="row">
                        <?php foreach ($listaProductos as $producto) { ?>
                            <div class="col-2">
                                <div class="card">
                                    <img class="card-img-top" src="<?php echo $producto['imagen']; ?>" alt="">
                                    <div class="card-body">
                                        <p class="card-text"><?php echo $producto['nombre']; ?></p>
                                        <a href="../inicio.php"><button class="btn btn-primary" type="button">Finalizar</button></a>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    </p>
                </div>

        </section>
    </main>
    <?php include 'templates/pie.php'; ?>