<?php
// los querys como el select, update, insert y el delete  debemos comprabar su exito; 
// El query que utiliza un select deben usar el metodo liberar 
// el query insert tambien tiene un metodo insert_id que retorna el id del nuevo row
// el query que modifique la tabla tiene el metodo affected_rows que retorna el total rows afectado

class Preguntas {
  private $sql;
  private $db;
  private $id_pregunta;
  private $id_encuesta;
  private $clave; //número de la pregunta
  private $contenido;
  private $descripcion;
  private $id_tipo;
  private $lst_resp;


    public function __construct() {
    	$this->db = new Conexion();
    }


    public function obt_preguntas_encuesta($id_encuesta) {
      $listPreguntas = array();
      $this->id_encuesta = $id_encuesta;
      $i = 0;

      $this->sql = $this->db->query("SELECT * FROM preguntas WHERE id_encuesta=".$this->id_encuesta);
      if($this->db->rows($this->sql) > 0) {
        while($d = $this->db->recorrer($this->sql)) { 
          $pregunta = new Preguntas();     
          $pregunta->id_pregunta = $d['id_pregunta'];
          $pregunta->id_encuesta = $d['id_encuesta'];
          $pregunta->clave = $d['clave'];
          $pregunta->contenido = ucfirst($d['pregunta']);
          $pregunta->descripcion = $d['descripcion'];
          $pregunta->id_tipo = $d['id_tipo'];
          $res = new RespPregunta();
          $pregunta->lst_resp = $res->obt_lstResp_Pregunta($d['id_pregunta']);          
          $listPreguntas[$i] = $pregunta;
          $i++;           
        }
      }
      $this->db->liberar($this->sql);
      return $listPreguntas;
    }

    public function obt_pregunta($id_pregunta) {
      $this->id_pregunta = $id_pregunta;
      $this->sql = $this->db->query("SELECT * FROM preguntas WHERE id_pregunta= ".$this->id_pregunta);
      if($this->db->rows($this->sql) > 0) {
        while($d = $this->db->recorrer($this->sql)) {      
          $this->id_pregunta = $d['id_pregunta'];
          $this->id_encuesta = $d['id_encuesta'];
          $this->clave = $d['clave'];
          $this->contenido = ucfirst($d['pregunta']);
          $this->descripcion = $d['descripcion'];
          $this->id_tipo = $d['id_tipo'];              
        }
      }
      $this->db->liberar($this->sql);
    }

    public function Update($id_encuesta, $clave, $contenido, $descripcion, $id_pregunta){
       if(!$this->sql = $this->db->query("UPDATE preguntas SET id_encuesta = ".$id_encuesta.", clave = ".$clave.", pregunta = '".$contenido."', descripcion ='".$descripcion."', id_tipo = ".$id_tipo." WHERE id_pregunta = ".$this->id_pregunta)){
        throw new Exception("Pregunta UPDATE", 1);
       }
    }

    public function Insert($id_encuesta, $clave, $contenido, $descripcion, $id_tipo){
      if(!$this->sql = $this->db->query("INSERT INTO preguntas (id_encuesta, clave, pregunta, descripcion, id_tipo) VALUES (".$id_encuesta.",".$clave.",'".$contenido."','".$descripcion."',".$id_tipo.")")){
        throw new Exception("Pregunta INSERT", 1);        
      } else {
        $this->id_pregunta = $this->db->insert_id;
        
      }
    } 

    public function Delete(){
      if ($this->sql = $this->db->query("DELETE FROM preguntas where id_pregunta =".$this->id_pregunta)){
        throw new Exception("Pregunta DELETE", 1);
      }
    } 

    public function __destruct() {
      $this->db->close();
    }

    public function __get($property)
    {
       if (property_exists($this, $property)) {
       return $this->$property;
       }
    }

    // public function __set($property, $value)
    // {
    //    if (property_exists($this, $property)) {
    //    $this->$property = $value;
    //    }
    // }
}

?>