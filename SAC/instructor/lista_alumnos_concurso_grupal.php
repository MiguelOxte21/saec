<?php
error_reporting(~E_NOTICE);
session_start();
if (!isset($_SESSION["id_instructor"]) || $_SESSION["id_instructor"] == null) {
    print "<script>window.location='../../index.php';</script>";
}

require_once '../Conexion.php';

// ID DEL INSTRUCTOR
$consultaIns0 = $DB_con->prepare('SELECT * FROM instructores WHERE id_user = :id_user');
$consultaIns0->execute(array(':id_user' => $_SESSION["id_instructor"]));
$datos = $consultaIns0->fetch(PDO::FETCH_ASSOC);
extract($datos);

// concurso
$consultaIns = $DB_con->prepare('SELECT * FROM concursos WHERE id_instructor = :id_instructor');
$consultaIns->execute(array(':id_instructor' => $datos["id_instructor"]));
$datos2 = $consultaIns->fetch(PDO::FETCH_ASSOC);
extract($datos2);
echo $datos["id_concurso"];

?>
<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Equipo</th>
            <th>Matricula</th>
            <th>Semestre y grupo</th>
            <th>Quitar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $consultaEquipo = $DB_con->prepare('SELECT * FROM equipos WHERE id_concurso=:id_concurso');
        $consultaEquipo->execute(array(':id_concurso' => $datos2["id_concurso"]));
        while ($datos3 = $consultaEquipo->fetch(PDO::FETCH_OBJ)) {
            // MOSTAR LISTA DE LOS ALUMNOS INSCRITOS AL CONCURSO
            $listaAlumno = $DB_con->prepare("SELECT alumnos.*, equipos.* FROM alumnos INNER JOIN equipos ON alumnos.id_equipo = equipos.id_equipo WHERE alumnos.id_equipo = :uidt ORDER BY equipos.nomEquipo ASC");
            $listaAlumno->execute(array(':uidt' => $datos3->id_equipo));
            while ($rowLista = $listaAlumno->fetch(PDO::FETCH_OBJ)) {
        ?>
                <tr>
                    
                    <td> <?php 
                    if ($rowLista->id_alumno == $datos3->id_jefe_equipo) {
                        echo $rowLista->nombre_alumno . ' ' . $rowLista->apellido_alumno .' <li class="fas fa-check" title="Jefe de equipo"></li>';
                    }else {
                        echo $rowLista->nombre_alumno . ' ' . $rowLista->apellido_alumno;
                    }
                    ?> </td>
                    <td> <?php echo $rowLista->nomEquipo; ?> </td>
                    <td> <?php echo $rowLista->matricula; ?> </td>
                    <td> <?php echo $rowLista->semestre_grupo; ?> </td>
                    <td>
                    <button class="btn btn-datatable btn-icon btn-transparent-dark" id="eliminar_g" data-id="<?php echo $rowLista->id_alumno; ?>" data-id_concurso="<?php echo $datos2["id_concurso"]; ?>"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
        <?php }
        }
        ?>
    </tbody>
</table>
<script src="../../plugins/admin/assets\demo\datatables-demo.js"></script>