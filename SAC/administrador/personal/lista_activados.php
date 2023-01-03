<?php
error_reporting(~E_NOTICE);
session_start();
if (!isset($_SESSION["id_administrador_carrera"]) || $_SESSION["id_administrador_carrera"] == null) {
    print "<script>window.location='../../../index.php';</script>";
}

require_once '../../Conexion.php';

//DATOS ADMIN (SABER LA CARRERA)
$consulta = $DB_con->prepare('SELECT * FROM admin_carreras WHERE id_user=:id_user');
$consulta->execute(array(':id_user' => $_SESSION["id_administrador_carrera"]));
$datosCarrera = $consulta->fetch(PDO::FETCH_ASSOC);
extract($datosCarrera);

?>
<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Matrícula</th>
            <th>Correo</th>
            <th>Semestre</th>
            <th>Status</th>
            <th>Comentarios</th>
            <th>Acciones</th>
            <th>Eliminar</th>

        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Nombre</th>
            <th>Matrícula</th>
            <th>Correo</th>
            <th>Semestre</th>
            <th>Status</th>
            <th>Comentarios</th>
            <th>Acciones</th>
            <th>Eliminar</th>
        </tr>
    </tfoot>
    <tbody>
        <?php
        // INFORMACION DE LOS CONCURSOS
        $Alumnos = $DB_con->prepare("SELECT transacciones.*, alumnos.*, ventas.* FROM `transacciones` inner JOIN ventas on transacciones.id_venta = ventas.id_venta inner JOIN alumnos on transacciones.id_alumno = alumnos.id_alumno WHERE ventas.status='completo' and alumnos.id_adminCarrera = :uid");
        $Alumnos->execute(array(':uid' => $datosCarrera["id_adminCarrera"]));
        while ($row = $Alumnos->fetch(PDO::FETCH_OBJ)) { ?>
            <tr>
                <td><?php echo $row->nombre_alumno  . ' ' . $row->apellido_alumno; ?></td>
                <td><?php echo $row->matricula; ?></td>
                <td><?php echo $row->correo_user; ?></td>
                <td><?php echo $row->semestre_grupo; ?></td>
                <td>
                    <?php
                    if ($row->status_alumno == 0) {
                        echo '<div class="badge badge-danger badge-pill">No activo</div>';
                    } elseif ($row->status_alumno == 1) {
                        echo '<div class="badge badge-success badge-pill">Activo</div>';
                    } else {
                        echo '<div class="badge badge-warning badge-pill">¡Error!</div>';
                    }
                    ?>

                </td>
                <td id="comentario_alumno" data-id_alumno="<?php echo $row->id_alumno; ?>" contenteditable><?php echo $row->comentarios; ?>
                </td>
                <td id="status_alumno" data-id_alumno="<?php echo $row->id_alumno; ?>">
                    <select class="form-control" onchange="selecion(this.value, <?php echo $row->id_alumno; ?>)">
                        <option value="">Status</option>
                        <option value="0">No activo</option>
                        <option value="1">Activar</option>
                    </select>
                </td>
                <td>
                    <a href="editar_alumno.php?id=<?php echo $row->id_alumno; ?>"> <button class="btn btn-datatable btn-icon btn-transparent-dark" id="editar_alumno"><i class="fas fa-edit"></i></button></a>

                    <button class="btn btn-datatable btn-icon btn-transparent-dark" id="eliminar_alumno" data-id="<?php echo $row->id_alumno; ?>"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script src="../../../plugins/admin/assets\demo\datatables-demo.js"></script>