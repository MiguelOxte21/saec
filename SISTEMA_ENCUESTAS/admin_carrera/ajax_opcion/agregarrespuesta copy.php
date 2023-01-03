<?php

if (isset($_POST['id_pregunta']) && isset($_POST['respuesta'])) {
    // Incluir archivo de conexión a base de datos
    include("../../conexion.php");

    // Obtener valores
    $id_pregunta     = $_POST['id_pregunta'];
    $valor 			 = $_POST['respuesta'];
    

    $query = "INSERT INTO opciones (id_pregunta, valr)
              VALUES ('$id_pregunta', '$valor')";

    $resultado = $con->query($query);




}
