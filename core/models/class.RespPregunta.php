<?php

  class RespPregunta {
    private $sql;
    private $db;
    private $id_resp;
    private $id_pregunta;
    private $clave;
    private $contenido;
  
    public function __construct() {
  		$this->db = new Conexion();
    }

    public function obt_lstResp_Pregunta($id_pregunta) {
    	$lstRespPreg = array();
      $this->id_pregunta = $id_pregunta;
    	$i = 0;

    	$this->sql = $this->db->query("SELECT * FROM resp_pregunta WHERE id_pregunta = ".$this->id_pregunta." order by clave;");
    	if($this->db->rows($this->sql) > 0) {
		    while($d = $this->db->recorrer($this->sql)) {
		    	$respuesta = new RespPregunta();
		    	$respuesta->id_resp = $d['id_resp'];
		     	$respuesta->id_pregunta = $d['id_pregunta'];
	        $respuesta->clave = $d['clave'];
	        $respuesta->contenido = $d['respuesta'];
	        $lstRespPreg[$i] = $respuesta;
			    $i++;      
		    }
			}
      $this->db->liberar($this->sql);
      return $lstRespPreg;
    }

    public function Update($id_resp, $id_pregunta, $clave, $contenido) {
        if(!$this->sql = $this->sql = $this->db->query("UPDATE resp_pregunta SET respuesta= '".$contenido."', id_pregunta = ".$id_pregunta.", clave = ".$clave." WHERE id_resp =".$id_resp)){
          throw new Exception("Respuesta Pregunta UPDATE", 1);
        }
    }

    public function Insert($id_pregunta, $clave, $contenido){
      if (!$this->sql = $this->db->query("INSERT INTO resp_pregunta (id_pregunta,clave,respuesta) VALUES (".$id_pregunta.", ".$clave.",'".$contenido."')")){
        throw new Exception("Respuesta Pregunta INSERT", 1);
      }
    }

    public function Delete($id_resp){
      if(!$this->sql = $this->db->query("DELETE FROM resp_pregunta where id_resp =".$id_resp)){
        throw new Exception("Respuesta Pregunta DELETE", 1);
      }
    }

    public function __get($property)
    {
       if (property_exists($this, $property)) {
       return $this->$property;
       }
    }

    public function __destruct() {
	    $this->db->close();
    }
  }

?>