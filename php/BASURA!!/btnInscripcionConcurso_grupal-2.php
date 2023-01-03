<?php
// Boquear el boton si el alumno esta inactivo
// Bloquear el boton si el alumno ya esta registrado en algun concruso
include('../SAC/Conexion.php');

$_POST['concurso']; //id_concurso
$_POST['a'];  //id_user
// ============ FUNCION PARA BLOQUEAR EL BOTON SI ESTA LLENO =============
$concultaConcurso = $DB_con->prepare("SELECT * FROM concursos WHERE id_concurso = :uid3 LIMIT 1");
$concultaConcurso->execute(array(':uid3' => $_POST['concurso']));
while ($row2 = $concultaConcurso->fetch(PDO::FETCH_OBJ)) {

    // CONTADOR DE ALUMNOS INSCRITOS AL CONCURSO
    $consulta2 = $DB_con->prepare('SELECT COUNT(*) AS cont FROM alumnos WHERE id_concurso =:uid');
    $consulta2->execute(array(':uid' => $_POST['concurso']));
    $contador = $consulta2->fetch(PDO::FETCH_ASSOC);
    extract($contador);
    echo $cuposT = $row2->cupo_concurso;
    $modalidad = $row2->modalidad;

    // CONTADOR DE EQUIPOS REGISTRADOS AL CONCURSO
    $consulta3 = $DB_con->prepare('SELECT COUNT(*) AS contEqui FROM equipos WHERE id_concurso =:uid');
    $consulta3->execute(array(':uid' => $_POST['concurso']));
    $contadorEquipos = $consulta3->fetch(PDO::FETCH_ASSOC);
    extract($contadorEquipos);
    echo $contadorEquipos['contEqui'];
}
// =========================================================================

//  INFORMACION DEL ALUMNO (solo para saber si el alumno esta activo y si esta en algun CONCURSO)
$datosAlumnos = $DB_con->prepare("SELECT * FROM alumnos WHERE id_user=:id_user");
$datosAlumnos->execute(array(':id_user' => $_POST['a']));
while ($row = $datosAlumnos->fetch(PDO::FETCH_OBJ)) {
    $estadoAlumno = $row->status_alumno;
    $concurso = $row->id_concurso;
}

if ($estadoAlumno == 0) { //Cuenta inactiva
    echo '<p style="color:red;">Realiza el pago correspondiente y espera a que el instructor active su cuenta, para poder inscribirte.</p>';
}
if ($estadoAlumno == 1) { //Pagado
    if($contadorEquipos['contEqui'] < $cuposT){//contados de equipos MENOR a cupo_concurso
        // echo '<button type="submit" class="btn btn-default" style="cursor: pointer;" disabled="disabled">No disponible</button>';
        echo '';
    } else { //Alumno inscrito a un CONCURSO
        if ($concurso == null) { //ALUMNO No tiene CONCURSO
            if ($modalidad == 2) { // modalidad grupal
                    echo ' <button class="au-btn" data-toggle="modal" data-target="#exampleModalCenter" style="cursor: pointer;">Inscribir equipo</button>';
            } elseif ($modalidad == 1) { //modalidad individual
?>
                <form role="form" action="inscripcion.php" method="post">
                    <input type="hidden" name="ta" value="<?php echo $_POST['concurso']; ?>">
                    <input type="hidden" name="us" value="<?php echo $_POST['a']; ?>">
                    <button name="concursoP" type="submit" class="au-btn" style="cursor: pointer;">¡Inscríbete!</button>
                </form>
<?php } else {
                echo '';
            }
        } else {
            echo '';
        }
    }
} ?>