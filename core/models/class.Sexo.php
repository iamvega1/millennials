<?php

class Sexo {
  private $sql;
  private $db;
  private $id_sexo;
  private $nombre;
  private $abreviatura;


	public function __construct() {
		$this->db = new Conexion();
	}

	public function obt_sexos()
    {
    	$listSexos = array();
    	$i = 0;
    	$this->sql = $this->db->query("SELECT * FROM sexo;");
    	if($this->db->rows($this->sql) > 0) {
		    while($d = $this->db->recorrer($this->sql)) {
		    	$rol = new Sexo();
		    	$rol->poblar($d);	
		        $listSexos[$i] = $rol;
			    $i++;      
		    }
		}
		$this->db->liberar($this->sql);
		return $listSexos;
	}
	public function obt_sexo($id_sexo){
		//$this->id_sexo = $id_sexo;
    	$this->sql = $this->db->query("SELECT * FROM sexo where id_sexo = ".$id_sexo.";");
    	if($this->db->rows($this->sql) > 0) {
		    while($d = $this->db->recorrer($this->sql)) {
		    	$this->poblar($d);     
		    }
		}
		$this->db->liberar($this->sql);
	}

	public function Update($id_sexo, $nombre, $abreviatura) {

		if (!$this->sql = $this->db->query("UPDATE sexo SET nombre = '".$nombre."', abreviatura = '".$abreviatura."' WHERE id_sexo = ".$id_sexo)){
			throw new Exception("sexo UPDATE", 1);
		}
	} 

    private function poblar($d){
    	$this->id_sexo = $d['id_sexo'];
        $this->nombre = ucfirst($d['nombre']);
        $this->abreviatura = $d['abreviatura'];
    }

	public function __set($var, $valor) {  
		if (property_exists(__CLASS__, $var)) {  
			$this->$var = $valor;  
		} else {  
			echo "No existe el atributo $var.";  
		}  
	}

	public function __get($var) {  
		if (property_exists(__CLASS__, $var)) {  
			return $this->$var;  
		}  
		return NULL;  
    }

    public function __destruct() {
	    $this->db->close();
    }  	
}

?>