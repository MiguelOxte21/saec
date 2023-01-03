<?php
include('../../Conexion.php');
    
$_POST['id']; //id del alumno
$_POST['texto']; //comentario o  status
$_POST['columna'];

//Actualizamos la tabla
if ($_POST['columna'] == "comentarios") {

    $consulta = $DB_con->prepare('UPDATE alumnos SET comentarios =:texto WHERE id_alumno =:id_alumno');
    $consulta->execute(array(':texto' =>$_POST['texto'], ':id_alumno' =>$_POST['id']));

}elseif ($_POST['columna'] == "status") {
  
    $consulta = $DB_con->prepare('UPDATE alumnos SET status_alumno =:texto WHERE id_alumno =:id_alumno');
    $consulta->execute(array(':texto' =>$_POST['texto'], ':id_alumno' =>$_POST['id']));

}elseif ($_POST['columna'] == "eliminar") {

    $consulta2 = $DB_con->prepare('DELETE FROM alumnos_conferencias WHERE id_alumno =:id_alumno');
    $consulta2->execute(array(':id_alumno' =>$_POST['id']));

    $consulta = $DB_con->prepare('DELETE alumnos.*, users.* FROM alumnos INNER JOIN users ON alumnos.id_user= users.id_user WHERE alumnos.id_alumno =:id_alumno');
    $consulta->execute(array(':id_alumno' =>$_POST['id']));
    // echo "eliminado" ; 
}
echo 'Actulizado';
