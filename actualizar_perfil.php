<?php
session_start();
$idUser = $_SESSION["id_alumno"];
if (!isset($_SESSION["id_alumno"]) || $_SESSION["id_alumno"] == null) {
    print "<script>window.location='index.php';</script>";
}
include("SAC/Conexion.php");

if (isset($_POST['perfil'])) {
$vacio = "";
    if ($_POST['password'] == $vacio) {
        // Sin contraseña
        $_POST['nombres'];
        $_POST['apellidos'];
        $_POST['matricula'];
        $_POST['semestre_grupo'];

        $_POST['email'];

        // iniciar transacción
        $DB_con->beginTransaction();

        try {
        // tabla users
        $sql = 'UPDATE users SET correo_user=:correo_user WHERE id_user=:id_user';
        $result = $DB_con->prepare($sql);
        $result->bindValue(':correo_user', $_POST['email'], PDO::PARAM_STR);
        $result->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        $result->execute();

        // tabla alumnos
        $sql = 'UPDATE alumnos SET nombre_alumno=:nombre_alumno, apellido_alumno=:apellido_alumno, matricula=:matricula, semestre_grupo=:semestre_grupo WHERE id_user=:id_user';
        $result = $DB_con->prepare($sql);
        $result->bindValue(':nombre_alumno', $_POST['nombres'], PDO::PARAM_STR);
        $result->bindValue(':apellido_alumno', $_POST['apellidos'], PDO::PARAM_STR);
        $result->bindValue(':matricula', $_POST['matricula'], PDO::PARAM_STR);
        $result->bindValue(':semestre_grupo', $_POST['semestre_grupo'], PDO::PARAM_STR);
        $result->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        $result->execute();
        
        $DB_con->commit();
        // echo 'Datos insertados';
        header("refresh:0;perfil.php");
        } catch (PDOException $e) {
        // si ocurre un error hacemos rollback para anular todos los insert
        $DB_con->rollback();
        $e->getMessage();;
        echo "¡Error al intentar actualizar su información! Compruebe que sus datos sean los correctos, o no esten duplicados";
        header("refresh:5;perfil.php");
        }

    }else {
        // Con contraseña
        $_POST['nombres'];
        $_POST['apellidos'];
        $_POST['matricula'];
        $_POST['semestre_grupo'];
        
        $_POST['email'];
        $pass = $_POST['password'];
        $password = password_hash($pass, PASSWORD_DEFAULT, array("cost"=>15));


        // iniciar transacción
        $DB_con->beginTransaction();

        try {
        // tabla users
        $sql = 'UPDATE users SET correo_user=:correo_user, password=:password WHERE id_user=:id_user';
        $result = $DB_con->prepare($sql);
        $result->bindValue(':correo_user', $_POST['email'], PDO::PARAM_STR);
        $result->bindValue(':password', $password, PDO::PARAM_STR);
        $result->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        $result->execute();

        // tabla alumnos
        $sql = 'UPDATE alumnos SET nombre_alumno=:nombre_alumno, apellido_alumno=:apellido_alumno, matricula=:matricula, semestre_grupo=:semestre_grupo WHERE id_user=:id_user';
        $result = $DB_con->prepare($sql);
        $result->bindValue(':nombre_alumno', $_POST['nombres'], PDO::PARAM_STR);
        $result->bindValue(':apellido_alumno', $_POST['apellidos'], PDO::PARAM_STR);
        $result->bindValue(':matricula', $_POST['matricula'], PDO::PARAM_STR);
        $result->bindValue(':semestre_grupo', $_POST['semestre_grupo'], PDO::PARAM_STR);
        $result->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        $result->execute();
        
        $DB_con->commit();
        // echo 'Datos insertados';
        header("refresh:0;perfil.php");
        } catch (PDOException $e) {
        // si ocurre un error hacemos rollback para anular todos los insert
        $DB_con->rollback();
        $e->getMessage();;
        echo "¡Error al intentar actualizar su información! Compruebe que sus datos sean los correctos, o no esten duplicados";
        header("refresh:5;perfil.php");

        }
    }
}
