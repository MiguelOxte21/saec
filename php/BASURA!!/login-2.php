<?php

if(!empty($_POST)){
	if(isset($_POST["username"]) &&isset($_POST["password"])){
		if($_POST["username"]!=""&&$_POST["password"]!=""){
			include "../conexion.php";
			
			$user_id=null;
			$sql1= "select * from user where (username=\"$_POST[username]\" or email=\"$_POST[username]\") and password=\"$_POST[password]\" ";
			$query = $conexion->query($sql1);
			while ($r=$query->fetch_array()) {
				$user_id=$r["id_user"];
				$rol=$r["rol"];
				$username=$r["username"];
				break;
			}
			if($user_id==null){
				print "<script>alert(\"Acceso invalido.\");window.location='../index.php';</script>";
			}elseif($rol == 0){
				session_start();
				$_SESSION["user_id"]=$user_id;
				print "<script>window.location='../inicio.php';</script>";				
			}elseif($rol == 1 and $username=='admin'){
				session_start();
				$_SESSION["id_admin"]=1;
				print "<script>window.location='../admin/control/index.php';</script>";				
			}elseif($rol == 2 and $username=='Instructor'){
				session_start();
				$_SESSION["id_admin"]=$user_id;
				print "<script>window.location='../admin/control/index.php';</script>";				
			}
		}
	}
}



?>