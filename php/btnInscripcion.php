<?php
// Boquear el boton si el alumno esta inactivo
// Bloquear el boton si el alumno ya esta registrado en algun taller
include('../SAC/Conexion.php');

$_POST['taller']; //id_taller
$_POST['a'];  //id_user

// ============ FUNCION PARA BLOQUEAR EL BOTON SI ESTA LLENO =============
$Talleres = $DB_con->prepare("SELECT * FROM talleres WHERE id_taller = :uid3 LIMIT 1");
$Talleres->execute(array(':uid3' => $_POST['taller']));
while ($row2 = $Talleres->fetch(PDO::FETCH_OBJ)) {

    // CONTADOR DE ALUMNOS INSCRITOS AL TALLER
    $consulta2 = $DB_con->prepare('SELECT COUNT(*) AS cont FROM alumnos WHERE id_taller =:uid');
    $consulta2->execute(array(':uid' => $_POST['taller']));
    $contador = $consulta2->fetch(PDO::FETCH_ASSOC);
    extract($contador);
    $cuposT = $row2->cupo_taller;
}
// =========================================================================

//  INFORMACION DEL ALUMNO (solo para saber si el alumno esta activo y si esta en algun taller)
$datosAlumnos = $DB_con->prepare("SELECT * FROM alumnos WHERE id_user=:id_user");
$datosAlumnos->execute(array(':id_user' => $_POST['a']));
while ($row = $datosAlumnos->fetch(PDO::FETCH_OBJ)) {
    $estadoAlumno = $row->status_alumno;
    $taller = $row->id_taller;
}

if ($estadoAlumno == 0) { //Cuenta inactiva
    echo '<p style="color:red;">Realiza el pago correspondiente y espera a que el instructor active tu cuenta, para poder inscribirte.</p>';
}
if ($estadoAlumno == 1) { //Pagado
        if($contador['cont'] >= $cuposT){//Bloqurar el boton si esta lleno el taller
            // echo '<button type="submit" class="btn btn-default" style="cursor: pointer;" disabled="disabled">No disponible</button>';
            echo '';
        } else {//Alumno inscrito a un taller
            if ($taller == null) { //No tiene taller
                ?>
                        <form role="form" action="inscripcion.php" method="post" onsubmit="return confirmation()">
                            <input type="hidden" name="ta" value="<?php echo $_POST['taller']; ?>">
                            <input type="hidden" name="us" value="<?php echo $_POST['a']; ?>">
                            <button name="tallerP" type="submit" class="au-btn" style="cursor: pointer;">¡Inscríbete!</button>
                        </form>
                <?php }else {
                    echo '';
                } 
        }
} ?>