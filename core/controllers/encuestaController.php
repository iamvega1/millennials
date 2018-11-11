<?php
if (isset($_SESSION['app_id'])){
	$action = $_GET['action'];

	$user = new User();
	$user->obt_usuario($_SESSION['app_id']);
	
	switch ($user->rolDesc) {
		case 'Admin':
		case 'Encuestador':
			switch ($action) {
				case 'ver':
					include('html/encuesta/visualizar.php');
					break;
				case 'crear':
					include('html/encuesta/crearEncuesta.php');
					break;
				case 'verPreg':
					include('html/encuesta/listarPreguntas.php');
					break;
				case 'verGraf':
					include('html/encuesta/verGrafica.php');
					break;
				case 'listar':
					$_SESSION['mostar'] = 1;
			}
		case 'Encuestado':
			switch ($action) {
				case 'listar':
					include('html/encuesta/listarEncuestas.php');
					break;
				case 'contestar':
					include('html/encuesta/visualizar.php');
					break;
				case 'verPreg':
					break;
				default:
					include('core/controllers/errorController.php');
					break;
			}
			break;
		default:
			include('core/controllers/errorController.php');
			break;
	}	
} else {
	include('html/index/index.php');
}


?>