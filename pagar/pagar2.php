<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';
$total = 250;
?>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<style>
    
    /* Media query for mobile viewport */
    @media screen and (max-width: 400px) {
        #paypal-button-container {
            width: 100%;
        }
    }
    
    /* Media query for desktop viewport */
    @media screen and (min-width: 400px) {
        #paypal-button-container {
            width: 250px;
            display: inline-block;
        }
    }
    
</style>


 <div class="jumbotron text-center">
     <h1 class="display-4">¡Activa tu cuenta!</h1>
     <hr class="my-4">
     <p class="lead">Estas a punto de pagar con paypal la cantidad de:
         <h4>$<?php echo number_format($total,2);?></h4>
         <div id="paypal-button-container"></div>


     </p>
     <p>Su cuenta será activada inmediatamente una vez que se haya realizado su pago.</p>
     <strong>Para aclaraciones contactar a: Lucia Esther Martínez (admin@itsva.edu.mx) </strong>
 </div>

 

 <script>
    paypal.Button.render({
        env: 'sandbox', // sandbox | production
        style: {
            label: 'checkout',  // checkout | credit | pay | buynow | generic
            size:  'responsive', // small | medium | large | responsive
            shape: 'pill',   // pill | rect
            color: 'gold'   // gold | blue | silver | black
        },

        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create

        client: {
            sandbox:   'AZDxjDScFpQtjWTOUtWKbyN_bDt4OgqaF4eYXlewfBP4-8aqX3PiV8e1GWU6liB2CUXlkA59kJXE7M6R',
            production: 'insert production client id'
        },

        // Wait for the PayPal button to be clicked

        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '<?php echo $total;?>', currency: 'MXN' }, 
                            description:"Sistema de Administración de Congresos ",
                            custom:"Codigo"
                        }
                    ]
                }
            });
        },

        // Wait for the payment to be authorized by the customer

        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                window.aler("Pago completado.");
                console.log(data);
                window.location="activacion.php?paymentToken="+data.paymentToken+"&paymentID="+data.paymentID;
            });
        }
    
    }, '#paypal-button-container');

</script>


