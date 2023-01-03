<?php
include ("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Administración de Eventos y Congresos</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-theme6.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
<style>
 
    #btn-acceso{
        position: right;
    }
    </style>
    
    <script type="text/javascript">
function mostrarPassword(){
		var cambio = document.getElementById("txtPassword");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}

	} 
	
	$(document).ready(function () {
	//CheckBox mostrar contraseña
	$('#ShowPassword').click(function () {
		$('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
	});
});
</script>

</head>
<body>
    
<?php
				$resultado=mysqli_query($conexion,"select * from logo where imagen_ID=1 limit 0,1");
				while($imglogo=mysqli_fetch_array($resultado)){
                    // echo '<span>'; echo $imglogo['imagen_img']; echo'/'; echo $imglogo['imagen_img']; echo'</span>';
?>
    <div class="form-body">
        
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="admin/control/logo/imagenes/<?php echo $imglogo['imagen_img'];?>" alt="Logo Jornada Academica">
                </div>
            </div>
           

    
            <?php
                }
        ?>        

            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3 class="text-center">Sistema de Administración de Eventos y Congresos</h3>
                        <p class="text-center">Error 404 ! Pagina No Encontrada</p>
                        <br>
                        <?php
echo "<input type='button' value='Atras' class='text-center' onClick='history.go(-1);'>";
?>
                    </div>
                </div>
            </div>

            
        </div>
    </div>


<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>