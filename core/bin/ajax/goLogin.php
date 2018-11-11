<?php
  if(isset($_POST['pass']) && isset($_POST['user'])){
    $user = new User();
      $res = $user->validar($_POST['user'], $_POST['pass']);
      if($res == 'true'){
        echo 1;
      }else {
        echo '<div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>ERROR:</strong> Las credenciales son incorrectas.
      </div>';
    }
  } else {
    echo '<div class="alert alert-dismissible alert-danger">
      <button type="button" class="close" data-dismiss="alert">x</button>
      <strong>ERROR:</strong> Todos los datos deben estar llenos.
    </div>';
  }

?>