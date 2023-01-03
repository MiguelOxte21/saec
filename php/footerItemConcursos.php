<?php
session_start();
$idAlumno = $_SESSION["id_alumno"];
if (!isset($_SESSION["id_alumno"]) || $_SESSION["id_alumno"] == null) {
    print "<script>window.location='index.php';</script>";
}
$id_concurso = $_POST['concurso']; //id_concurso
$id_carrera = $_POST['c'];  //id_carrera

include('../SAC/Conexion.php');
$consultaConcurso = $DB_con->prepare("SELECT * FROM concursos WHERE id_concurso  =:uid");
$consultaConcurso->execute(array(':uid' => $id_concurso));

while ($row = $consultaConcurso->fetch(PDO::FETCH_OBJ)) {

    // CONTADOR DE ALUMNOS INSCRITOS AL CONCURSO
    $consulta2 = $DB_con->prepare('SELECT COUNT(*) AS cont FROM alumnos WHERE id_concurso =:uid');
    $consulta2->execute(array(':uid' => $id_concurso));
    $contador = $consulta2->fetch(PDO::FETCH_ASSOC);
    extract($contador);

    $consulta3 = $DB_con->prepare('SELECT COUNT(*) AS contEquipos FROM equipos WHERE id_concurso =:uid');
    $consulta3->execute(array(':uid' => $id_concurso));
    $contadorEquipos = $consulta3->fetch(PDO::FETCH_ASSOC);
    extract($contadorEquipos);

    $contadorEquipos['contEquipos']; //total equipos
    if ($row->modalidad == 1) { //individual
?>
        <div class="desc display-flex">
            <div class="comments-students"> <a class="comments"><i class="fas fa-user-graduate"></i><?php echo $contador['cont']; ?> inscritos de <b><?php echo $row->cupo_concurso; ?></b></a>
            </div>
            <?php if ($contador['cont'] >= $row->cupo_concurso) {
                echo '<span class="price notfree">Completado</span>';
            } else {
                echo '<span class="price free">Disponible</span>';
            }
        } elseif ($row->modalidad == 2) { //grupal
            ?>
            <div class="desc display-flex">
                <div class="comments-students"> <a class="comments"><i class="fas fa-users"></i><?php echo $contadorEquipos['contEquipos']; ?> equipos de <b><?php echo $row->cupo_concurso; ?></b></a>
                </div>
        <?php
            if ($contadorEquipos['contEquipos'] >= $row->cupo_concurso) {
                echo '<span class="price notfree">Completado</span>';
            } else {
                echo '<span class="price free">Disponible</span>';
            }
        } else {
        }
    } ?>
            </div>