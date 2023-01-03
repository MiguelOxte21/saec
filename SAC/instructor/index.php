<?php
// INSTRUCTOR:
// Debe de agregar elinimar y editar , taller concurso conferencia 
// ver las lista de los alumnos inscritos a estas
// impirmir las lista de alumnos
// descargar su constancia del taller
// ver informacion del alumno , al igual que lo puede eliminar 
// cambiar perfil 
session_start();
$id_instructor = $_SESSION["id_instructor"];
if (!isset($_SESSION["id_instructor"]) || $_SESSION["id_instructor"] == null) {
    print "<script>window.location='../../index.php';</script>";
}

//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {
    $inactivo = 900; //15min en este caso.
    $vida_session = time() - $_SESSION['tiempo'];
    if ($vida_session > $inactivo) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    } else {  // si no ha caducado la sesion, actualizamos
        $_SESSION['tiempo'] = time();
    }
} else {
    $_SESSION['tiempo'] = time();
}

include("../Conexion.php");

// Datos del instructor
$stmt_edit = $DB_con->prepare('SELECT * FROM instructores  WHERE id_user =:uid');
$stmt_edit->execute(array(':uid' => $_SESSION["id_instructor"]));
$datosInstructor = $stmt_edit->fetch(PDO::FETCH_ASSOC);
extract($datosInstructor);
$nombre_instructor = $datosInstructor['nombre_instructor'];
$nombre_instructor .= ' ';
$nombre_instructor .= $datosInstructor['apellido_instructor'];
$status_instructor = $datosInstructor['status_instructor'];

// Carrera
$carreraIns = $DB_con->prepare('SELECT * FROM admin_carreras WHERE id_adminCarrera =:id_adminCarrera');
$carreraIns->execute(array(':id_adminCarrera' => $datosInstructor['id_adminCarrera']));
$carreraInstructor = $carreraIns->fetch(PDO::FETCH_ASSOC);
extract($carreraInstructor);
$_SESSION["carrera"] = $carreraInstructor['carrera'];

// Contadores
$cupo_taller = 0;
$contadorAlumnos = 0;
$porcentajeTaller = 0;

$cupo_conferencia = 0;
$contadorAlumnosConferencia = 0;
$porcentajeConferencia = 0;


// TALLERES
$num1 = $DB_con->prepare("SELECT alumnos.*, talleres.* FROM alumnos INNER JOIN talleres ON alumnos.id_taller = talleres.id_taller WHERE talleres.id_instructor = :id_instructor");
$num1->execute(array(':id_instructor' => $datosInstructor['id_instructor']));
while ($rowLista = $num1->fetch(PDO::FETCH_OBJ)) {
    $contadorAlumnos++;
    $cupo_taller = $rowLista->cupo_taller; 
}

if (!$cupo_taller == 0 || !$cupo_taller == null) {
    $porcentajeTaller = round (($contadorAlumnos / $cupo_taller) * 100) . '%'; 
}

// CONFERENCIAS
$num12 = $DB_con->prepare("SELECT alumnos.*, conferencias.* FROM alumnos INNER JOIN conferencias ON alumnos.id_taller = conferencias.id_conferencia WHERE id_instructor = :id_instructor");
$num12->execute(array(':id_instructor' => $datosInstructor['id_instructor']));
while ($rowLista2 = $num12->fetch(PDO::FETCH_OBJ)) {
    $contadorAlumnosConferencia++;
    $cupo_conferencia = $rowLista2->cupo_conferencia; 
}

if (!$cupo_conferencia == 0 || !$cupo_conferencia == null) {
    $porcentajeConferencia = round (($contadorAlumnosConferencia / $cupo_conferencia) * 100) . '%'; 
}

// // CONCURSOS
// $num13 = $DB_con->prepare("SELECT alumnos.*, concursos.* FROM alumnos INNER JOIN concursos ON alumnos.id_taller = concursos.id_concurso WHERE id_instructor = :id_instructor");
// $num13->execute(array(':id_instructor' => $datosInstructor['id_instructor']));
// while ($rowLista3 = $num13->fetch(PDO::FETCH_OBJ)) {
//     $contadorConcurso++;
//     $cupo_concurso = $rowLista3->cupo_concurso; 
//     $modalidad = $rowLista3->modalidad;  // 1 
//     $max_alumnos_grupal = $rowLista3->max_alumnos_grupal; 
// }

// if (!$cupo_concurso == 0 || !$cupo_concurso == null) {
//     $porcentajeConferencia = round (($contadorConcurso / $cupo_concurso) * 100) . '%'; 
// }


?>

<?php include('../Conexion.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sistema de Administración de Congresos</title>

    <link href="../../plugins/admin/css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../plugins/admin/assets\img\favicon.png">

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>


</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
        <a class="navbar-brand d-none d-sm-block" href="index">SAC</a><button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#"><i data-feather="menu"></i></button>
        <ul class="navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="../../images/icono_usuario.png"></a>
                <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="../../images/icono_usuario.png">
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name">Instructor</div>
                            <div class="dropdown-user-details-email"><?php echo $carreraInstructor['carrera']; ?></div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="perfil">
                        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                        Modificar Perfil
                    </a>
                    <a class="dropdown-item" href="../logout">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Salir
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include('nav.php'); ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid mt-5">
                    <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                        <div class="mr-4 mb-3 mb-sm-0">
                            <h1 class="mb-0"><?php echo $carreraInstructor['carrera']; ?></h1>
                        </div>

                    </div>
                    <div class="alert alert-primary border-0 mb-4 mt-5 px-md-5">
                        <div class="position-relative">
                            <div class="row align-items-center justify-content-between">
                                <div class="col position-relative">
                                    <?php
                                    if ($status_instructor == 1) {
                                    ?>
                                        <h2 class="text-primary">¡Bienvenido de nuevo! <?php echo $nombre_instructor; ?></h2>
                                        <p class="text-gray-700"> <b> “La educación no cambia al mundo: cambia a las personas que van a cambiar el mundo.”</b>
                                    </p>
                                    <p class="text-right text-gray-700"><i> - Paulo Freire</i><br></p>
                                        <a class="btn btn-teal" href="alumnos.php">Mis Alumnos<i class="ml-1" data-feather="arrow-right"></i></a>
                                    <?php
                                    } else {
                                    ?>
                                        <h2 class="text-primary">¡Hola! <?php echo $nombre_instructor; ?></h2>
                                        <p class="text-gray-700">Por el momento su cuenta se encuentra <b>Inactiva</b> espere a que el encargado verifique su cuenta, sin embargo podrá subir su <a href="congreso/taller.php">taller</a> , <a href="congreso/concurso.php">concurso</a> o su <a href="congreso/conferencia.php">conferencia</a> al sistema, aunque no se hará publica hasta que su cuenta este activa</p>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="col d-none d-md-block text-right pt-3"><img class="img-fluid mt-n5" src="../../plugins/admin/assets\img\drawkit\color\drawkit-charts-and-graphs.svg" style="max-width: 25rem;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="footer mt-auto footer-light">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 small">Sistema de Administración de Congresos</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="../../plugins/admin/js\scripts.js"></script>
    <script src="../../plugins/admin/assets\demo\datatables-demo.js"></script>

    <script src="../../plugins/admin/js\sb-customizer.js"></script>
</body>

</html>