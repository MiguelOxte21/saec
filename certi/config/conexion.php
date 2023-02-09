<?php

    session_start();
    class Conectar{
        protected $dbh;
        protected function conexion(){
            try {
          	$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=congreso","congreso","abc123$");
                
				  return $conectar;
			} catch (Exception $e) {
				print "¡Error BD!: " . $e->getMessage() . "<br/>";
				die();
			}
        }
  }
        public function set_names(){
            return $this->dbh->query("SET NAMES 'utf8'");
        }
        public static function ruta(){
            return "https://congresosyeventos.valladolid.tecnm.mx/certi/";
            
        }

    }
?>
