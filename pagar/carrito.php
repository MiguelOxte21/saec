<?php
session_start();
$mensaje = "";


if (isset($_POST['btnAccion'])) {
    switch ($_POST['btnAccion']) {
        case 'Agregar':

            if (is_numeric(openssl_decrypt($_POST['id_producto'], COD, KEY))) {
                $ID = openssl_decrypt($_POST['id_producto'], COD, KEY);
                $mensaje .= "ID Correcto... " . $ID . "<br/>";
            } else {
                $mensaje .= "Ocurrió algo le sugerimos cerrar su sesión y volver a seleccionar el pago." . $ID . "<br/>";
            }


            if (is_string(openssl_decrypt($_POST['nombre'], COD, KEY))) {
                $NOMBRE = openssl_decrypt($_POST['nombre'], COD, KEY);
                $mensaje .= "Nombre " . $NOMBRE . "<br/>";
            } else {
                $mensaje .= "Upss... Algo paso con tu nombre" . $NOMBRE . "<br/>";
            }


            if (is_numeric(openssl_decrypt($_POST['cantidad'], COD, KEY))) {
                $CANTIDAD = openssl_decrypt($_POST['cantidad'], COD, KEY);
                $mensaje .= "Cantidad " . $CANTIDAD . "<br/>";
            } else {
                $mensaje .= "Upss... Algo paso con la cantidad" . $CANTIDAD . "<br/>";
            }


            if (is_numeric(openssl_decrypt($_POST['precio'], COD, KEY))) {
                $PRECIO = openssl_decrypt($_POST['precio'], COD, KEY);
                $mensaje .= "El precio es... " . $PRECIO . "<br/>";
            } else {
                $mensaje .= "Upss... Algo paso con el precio" . $PRECIO . "<br/>";
            }
            if (!isset($_SESSION['CARRITO'])) {
                $producto = array(
                    'ID' => $ID,
                    'NOMBRE' => $NOMBRE,
                    'CANTIDAD' => $CANTIDAD,
                    'PRECIO' => $PRECIO,
                );
                $_SESSION['CARRITO'][0] = $producto;
                $mensaje = "Se ha seleccionado correctamente.";
            } else {
                $idProductos = array_column($_SESSION['CARRITO'], "ID");

                if (in_array($ID, $idProductos)) {
                    echo "<script>alert('El producto ha sido seleccionado...')</script>";
                    $mensaje = "";
                } else {
                    $NumeroProductos = count($_SESSION['CARRITO']);
                    $producto = array(
                        'ID' => $ID,
                        'NOMBRE' => $NOMBRE,
                        'CANTIDAD' => $CANTIDAD,
                        'PRECIO' => $PRECIO,
                    );
                    $_SESSION['CARRITO'][$NumeroProductos] = $producto;
                    $mensaje = "Se ha seleccionado correctamente.";
                }
            }
            //$mensaje = print_r($_SESSION, true);

            break;
        case "Eliminar":
            if (is_numeric(openssl_decrypt($_POST['id'], COD, KEY))) {
                $ID = openssl_decrypt($_POST['id'], COD, KEY);
                foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                    if ($producto['ID'] == $ID) {
                        unset($_SESSION['CARRITO'][$indice]);
                        echo "<script>alert('Elemento borrado...')</script>";
                    }
                }
            } else {
                $mensaje .= "Upss... ID Incorrecto" . $ID . "<br/>";
            }
            break;
    }
}
