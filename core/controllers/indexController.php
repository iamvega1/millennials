<?php
if (isset($_SESSION['app_id'])){
	$user = new User();
	$user->obt_usuario($_SESSION['app_id']);
	
	switch ($user->rolDesc) {
		case 'Admin':
			include('html/usuario/listarUsuarios.php');
			break;
		case 'Encuestador':
			include('html/encuesta/listarEncuestas.php');
			break;
		case 'Encuestado':
			include('html/encuesta/listarEncuestas.php');
			break;
		default:
			include('core/controllers/errorController.php');
			break;
	}
	
} else {
	include('html/index/index.php');
}


?>
