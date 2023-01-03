<?php
include("SAC/Conexion.php");
try {

   if (isset($_POST["login"])) {
      if (empty($_POST["usuario"]) || empty($_POST["password"]) ||  empty($_POST["c"])) {
         $errMSG = 'Todos los campos son requeridos';
         $errMSG = 'Todos los campos son requeridos';
         print "<script>window.location='index.php';</script>";
      } else {
         $nombre = htmlentities(addslashes($_POST['usuario']));
         $clave = htmlentities(addslashes($_POST['password']));
         $carrera = htmlentities(addslashes($_POST['c']));

         //consulta SQL - Buscamos el usuario
         $id_user = 0;
         $sql = "SELECT * FROM users WHERE correo_user = :nombre";
         $resultado = $DB_con->prepare($sql);
         $resultado->execute(array(":nombre" => $nombre));

         // Verificamos el Password
         while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {

            if (password_verify($clave, $registro['password'])) {
               $id_user = $registro['id_user'];
               $id_rol = $registro['id_rol'];
            } else {
               print "<script>window.location='dangerlogin.php';</script>";

            }
         }
         // Redireccionamiento
         if ($id_user == 0) {
            print "<script>window.location='dangerlogin.php';</script>";
         } elseif ($id_rol == 1) {
            session_start();
            $_SESSION["id_administrador_general"] = $id_user;
            print "<script>window.location='SAC/administrador_general/index.php';</script>";
         } elseif ($id_rol == 2) {
            session_start();
            $_SESSION["id_administrador_carrera"] = $id_user;
            print "<script>window.location='SAC/administrador/index.php';</script>";
         } elseif ($id_rol == 3) {
            session_start();
            $_SESSION["id_instructor"] = $id_user;
            print "<script>window.location='SAC/instructor/index.php';</script>";
         } elseif ($id_rol == 4) {
            session_start();
            $_SESSION["id_alumno"] = $id_user;
            print "<script>window.location='inicio.php';</script>";
         }
       

      }
   } else {
      print "<script>window.location='index.php';</script>";
   }

   //cierro la conexion
   $conexion = null;
} catch (Exception $e) {
   die($e->getMessage());
   echo "Error!, Por favor contacte a soporte";
}
