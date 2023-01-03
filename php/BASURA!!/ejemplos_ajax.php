<html>

<head>
    <title>Ejemplo sencillo de AJAX</title>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script>
        function realizaProceso() {
            var parametros = {
                "valorCaja1": 23,
                "valorCaja2": 3
            };
            $.ajax({
                data: parametros, //datos que se envian a traves de ajax
                url: 'ejemplo_ajax_proceso.php', //archivo que recibe la peticion
                type: 'post', //método de envio
                success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    $("#resultado").html(response);
                }
            });
        }
        setInterval(realizaProceso, 1000);
    </script>

<script>
        function realizaProceso2() {
            var parametros = {
                "valorCaja1": 23,
                "valorCaja2": 32
            };
            $.ajax({
                data: parametros, //datos que se envian a traves de ajax
                url: 'ejemplo_ajax_proceso.php', //archivo que recibe la peticion
                type: 'post', //método de envio
                success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    $("#resultado2").html(response);
                }
            });
        }
        setInterval(realizaProceso2, 1000);
    </script>
    
</head>

<body>
   
    Resultado: <span id="resultado">0</span>
    <br>
    Resultado: <span id="resultado2">0</span>
  
</body>

</html>