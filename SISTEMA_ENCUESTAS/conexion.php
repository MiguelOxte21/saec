<?php

$servername = "localhost";
$username = "congreso";
$password = "abc123$";
$dbname = "congreso";

// Creamos la conexión
$con = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($con,"utf8");

// Verificamos la conexión
if ($con->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
	// echo "Conexión exitosa";
}
