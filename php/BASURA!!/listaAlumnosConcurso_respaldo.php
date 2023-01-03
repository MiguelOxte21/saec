<?php
session_start();
$idAlumno = $_SESSION["id_alumno"];
if (!isset($_SESSION["id_alumno"]) || $_SESSION["id_alumno"] == null) {
    print "<script>window.location='index.php';</script>";
}
$id_concursoPost = $_POST['concurso'];
$_POST['cupo'];
include('../SAC/Conexion.php');

// CUPO DEL CONCURSO
$cupoConcurso = $DB_con->prepare("SELECT * FROM concursos WHERE id_concurso = :uidt");
$cupoConcurso->execute(array(':uidt' => $id_concursoPost));
?>

<div class="card-header" id="headingcurriculumOne">
    <div class="title" data-toggle="collapse" data-target="#curriculumOne" aria-expanded="true" aria-controls="curriculumOne" role="button">
        Alumnos inscritos a este concurso
    </div>
    <span><?php echo $_SESSION["contInscritos"]; echo ' / '; echo $_POST['cupo'];?></span>
</div>

<div id="curriculumOne" class="collapse show" aria-labelledby="headingcurriculumOne" data-parent="#curriculum-content">
    <div class="card-body content">
        <ul>
            <?php
            $_SESSION["contInscritos"] = 0;
            // MOSTAR LISTA DE LOS ALUMNOS INSCRITOS 
            $listaAlumno = $DB_con->prepare("SELECT * FROM alumnos WHERE id_concurso = :uidt");
            $listaAlumno->execute(array(':uidt' => $id_concursoPost));

            while ($rowLista = $listaAlumno->fetch(PDO::FETCH_OBJ)) {

                // CONTADOR DE ALUMNOS INSCRITOS A ESTE CONCURSO
                $consulta2 = $DB_con->prepare('SELECT COUNT(*) AS cont FROM alumnos WHERE id_concurso =:uid');
                $consulta2->execute(array(':uid' => $rowLista->id_concurso));
                $contador = $consulta2->fetch(PDO::FETCH_ASSOC);
                extract($contador);
                $_SESSION["contInscritos"] =  $contador['cont'];

            ?>
                <li class="display-flex">
                    <a><span><i class="fas fa-user"></i><?php echo $rowLista->nombre_alumno;
                                                        echo ' ';
                                                        echo $rowLista->apellido_alumno; ?></span>
                    </a><span class="lesson-time"><i class="far fa-"><?php echo $rowLista->semestre_grupo; ?></i></span>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>