<?php
include('SAC/Conexion.php');
//NO se puede inscribir a carreras de otras carreras y de insctructores inactivos*****

// ============================
//      INSCRIBIR A TALLER
// ============================
if (isset($_POST['tallerP'])) {
    $id_taller = $_POST['ta']; //id_taller
    $id_user = $_POST['us']; //id_usuario

    // iniciar transacción
    $DB_con->beginTransaction();

    try {
        // tabla alumnos
        $sql = 'UPDATE alumnos 
                SET id_taller=:id_taller
                WHERE id_user=:uid';
        $result = $DB_con->prepare($sql);
        $result->bindValue(':id_taller', $id_taller, PDO::PARAM_INT);
        $result->bindValue(':uid', $id_user, PDO::PARAM_INT);
        $result->execute();

        $DB_con->commit();
        header("refresh:0;taller.php?i=$id_taller"); // redirects image view page after 5 seconds.
    } catch (PDOException $e) {
        // si ocurre un error hacemos rollback para anular todos los insert
        $DB_con->rollback();
        $e->getMessage();;
        echo "¡Error al realizar la operación!";
    }
}

if (isset($_POST['concursoP'])) {
    $id_concurso = $_POST['co']; //id_concurso
    $id_user = $_POST['us']; //id_usuario

    // iniciar transacción
    $DB_con->beginTransaction();

    try {
        // tabla alumnos
        $sql = 'UPDATE alumnos 
                SET id_concurso=:id_concurso
                WHERE id_user=:uid';
        $result = $DB_con->prepare($sql);
        $result->bindValue(':id_concurso', $id_concurso, PDO::PARAM_INT);
        $result->bindValue(':uid', $id_user, PDO::PARAM_INT);
        $result->execute();

        $DB_con->commit();
        header("refresh:0;concurso.php?i=$id_concurso"); // redirects image view page after 0 seconds.
    } catch (PDOException $e) {
        // si ocurre un error hacemos rollback para anular todos los insert
        $DB_con->rollback();
        $e->getMessage();;
        echo "¡Error al intentar inscribirte!";
    }
}

// =======================================
//      INSCRIBIR A CONCURSO GRUPAL
// =======================================
if (isset($_POST['concursoEquipos'])) {
    $_POST['maxAlum'];
    $id_concurso = $_POST['concurso'];
    $nomEquipo = $_POST['nomEquipo'];
    $id_jefe_equipo = $_POST['alumno1'];



    // iniciar transacción
    $DB_con->beginTransaction();

    try {
        // tabla equipos
        $sql = 'INSERT INTO equipos(nomEquipo,id_jefe_equipo,id_concurso) VALUES(:nomEquipo, :id_jefe_equipo, :id_concurso)';
        $result = $DB_con->prepare($sql);
        $result->bindValue(':nomEquipo', $nomEquipo, PDO::PARAM_STR);
        $result->bindValue(':id_jefe_equipo', $id_jefe_equipo, PDO::PARAM_INT);
        $result->bindValue(':id_concurso', $id_concurso, PDO::PARAM_INT);
        $result->execute();
        $lastId = $DB_con->lastInsertId();

        for ($i = 1; $i <= $_POST['maxAlum']; $i++) {
            $id_alumno = $_POST['alumno' . $i];
            // Tabla alumnos
            $sql = 'UPDATE alumnos 
                SET id_concurso=:id_concurso, id_equipo =:id_equipo
                WHERE id_alumno=:uid';
            $result = $DB_con->prepare($sql);
            $result->bindValue(':id_concurso', $id_concurso, PDO::PARAM_INT);
            $result->bindValue(':id_equipo', $lastId, PDO::PARAM_INT);
            $result->bindValue(':uid', $id_alumno, PDO::PARAM_INT);
            $result->execute();
        }

        $DB_con->commit();
    } catch (PDOException $e) {
        // si ocurre un error hacemos rollback para anular todos los insert
        $DB_con->rollback();
        $e->getMessage();;
        echo "¡Error al realizar la operación!";
    }

    header("refresh:0;concurso.php?i=$id_concurso"); // redirects image view page after 5 seconds.
}

// =======================================
//      INSCRIBIR A LA CONFERENCIA
// =======================================
if (isset($_POST['conferenciaP'])) {
    $id_conferencia = $_POST['co']; //id_conferencia
    $id_user = $_POST['us']; //id_usuario

    //  INFORMACION DEL ALUMNO (solo para saber si el alumno esta activo y su id)
    $datosAlumnos = $DB_con->prepare("SELECT * FROM alumnos WHERE id_user =:id_user");
    $datosAlumnos->execute(array(':id_user' => $id_user));
    while ($row = $datosAlumnos->fetch(PDO::FETCH_OBJ)) {
        $id_alumno = $row->id_alumno;
    }

    // iniciar transacción
    $DB_con->beginTransaction();

    try {
        // tabla alumnos
        $sql = 'INSERT INTO alumnos_conferencias(id_alumno,id_conferencia) VALUES(:id_alumno, :id_conferencia)';
        $result = $DB_con->prepare($sql);
        $result->bindValue(':id_alumno', $id_alumno, PDO::PARAM_INT);
        $result->bindValue(':id_conferencia', $id_conferencia, PDO::PARAM_INT);
        $result->execute();

        $DB_con->commit();
        header("refresh:0;conferencia.php?i=$id_conferencia"); // redirects image view page after 5 seconds.
    } catch (PDOException $e) {
        // si ocurre un error hacemos rollback para anular todos los insert
        $DB_con->rollback();
        $e->getMessage();;
        echo "¡Error al realizar la inscripción";
    }
}

// Si estan vacios, lo devolvemos hacia atras
if (!isset($_POST['tallerP']) && !isset($_POST['concursoP']) && !isset($_POST['concursoEquipos']) && !isset($_POST['conferenciaP'])) {
    print "<script>history.go(-1);</script>";
}