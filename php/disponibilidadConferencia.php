<?php
include('../SAC/Conexion.php');
$id_conferenciaGet = $_POST['conferencia'];
// INFORMACION DE LOS conferencias
$conferencia = $DB_con->prepare("SELECT * FROM conferencias WHERE id_conferencia = :uid3 LIMIT 1");
$conferencia->execute(array(':uid3' => $id_conferenciaGet));
while ($row = $conferencia->fetch(PDO::FETCH_OBJ)) {

    // CONTADOR DE ALUMNOS INSCRITOS AL conferencia
    $consulta2 = $DB_con->prepare('SELECT COUNT(*) AS cont FROM alumnos_conferencias WHERE id_conferencia =:uid');
    $consulta2->execute(array(':uid' => $row->id_conferencia));
    $contador = $consulta2->fetch(PDO::FETCH_ASSOC);
    extract($contador);

    if ($contador['cont'] >= $row->cupo_conferencia) {
        echo '<span class="price notfree">Completado</span>';
    } else {
        echo '<span class="price free">Disponible</span>';
    }
}
