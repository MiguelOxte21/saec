<?php 

	include '../conexion.php';
	$id_encuesta = $_GET['id_encuesta'];

	/* Consulta para extraer título y descripción de la encuesta*/
	$query3 = "SELECT * FROM encuestas WHERE id_encuesta = '$id_encuesta'";
	$resultados3 = $con->query($query3);
	$row3 = $resultados3->fetch_assoc();
error_reporting(~E_NOTICE);
			  session_start();
			  if (!isset($_SESSION["id_administrador_carrera"]) || $_SESSION["id_administrador_carrera"] == null) {
				  print "<script>window.location='../../index.php';</script>";
			  }
			  
			  
			  //Comprobamos si esta definida la sesión 'tiempo'.
			  if (isset($_SESSION['tiempo'])) {
				  $inactivo = 900; //15min en este caso.
				  $vida_session = time() - $_SESSION['tiempo'];
				  if ($vida_session > $inactivo) {
					  session_unset();
					  session_destroy();
					  header("Location: ../../index");
					  exit();
				  } else {  // si no ha caducado la sesion, actualizamos
					  $_SESSION['tiempo'] = time();
				  }
			  } else {
				  $_SESSION['tiempo'] = time();
			  }
			  require_once '../../SAC/Conexion.php';
				
// Datos del administrador de la carrera
$stmt_edit = $DB_con->prepare('SELECT * FROM admin_carreras  WHERE id_user =:uid');
$stmt_edit->execute(array(':uid' => $_SESSION["id_administrador_carrera"]));
$datosAdministradorCarrera = $stmt_edit->fetch(PDO::FETCH_ASSOC);
extract($datosAdministradorCarrera);
$datosAdministradorCarrera['nombre_adminCarrera'];
$datosAdministradorCarrera['carrera'];
$id_adminCarrera = $datosAdministradorCarrera['id_adminCarrera'];

// === CONTADORES ===

// 
$contadorAlumnosP = $DB_con->prepare('SELECT COUNT(*) AS contador FROM alumnos WHERE id_adminCarrera =:uid');
$contadorAlumnosP->execute(array(':uid' => $id_adminCarrera));
$contador1 = $contadorAlumnosP->fetch(PDO::FETCH_ASSOC);
extract($contador1);
echo $contador1['contador'];	 

 ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sistemas de Administración de Eventos y Congresos</title>

    <link href="../../plugins/admin/css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../plugins/admin/assets\img\favicon.png">

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="appIns.js"></script>
  <!-- Bootstrap CSS 
  	<link rel="stylesheet" href="../css/bootstrap.min.css">-->
  <!-- Favicon - FIS -->
  <link rel="shortcut icon" href="../imagenes/tec.png">


</head>
<body>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
        <a class="navbar-brand d-none d-sm-block" href="../../SAC/administrador/index.php">SAC</a><button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#"><i data-feather="menu"></i></button>
        <ul class="navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="../../images/icono_usuario.png"></a>
                <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="../../images/icono_usuario.png">
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name">Administrador</div>
                            <div class="dropdown-user-details-email"><?php echo $datosAdministradorCarrera['carrera']; ?></div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../../SAC/administrador/perfil.php">
                        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                        Modificar Perfil
                    </a>
                    <a class="dropdown-item" href="../../logout.php">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Salir
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include('nav.php') ?>
        </div>
        <div id="layoutSidenav_content">
	
		<main>
        <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
          <div class="container-fluid">
            <div class="page-header-content">
              <h1 class="page-header-title">
                <div class="page-header-icon"><i></i></div>
                <span>Resultado</span>
              </h1>
              <p style="color: white;"></p>
              
            </div>
          </div>
        </div>
     
     
		<div class="container-fluid mt-n10" style="margin-top: 30px;">
                    <div class="card mb-4">
                        <div class="card-header">Grafica de resultado</div>
                        <div class="card-body">
                            <div class="datatable table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
         

      <!--NAVBAR-->
      <div class="row">
            <div class="col-md-19 row">
              <div class="col-md-12 col-xs-12">
              </div>
            </div>
          </div>

  	
  		
  	<?php

  	$consulta = "SELECT * FROM preguntas WHERE id_encuesta = '$id_encuesta'";
	$resultados2 = $con->query($consulta);

	 ?>

	<hr/>
	<div class="container text-center">
		<h1><?php echo $row3['titulo'] ?></h1>
		<p><?php echo $row3['descripcion'] ?></p>
	</div>
	<hr/>

	<?php
		while ($row2 = $resultados2->fetch_assoc()) {
		
		$id_pregunta = $row2['id_pregunta'];

		$query = "SELECT preguntas.id_pregunta, preguntas.titulo,COUNT('preguntas.titulo') as count, opciones.valor FROM opciones INNER JOIN preguntas ON opciones.id_pregunta=preguntas.id_pregunta INNER JOIN resultados ON opciones.id_opcion=resultados.id_opcion WHERE preguntas.id_pregunta = '$id_pregunta' GROUP BY opciones.valor ORDER BY preguntas.id_pregunta";
		$resultados = $con->query($query);

				/*TITULO*/
		echo "<h3>" . $row2['titulo'] . "</h3>";

		$cantidades = array();
		$titulos = array();
		$tamaño = array(); 
		$i = 1;
		while ($row = $resultados->fetch_assoc()) {
			$cantidades[$i] = 0;
			$cantidades[$i] = $row['count'];
			$titulos[$i] = $row['valor'];
			$i++;
		}

		$opciones = $i - 1;
		for ($i = 1; $i <= $opciones; $i++) {

		?>

		<input type="hidden" class="<?php echo "valor$i" ?>" value="<?php echo $cantidades[$i] ?>">
		<input type="hidden" class="<?php echo "titulo$i" ?>" value="<?php echo $titulos[$i] ?>">

		<?php  
		}/*95*/

		 ?>

		<input type="hidden" class="tamaño" value="<?php echo $opciones ?>">
		<div class="container" style="width: 50%; margin: 0 auto; width: 400px;">		
			<canvas class="oilChart" width="600" height="400"></canvas>
		</div>

		<script src='js/Chart.min.js'></script>

		<hr/>

		<script src="js/resultados.js">

		</script>

	<?php


	}
  	 ?>

	<div class="container text-center" style="margin-bottom: 20px">
		<a href="reporte.php" class="btn btn-primary" target="_blank">GENERAR REPORTE</a>
		
		<!-- <a href="reporte2.php?id_encuesta=<?php echo $id_encuesta ?>" class="btn btn-primary" target="_blank">GENERAR REPORTE2</a>
		-->
	</div>

    </table>
</div></div></div>

      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="../../js/jquery-3.3.1.min.js"></script>
      <script src="../../js/popper.min.js"></script>
      <script src="../../js/bootstrap.min.js"></script>
      <script src="js/encuestas.js"></script>



      <footer class="footer mt-auto footer-light">

        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 small">Sistema de Administración de Congresos</div>
          </div>
        </div>
      </div>
    </footer>
    
	</main>
  </body>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="../../plugins/admin/js\scripts.js"></script>

<script src="../../plugins/admin/js\sb-customizer.js"></script>
<script src="../../plugins/admin/assets\demo\chart-bar-demo.js"></script>

  	<!-- Optional JavaScript -->
  	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
  	
</body>
</html>