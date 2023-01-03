<?php
include("../../Conexion.php");
$id = $_POST["id"];
$nulo = null;

// ACTULIZAR ALUMNOS INCRITOS
if ($_POST["lista"] == "taller") {

    $upAlumnos = $DB_con->prepare('UPDATE alumnos SET id_taller=:nulo WHERE id_alumno =:uid');
    $upAlumnos->execute(array(':nulo' => $nulo, ':uid' => $id));
} elseif ($_POST["lista"] == "concurso") {

    $upAlumnos2 = $DB_con->prepare('UPDATE alumnos SET id_concurso=:nulo WHERE id_alumno =:uid2');
    $upAlumnos2->execute(array(':nulo' => $nulo, ':uid2' => $id));
} elseif ($_POST["lista"] == "concurso_grupal") {

    $id_concurso = $_POST["id_concurso"];
    // SI EL ALUMNO ES JEFE DE EQUIPO TENDRA QUE SER ELIMINADO TODO LO RELACIONADO
    $upAlumnos4 = $DB_con->prepare('UPDATE alumnos SET id_concurso=:nulo, id_equipo=:nulo WHERE id_alumno =:uid3');
    $upAlumnos4->execute(array(':nulo' => $nulo, ':uid3' => $id));

} elseif ($_POST["lista"] == "conferencia") {

    $eliminarConf = $DB_con->prepare('DELETE FROM alumnos_conferencias WHERE id_alumno=:uid4');
    $eliminarConf->execute(array(':uid4' => $id));
}
