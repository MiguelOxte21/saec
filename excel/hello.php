
<?php

require '../SAC/Conexion.php';

if (isset($_POST['lista_taller'])) {
    $consultaIns = $DB_con->prepare('SELECT * FROM talleres WHERE id_taller = :id_taller');
    $consultaIns->execute(array(':id_taller' => $_POST["lista_taller"]));
    $datos = $consultaIns->fetch(PDO::FETCH_ASSOC);
    extract($datos);
    $nombre = $datos['nombre_taller'];
    $tipo = 'taller='.$datos["id_taller"].'&agrupar=nombre';
    
} 

header("content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("content-Disposition: attachment; filename=usuarios del taller.xlsx");

header('pragma: no-cache');
header('Expires: 0');
echo '<table border=1>';
    echo '<tr>';
        echo '<th colspan=4>reporte de Taller</th>';
    echo '</tr>';

    echo '<tr>';
        echo '<th>Nombre</th>';
        echo '<th>Apellido</th>';
        echo '<th>matricula</th>';
        echo '<th>semestre/grupo</th>';
        echo '<th>correo</th>';
    echo '</tr>';
    $listaAlumno = $DB_con->prepare("SELECT * FROM alumnos WHERE id_taller = :uidt");
    $listaAlumno->execute(array(':uidt' => $_POST['lista_taller']));
    while ($rowLista = $listaAlumno->fetch(PDO::FETCH_OBJ)) {
            echo '<tr>';

            echo '<td>'.$rowLista["nombre_alumno"].'</td>';
            echo '<td>'.$rowLista["apellido_alumno"].'</td>';
            echo '<td>'.$rowLista["matricula"].'</td>';
            echo '<td>'.$rowLista["semestre_grupo"].'</td>';
            echo '<td>'.$rowLista["correo_user"].'</td>';
            echo '</tr>';
    }
echo '</table>';     