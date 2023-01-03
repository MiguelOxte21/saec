<?php
error_reporting(~E_NOTICE);
session_start();
if (!isset($_SESSION["id_administrador_carrera"]) || $_SESSION["id_administrador_carrera"] == null) {
    print "<script>window.location='../../index.php';</script>";
}

require_once '../Conexion.php';

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
            <th>Clave</th>
            <th>Correo</th>
            <th>Status</th>
            <th>Acciones</th>
            <th>Eliminar</th>

        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Nombre</th>
            <th>Clave</th>
            <th>Correo</th>
            <th>Status</th>
            <th>Acciones</th>
            <th>Eliminar</th>
        </tr>
    </tfoot>
    <tbody>
        <?php
        // INFORMACION DE LOS CONCURSOS
        $Instructores = $DB_con->prepare("SELECT instructores.*, users.* FROM instructores INNER JOIN users ON instructores.id_user = users.id_user WHERE instructores.id_adminCarrera =:uid AND status_instructor=0 ORDER BY nombre_instructor ASC");
        $Instructores->execute(array(':uid' => $datosCarrera["id_adminCarrera"]));
        while ($row = $Instructores->fetch(PDO::FETCH_OBJ)) { ?>
            <tr>
                <td><?php echo $row->nombre_instructor  . ' ' . $row->apellido_instructor; ?></td>
                <td><?php echo $row->clave;?></td>
                <td><?php echo $row->correo_user; ?></td>
                <td>
                    <?php
                    if ($row->status_instructor == 0) {
                        echo '<div class="badge badge-danger badge-pill">No activo</div>';
                    }elseif($row->status_instructor == 1){
                        echo '<div class="badge badge-success badge-pill">Activo</div>';
                    }else{
                        echo '<div class="badge badge-warning badge-pill">¡Error!</div>';
                    }
                    ?>
                    
                </td>
                <td id="status_instructor" data-id_instructor="<?php echo $row->id_instructor; ?>">
                    <select class="form-control" onchange="selecion(this.value, <?php echo $row->id_instructor; ?>)">
                        <option value="">Status</option>
                        <option value="0">No activo</option>
                        <option value="1">Activar</option>
                    </select>
                </td>
                <td>
                    <button class="btn btn-datatable btn-icon btn-transparent-dark" id="eliminar_instructor" data-id="<?php echo $row->id_instructor; ?>"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script src="../plugins/admin/assets\demo\datatables-demo.js"></script>