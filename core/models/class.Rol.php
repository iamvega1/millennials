<?php

class Rol {
  private $sql;
  private $db;
  private $id_rol;
  private $nombre;
  private $descripcion;


	public function __construct() {
		$this->db = new Conexion();
	}

	public function obt_roles()
    {
    	$listRoles = array();
    	$i = 0;
    	$this->sql = $this->db->query("SELECT * FROM roles;");
    	if($this->db->rows($this->sql) > 0) {
		    while($d = $this->db->recorrer($this->sql)) {
		    	$rol = new Rol();
		    	$rol->poblar($d);	
		        $listRoles[$i] = $rol;
			    $i++;      
		    }
		}
		$this->db->liberar($this->sql);
		return $listRoles;
	}
	public function obt_rol($id_rol){
		$this->id_rol = $id_rol;
    	$this->sql = $this->db->query("SELECT * FROM roles where id_rol = ".$this->id_rol.";");
    	if($this->db->rows($this->sql) > 0) {
		    while($d = $this->db->recorrer($this->sql)) {
		    	$this->poblar($d);     
		    }
		}
		$this->db->liberar($this->sql);
	}

	public function Update($id_rol, $nombre, $descripcion) {

		if (!$this->sql = $this->db->query("UPDATE roles SET nombre = '".$nombre."', descripcion = '".$descripcion."' WHERE id_rol = ".$id_rol)){
			throw new Exception("roles UPDATE", 1);
		}
	} 

    private function poblar($d){
    	$this->id_rol = $d['ID_ROL'];
        $this->nombre = ucfirst($d['NOMBRE']);
        $this->descripcion = $d['DESCRIPCION'];
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