<?php
try {
  if(isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['pass_dos']) && isset($_POST['name']) && isset($_POST['ape_paterno']) && isset($_POST['ape_materno']) && isset($_POST['cp']) && isset($_POST['fec_nac']) && isset($_POST['sexo']) ) {
      $pass =  $_POST['pass'];
      $user = $_POST['user'];
      $pass_dos = $_POST['pass_dos'];
      $name = $_POST['name'];
      $ape_paterno = $_POST['ape_paterno'];
      $ape_materno = $_POST['ape_materno'];
      $cp = $_POST['cp'];
      $fec_nac = $_POST['fec_nac'];
      $sexo = $_POST['sexo'];
      $rol = isset($_POST['rol']) ? $_POST['rol'] : 3;

      if ($pass == $pass_dos) {
        $usuario = new User();
        if (isset($_SESSION['app_id'])){
          $usuario->Insert($user, $rol, $name, $ape_paterno, $ape_materno, $pass, $cp, $sexo, $fec_nac);
        } else {
          $usuario->Insert($user, $rol, $name, $ape_paterno, $ape_materno, $pass, $cp, $sexo, $fec_nac);
        }
        echo 1;
        //}
        } else {
        echo '<div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>ERROR:</strong> Las contraseñas no coinciden.
        </div>';
      }
  } else {
      echo '<div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>ERROR: Todos los campos deben estar llenos</strong> 
      </div>';
  }
} catch(Exception $e){
  echo '<div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>ERROR: </strong>'.$e->getMessage().'</div>';
}
?>