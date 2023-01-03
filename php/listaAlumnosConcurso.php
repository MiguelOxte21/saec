<?php
session_start();
if (!isset($_SESSION["id_alumno"]) || $_SESSION["id_alumno"] == null) {
    // print "<script>window.location='index.php';</script>";
}
$idEquipo = null;
$id_concursoPost = $_POST['concurso'];
$_POST['cupo'];
include('../SAC/Conexion.php');
?>
<?php
// INFORMACION DEL EQUIPO
$concultaConcurso2 = $DB_con->prepare("SELECT * FROM equipos WHERE id_concurso =:uid");
$concultaConcurso2->execute(array(':uid' => $id_concursoPost));
while ($rowC = $concultaConcurso2->fetch(PDO::FETCH_OBJ)) {
    $idEquipo = $rowC->id_equipo;
    $id_jefe_equipo = $rowC->id_jefe_equipo;
?>

    <div class="card-header" id="headingcurriculumOne">
        <div class="title" data-toggle="collapse" data-target="#curriculumOne" aria-expanded="true" aria-controls="curriculumOne" role="button">
            <?php echo $rowC->nomEquipo; ?>
        </div>
    </div>
    <?php
    // INFORMACION DE LOS ALUMNO DE ESTE EQUIPO
    $concultaConcurso = $DB_con->prepare("SELECT * FROM alumnos  WHERE id_concurso =:uid AND id_equipo =:id_equipo");
    $concultaConcurso->execute(array(':uid' => $id_concursoPost, ':id_equipo' => $idEquipo));
    while ($rowT = $concultaConcurso->fetch(PDO::FETCH_OBJ)) {
    ?>
        <div id="curriculumOne" class="collapse show" aria-labelledby="headingcurriculumOne" data-parent="#curriculum-content">
            <div class="card-body content">
                <ul>
                    <li class="display-flex">
                        <a>

                            <?php
                            if ($rowT->id_alumno == $id_jefe_equipo) {
                                echo '<span title="Jefe de equipo">
                        <i class="fas fa-user"></i>';
                                echo $rowT->nombre_alumno . ' ' . $rowT->apellido_alumno;
                                echo '</span>';
                            } else {
                                echo '<span>
                        <i class="fas fa-user"></i>';
                                echo $rowT->nombre_alumno . ' ' . $rowT->apellido_alumno;
                                echo '
                    </span>';
                            }
                            ?>
                        </a><span class="lesson-time"><i><?php echo $rowT->semestre_grupo; ?></i></span>
                    </li>
            </div>
        </div>

<?php }
    echo '<br> <br>';
} ?>