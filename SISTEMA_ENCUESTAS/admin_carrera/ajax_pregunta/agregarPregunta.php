<?php

if (isset($_POST['id_encuesta']) && isset($_POST['titulo']) && isset($_POST['id_tipo_pregunta'])) {
    // Incluir archivo de conexión a base de datos
    include("../../conexion.php");

    // Obtener valores
    $id_encuesta 		= $_POST['id_encuesta'];
    $titulo     		= $_POST['titulo'];
    $id_tipo_pregunta 	= $_POST['id_tipo_pregunta'];
if  ($id_tipo_pregunta == 1){
    $query = "INSERT INTO preguntas (id_encuesta, titulo, id_tipo_pregunta)
              VALUES ('$id_encuesta', '$titulo', '$id_tipo_pregunta')";

    $resultado = $con->query($query);
}else if($id_tipo_pregunta==2){
    $query = "INSERT INTO preguntas (id_encuesta, titulo, id_tipo_pregunta)
              VALUES ('$id_encuesta', '$titulo', '$id_tipo_pregunta')";

    $resultado = $con->query($query);
}

}
