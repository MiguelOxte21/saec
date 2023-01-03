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
$datos2 = $consultaIns0->fetch(PDO::FETCH_ASSOC);
extract($datos2);

//CONFERENCIA DEL INSTRUCTOR
$consultaIns3 = $DB_con->prepare('SELECT * FROM conferencias WHERE id_instructor = :id_instructor');
$consultaIns3->execute(array(':id_instructor' => $datos2["id_instructor"]));
$datos = $consultaIns3->fetch(PDO::FETCH_ASSOC);
extract($datos);
?>
<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Matricula</th>
            <th>Semestre y grupo</th>
            <th>Quitar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // MOSTAR LISTA DE LOS ALUMNOS INSCRITOS A LA CONFERENCIA
        $listaAlumno = $DB_con->prepare("SELECT alumnos.*, alumnos_conferencias.* FROM alumnos INNER JOIN alumnos_conferencias ON alumnos.id_alumno = alumnos_conferencias.id_alumno WHERE alumnos_conferencias.id_conferencia = :uidt");
        $listaAlumno->execute(array(':uidt' => $datos['id_conferencia']));
        while ($rowLista = $listaAlumno->fetch(PDO::FETCH_OBJ)) {
        ?>
            <tr>
                <td> <?php echo $rowLista->nombre_alumno . ' ' . $rowLista->apellido_alumno; ?> </td>
                <td> <?php echo $rowLista->matricula; ?> </td>
                <td> <?php echo $rowLista->semestre_grupo; ?> </td>
                <td>
                    <button class="btn btn-datatable btn-icon btn-transparent-dark" id="eliminar_conf" data-id="<?php echo $rowLista->id_alumno; ?>"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        <?php }  ?>
    </tbody>
</table>
<script src="../../plugins/admin/assets\demo\datatables-demo.js"></script>