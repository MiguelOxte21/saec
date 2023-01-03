<?php
include"../SAC/Conexion.php";
$email= $_POST['email'];
$p1= $_POST['p1'];
$p2= $_POST['p2'];

$correcto=true;
if($p1==$p2){
    $p1 = password_hash($_POST['p1'], PASSWORD_DEFAULT, array("cost" => 15));
    //$p1 = sha1($p1);
    mysqli_query($DB_con1,"UPDATE users SET password ='$p1' WHERE correo_user='$email'");
    mysqli_close($DB_con1);



}else{

    $correcto= false;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset</title>
    <!-- <title>Sistema de Administración de Eventos y Congresos</title> -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="../css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="../css/iofrm-theme6.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <style>
        #btn-acceso {
            position: right;
        }
    </style>


</head>


<body>
<div class="form-body">
       <div class="row ">
           <div class="img-holder">
               <div class="bg"></div>
               <div class="info-holder">
                   <img src="images/logos/1204182.jpg" alt="logos">
               </div>
           </div>

           <div class="form-holder">
               <div class="form-content">

                   <div class="form-items">
                       <h3 class="">Sistema de Administración de Eventos y Congresos</h3>
                       <p class="text-center"></p>

                       <?php if ($correcto) { ?>
                        <div class="alert alert-success Sp-3 mb-2 bg-white" role="alert">
                            <h4 class="alert-heading ">Se ha realizado el cambio de contraseña</h4>
                               
                                 <hr>
                                     <p class="mb-3 text-success">   Ir al inicio</p>
                                <button type="submit" class=" btn btn-primary  text-white">  <a href="http://localhost/congreso-master/index.php" title="Vovler al inicio"><i class='fas fa-home icon'></i></a></button>

                        </div>



                        <?php } else { ?>
                                <div class="mb-3">
                                    <div class="alert alert-warning Sp-3 mb-2 bg-white ">Las contraseñas no coinciden
                                        <div></div>
                                    <button type="submit" class=" btn btn-primary  text-white"><a href="javascript:history.back()" >Regresar</a></button>

                                </div>
                        <?php } ?>

                        </div>

                    </div>
                </div>
            </div>


    </div>
    </div>



    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>

    <script type='text/javascript'>
        document.oncontextmenu = function() {
            return false
        }
    </script>
</body>

</html>