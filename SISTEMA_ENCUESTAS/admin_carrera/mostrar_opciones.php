<?php

include("../conexion.php") ;

$id_pregunta = $_GET['id_pregunta'];

$query = "SELECT * FROM preguntas WHERE id_pregunta = '$id_pregunta'";
$respuesta = $con->query($query);
$row = $respuesta->fetch_assoc();
error_reporting(~E_NOTICE);
session_start();
$id_administrador_carrera = $_SESSION["id_administrador_carrera"];
if (!isset($_SESSION["id_administrador_carrera"]) || $_SESSION["id_administrador_carrera"] == null) {
    print "<script>window.location='../admin_carrera/index.php';</script>";
}

//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {
    $inactivo = 900; //15min en este caso.
    $vida_session = time() - $_SESSION['tiempo'];
    if ($vida_session > $inactivo) {
        session_unset();
        session_destroy();
        header("Location: ../../index.php");
        exit();
    } else {  // si no ha caducado la sesion, actualizamos
        $_SESSION['tiempo'] = time();
    }
} else {
    $_SESSION['tiempo'] = time();
}

include('../../SAC/Conexion.php');


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
      <!-- Content Section -->
      <main>
        <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
          <div class="container-fluid">
            <div class="page-header-content">
              <h1 class="page-header-title">
                <div class="page-header-icon"><i></i></div>
                <span>opciones de preguntas</span>
              </h1>
              <p style="color: white;"></p>
              <button class="float-right btn btn-primary" id="boton_agregar">
              Agregar opcion

              </button>
            </div>
          </div>
        </div>
        <div class="container-fluid mt-n10" style="margin-top: 30px;">
                    <div class="card mb-4">
                        <div class="card-header">Lista de opciones</div>
                        <div class="card-body">
                            <div class="datatable table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">

  <!-- Content Section -->
  <div class="container" style="margin-top: 30px;">
      <div class="row">
          <div class="col-md-12 row">
            <div class="col-md-10 col-xs-12">
              <h3><?php echo $row['titulo'] ?></h3>
            </div>
            <div class="col-md-2 col-xs-12">
               
            </div>
          </div>
      </div>
      <hr/>
      <div class="row">
          <div class="col-md-12">
              <h4>Opciones:</h4>
              <input type="hidden" id="id_pregunta" value="<?php echo $row['id_pregunta'] ?>">
              <div class="table-responsive">
                <div id="tabla_opciones"></div>
                </div>
            </div>
           
          </div>
         
        </div>
        </div>
                        </div>
                    </div>
        <!-- /Content Section -->
      </main></table>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="../js/jquery-3.3.1.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="js/opciones.js"></script>
 

  <footer class="footer mt-auto footer-light">

<div class="container-fluid">
  <div class="row">
    <div class="col-md-6 small">Sistema de Administración de Congresos</div>
  </div>
</div>
</div>
</footer>
</body>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="../../plugins/admin/js\scripts.js"></script>

<script src="../../plugins/admin/js\sb-customizer.js"></script>
<script src="../../plugins/admin/assets\demo\chart-bar-demo.js"></script>



</body>
</html>

<!-- Modal Agregar Nueva Opción -->
<div class="modal fade" id="modal_agregar" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title">Agregar Nueva Opción</h4>
              <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group row">
                <label for="valor" class="col-sm-3 col-form-label">Valor</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="valor" placeholder="Valor" autocomplete="off" autofocus>
                </div>
              </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="agregarOpcion()">Agregar Opción</button>
            </div>

        </div>
    </div>
</div>

<!-- Modal Modificar Pregunta -->
<div class="modal fade" id="modal_modificar" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title">Modificar Opción</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
              <div class="form-group row">
                <label for="modificar_valor" class="col-sm-3 col-form-label">Valor</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="modificar_valor" placeholder="Valor">
                </div>
              </div>           
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="modificarDetallesOpcion()">Modificar Opción</button>
                <input type="hidden" id="hidden_id_opcion">
            </div>

        </div>
    </div>
</div>