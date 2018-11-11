<?php

	class Encuestas {
		
		private $sql; 
		private $db;  
		private $id_encuesta;
		private $nombre;
		private $descripcion;
		private $usuario;
		private $fecha_crea;
		private $fecha_mod;
		private $lst_preg;



		public function __construct() {
			$this->db = new Conexion();
			$this->usuario = isset($_SESSION['app_id']) ? $_SESSION['app_id'] : null;
		}
	    
		public function validarNom($nom) {
			$this->sql = $this->db->query("SELECT * FROM encuestas WHERE nombre='".$nom."' LIMIT 1;");
			if($this->db->rows($this->sql) > 0) {
			    while($d = $this->db->recorrer($this->sql)) {
			    	$this->poblar($d);
			        $res = FALSE;     
			    } 
			} else{
				$res= TRUE;
			}
			$this->db->liberar($this->sql);
			return $res;
		}	

		public function obt_encuestas() {
	    	$listEncuestas = array();
	    	$i = 0;

	    	$this->sql = $this->db->query("SELECT * FROM encuestas;");
	    	if($this->db->rows($this->sql) > 0) {
			    while($d = $this->db->recorrer($this->sql)) {
			    	$encuesta = new Encuestas();
			    	$encuesta->poblar($d);
			        $listEncuestas[$i] = $encuesta;
				    $i++;      
			    }		
			}
			$this->db->liberar($this->sql);
			return $listEncuestas;
		}
		    
		public function obt_encuesta($nombre) {
			$this->nombre = $nombre;
			$this->sql = $this->db->query("SELECT * FROM encuestas WHERE nombre='".$this->nombre."';");
			if($this->db->rows($this->sql) > 0) {
			    while($d = $this->db->recorrer($this->sql)) {
			    	$this->poblar($d);
			    } 
			} 
			$this->db->liberar($this->sql);
		}

		public function obt_ultima_enc_creada($user) {
			$this->usuario = $user;
			$this->sql = $this->db->query("SELECT * FROM `encuestas` WHERE usuario = '".$this->usuario."' AND fecha_crea = (SELECT max(fecha_crea) from encuestas where usuario = '".$this->usuario."')");
			if($this->db->rows($this->sql) > 0) {
			    while($d = $this->db->recorrer($this->sql)) {
			    	$this->poblar($d);
			    } 
			} 
			$this->db->liberar($this->sql);
		}

		public function Update($nombre,$descripcion,$usuario){
			if (!$this->sql = $this->db->query("UPDATE encuestas SET nombre = '".$nombre."', descripcion = '".$descripcion."', usuario = '".$usuario."' WHERE id_encuesta = ".$id_encuesta)){
				throw new Exception("Encuesta UPDATE", 1);
			}
		} 

		public function Insert($nombre,$descripcion,$usuario){
			if (!$this->sql = $this->db->query("INSERT INTO encuestas (nombre,descripcion,usuario) VALUES ('".$nombre."','".$descripcion."','".$usuario."')")){
				throw new Exception("Encuesta INSERT", 1);
			} else {
				$this->id_encuesta = $this->db->insert_id;
			}
	    }

	    private function poblar($d){
	    	$this->id_encuesta = $d['id_encuesta'];
	        $this->nombre = ucfirst($d['nombre']);
	        $this->descripcion = $d['descripcion'];
	        $this->usuario = $d['usuario'];
	        $this->fecha_crea =  new DateTime($d['fecha_crea']);
	        $this->fecha_mod = $d['fecha_mod'];
	        $preg = new Preguntas();
	        $this->lst_preg = $preg->obt_preguntas_encuesta($d['id_encuesta']);
	    }
	    

		public function Delete(){
	        if (!$this->sql = $this->db->query("DELETE FROM encuestas where id_encuesta =".$this->id_encuesta)){
	        	throw new Exception("Encuesta DELETE", 1);
	        }
		}

	    public function __get($property){
	       if (property_exists($this, $property)) {
	       return $this->$property;
	       }
	    }

	    public function __destruct() {
		    $this->db->close();
	    }
	}

?>



