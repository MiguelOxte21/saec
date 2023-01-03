<?php
session_start();
$idAlumno = $_SESSION["id_alumno"];
if (!isset($_SESSION["id_alumno"]) || $_SESSION["id_alumno"] == null) {
    print "<script>window.location='index.php';</script>";
}
$id_conferencia = $_POST['conferencia']; //id_conferencia
$id_carrera = $_POST['c'];  //id_carrera

include('../SAC/Conexion.php');
$conferenciaInfo = $DB_con->prepare("SELECT * FROM conferencias WHERE id_conferencia  =:uid");
$conferenciaInfo->execute(array(':uid' => $id_conferencia));

while ($row = $conferenciaInfo->fetch(PDO::FETCH_OBJ)) {

    // CONTADOR DE ALUMNOS INSCRITOS A ESTA CONFERENCIA 
    $consulta2 = $DB_con->prepare('SELECT COUNT(*) AS cont FROM alumnos_conferencias WHERE id_conferencia =:uid');
    $consulta2->execute(array(':uid' => $id_conferencia));
    $contador = $consulta2->fetch(PDO::FETCH_ASSOC);
    extract($contador);

?>
    <div class="desc display-flex">
        <div class="comments-students"> <a class="comments"><i class="fas fa-user-graduate"></i><?php echo $contador['cont']; ?> alumnos de <b><?php echo $row->cupo_conferencia; ?></b></a>
        </div>
    <?php if ($contador['cont'] >= $row->cupo_conferencia) {
        echo '<span class="price notfree">Completado</span>';
    } else {
        echo '<span class="price free">Disponible</span>';
    }
} ?>


    </div>