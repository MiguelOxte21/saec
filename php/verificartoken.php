<?php

include('../SAC/Conexion.php');
$email= $_POST['email'];
$token  = $_POST['token'];
$codigo = $_POST['codigo'];


$res=$DB_con1->query("SELECT * FROM passwords WHERE email='$email' and token='$token' and codigo=$codigo")or die ($DB_con1->error);

$correcto=false;
if(mysqli_num_rows($res) > 0){
 $fila= mysqli_fetch_row($res);
 $fecha= $fila[4];
 $fecha_actual = date("Y-m-d h:m:s");
 $seconds = strtotime($fecha_actual)- strtotime($fecha);
   $minutos = $seconds/60 ;
   $correcto = true;
   }else{
    $correcto= false;
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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

<script type="text/javascript">
        function mostrarPassword() {
            var cambio = document.getElementById("txtPassword");
            if (cambio.type == "password") {
                cambio.type = "text";
                $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            } else {
                cambio.type = "password";
                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }

        }

        $(document).ready(function() {
            //CheckBox mostrar contraseña
            $('#ShowPassword').click(function() {
                $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });
        });
    </script>

<script type="text/javascript">
        function mostrarPassword1() {
            var cambio = document.getElementById("txtPassword1");
            if (cambio.type == "password") {
                cambio.type = "text";
                $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            } else {
                cambio.type = "password";
                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }

        }

        $(document).ready(function() {
            //CheckBox mostrar contraseña
            $('#ShowPassword1').click(function() {
                $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });
        });
    </script>


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
                            <h2 class="   text-white" >Restablecer Contraseña</h2>
                            <p class="text-center"></p>
                            <div class="page-links text-center">
                            </div>
                             <?php if ($correcto) { ?>

                            <form rol="form" action="./cambiarpassword.php" method="POST">
                                <h3 >Contraseña Nueva</h3>

                                <div class="input-group">
                                    <input ID="txtPassword"  type="password" class="form-control" id="c" name="p1" placeholder="Nueva Contraseña" minlength="8" maxlength="16" pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$" required>
                                    <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                                    <input type="hidden" class="form-control" id="c" name="email" value="<?php echo $email?>">
                                    <p> <small>La contraseña debe tener entre 8 y 16 caracteres, al menos un dígito y al menos una mayúscula.</small></p>
                                </div>
                                <h3 >Confirma Contraseña</h3>
                                <div class="input-group">
                                    <input ID="txtPassword1" type="password" class="form-control" id="c" name="p2" placeholder="Confirma Contraseña" minlength="8" maxlength="16" pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$" required ><button id="show_password1" class="btn btn-primary" type="button" onclick="mostrarPassword1()"> <span class="fa fa-eye-slash icon"></span> </button>
                                    </div>
                                <div class="form-button">
                                <button id="submit" name="login" type="submit" class="ibtn">Cambiar</button>

                            </form>

                            <?php } else { ?>
                            <div class="alert alert-warning Sp-3 mb-2 bg-white">Código incorrecto o vencido, Verifica tu código para restablecer tu contraseña 
                            <div> </div>
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