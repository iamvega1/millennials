<?php
  if (isset($_SESSION['app_id'])){
    try {
      if(isset($_POST['user'])){
        $user = new User();
        $user->Delete($_POST['user']);  
        echo 1;
      } else {
        echo '<div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>ERROR:</strong> Todos los datos deben estar llenos.
        </div>';
      }
    } catch(Exception $e){
      echo '<div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>ERROR: </strong>'.$e->getMessage().'</div>';
    }
  }

?>