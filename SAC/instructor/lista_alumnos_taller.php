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

//TALLER DEL INSTRUCTOR
if (isset($_POST['lista_taller'])) {
    $consultaIns = $DB_con->prepare('SELECT * FROM talleres WHERE id_instructor = :id_instructor');
    $consultaIns->execute(array(':id_instructor' => $datos["id_instructor"]));
    $datos2 = $consultaIns->fetch(PDO::FETCH_ASSOC);
    extract($datos2);
}
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
        // MOSTAR LISTA DE LOS ALUMNOS INSCRITOS AL TALLER
        $listaAlumno = $DB_con->prepare("SELECT * FROM alumnos WHERE id_taller = :uidt");
        $listaAlumno->execute(array(':uidt' => $datos2['id_taller']));
        while ($rowLista = $listaAlumno->fetch(PDO::FETCH_OBJ)) {
        ?>
            <tr>
                <td> <?php echo $rowLista->nombre_alumno . ' ' . $rowLista->apellido_alumno; ?> </td>
                <td> <?php echo $rowLista->matricula; ?> </td>
                <td> <?php echo $rowLista->semestre_grupo; ?> </td>
                <td>
                    <button class="btn btn-datatable btn-icon btn-transparent-dark" id="eliminar_t" data-id="<?php echo $rowLista->id_alumno; ?>"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        <?php }  ?>
    </tbody>
</table>
<script src="../../plugins/admin/assets\demo\datatables-demo.js"></script>
