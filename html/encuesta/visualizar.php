<?php include(HTML_DIR . 'overall/header.php'); ?>
	<body>
		<section class="engine"><a rel="nofollow" href="#"><?php echo APP_TITLE ?></a></section>
		<?php include(HTML_DIR . '/overall/topnav.php'); ?>
		
		<section class="mbr-section mbr-after-navbar">
			<div class="mbr-section__container container mbr-section__container--isolated">
				<div class="row">
					<div class="mbr-article mbr-article--wysiwyg col-sm-12 col-sm-offset-0">
						<div class="modal-content">
							<div class="modal-header">
				               <h4 style="color:#384d53;"><span class="glyphicon glyphicon-th-list"></span> 
				                <?php
				                	if(isset($_GET['encuesta'])){
				                		$id_encuesta = $_GET['encuesta'];
				                		$enc = new Encuestas();
										$enc->obt_encuesta($id_encuesta);
										echo $enc->nombre;

				                	}	
									
								?>
				               </h4>
				             </div>
			            	<div class="modal-body">
			             	<?php

			             		foreach ($enc->lst_preg as $preg) {
			             			echo '<div class="pregunta">              	
						               		<h4 id="txtPreg">'.$preg->clave.'.-'.$preg->contenido.'</h4>
							               	<div class="respuestas">';
			             			switch ($preg->id_tipo) {
			             				case 1:
			             					
							               	foreach ($preg->lst_resp as $res) {
							               	  	echo '<div class="radio">
								               			<input id=res_'.$preg->clave.'_'.$res->clave.'   name=res_'.$preg->clave.' type="radio">
								               			<label for="res_'.$preg->clave.'_'.$res->clave.'" class="label">'.$res->contenido.'</label>
							               			</div>';
							               	}
			             					break;
			             				case 2:
			             					foreach ($preg->lst_resp as $res) {
							               	  	echo '<div class="checkbox">
								               			<input id=res_'.$preg->clave.'_'.$res->clave.'   name=res_'.$preg->clave.' type="checkbox">
								               			<label for="res_'.$preg->clave.'_'.$res->clave.'" class="label">'.$res->contenido.'</label>
							               			</div>';
							               	}
			             					break;
			             				case 3:
			             					echo '<div style="display: flex">
			             							<div style="width: 50%;">
							               				<table>
								               				<tr>
								               					<td style="text-align: -webkit-center;">Arrastra los elementos</td>
								               				</tr>';
								               	foreach ($preg->lst_resp as $res) {
								               		echo '<tr> <td>';
								               			echo '<div class="list-group">
		               											<label id="res_'.$preg->clave.'_'.$res->clave.'" class="list-group-item label resDrag" style="color: black;">'.$res->contenido.'</label>
		               										</div>';
		               								echo '</td> </tr>';
								               	}
									        echo '</table>
									             </div>
									            <div style="width: 50%">
						               			<table class="tblRes" >
						               				<tr>
						               					<td>Agregalos aqui</td>
						               				</tr>
						               				<tr>
						               					<td style="border: 1px solid #303F9F; height: 100%;">&nbsp;</td>
						               				</tr>
						               			</table>
						               		</div>';
			             					break;
			             				default:
			             					echo "<script>console.log( 'Error: pregunta num.". $preg->clave ."' );</script>";
			             					break;
			             			}
			             			echo '</div>
									            </div>';							               		
			             		}
			             	?>
			             	<a class="btn btn-primary center" onClick="terminar()" style="border-radius: 10px;display:block; width: 200px; margin: auto; margin-bottom: 10px;">Terminar</a>
			             	</div>
			             	<div class="modal-footer">
			             		<p> Encuesta realizada por
			             		<?php
			             			$user = new User();
			             			$user->obt_usuario($enc->usuario);
			             			echo $user->nombre." ".$user->ape_pat;
			             		?>
			             		</p>

			             	</div>

						</div>
					</div>
				</div>
			</div>
		</section>
	<?php include(HTML_DIR . 'overall/footer.php'); ?>
	<script src="views/app/js/contEnc.js"></script>
	
	</body>
</html>
