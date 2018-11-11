<?php

class User {
	private $sql;
	private $db;
	private $id;
	private $rol;
	private $rolDesc;
	private $nombre;
	private $ape_pat;
	private $ape_mat;
	private $pass;
	private $cont;
	private $sexo;
	private $sexoDesc;
	private $codigo_postal;
	private $fecha_crea;
	private $fecha_ult_ingreso;
	private $fecha_nacimiento;


	public function __construct() {
		$this->db = new Conexion();
		$this->rol = new Rol();
		$this->sexo = new Sexo();
		$this->id = isset($_SESSION['app_id']) ? $_SESSION['app_id'] : null;
	}

	public function validar($user, $pass) {
		$res = 'false';
		$this->sql = $this->db->query("SELECT * FROM usuarios WHERE usuario='".$user."' LIMIT 1;");
		if($this->db->rows($this->sql) > 0) {
		    while($d = $this->db->recorrer($this->sql)) {
		    	$this->poblar($d);	      
		    }
		    if($this->pass == $pass){
		    	$_SESSION['app_id'] = $user;
				$_SESSION['nomUser'] = $this->nombre;
				$this->registarIngreso();
				$res = 'true';
		    }	    
		} 
		$this->db->liberar($this->sql);
		//$this->db->close();
		return $res;
	}

	private function registarIngreso()
	{
		$db = new Conexion();
		$sql = "UPDATE usuarios SET contador = ".$this->cont." + 1, fecha_ult_ingreso = CURRENT_TIMESTAMP WHERE usuario= '".$this->id."';";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$db->close();		
	}
	public function obt_usuarios()
    {
    	$listUser = array();
    	$i = 0;
    	$this->sql = $this->db->query("SELECT * FROM usuarios;");
    	
    	if($this->db->rows($this->sql) > 0) {
		    while($d = $this->db->recorrer($this->sql)) {
		    	$user = new User();
		    	$user->poblar($d);	
		        $listUser[$i] = $user;
			    $i++;      
		    }
		}
		$this->db->liberar($this->sql);
		return $listUser;
	}
	public function obt_usuario($user){
		$this->id = $user;
    	$this->sql = $this->db->query("SELECT * FROM usuarios where usuario = '".$this->id."';");
    	if($this->db->rows($this->sql) > 0) {
		    while($d = $this->db->recorrer($this->sql)) {
		    	$this->poblar($d);
		    }
		}
		$this->db->liberar($this->sql);
	}

	public function Update($usuario, $id_rol, $nombre, $ape_pat, $ape_mat, $pass, $codigo_postal, $id_sexo, $fecha_nacimiento) {

		if (!$this->sql = $this->db->query("UPDATE `usuarios` SET `id_rol` = '".$id_rol."', `nombre` = '".$nombre."', `ape_pat` = '".$ape_pat."', `ape_mat` = '".$ape_mat."', `password` = '".$pass."', `codigo_postal` = '".$codigo_postal."', `id_sexo` = '".$id_sexo."', `fecha_nacimiento` = '".$fecha_nacimiento."' WHERE `usuarios`.`usuario` = '".$usuario."'")){

			throw new Exception("usuario UPDATE", 1);
		}
	} 
	public function Insert($usuario, $id_rol, $nombre, $ape_pat, $ape_mat, $pass, $codigo_postal, $id_sexo, $fecha_nacimiento) {

		if (!$this->sql = $this->db->query("INSERT INTO usuarios (usuario, id_rol, nombre, ape_pat, ape_mat, password, contador, codigo_postal, id_sexo, fecha_nacimiento) VALUES ('".$usuario."',".$id_rol.",'".$nombre."','".$ape_pat."','".$ape_mat."','".$pass."', 0,".$codigo_postal.",".$id_sexo.",'".$fecha_nacimiento."')")) {
			
			throw new Exception("Usuarios INSERT", 1);
		} else {
			$this->id = $this->db->insert_id;
		}
    }

	public function Delete($user){
	    if (!$this->sql = $this->db->query("DELETE FROM usuarios where usuario ='".$user."'")){
	    	throw new Exception("User DELETE", 1);
	    }
	}

    private function poblar($d){

    	$this->id = $d['usuario'];
        $this->nombre = ucfirst($d['nombre']);
        $this->ape_pat = ucfirst($d['ape_pat']);
        $this->ape_mat = $d['ape_mat'];
        $this->pass = $d['password'];
        $this->cont = $d['contador'];
        $this->fecha_crea = new DateTime($d['fecha_crea']);
        $this->fecha_ult_ingreso = $d['fecha_ult_ingreso'];
        $this->codigo_postal = $d['codigo_postal'];
        $this->fecha_nacimiento = new DateTime($d['fecha_nacimiento']);

        $this->rol->obt_rol($d['id_rol']);
        $this->rolDesc = $this->rol->nombre;

        $this->sexo->obt_sexo($d['id_sexo']);
        $this->sexoDesc = $this->sexo->nombre;
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