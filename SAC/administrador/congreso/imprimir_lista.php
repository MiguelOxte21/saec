<?php
error_reporting(~E_NOTICE);
session_start();
$id_instructor = $_SESSION["id_administrador_carrera"];
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
require_once '../../Conexion.php';

// METODO DE AGRUPACION DE LA LISTA
if ($_GET['agrupar'] == 'nombre') {
    $agrupar = 'apellido_alumno';
} elseif ($_GET['agrupar'] == 'matricula') {
    $agrupar = 'matricula';
} elseif ($_GET['agrupar'] == 'semestre') {
    $agrupar = 'semestre_grupo';
} else {
    print "<script>window.location='../index.php';</script>";
}

if (isset($_GET['taller'])) { //TALLER
    $consultaIns = $DB_con->prepare('SELECT * FROM talleres WHERE id_taller = :id_taller');
    $consultaIns->execute(array(':id_taller' => $_GET['taller']));
    $datos = $consultaIns->fetch(PDO::FETCH_ASSOC);
    extract($datos);
    $nombre = $datos['nombre_taller'];
    $txt = 'taller';
    $txtGet = 'taller='.$datos['id_taller'];
    $id_get = $datos['id_taller'];

    $listaAlumno = $DB_con->prepare("SELECT users.*, alumnos.* FROM users INNER JOIN alumnos ON users.id_user = alumnos.id_user WHERE alumnos.id_taller = :uidt ORDER BY $agrupar ASC");
    $listaAlumno->execute(array(':uidt' => $datos['id_taller']));
    
} elseif (isset($_GET['concurso']) || isset($_GET['lista_concurso_grupal'])) { // CONCURSO
    if (isset($_GET['concurso'])) {
        $id_concurso = $_GET['concurso'];
    } elseif (isset($_GET['lista_concurso_grupal'])) {
        $id_concurso = $_GET['lista_concurso_grupal'];
    }

    $consultaIns2 = $DB_con->prepare('SELECT * FROM concursos WHERE id_concurso = :id_concurso');
    $consultaIns2->execute(array(':id_concurso' => $id_concurso));
    $datos = $consultaIns2->fetch(PDO::FETCH_ASSOC);
    extract($datos);
    $nombre = $datos['nombre_concurso'];
    $txt = 'concurso';
    $txtGet = 'concurso='.$datos['id_concurso'];
    $id_get = $datos['id_concurso'];

    // SELECIONAR ALUMNOS DEL CONCURSO INDIVIDUAL
    $listaAlumno = $DB_con->prepare("SELECT users.*, alumnos.* FROM users INNER JOIN alumnos ON users.id_user = alumnos.id_user WHERE alumnos.id_concurso = :uidt ORDER BY $agrupar ASC");
    $listaAlumno->execute(array(':uidt' => $datos['id_concurso']));

    
} elseif (isset($_GET['conferencia'])) { //CONFERENCIA
    $consultaIns3 = $DB_con->prepare('SELECT * FROM conferencias WHERE id_conferencia = :id_conferencia');
    $consultaIns3->execute(array(':id_conferencia' => $_GET['conferencia']));
    $datos = $consultaIns3->fetch(PDO::FETCH_ASSOC);
    extract($datos);
    $nombre = $datos['nombre_conferencia'];
    $txt = 'conferencia';
    $txtGet = 'conferencia='.$datos['id_conferencia'];
    $id_get = $datos['id_conferencia'];

    $listaAlumno = $DB_con->prepare("SELECT alumnos.*, alumnos_conferencias.*, users.* FROM ((alumnos INNER JOIN alumnos_conferencias ON alumnos.id_alumno = alumnos_conferencias.id_alumno) INNER JOIN users ON users.id_user = alumnos.id_user) WHERE alumnos_conferencias.id_conferencia = :uidt ORDER BY $agrupar ASC");

    $listaAlumno->execute(array(':uidt' => $datos['id_conferencia']));
} else {
    print "<script>window.location='../index.php';</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Lista de alumnos | <?php echo $nombre; ?></title>
    <link rel="stylesheet" href="../../../assets/css/main.css">
    <style type="text/css" media="print">
        @page {
            size: auto;
            /* auto is the initial value */
            margin: 30px;
            /* this affects the margin in the printer settings */
        }
    </style>
    <style>
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .control-bar {
            background-color: #333 !important;
        }

        h1 {
            color: #ed1b24 !important;
        }

        hr {
            height: 2px;
            border-width: 0;
            color: gray;
            background-color: gray;
            margin-top: 35px;
        }
    </style>


    <style>
        #customers {
            font-family: 'Century Gothic';
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        /* #customers tr:nth-child(even){background-color: #f2f2f2;} */

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            /* background-color: #4CAF50; */
            color: black;
        }

        h1 {
            color: black !important;
            font-family: 'Century Gothic';
        }
    </style>

    <script type='text/javascript'>
        document.oncontextmenu = function() {
            return false
        }
    </script>
</head>

<body>
    <div class="control-bar">
        <div class="container">
            <div class="row">
                <div class="col-2-4">
                    <!-- <div class="slogan">Lista de alumnos.</div> -->
                    <form method="GET" action="imprimir_lista.php?<?php echo $txtGet; ?>&">
                        <div class="slogan">Agrupar Por:</div>
                        <input type='hidden' name='<?php echo $txt; ?>' value='<?php echo $id_get; ?>' />

                        <input class="form-check-input" type="radio" name="agrupar" id="nombre" value="nombre" <?php if ($_GET['agrupar'] == 'nombre') {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
                        <label class="form-check-label" for="nombre">
                            Nombre.
                        </label>

                        <input class="form-check-input" type="radio" name="agrupar" id="matricula" value="matricula" <?php if ($_GET['agrupar'] == 'matricula') {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                        <label class="form-check-label" for="matricula">
                            Matricula.
                        </label>

                        <input class="form-check-input" type="radio" name="agrupar" id="semestre" value="semestre" <?php if ($_GET['agrupar'] == 'semestre') {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                        <label class="form-check-label" for="semestre">
                            Semestre.
                        </label>
                        <input type="submit" value="Actualizar" class="btn btn-primary" title="Actualizar">
                    </form>

                    <!-- <div class="slogan">Ordenar:</div>


          <input class="form-check-input" type="radio" name="ordenar" id="asc" value="option1" checked>
          <label class="form-check-label" for="asc">
            Asc.
          </label>

          <input class="form-check-input" type="radio" name="ordenar" id="des" value="1">
          <label class="form-check-label" for="des">
            Desc.
          </label> -->

                    <!--           

          <label for="config_note">Nota:
            <input type="checkbox" id="config_note" />
          </label> -->

                </div>
                <div class="col-4 text-right">
                    <a href="javascript:window.print()">Imprimir</a>
                </div>
                <!--.col-->
            </div>
            <!--.row-->
        </div>
        <!--.container-->
    </div>
    <!--.control-bar-->

    <div class="row">
        <div class="">
            <img height="100px" src="../../../assets/img/encabezado.png">
        </div>
        <!--.logoholder-->
        <!-- <hr> -->
    </div>
    <br>
    <br>
    <br>

    <div class="row">
        <div class="text-center">
            <h1><?php echo $nombre; ?></h1>
        </div>
    </div>

    <br>
    <br>

    <table id="customers">
        <tr>
            <th>Nombre</th>
            <th>Matricula</th>
            <th>Semestre y Grupo</th>
            <th>Correo</th>
            <th>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Firma &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
        </tr>


        <?php
        // MOSTAR LISTA

        while ($rowLista = $listaAlumno->fetch(PDO::FETCH_OBJ)) {
        ?>
            <tr>
                <td> <?php echo $rowLista->apellido_alumno . ' ' . $rowLista->nombre_alumno; ?> </td>
                <td> <?php echo $rowLista->matricula; ?> </td>
                <td> <?php echo $rowLista->semestre_grupo; ?> </td>
                <td> <?php echo $rowLista->correo_user; ?> </td>
                <td></td>
            </tr>
        <?php }  ?>

    </table>




    <!-- <div class="note" contenteditable>
    <h2>Nota:</h2>
  </div> -->
    <!--.note-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="assets/bower_components/jquery/dist/jquery.min.js"><\/script>')
    </script>
    <script src="assets/js/main.js"></script>
</body>

</html>