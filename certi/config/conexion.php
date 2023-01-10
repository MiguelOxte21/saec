<?php
    /*TODO: Inicializando la sesion del usuario */
    session_start();

    /*TODO: Iniciamos Clase Conectar */
    class Conectar{
        protected $dbh;

        /*TODO: Funcion Protegida de la cadena de Conexion */
        protected function conexion(){
            try {
                /*TODO: Cadena de Conexion QA*/
				$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=congreso","congreso","abc123$");
                /*TODO: Cadena de Conexion Produccion*/
				return $conectar;
			} catch (Exception $e) {
                /*TODO: En Caso hubiera un error en la cadena de conexion */
				print "¡Error BD!: " . $e->getMessage() . "<br/>";
				die();
			}
        }

        /*TODO: Para impedir que tengamos problemas con las ñ o tildes */
        public function set_names(){
            return $this->dbh->query("SET NAMES 'utf8'");
        }

        /*TODO: Ruta principal del proyecto */
        public static function ruta(){
            
            return "https://congresosyeventos.valladolid.tecnm.mx:443/congreso/certi/";
            
        }

    }
?>
