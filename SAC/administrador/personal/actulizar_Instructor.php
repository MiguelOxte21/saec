<?php
include('../../Conexion.php');
    
$_POST['id']; //id del instructor
$_POST['texto']; //comentario o  status
$_POST['columna'];
$nulo = null;

if ($_POST['columna'] == "status") {
  
    $consulta = $DB_con->prepare('UPDATE instructores SET status_instructor =:texto WHERE id_instructor =:id_instructor');
    $consulta->execute(array(':texto' =>$_POST['texto'], ':id_instructor' =>$_POST['id']));

}elseif ($_POST['columna'] == "eliminar") {
    //CONFERENCIAS 
    $consulta2 = $DB_con->prepare('DELETE conferencias.*, alumnos_conferencias.* FROM conferencias INNER JOIN alumnos_conferencias ON conferencias.id_conferencia = alumnos_conferencias.id_conferencia WHERE conferencias.id_instructor =:id_instructor');
    $consulta2->execute(array(':id_instructor' =>$_POST['id']));

    // CONCURSOS
    $consulta4 = $DB_con->prepare('DELETE concursos.*, equipos.* FROM concursos INNER JOIN equipos ON concursos.id_concurso = equipos.id_concurso WHERE concursos.id_instructor = :id_instructor');
    $consulta4->execute(array(':id_instructor' =>$_POST['id']));
    $lastId4 = $DB_con->lastInsertId();

    // TALLERES
    $consulta6 = $DB_con->prepare('DELETE FROM talleres WHERE id_instructor =:id_instructor');
    $consulta6->execute(array(':id_instructor' =>$_POST['id']));
    $lastId6 = $DB_con->lastInsertId();

    // ALUMNOS
    $consulta6 = $DB_con->prepare('UPDATE alumnos SET id_taller =:nulo WHERE id_taller =:id_taller');
    $consulta6->execute(array(':nulo' => $nulo, ':id_taller' =>$lastId6));

    $consulta7 = $DB_con->prepare('UPDATE alumnos SET id_concurso =:nulo WHERE id_concurso =:id_concurso');
    $consulta7->execute(array(':nulo' => $nulo, ':id_concurso' =>$lastId4));
   

    $consulta = $DB_con->prepare('DELETE instructores.*, users.* FROM instructores INNER JOIN users ON instructores.id_user= users.id_user WHERE instructores.id_instructor =:id_instructor');
    $consulta->execute(array(':id_instructor' =>$_POST['id']));
    // echo $e->getMessage();;
     
}
// echo 'Actulizado';
