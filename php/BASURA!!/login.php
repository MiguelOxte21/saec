<?php
echo $email = $_POST["email"];
echo '<br>';
echo $pass = $_POST["password"];
$comillas1 = "'";
$comillas2 = "'";

include "../conexion.php";
$sentecia="SELECT * FROM user where email = '$email' LIMIT 1";

$resultado= $conexion->query($sentecia) or die (mysqli_error($conexion));
while($fila=$resultado->fetch_assoc())
{
	echo '<br>';
	echo '<br>';
	echo $usuario=$fila['email'];
	echo '<br>';	
	echo $hash1=$comillas1. $fila['password']. $comillas2;	
	echo '<br>';	
	echo $hash= '$2y$10$O/2T71Pt1ZISn9BHm9pG4.5Kc9YtAqZL8A6bpqrGvIFftQ6BTWoGC';
	echo '<br>';	
	echo '<br>';	
	
	if (password_verify('omar', $hash)) {
		    echo '¡La contraseña es válida!';
		} else {
		    echo 'La contraseña no es válida.';
		}

	}




// Ver el ejemplo de password_hash() para ver de dónde viene este hash.
// $hash = '$2y$10$Ek.5PAO3mr5lguP5kOTR2uSp7uuytdXLdL6RpkQKRGPp1iyxQrtIC';


// if (password_verify('jesus', $hash)) {
//     echo '¡La contraseña es válida!';
// } else {
//     echo 'La contraseña no es válida.';
// }
?>

<?php

// if(!empty($_POST)){
// 	if(isset($_POST["email"]) &&isset($_POST["password"])){
// 		if($_POST["email"]!=""&&$_POST["password"]!=""){
// 			include "conexion.php";
// 			$user_id=null;
// 			$sql1= "select * from user where (email=\"$_POST[email]\" or email=\"$_POST[email]\") and password=\"$_POST[password]\" ";
// 			$query = $con->query($sql1);
// 			while ($r=$query->fetch_array()) {
// 				$user_id=$r["id_user"];
// 				break;
// 			}
// 			if($user_id==null){
// 				print "<script>alert(\"Acceso invalido.\");window.location='../index.php';</script>";
// 			}else{
// 				session_start();
// 				$_SESSION["user_id"]=$user_id;
// 				print "<script>window.location='../inicio.php';</script>";				
// 			}
// 		}
// 	}
// }



?>


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