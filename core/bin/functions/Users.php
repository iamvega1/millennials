<?php

function Users() {
  $db = new Conexion();
  $sql = $db->query("SELECT * FROM usuarios;");
  if($db->rows($sql) > 0) {
    while($d = $db->recorrer($sql)) {
      $users[$d['usuario']] = array(
        'id' => $d['usuario'],
        'id_rol' => $d['id_rol'],
        'nombre' => $d['nombre'],
        'ape_pat' => $d['ape_pat'],
        'ape_mat' => $d['ape_mat'],
        'pass' => $d['password'],
        'id_sexo' => $d['id_sexo'],
        'codigo_postal' => $d['codigo_postal']
      );
    }
  } else {
    $users = false;
  }
  $db->liberar($sql);
  $db->close();

  return $users;
}

?>
