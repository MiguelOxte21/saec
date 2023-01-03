<?php 	

	session_start();
	session_destroy();

	header("http://localhost/congreso-master/index.php");
