<?php 
$resultado = $_POST['valorCaja1'] + $_POST['valorCaja2'] + 100; 
echo $resultado; //haciendo este echo estas respondiendo la solicitud ajax
?>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
			<article class="item">
				
			<?php echo 'Chales we que pdo';?>
			<?php echo '<br>';?>
			<?php echo $resultado;?>
			</article>
		</div>