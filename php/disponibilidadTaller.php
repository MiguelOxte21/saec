<?php
include('../SAC/Conexion.php');
$id_tallerGet = $_POST['taller'];
// INFORMACION DE LOS TALLERES
$Talleres = $DB_con->prepare("SELECT * FROM talleres WHERE id_taller = :uid3 LIMIT 1");
$Talleres->execute(array(':uid3' => $id_tallerGet));
while ($row = $Talleres->fetch(PDO::FETCH_OBJ)) {

    // CONTADOR DE ALUMNOS INSCRITOS AL TALLER
    $consulta2 = $DB_con->prepare('SELECT COUNT(*) AS cont FROM alumnos WHERE id_taller =:uid');
    $consulta2->execute(array(':uid' => $row->id_taller));
    $contador = $consulta2->fetch(PDO::FETCH_ASSOC);
    extract($contador);

    if ($contador['cont'] >= $row->cupo_taller) {
        echo '<span class="price notfree">Completado</span>';
    } else {
        echo '<span class="price free">Disponible</span>';
    }
}