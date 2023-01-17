<?php
$idcarr = $_SESSION["id_adminCarrera"];

// RECONOCER LOGO
$logoAlumno = $DB_con->prepare('SELECT * FROM logos WHERE id_imagen =:id_imagen');
$logoAlumno->execute(array(':id_imagen' => $_SESSION['imgLogo']));
$logoA = $logoAlumno->fetch(PDO::FETCH_ASSOC);
extract($logoA);
$img = $logoA['imagen'];

$contadorTalleres = 0;
$contadorConcursos = 0;
$contadorConferencias = 0;
$statusInstructor = 1;

$contTaller = $DB_con->prepare("SELECT instructores.*, talleres.* FROM talleres INNER JOIN instructores ON talleres.id_instructor = instructores.id_instructor WHERE instructores.status_instructor = :status_instructor AND instructores.id_adminCarrera = :id_adminCarrera");
$contTaller->execute(array(':id_adminCarrera' => $idcarr, ':status_instructor' => $statusInstructor));
while ($row = $contTaller->fetch(PDO::FETCH_OBJ)) {
    $contadorTalleres++;
}

$conConcurso = $DB_con->prepare("SELECT instructores.*, concursos.* FROM concursos INNER JOIN instructores ON concursos.id_instructor = instructores.id_instructor WHERE status_instructor = 1 AND id_adminCarrera = :id_adminCarrera");
$conConcurso->execute(array(':id_adminCarrera' => $_SESSION["id_adminCarrera"]));
while ($row = $conConcurso->fetch(PDO::FETCH_OBJ)) {
    $contadorConcursos++;
}

$conrConferencias = $DB_con->prepare("SELECT instructores.*, conferencias.* FROM conferencias INNER JOIN instructores ON conferencias.id_instructor = instructores.id_instructor WHERE status_instructor = 1 AND id_adminCarrera = :id_adminCarrera");
$conrConferencias->execute(array(':id_adminCarrera' => $_SESSION["id_adminCarrera"]));
while ($row = $conrConferencias->fetch(PDO::FETCH_OBJ)) {
    $contadorConferencias++;
}

// $status = 1;
// Contador del taller (Para activar la opcion de talleres en el menu)
// $contTaller = $DB_con->prepare('SELECT instructores.*, talleres.*, COUNT(*) AS contTaller FROM talleres INNER JOIN instructores ON talleres.id_instructor = instructores.id_instructor WHERE instructores.status_instructor = :status_instructor AND instructores.id_adminCarrera = :id_adminCarrera');
// $contTaller->execute(array(':id_adminCarrera' => $idcarr,':status_instructor' => $status));
// $contT = $contTaller->fetch(PDO::FETCH_ASSOC);
// extract($contT);

// // Contador del concurso (Para activar la opcion de concurso en el menu)
// $consultaConcur = $DB_con->prepare('SELECT instructores.*, concursos.*, COUNT(*) AS contConcurso FROM concursos INNER JOIN instructores ON concursos.id_instructor = instructores.id_instructor WHERE status_instructor = 1 AND id_adminCarrera = :id_adminCarrera');
// $consultaConcur->execute(array(':id_adminCarrera' => $_SESSION["id_adminCarrera"]));
// $contC = $consultaConcur->fetch(PDO::FETCH_ASSOC);
// extract($contC);

// // Contador de las conferencias (Para activar la opcion de conferencia en el menu)
// $consultaConferencias2 = $DB_con->prepare('SELECT instructores.*, conferencias.*, COUNT(*) AS contConferencias FROM conferencias INNER JOIN instructores ON conferencias.id_instructor = instructores.id_instructor WHERE status_instructor = 1 AND id_adminCarrera = :id_adminCarrera');
// $consultaConferencias2->execute(array(':id_adminCarrera' => $_SESSION["id_adminCarrera"]));
// $contConf = $consultaConferencias2->fetch(PDO::FETCH_ASSOC);
// extract($contConf);

// // CONTADORES
// echo $contT['contTaller'];
// $contC['contConcurso'];
// $contConf['contConferencias'];
?>

<!-- MENU DE NAVEGACION-->
<header class="header">
    <div class="header-bottom hidden-tablet-landscape" id="js-navbar-fixed">
        <div class="container">
            <div class="header-bottom">
                <div class="header-bottom-content display-flex">
                    <div class="logo" style="width:70px;height:70px;position:relative;">
                        <a href="inicio.php">
                            <img src="images/logos/<?php echo $img; ?>" alt="" style="width:90%;height:90%;position:absolute;" />
                        </a>
                    </div>
                    <div class="menu-search display-flex">
                        <nav class="menu">
                            <div>
                                <ul class="menu-primary">
                                    <li class="menu-item curent-menu-item">
                                        <a href="inicio.php">Inicio</a>
                                    </li>
                                    <?php
                                    if ($contadorTalleres <> 0) {
                                        echo '<li class="menu-item curent-menu-item">
                                            <a href="talleres.php">Talleres</a>
                                        </li>';
                                    }
                                    if ($contadorConcursos != 0) {
                                        echo '<li class="menu-item curent-menu-item">
                                        <a href="concursos.php">Concursos</a>
                                    </li>';
                                    }
                                    if ($contadorConferencias != 0) {
                                        echo '<li class="menu-item curent-menu-item">
                                        <a href="conferencias.php">Conferencias</a>
                                    </li>';
                                    }

                                    ?>
                                    <li class="menu-item curent-menu-item">
                                        <a href="avisos.php">Avisos</a>
                                    </li>
                                    <li class="menu-item curent-menu-item">
                                        <a href="pagar/index.php">Pagar</a>
                                    </li>
                                    <li class="menu-item curent-menu-item">
                                        <a href="perfil.php">Perfil</a>
                                    </li>
                                    <li class="menu-item curent-menu-item">
                                        <a href="SISTEMA_ENCUESTAS/usuario/index.php">Encuesta</a>
                                    </li>
                                    
                                    <li class="menu-item curent-menu-item">
                                        <a href="logout.php">Cerrar</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden-tablet-landscape-up header-mobile">
        <div class="header-top-mobile">
            <div class="container-fluid">
                <div class="logo" style="width:60px;height:60px;position:relative;">
                    <a href="inicio.php">


                        <img src="images/logos/<?php echo $img; ?>" style="width:100%;height:100%;position:absolute;" />

                    </a>
                </div>
                <button class="hamburger hamburger--spin hidden-tablet-landscape-up" id="toggle-icon">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>

        <div class="au-nav-mobile">
            <nav class="menu-mobile">
                <div>
                    <ul class="au-navbar-menu">
                        <li class="menu-item curent-menu-item">
                            <a href="inicio.php">Inicio</a>
                        </li>
                        <?php
                        if ($contadorTalleres != 0) {
                            echo '<li class="menu-item">
                                        <a href="talleres.php">Talleres</a>
                                    </li>';
                        }
                        if ($contadorConcursos != 0) {
                            echo '<li class="menu-item">
                                        <a href="concursos.php">Concursos</a>
                                    </li>';
                        }
                        if ($contadorConferencias != 0) {
                            echo '<li class="menu-item">
                            <a href="conferencias.php">Conferencias</a>
                        </li>';
                        }
                        ?>
                        <li class="menu-item">
                            <a href="perfil.php">Perfil</a>
                        </li>
                        <li class="menu-item curent-menu-item">
                                        <a href="pagar/index.php">Pagar</a>
                                    </li>
                        <li class="menu-item">
                                        <a href="SISTEMA_ENCUESTAS/usuario/index.php">Encuesta</a>
                                    </li>
                        <li class="menu-item">
                            <a href="logout.php">Salir</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="clear"></div>
    </div>
</header>
