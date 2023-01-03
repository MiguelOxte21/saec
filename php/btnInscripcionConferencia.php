<?php
// Boquear el boton si el alumno esta inactivo
// Bloquear el boton si el alumno ya esta registrado en algun conferencia
include('../SAC/Conexion.php');

$_POST['conferencia']; //id_conferencia
$_POST['a'];  //id_user

// ============ FUNCION PARA BLOQUEAR EL BOTON SI ESTA LLENO =============
$conferencia12 = $DB_con->prepare("SELECT * FROM conferencias WHERE id_conferencia = :uid3 LIMIT 1");
$conferencia12->execute(array(':uid3' => $_POST['conferencia']));
while ($row2 = $conferencia12->fetch(PDO::FETCH_OBJ)) {

    // CONTADOR DE ALUMNOS INSCRITOS AL conferencia
    $consulta2 = $DB_con->prepare('SELECT COUNT(*) AS cont FROM alumnos_conferencias WHERE id_conferencia =:uid');
    $consulta2->execute(array(':uid' => $_POST['conferencia']));
    $contador = $consulta2->fetch(PDO::FETCH_ASSOC);
    extract($contador);
    $cuposT = $row2->cupo_conferencia;
}
// =========================================================================

//  INFORMACION DEL ALUMNO (solo para saber si el alumno esta activo y su id)
$datosAlumnos = $DB_con->prepare("SELECT * FROM alumnos WHERE id_user =:id_user");
$datosAlumnos->execute(array(':id_user' => $_POST['a']));
while ($row = $datosAlumnos->fetch(PDO::FETCH_OBJ)) {
    $estadoAlumno = $row->status_alumno;
    $id_alumno = $row->id_alumno;
}

//  alumnos_conferencias
$conferencia = 0;
$datosAlumnos2 = $DB_con->prepare("SELECT * FROM alumnos_conferencias WHERE id_alumno =:id_alumno AND id_conferencia =:id_conferencia");
$datosAlumnos2->execute(array(':id_alumno' => $id_alumno, ':id_conferencia' => $_POST['conferencia']));
while ($row3 = $datosAlumnos2->fetch(PDO::FETCH_OBJ)) {
    $conferencia = $row3->id_conferencia;
}

if ($estadoAlumno == 0) { //Cuenta inactiva
    echo '<p style="color:red;">Realiza el pago correspondiente y espera a que el instructor active tu cuenta, para poder inscribirte.</p>';
}
if ($estadoAlumno == 1) { //Pagado
    if ($contador['cont'] >= $cuposT) { //Bloqurar el boton si esta lleno el conferencia
        // echo '<button type="submit" class="btn btn-default" style="cursor: pointer;" disabled="disabled">No disponible</button>';
        echo '';
    } else { //Alumno inscrito a un conferencia
        if ($conferencia != 0) {
            // NO MOSTRAR EL BOTON SI ESTA INSCRITO A ESTA CONFERENCIA
            // echo 'estas inscrito aqui';
        } else {
?>
            <form role="form" action="inscripcion.php" method="post" onsubmit="return confirmation()">
                <input type="hidden" name="co" value="<?php echo $_POST['conferencia']; ?>">
                <input type="hidden" name="us" value="<?php echo $_POST['a']; ?>">
                <button name="conferenciaP" type="submit" class="au-btn" style="cursor: pointer;">¡Inscríbete!</button>
            </form>
<?php
        }
    }
} ?>