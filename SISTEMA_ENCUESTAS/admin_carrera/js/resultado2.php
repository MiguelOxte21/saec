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

<script src="js/Chart.min.js"></script>

<hr/>

<script src="js/resultados.php"></script>


<?php
}
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses', 'Profit'],
         <?php echo "['" . $row['count'] . "']";  ?>

        ]);

        var options = {
          chart: {
            title: <?php echo "['" .$row2['titulo']."', " .$row['count']."],";?>
           
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
  </head>
  <body>
    <div id="columnchart_material" style="width: 800px; height: 500px;"></div>
  </body>
</html>
