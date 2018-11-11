<?php
	
	try{
		if(isset($_POST['proceso'])){
			switch ($_POST['proceso']) {
				case 'init':
					if(isset($_POST['name'])){
						$ec = new Encuestas();
						if ($ec->validarNom($_POST['name'])) {
							$ec->Insert($_POST['name'], 'null', $_SESSION['app_id']);
							$_SESSION['id_encuesta'] = $ec->id_encuesta;
							echo  1;
						} else {
							echo '<div class="alert alert-dismissible alert-danger">
					      	<button type="button" class="close" data-dismiss="alert">x</button>
					      	<strong>ERROR:</strong> El nombre que quiere ultilizar ya existe en otra encuesta.
					    	</div>';
						}
					}else {
						echo '<div class="alert alert-dismissible alert-danger">
				      	<button type="button" class="close" data-dismiss="alert">x</button>
				      	<strong>ERROR:</strong> Falta llenar el campo del nombre.
				    	</div>';
					}
					break;
				case 'addPreg':
					$datPreg = (isset($_POST["datos"])) ? json_decode($_POST["datos"], true) : null;
					$preg = new Preguntas();
					$id_encuesta = (isset($_SESSION['id_encuesta'])) ? $_SESSION['id_encuesta'] : null;
					$contenido = (isset($datPreg['preg'])) ? $datPreg['preg'] : null; 
					$contador = (isset($datPreg['cont'])) ? $datPreg['cont'] : null;
					$tipo = (isset($datPreg['tipo'])) ? $datPreg['tipo'] : null;
					if($datPreg != null & $id_encuesta != null && $contenido != null && $contador != null && $tipo != null){
						$preg->Insert($id_encuesta, $contador, $contenido,'NULL',$tipo);
						$io;
						foreach ($datPreg['respuestas'] as $res) {
							$resp = new RespPregunta();
							$resp->Insert($preg->id_pregunta, $res['cont'], $res['res']);
						}
						//print_r($io);
						echo 1;
						break;
					}
				default:
					echo '<div class="alert alert-dismissible alert-danger">
				      	<button type="button" class="close" data-dismiss="alert">x</button>
				      	<strong>ERROR:</strong> Falta llenar los campos.
				    	</div>';
					break;
			}
		}
	}catch(Exception $e){
		echo '<div class="alert alert-dismissible alert-danger">
	      	<button type="button" class="close" data-dismiss="alert">x</button>
	      	<strong>ERROR INESPERADO: </strong>'.$e->getMessage().
	    	'</div>';
	}

?>