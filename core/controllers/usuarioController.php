<?php
if (isset($_SESSION['app_id'])){
	$action = $_GET['action'];

	$user = new User();
	$user->obt_usuario($_SESSION['app_id']);
	
	switch ($user->rolDesc) {
		case 'Admin': // si no es admin no podra ver la vista
			include('html/usuario/listarUsuarios.php');
			break;
		default:
			include('core/controllers/errorController.php');
			break;
	}

		
} else {
	include('html/index/index.php');
}


?>