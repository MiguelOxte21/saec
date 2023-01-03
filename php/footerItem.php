<?php
session_start();

$id_taller = $_POST['taller']; //id_taller
$id_carrera = $_POST['c'];  //id_carrera

include('../SAC/Conexion.php');
$Talleres = $DB_con->prepare("SELECT * FROM talleres WHERE id_taller  =:uid");
$Talleres->execute(array(':uid' => $id_taller));

while ($row = $Talleres->fetch(PDO::FETCH_OBJ)) {

    // CONTADOR DE ALUMNOS INSCRITOS AL TALLER
    $consulta2 = $DB_con->prepare('SELECT COUNT(*) AS cont FROM alumnos WHERE id_taller =:uid');
    $consulta2->execute(array(':uid' => $id_taller));
    $contador = $consulta2->fetch(PDO::FETCH_ASSOC);
    extract($contador);

?>
    <div class="desc display-flex">
        <div class="comments-students"> <a class="comments"><i class="fas fa-user-graduate"></i> <?php echo $contador['cont']; ?> alumnos de <b><?php echo $row->cupo_taller; ?></b></a>
        </div>
    <?php if ($contador['cont'] >= $row->cupo_taller) {
        echo '<span class="price notfree">Completado</span>';
    } else {
        echo '<span class="price free">Disponible</span>';
    }
} ?>


    </div>