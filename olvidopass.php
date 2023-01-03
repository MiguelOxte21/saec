
<!DOCTYPE html>
<html lang= "en">
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
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>


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
    
    <style>
        .selcls {
            padding: 9px;
            border: solid 1px #517B97;
            outline: 0;
            /* background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #CAD9E3), to(#FFFFFF));  */
            /* background: -moz-linear-gradient(top, #FFFFFF, #CAD9E3 1px, #FFFFFF 25px); 
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  */
            -moz-box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 8px;
            -webkit-box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 8px;
            margin-bottom: 12px;
            width: 100%;
        }

        .input-group {
            width: 100%;
        }
    </style>



    </head>
    
    
    <body>
    <div class="form-body">

        <div class="row">
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
                        <div class="page-links text-center">
                        <a href="index.php" title="Vovler al inicio"><i class='fas fa-home icon'></i></a>
                          <!--  <a href="" class="active">Login</a><a href="registro.php?carrera=<?php echo $id; ?>">Registrarme</a>-->
                        </div>
                        <form rol="form" action="./php/restablecer.php" method="POST">
                                    <h3>Restablece tu contraseña</h3>
                                    <div class="mb-3">
                                    <input type="hidden" name="c" value="" require>
                                     <!--   <label for="c" class="form-label">Email</label> -->
                                        <input type="email" class="form-control" id="c" name="email" placeholder="Correo" maxlength="" required>


                                    </div>
                                             <button type="submit"   class="btn btn-primary" >Enviar Solicitud</button>

                            </form>
                    </div>
                </div>
            </div>


        </div>
    </div>










<!--
            
                    <div class="container">
                            <div class="row justify-contnt-md-center" style="margin-top:15%">
                                    <form class="col-3" action="./php/restablecer.php" method="POST">
                                    <h2>Restablecer Contraseña</h2>
                                    <div class="mb-3">
                                        <label for="c" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="c" name="email">
                                    </div>
                                             <button type="submit"   class="btn btn-primary" >Restablecer</button>
                                    </form>
                            </div>
                    </div>

                    </div> 
    }

    </div> -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    <script type='text/javascript'>
        document.oncontextmenu = function() {
            return false
        }
    </script>
    </body>
</html>