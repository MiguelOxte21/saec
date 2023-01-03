<?php

$Localhost = 'localhost';
$Usuario_BD = 'root';
$Password_BD = '';
$Nombre_BD = 'congreso';

try{
  $DB_con = new PDO("mysql:host={$Localhost};dbname={$Nombre_BD};",$Usuario_BD,$Password_BD);
  $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // $conexion = new mysqli($Localhost,$Usuario_BD,$Password_BD,$Nombre_BD);
}
catch(PDOException $e){
  echo $e->getMessage();
}


$DB_con1= new mysqli('localhost','root', '', 'congreso');
if($DB_con1-> connect_error){
die ('no se pudo conectar a la base de datoas');
}
?>