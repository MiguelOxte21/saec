<?php
// require "../plugins/v2/BD.php";

// $_GET['id'];
// DATOS DEL TRANSPORTE A EDITAR
// $consulta = "SELECT * FROM reservaciones_transportes WHERE id_reservaciones_transportes = " . $_GET['id'];
// $filas = mysqli_query($conexion, $consulta);
// $datos_transporte = mysqli_fetch_assoc($filas);
// // var_dump($datos_transporte);

// // DATOS DEL SOCIO
// $consulta2 = "SELECT * FROM usuarios WHERE id_usuario = " . $datos_transporte['id_usuario'];
// $filas2 = mysqli_query($conexion, $consulta2);
// $datos_agente = mysqli_fetch_assoc($filas2);
// // var_dump($datos_agente);

// if (!isset($datos_transporte) || !isset($datos_agente)) {
//   header("refresh:0;reservas_transportes.php");
// }

// // CAMBIAR FECHA A ESPAÑOL
// function fechaCastellano($fecha)
// {
//   if ($fecha == 'No aplica.') {
//     $fecha = '<strike>No aplica.</strike>';
//     return $fecha;
//   } else {
//     $fecha = substr($fecha, 0, 10);
//     $numeroDia = date('d', strtotime($fecha));
//     $dia = date('l', strtotime($fecha));
//     $mes = date('F', strtotime($fecha));
//     $anio = date('Y', strtotime($fecha));
//     $dias_ES = array("Lunes,", "Martes,", "Miércoles,", "Jueves,", "Viernes,", "Sábado,", "Domingo,");
//     $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
//     $nombredia = str_replace($dias_EN, $dias_ES, $dia);
//     $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
//     $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
//     $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
//     return $nombredia . " " . $numeroDia . " de " . $nombreMes . " de " . $anio;
//   }
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Lista de alumnos</title>
  <link rel="stylesheet" href="assets/css/main.css">
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



          <div class="slogan">Agrupar Por:</div>

          <input class="form-check-input" type="radio" name="agrupar" id="nombre" value="option1" checked>
          <label class="form-check-label" for="nombre">
            Nombre.
          </label>

          <input class="form-check-input" type="radio" name="agrupar" id="matricula" value="option1">
          <label class="form-check-label" for="matricula">
            Matricula.
          </label>

          <input class="form-check-input" type="radio" name="agrupar" id="semestre" value="1">
          <label class="form-check-label" for="semestre">
            Semestre.
          </label>

          <div class="slogan">Ordenar:</div>


          <input class="form-check-input" type="radio" name="ordenar" id="asc" value="option1" checked>
          <label class="form-check-label" for="asc">
            Asc.
          </label>

          <input class="form-check-input" type="radio" name="ordenar" id="des" value="1">
          <label class="form-check-label" for="des">
            Desc.
          </label>

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
      <img height="100px" src="assets/img/encabezado.png">
    </div>
    <!--.logoholder-->
    <!-- <hr> -->
  </div>
  <br>
  <br>
  <br>

  <div class="row">
    <div class="text-center">
      <h1>Taller de Flutter.</h1>
    </div>
  </div>

  <br>
  <br>

  <table id="customers">
    <tr> 
      <th>Nombre</th>
      <th>Matrícula</th>
      <th>Semestre y Grupo</th>
      <th>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Firma &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
    </tr>

    <tr>
      <td>Jesus Alberto Medina Dzib</td>
      <td>16070022</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Karina Chiguil Euan</td>
      <td>16070014</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Jesus Alberto Medina Dzib</td>
      <td>16070022</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Karina Chiguil Euan</td>
      <td>16070014</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Jesus Alberto Medina Dzib</td>
      <td>16070022</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Karina Chiguil Euan</td>
      <td>16070014</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Jesus Alberto Medina Dzib</td>
      <td>16070022</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Karina Chiguil Euan</td>
      <td>16070014</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Jesus Alberto Medina Dzib</td>
      <td>16070022</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Karina Chiguil Euan</td>
      <td>16070014</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Jesus Alberto Medina Dzib</td>
      <td>16070022</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Karina Chiguil Euan</td>
      <td>16070014</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Jesus Alberto Medina Dzib</td>
      <td>16070022</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Karina Chiguil Euan</td>
      <td>16070014</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Jesus Alberto Medina Dzib</td>
      <td>16070022</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>
    <tr>
      <td>Karina Chiguil Euan</td>
      <td>16070014</td>
      <td>7° 'A'</td>
      <td></td>
    </tr>

  </table>




  <div class="note" contenteditable>
    <h2>Nota:</h2>
  </div>
  <!--.note-->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script>
    window.jQuery || document.write('<script src="assets/bower_components/jquery/dist/jquery.min.js"><\/script>')
  </script>
  <script src="assets/js/main.js"></script>
</body>

</html>