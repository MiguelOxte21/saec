<?php
include('../SAC/Conexion.php');
$id_concursoGet = $_POST['concurso'];
// INFORMACION DE LOS CONCURSOS
$concultaConcursos = $DB_con->prepare("SELECT * FROM concursos WHERE id_concurso = :uid3 LIMIT 1");
$concultaConcursos->execute(array(':uid3' => $id_concursoGet));
while ($row = $concultaConcursos->fetch(PDO::FETCH_OBJ)) {

    // CONTADOR DE ALUMNOS INSCRITOS AL CONCURSO
    $consulta2 = $DB_con->prepare('SELECT COUNT(*) AS cont FROM alumnos WHERE id_concurso =:uid');
    $consulta2->execute(array(':uid' => $row->id_concurso));
    $contador = $consulta2->fetch(PDO::FETCH_ASSOC);
    extract($contador);

    $consulta3 = $DB_con->prepare('SELECT COUNT(*) AS contEquipos FROM equipos WHERE id_concurso =:uid');
    $consulta3->execute(array(':uid' => $row->id_concurso));
    $contadorEquipos = $consulta3->fetch(PDO::FETCH_ASSOC);
    extract($contadorEquipos);

    $contadorEquipos['contEquipos']; //total equipos
    if ($row->modalidad == 1) { //individual
        if ($contador['cont'] >= $row->cupo_concurso) {
            echo '<span class="price notfree">Completado</span>';
        } else {
            echo '<span class="price free">Disponible</span>';
        }
    } elseif ($row->modalidad == 2) { //grupal

        if ($contadorEquipos['contEquipos'] >= $row->cupo_concurso) {
            echo '<span class="price notfree">Completado</span>';
        } else {
            echo '<span class="price free">Disponible</span>';
        }
    } else {
    }
}
