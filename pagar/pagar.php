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

                if ($_POST) {
                    $total = 0;
                    $SID = session_id();
                    $Correo = $_POST['email'];

                    foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                        $total = $total + $producto['PRECIO'] * $producto['CANTIDAD'];
                    }

                    $sentencia = $DB_con->prepare("INSERT INTO `ventas` (`id_venta`, `clave_transaccion`, `paypal_datos`, `fecha`, `correo`, `total`, `status`) VALUES (NULL, :clave_transaccion, '', NOW(), :correo, :total, 'Pendiente')");
                    $sentencia->bindParam(":clave_transaccion", $SID);
                    $sentencia->bindParam(":correo", $Correo);
                    $sentencia->bindParam(":total", $total);
                    $sentencia->execute();
                    $idVenta = $DB_con->lastInsertId();
                    echo ($idalumno);
                    foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                        $sentencia = $DB_con->prepare("INSERT INTO `transacciones` (`id_transaccion`, `id_venta`, `id_producto`, `precio_unitario`, `cantidad`, `descargado`, `id_alumno`)
                        VALUES (NULL, :id_venta, :id_producto, :precio_unitario, :cantidad, '0', :id_alumno); 
                    ");
                        $sentencia->bindParam(":id_venta", $idVenta);
                        $sentencia->bindParam(":id_producto", $producto['ID']);
                        $sentencia->bindParam(":precio_unitario", $producto['PRECIO']);
                        $sentencia->bindParam(":cantidad", $producto['CANTIDAD']);
                        $sentencia->bindParam(":id_alumno", $id_alumno);
                        $sentencia->execute();
                    }

                    // echo '<h3>' . $total . '</h3>'
                };
                ?>

                <script src="https://www.paypalobjects.com/api/checkout.js"></script>

                <style>
                    /* Media query for mobile viewport */
                    @media screen and (max-width: 400px) {
                        #paypal-button-container {
                            width: 100%;
                        }
                    }

                    /* Media query for desktop viewport */
                    @media screen and (min-width: 400px) {
                        #paypal-button-container {
                            width: 250px;
                            display: inline-block;
                        }
                    }
                </style>

                <div class="jumbotron text-center">
                    <h1 class="display-4">¡Paso Final!</h1>
                    <hr class="my-4">
                    <p class="lead">Estas a punto de pagar con PayPal la cantidad de:
                    <h4>$<?php echo number_format($total, 2);
                            ?></h4>

                    <div id="paypal-button-container"></div>


                    </p>
                    <p>Su cuenta será activada inmediatamente una vez que se haya realizado su pago.</p>
                    <strong>Para aclaraciones contactar a: Administrador (congresosyeventosvalladolid@gmail.com)</strong>
                </div>



                <script>
                    paypal.Button.render({
                        env: 'sandbox', // sandbox | production
                        style: {
                            label: 'checkout', // checkout | credit | pay | buynow | generic
                            size: 'responsive', // small | medium | large | responsive
                            shape: 'pill', // pill | rect
                            color: 'gold' // gold | blue | silver | black
                        },

                        // PayPal Client IDs - replace with your own
                        // Create a PayPal app: https://developer.paypal.com/developer/applications/create

                        client: {
                            sandbox: 'AdKbqrIuWVYhaoIDjVBCqpJIdtok8A204eL_Kn-4iq1eRJ8x-373gFIxpBTwBqtyYl5PStlMtZh89I4f',
                            //production: 'AWlVkZH9-9sbXRzWLibzsqyMB-0PzvKTCHKSlhI6fPlObrVubDjF-Gei5RgTRbpH2veKMEsiv3rglioT'
                        },

                        // Wait for the PayPal button to be clicked

                        payment: function(data, actions) {
                            return actions.payment.create({
                                payment: {
                                    transactions: [{
                                        amount: {
                                            total: '<?php echo $total; ?>',
                                            currency: 'MXN'
                                        },
                                        description: "Compra de productos a Develoteca:$<?php //echo number_format($total, 2); 
                                                                                        ?>",
                                        custom: "<?php echo $SID;
                                                    ?>#<?php echo openssl_encrypt($idVenta, COD, KEY);
                                                        ?>"
                                    }]
                                }
                            });
                        },

                        // Wait for the payment to be authorized by the customer

                        onAuthorize: function(data, actions) {
                            return actions.payment.execute().then(function() {

                                console.log(data);
                                window.location = "verificador.php?paymentToken=" + data.paymentToken + "&paymentID=" + data.paymentID;
                            });
                        }

                    }, '#paypal-button-container');
                </script>

        </section>
    </main>
    <?php include 'templates/pie.php'; ?>